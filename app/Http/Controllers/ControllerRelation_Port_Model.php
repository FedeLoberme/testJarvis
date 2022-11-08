<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jarvis\Relation_Port_Model;
use DB;
use Jarvis\user;
use Jarvis\Constants;
use Carbon\Carbon;
use Jarvis\Http\Controllers\ControllerPort_Equipment_Model;
class ControllerRelation_Port_Model extends Controller
{
    public function store(){
        if (!Auth::guest() == false){ return $data = array('resul' => 'login', ); }
    	$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
        if ($authori_status['permi'] >= 10){
        	$id_equip=$_POST['id_equip'];
            $id_port = $_POST['id_port'];
            $label = $_POST['label'];
                $consul = Relation_Port_Model::relation_exi($id_equip, $id_port);
                if (count($consul) == 0) {
                    $Relation = new Relation_Port_Model();
                        $Relation->id_equipment_model = $id_equip;
                        $Relation->id_port_equipment_model = $id_port;
                        $Relation->description_label = $label;
                    $Relation->save();
                }
            $data = array('resul' => "yes", );
        }else{
            $data = array('resul' => 'authori',);
        }
    	return $data;
    }

    public function deactivate($id){
        if (!Auth::guest() == false){ return redirect('login')
        ->withErrors([Lang::get('validation.login'),]);}
        $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
        if ($authori_status['permi'] >= 10){
            $port_exis = DB::table('relation_port_model')
            ->join('port_equipment_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
            ->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->where('relation_port_model.id', '=', $id)
            ->select('port_equipment_model.id')->get();
            // aqui tiene ir la consulta aqui --------------------------------------
            $relation = Relation_Port_Model::find($id);
                    $equip_id = $relation->id_equipment_model;
            if (count($port_exis) == 0) {
                Relation_Port_Model::destroy($id);
            }else{
                    $relation->status = 'Inactivo';
                $relation->save();
            }
            $notification = array(
                    'message' => trans('validation.msj.update'),
                    'alert-type' => 'success'
                );
            return redirect('crear/puerto'.'/'.$equip_id )->with($notification);
        }else{
            return  redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function activate($id){
        if (!Auth::guest() == false){ return redirect('login')
      ->withErrors([Lang::get('validation.login'),]);}
        $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
        if ($authori_status['permi'] >= 10){
            $relation = Relation_Port_Model::find($id);
                $equip_id = $relation->id_equipment_model;
                $relation->status = 'Activo';
            $relation->save();
            $notification = array(
                    'message' => trans('validation.msj.update'),
                    'alert-type' => 'success'
                );
            return redirect('crear/puerto'.'/'.$equip_id )->with($notification);
        }else{
            return  redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function relation_edit(){
        if (!Auth::guest() == false){ return $dato = array('resul' => 'login', ); }
        $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
        if ($authori_status['permi'] >= 10){
            $id = $_POST['id'];
            $relation = Relation_Port_Model::find($id);
            if($relation->description_label <> null){
                $data = ControllerPort_Equipment_Model::fsp($relation->description_label);
                $contar = count($data);
                $dato = array($contar, $data,);
            }else{
                $dato = array('0', 'nop',);
            }
        }else{
            $dato = array('resul' => 'authori',);
        }
        return $dato;
    }

    public function update_relation(){
        if (!Auth::guest() == false){ return $data = array('resul' => 'login', ); }
        $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
        if ($authori_status['permi'] >= 10){
            $label = $_POST['label'];
            $id_relation = $_POST['id_relation'];
            $relation = Relation_Port_Model::find($id_relation);
                $relation->description_label = $label;
            $relation->save();
            $data = array('resul' => 'yes', );
        }else{
            $data = array('resul' => 'authori',);
        }
        return $data;
    }

    public function description_label(){
        $id_equip= $_POST['equip'];
        $id_port= $_POST['port'];
        $port = DB::table('relation_port_model')
        ->join('port_equipment_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
        ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
        ->where('relation_port_model.status', '=', 'Activo')
        ->where('relation_port_model.id_equipment_model', '=', $id_equip)
        ->where('relation_port_model.id_port_equipment_model', '=', $id_port)
        ->select('relation_port_model.description_label', 'relation_port_model.id', 'list_module_board.name as board', 'port_equipment_model.id_label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f')->get();
        if ($port[0]->description_label != null) {
            $elemento = explode('#', $port[0]->description_label);
            $contar_eleme = count($elemento);
            foreach ($elemento as $value) {
                $sub_elemeto[] = explode('%', $value);
            }
            $rago[] = '';
            foreach ($sub_elemeto as $sub) {
                   unset($rago);
                for ($z=$sub[1]; $z <=$sub[2] ; $z++) {
                    $rago[] = $z;
                }
                $label[] = array(
                                'board' => $port[0]->board,
                                'con' => $contar_eleme,
                                'letra' => $sub[0],
                                'separado' => $sub[3],
                                'margen' => $rago,
                                'id_label' => $port[0]->id_label,
                                'port_f_i' => $port[0]->port_l_i,
                                'port_f_f' => $port[0]->port_l_f,
                                'placas' => $id_port,
                                );

            }
            return $label;
        }
    }
}
