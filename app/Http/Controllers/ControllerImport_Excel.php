<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Constants;
use Maatwebsite\Excel\Facades\Excel;
use Jarvis\ImportExcel;
use Jarvis\ImportStExcel;
use Jarvis\Imports\PostsImport;
use Jarvis\Imports\StockImport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use DB;
use Carbon\Carbon;
use Jarvis\User;
use Jarvis\Http\Controllers\ControllerRing;
use Jarvis\Http\Requests\RequestImport;

class ControllerImport_Excel extends Controller
{
    #############   AGREGADORES ###############
    public function agg_post(){
        if (!Auth::guest() == false){
           return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(17);
        if ($authori_status['permi'] >= 3) {
            return view('import/agg_excel',compact('authori_status'));
        }else{
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_lis_impor_agg(){
        $data = [];
        $info = DB::table('import_excels')
            ->select('ip', 'hostname', 'interface', 'adminstatus', 'operstatus', 'descripcion', 'nombremodulo', 'descripmodulo', 'date')->get();
        foreach ($info as $value) {
            $data[] = array(
                'ip' => $value->ip,
                'hostname' => $value->hostname,
                'interface' => $value->interface,
                'adminstatus' => $value->adminstatus,
                'operstatus' => $value->operstatus,
                'descripcion' => $value->descripcion,
                'nombremodulo' => $value->nombremodulo,
                'descripmodulo' => $value->descripmodulo,
                'date' => $value->date,
            );
        }
        return datatables()->of($data)->make(true);
    }

    public function import_agg(RequestImport $request){
        if (!Auth::guest() == false){
           return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(17);
        if ($authori_status['permi'] >= 10) {
            DB::table('import_excels')->truncate();
            $excel = $request->file('file');
            Excel::import(new PostsImport, $excel);
            return back();
        }else{
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }

    }

    public function export_agg(){
        return Excel::download(new PostsExport, 'posts.xlsx');
    }

    ############# STOCK SAP ###################
    public function stock_post(){
        $authori_status = User::authorization_status(17);
        if ($authori_status['permi'] >= 3) {
            return view('import/stock_excel',compact('authori_status'));
        }else{
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_lis_impor_stock(){
        $authori_status = User::authorization_status(17);
        if ($authori_status['permi'] < 3) return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);

        $data = [];
        $info = ImportStExcel::all();
        foreach ($info as $value) {
            $data[] = array(
                'tecn' => $value->tecn,
                'marca' => $value->marca,
                'codsap' => $value->codsap,
                'codsap_anterior' => $value->codsap_anterior,
                'descripcion' => $value->descripcion,
                'stock_benavidez' => $value->stock_benavidez,
                'stock_cordoba' => $value->stock_cordoba,
                'stock_mantenimiento' => $value->stock_mantenimiento,
                'stock_proyectos' => $value->stock_proyectos,
                'traslado_origen' => $value->traslado_origen,
                'oc_generada' => $value->oc_generada,
                'stock_mimnimo' => $value->stock_mimnimo,
                'futuro_uso1' => $value->futuro_uso1,
                'futuro_uso2' => $value->futuro_uso2,
                'costo_uss' => $value->costo_uss,
            );
        }
        return datatables()->of($data)->make(true);
    }

    public function import_stock(RequestImport $request){
        if (!Auth::guest() == false){
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(17);
        if ($authori_status['permi'] >= 3) {
            DB::table('import_st_excels')->truncate();
            $excel = $request->file('file');
            Excel::import(new StockImport, $excel);
            DB::table('import_st_excels')->where('codsap', NULL)->delete();
            return back();
        }else{
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function detal_port_equipmen(){
        if (!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(7);
        if ($authori_status['permi'] >= 3) {
            $board = $_POST['board'];
            $port = $_POST['port'];
            $data = [];
            $id_agg = '';
            $info = DB::table('board')
                ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
                ->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
                ->where('board.id', '=', $board)
                ->select('equipment.acronimo', 'list_label.name as label', 'board.slot')->get();
            if (count($info) > 0) {
                $slot = ControllerRing::label_por($info[0]->slot);
                $id_agg = $info[0]->acronimo.'/'.$info[0]->label.$slot.$port;
                $id_agg_corto = $info[0]->acronimo.'/'.substr($info[0]->label, 2).$slot.$port;
                $sql = DB::table('import_excels')
                    ->where('import_excels.idagg', '=', $id_agg)
                    ->orWhere('import_excels.idagg', '=', $id_agg_corto)
                    ->select('*')->get();
                foreach ($sql as $value) {
                    $data[] = array(
                        'adminstatus' => $value->adminstatus,
                        'operstatus' => $value->operstatus,
                        'anillo' => $value->anillo,
                        'nombremodulo' => $value->nombremodulo,
                        'tipomodulo' => $value->tipomodulo,
                        'distancia' => $value->distancia,
                        'descripcion' => $value->descripcion,
                        'date' => $value->date,
                    );
                }
            }
            return array('resul' => 'yes', 'datos' => $data, 'port' => $id_agg,);
        }else{
            return array('resul' => 'autori',);
        }
    }

    // -----------------Funcion para listar stock de productos---------------------------
    public function index(){
        if (!Auth::guest() == false){
           return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
        // if ($authori_status['permi'] >= 3) {
            return view('stock.list',compact('authori_status'));
        // }else{
        //     return redirect('home')
        //         ->withErrors([Lang::get('validation.authori_status'),]);
        // }
    }

    public function index_list(){
        if (!Auth::guest() == false){
           return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        // $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
        // if ($authori_status['permi'] >= 3) {
        $stock = ImportStExcel::all(['id','marca','codsap','descripcion','stock_benavidez','tecn'])
        ->sortBy('codsap');
        return datatables()->of($stock)->make(true);
        // }else{
        //     return redirect('home')
        //         ->withErrors([Lang::get('validation.authori_status'),]);
        // }
    }
}
