<?php

namespace Jarvis\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Jarvis\User;
use Jarvis\Agg_Association;
use Jarvis\Equipment;
use Jarvis\Http\Controllers\ControllerUser_history;

class ControllerAgg_Association extends Controller
{
    public function index() {
        try {
            if (!Auth::guest() == false) return redirect('login')->withErrors([Lang::get('validation.login')]);
            $authori_status = User::authorization_status(30);
            if ($authori_status['permi'] < 3) return redirect('home')->withErrors([Lang::get('validation.authori_status')]);
            return view('agg_association.list', compact('authori_status'));
        } catch (Exception $e) {
			return redirect('home')->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function index_list() {
        try {
            if (!Auth::guest() == false) return redirect('login')->withErrors([Lang::get('validation.login')]);
            $authori_status = User::authorization_status(30);
		    if ($authori_status['permi'] < 3) return redirect('home')->withErrors([Lang::get('validation.authori_status')]);
            $list = DB::table('agg_association')
                ->join('equipment as e1', 'agg_association.id_agg', '=', 'e1.id')
                ->join('ip', 'e1.id', '=', 'ip.id_equipment')
                ->join('list_key_value as lkv1', function($join) {
                    $join->on('agg_association.id_home_zone', '=', 'lkv1.value')->where('lkv1.key_name', '=', 'id_zone');
                })
                ->join('equipment as e2', 'agg_association.id_home_pe', '=', 'e2.id')
                ->join('equipment as e3', 'agg_association.id_home_pei', '=', 'e3.id')
                ->join('list_key_value as lkv2', function($join) {
                    $join->on('agg_association.id_multihome_zone', '=', 'lkv2.value')->where('lkv2.key_name', '=', 'id_zone');
                })
                ->join('equipment as e4', 'agg_association.id_multihome_pe', '=', 'e4.id')
                ->join('equipment as e5', 'agg_association.id_multihome_pei', '=', 'e5.id')
                ->select('e1.acronimo as agg', 'e1.id as agg_id', 'ip.ip', 'lkv1.description as home_zone', 'e2.acronimo as pe_home', 'e3.acronimo as pei_home', 'lkv2.description as multihome_zone', 'e4.acronimo as pe_multihome', 'e5.acronimo as pei_multihome', 'e1.status')
                ->get();
            foreach ($list as $assoc) {
                $assoc->home_zone = str_replace('Zona: ', '', $assoc->home_zone);
                $assoc->multihome_zone = str_replace('Zona: ', '', $assoc->multihome_zone);
            }
            return datatables()->of($list)->make(true);
        } catch (Exception $e) {
			return redirect('home')->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function create() {
        try {
            if (!Auth::guest() == false) return ['resul' => 'login'];
		    $authori_status = User::authorization_status(30);
		    if ($authori_status['permi'] < 10) return ['resul' => 'autori'];
            $agg = Agg_Association::where('id_agg', $_POST['agg_id'])->first();
            if (isset($agg)) return ['resul' => 'nop', 'datos' => 'Este agregador ya se utiliza en otra asociaci&oacute;n'];
            $agg_asc = new Agg_Association;
            $agg_asc->id_agg = $_POST['agg_id'];
            $agg_asc->prefijo_agg = $_POST['agg_prefix'];
            $agg_asc->id_home_zone = $_POST['home_zone_id'];
            $agg_asc->id_home_pe = $_POST['pe_home_id'];
            $agg_asc->id_home_pei = $_POST['pei_home_id'];
            $agg_asc->id_multihome_zone = $_POST['multihome_zone_id'];
            $agg_asc->id_multihome_pe = $_POST['pe_multihome_id'];
            $agg_asc->id_multihome_pei = $_POST['pei_multihome_id'];
            $agg_asc->save();
            ControllerUser_history::store(
                "Asoció Agregador ".$_POST['agg_acr']." a Home Pe ".$_POST['pe_home_acr'].", Home Pei ".$_POST['pei_home_acr'].", Multihome Pe ".$_POST['pe_multihome_acr']." y Multihome Pei ".$_POST['pei_multihome_acr']
            );
            return ['resul' => 'yes'];
        } catch (Exception $e) {
            return ['resul' => 'nop', 'datos' => $e->getMessage()];
        }
    }

    public function enable_disable_agg() {
        try {
            if (!Auth::guest() == false) return redirect('login')->withErrors([Lang::get('validation.login')]);
            $authori_status = User::authorization_status(30);
		    if ($authori_status['permi'] < 5) return redirect('home')->withErrors([Lang::get('validation.authori_status')]);


            $agg = Equipment::find($_POST['id']);
            if ($agg->status == 'ALTA') {
                $agg->status = 'DESHABILITADO';
                ControllerUser_history::store("Deshabilitó Agregador $agg->acronimo");
                $agg->save();
                return ['resul' => 'yes'];
            } elseif ($agg->status == 'DESHABILITADO') {
                $agg->status = 'ALTA';
                ControllerUser_history::store("Habilitó Agregador $agg->acronimo");
                $agg->save();
                return ['resul' => 'yes'];
            } else {
                return ['resul' => 'nop', 'datos' => 'Estado de equipo no v&aacute;lido para realizar esta operaci&oacute;n'];
            }
            
            
        } catch (Exception $e) {
            return ['resul' => 'nop', 'datos' => $e->getMessage()];
        }
    }
}
