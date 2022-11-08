<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Equipment_Model;
use Jarvis\Equipment;
use Jarvis\Client;
use Jarvis\IP;
use Jarvis\User;
use Jarvis\Service_Port;
use Jarvis\Service;
use Jarvis\List_Status_IP;
use Jarvis\Lacp_Port;
use Jarvis\Port;
use Jarvis\Record_ip;
use Jarvis\Board;
use Jarvis\List_Service_Type;
use Jarvis\Function_Equipment_Model;
use Jarvis\List_Down;
use Jarvis\List_Countries;
use Jarvis\Port_Equipment_Model;
use Jarvis\List_Label;
use Jarvis\Http\Controllers\ControllerUser_history;
use Jarvis\Http\Controllers\ControllerAddress;
use Jarvis\Http\Controllers\ControllerEquipment_Model;
use Jarvis\Http\Controllers\ControllerRing;
use Jarvis\Http\Controllers\ControllerIP;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Cache;

class ControllerService extends Controller
{
    public function index(){
    	if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(15);
		if ($authori_status['permi'] >= 3){
			$equipment = Equipment_Model::List();
			$bw = $equipment['bw'];
			$pais = List_Countries::all(['id', 'name'])->sortBy('name');
			$list_service = List_Service_Type::all();
			$status = List_Status_IP::all(['id', 'name'])->where('id','!=',4);
			$functi = Function_Equipment_Model::all(['id', 'name'])->sortBy('name');
			$down = List_Down::all(['id', 'name'])->sortBy('name');
			return view('servicio.list',compact('authori_status', 'bw', 'pais', 'list_service', 'status', 'functi', 'down'));
		}else{
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function list_equipment(){
		if(!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$equip = Cache::remember('key', function () {
		    return DB::table("equipment")
			->join('function_equipment_model', 'equipment.id_function', '=', 'function_equipment_model.id')
			->join('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
			->join('list_mark', 'equipment_model.id_mark', '=', 'list_mark.id')
			->leftJoin('address', 'equipment.address', '=', 'address.id')
			->leftJoin('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
			->leftJoin('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
			->whereNull('equipment.ir_os_down')
			->where('equipment.id_function', '=', $id)
			->select('equipment.id', 'equipment.acronimo', 'equipment.status','function_equipment_model.name', 'equipment_model.model', 'list_mark.name as mark', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'list_countries.name as countries', 'list_provinces.name as provinces')->get();
		});
		$equi_all = [];
		if (count($equip) > 0) {
			foreach ($equip as $value) {
				$direc = $value->countries.' '.$value->provinces.' '.$value->location.' '.$value->street.' '.$value->height;
				if ($value->floor != null) {
					$direc = $direc.' Piso'.$value->floor;
				}
				if ($value->department != null) {
					$direc = $direc.' Departamento'.$value->department;
				}
				$equi_all[] = array(
					'id' => $value->id, 
					'acronimo' => $value->acronimo, 
					'status' => $value->status, 
					'name' => $value->name, 
					'model' => $value->model, 
					'mark' => $value->mark, 
					'direc' => $direc, 
				);
			}
			$resul = 'yes';
		}else{
			$resul = 'no';
		}
		return array('resul' => $resul, 'datos' => $equi_all,);
	}

	public function insert_update_service(){
		if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$authori_status = User::authorization_status(15);
		if ($authori_status['permi'] >= 5) {
			$id=$_POST['id'];
			$service=$_POST['service'];
			$type=$_POST['type'];
			$id_client=$_POST['id_client'];
			$ord=$_POST['ord'];
			$direc_a=$_POST['direc_a'];
			$direc_b=$_POST['direc_b'];
			$bw=$_POST['bw'];
			$come=$_POST['come'];
			$relation=$_POST['servi_relation'];
			$validar = DB::table('service')
				->where('service.number', '=', $service)
				->where('service.status', '=', 'ALTA')
				->where('service.id', '!=', $id)
				->select('service.id')->get();
			if (count($validar) == 0) {
				$bw_service = List_Service_Type::find($type);
				if ($bw_service->require_bw == 'NO') {
					$bw = 2000;
				}
				if ($id <> 0) {
		        	$msj_servi = 'Modifico el servicio ';
		        	$datos = Service::find($id);
			    }else{
			    	if ($authori_status['permi'] >= 10) {
			        	$msj_servi = 'Registro el servicio ';
				        $datos = new Service();
			        }else{
			        	return array('resul' => 'autori', );
			      	}
			    }
				    $datos->number = $service;
					$datos->id_type = $type;
					$datos->bw_service = $bw;
					$datos->commentary = $come;
					$datos->order_high = $ord;
					$datos->id_client = $id_client;
					$datos->id_address_a = $direc_a;
					$datos->id_address_b = $direc_b;
					$datos->status = 'ALTA' ;
					$datos->relation = $relation;
				$datos->save();
				ControllerUser_history::store($msj_servi.$datos->number);  
				return array('resul' => 'yes',);
			}else{
				return array('resul' => 'exis',);
			}
		}else{
			return array('resul' => 'autori', );
		}
	}

	public function index_list(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(15);
		if ($authori_status['permi'] >= 3) {
			$datos = [];
			$service = DB::table('service')
			->leftJoin('list_service_type', 'service.id_type', '=', 'list_service_type.id')
			->leftJoin('client', 'client.id', '=', 'service.id_client')
			->select('client.business_name', 'list_service_type.name', 'service.id_type', 'service.number', 'service.bw_service', 'service.order_high', 'service.order_down', 'service.created_at', 'service.id', 'list_service_type.require_ip', 'service.status', 'service.relation')
			->orderBy('service.created_at', 'desc')->get();
			foreach ($service as $value) {
				$bw = ControllerEquipment_Model::format_bw($value->bw_service);
				$number = $value->number;
				if ($value->relation != null) {
                    $number = $number.' ('.$value->relation.')';
                }
				$datos[] = array(
					'business_name' => $value->business_name, 
					'name' => $value->name, 
					'number' => $number, 
					'bw_service' => $bw['data'].$bw['signo'], 
					'order_high' => $value->order_high, 
					'order_down' => $value->order_down, 
					'created_at' => $value->created_at, 
					'id' => $value->id, 
					'require_ip' => $value->require_ip, 
					'status' => $value->status, 
					'relation' => $value->relation,
					'type' => $value->id_type
				);
			}
        	return datatables()->of($datos)->make(true);
        }else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function index_list_select(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(15);
		if ($authori_status['permi'] >= 3) {
			$datos = [];
			$service = DB::table('service')
			->leftJoin('list_service_type', 'service.id_type', '=', 'list_service_type.id')
			->leftJoin('client', 'client.id', '=', 'service.id_client')
			->where('service.status', '=', 'ALTA')
			->select('client.business_name', 'list_service_type.id as type_id', 'list_service_type.name', 'service.number', 'service.bw_service', 'service.order_high', 'service.order_down', 'service.created_at', 'service.id', 'list_service_type.require_ip', 'service.status', 'service.relation')->orderBy('service.created_at', 'desc')->get();
			foreach ($service as $value) {
				$bw = ControllerEquipment_Model::format_bw($value->bw_service);
				$relation = '';
				if ($value->relation != null) {
					$relation = ' ('.$value->relation.')';
				}
				$datos[] = array(
					'business_name' => $value->business_name, 
					'name' => $value->name, 
					'number' => $value->number.$relation, 
					'bw_service' => $bw['data'].$bw['signo'],
					'order_high' => $value->order_high, 
					'order_down' => $value->order_down, 
					'created_at' => $value->created_at, 
					'id' => $value->id, 
					'require_ip' => $value->require_ip, 
					'status' => $value->status, 
					'relation' => $value->relation,
					'type_id' => $value->type_id,
				);
			}
        return datatables()->of($datos)->make(true);
        }else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function search_service(){
		if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$authori_status = User::authorization_status(15);
		if ($authori_status['permi'] >= 5) {
			$id=$_POST['id'];
			$datos = Service::find($id);
			$bw = ControllerEquipment_Model::format_bw($datos->bw_service);
			return array('resul' => 'yes', 'datos' => $datos, 'bw' => $bw);
		}else{
			return array('resul' => 'autori', );
		}
	}
    
    public function port_service(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id = $_POST['id'];
    	$id_servivio = $_POST['servivio'];
    	$data_mostrar = [];
    	$port = DB::table('equipment')
		    ->join('board', 'board.id_equipment', '=', 'equipment.id')		    
		    ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
		    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
		    ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		    ->where('equipment.id', '=', $id)
		    ->where('list_port.name', '!=', 'ANTENA')
		    ->where('list_port.name', '!=', 'ODU')
		    ->where('list_port.name', '!=', 'IF')
		    ->where('board.status', '=', 'ACTIVO')
		    ->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'board.slot', 'list_module_board.name as model', 'board.id', 'list_port.name as type')->orderBy('slot', 'asc')->orderBy('port_l_i', 'asc')->get();
		foreach ($port as $val) {
			$fsp_label=ControllerRing::label_por($val->slot);
		    for ($z=$val->port_l_i; $z <= $val->port_l_f; $z++) {
		    	$status_por = DB::table('port')
			    	->Join('status_port', 'port.id_status', '=', 'status_port.id')
			    	->leftJoin('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
					->leftJoin('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
			    	->where('port.id_board', '=', $val->id)
			    	->where('port.n_port', '=', $z)
			    	->select('port.id_status','status_port.name as status', 'port.id_lacp_port', 'lacp_port.lacp_number', 'port.type', 'port.id', 'lacp_port.group_lacp', 'port.commentary')->get(); 
		    	$grupos = '';
		    	$status = '2';
		    	$atributo = 'VACANTE';
		    	$name = '';
		    	$type = '';
		    	$number = '';
		    	$commentary = '';
		    	if (count($status_por) > 0){
			    	$status = $status_por[0]->id_status;
			    	$atributo = $status_por[0]->status;
			    	$type = $status_por[0]->type;
					if ($status_por[0]->group_lacp == 'SI') {
		    			$atributo = 'LACP | '.$status_por[0]->lacp_number;
		    			$dividir_grupo = explode('-', $status_por[0]->lacp_number);
		    			$name = $dividir_grupo[1];
		    			$number = '';
		    		}else{
		    			$number = ControllerService::number_service($z, $val->id);
		    		}
		    		if ($status_por[0]->commentary != '' && $status_por[0]->commentary != null) {
		    			$commentary = $status_por[0]->commentary;
		    		}
		    	}
		    	$data_mostrar[] = array(
			    	'f_s_p' => $fsp_label, 
			    	'por_selec' => $z, 
			    	'label' => $val->label, 
			    	'model' => $val->model, 
			    	'atributo' => $atributo, 
			    	'group' => $name,
			    	'type' => $type,
			    	'type_port' => $val->type,
			    	'service' => $number,
			    	'id' => $z.'~'.$val->id,
			    	'board' => $val->id,
			    	'commentary' => $commentary,
			    );
		    }
		}
		if (count($data_mostrar) > 0) {
			$port_order  = array_column($data_mostrar, 'por_selec');
			$pose_order  = array_column($data_mostrar, 'f_s_p');
			array_multisort($pose_order, SORT_ASC,$port_order,SORT_ASC,$data_mostrar);
		}
		$grupos_equipos = DB::table("lacp_port")
				->join('port', 'port.id_lacp_port', '=', 'lacp_port.id')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->where('lacp_port.group_lacp', '=', 'SI')
				->where('equipment.id', '=', $id)
				->where('board.status', '=', 'ACTIVO')
				->select('lacp_port.lacp_number','lacp_port.id')->groupBy('lacp_port.lacp_number','lacp_port.id')->get();
		$group_equipmen = [];
		foreach ($grupos_equipos as $value) {
			$id_group = DB::table("lacp_port")
				->join('port', 'port.id_lacp_port', '=', 'lacp_port.id')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
        		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->where('lacp_port.id', '=', $value->id)
				->select('board.slot', 'port.n_port', 'list_label.name', 'lacp_port.commentary', 'board.id')->orderBy('n_port', 'asc')->get();
			$atributo = 'LACP: ';
			foreach ($id_group as $valor) {
				$fsp = ControllerRing::label_por($valor->slot);
				$atributo =$atributo.$valor->name.$fsp.$valor->n_port.' -';				
			}
			$atributo = substr($atributo, 0, -2);
			$number = ControllerService::number_service($id_group[0]->n_port, $id_group[0]->id);
			$group_equipmen[] = array(
				'name' => $value->lacp_number, 
				'grupo' => $value->lacp_number, 
				'atributo' => $atributo, 
				'number' => $number, 
				'id_group' => $value->id, 
				'commentary' => $id_group[0]->commentary, 
				'port' => $id_group[0]->n_port.'~'.$id_group[0]->id, 
			);
		}
		return array(	'resul' => 'yes', 'datos' => $data_mostrar, 'grupo' => $group_equipmen,);
    }

    public static function number_service($port, $board){
    	$resulta = '';
		$infor = DB::table('service')
			->join('service_port', 'service_port.id_service', '=', 'service.id')
			->Join('lacp_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
			->join('port', 'port.id_lacp_port', '=', 'lacp_port.id')
			->where('port.id_board', '=', $board)
			->where('port.n_port', '=', $port)
			->select('service.number')->get();
		if (count($infor) > 0){
			foreach ($infor as $val) {
				if ($resulta == '') {
					$resulta = $val->number;
				} else {
					$resulta = $resulta.' | '.$val->number;
				}
			}
		}
		return $resulta;
    }

    public function port_service_mostrar(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id = $_POST['id'];
    	$servicio = $_POST['servicio'];
    	$id_port_all = [];
		//return ['resul' => 'nop', 'datos' => $_POST['servicio']];
    	foreach ($id as $value) {
    		$separar = explode('~', $value);
    		$id_por = ControllerService::port_id_new_old($separar[0], $separar[1]);
    		$id_port_all[] = $id_por;
    		$group =Port::find($id_por);
    		if ($group->id_lacp_port != null && $group->id_lacp_port != '' ) {
    			$port_group = DB::table('port')
    				->join('lacp_port', 'port.id_lacp_port', '=', 'lacp_port.id')
    				->join('board', 'port.id_board', '=', 'board.id')
    				->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
					    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
					    ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		    		->where('port.id_lacp_port', '=', $group->id_lacp_port)
				    ->select('board.id_equipment', 'port.id', 'lacp_port.group_lacp', 'list_label.name as label', 'board.slot', 'list_module_board.name as model', 'port.n_port', 'lacp_port.lacp_number')->get();
				    $ver = '';
				$id_equi = $port_group[0]->id_equipment;
				foreach ($port_group as $value) {
					$slot = ControllerRing::label_por($value->slot);
					$ver = $ver.$value->label.$slot.$value->n_port.' ';
				}
				if ($port_group[0]->group_lacp == 'SI') {
					$data = "LACP: '".$port_group[0]->lacp_number."' ".$ver;
				}else{
					$data = $ver;
				}
    		}else{
	    		$port_sql_new = DB::table('board')	    
			    ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
			    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			    ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
			    ->join('port', 'port.id_board', '=', 'board.id')
			    ->where('port.id', '=', $id_por)
			    ->select('board.id_equipment', 'list_label.name as label', 'board.slot', 'list_module_board.name as model', 'port.n_port')->orderBy('slot', 'asc')->get();
			    $slot = ControllerRing::label_por($port_sql_new[0]->slot);
				$data = $port_sql_new[0]->label.$slot.$port_sql_new[0]->n_port.' ';
				$id_equi = $port_sql_new[0]->id_equipment;
    		}
		    $all[] = array(
		    	'port' => $data,  
		    	'id' => $id_por,  
		    );
    	}
    	$bw_port = 0;
    	$bw_service_all_max = 0;
    	$bw_anillo = 0;
    	$service_bw = Service::find($servicio);
    	$bw_service = $service_bw->bw_service;
    	$anillo =DB::table('port')
			->join('board', 'port.id_board', '=', 'board.id')
			->join('ring', 'port.id_ring', '=', 'ring.id')
			->where('board.id_equipment', '=', $id_equi)
			->select('ring.id', 'ring.bw_limit')->groupBy('ring.id', 'ring.bw_limit')->get();
    	$bw_all = DB::table('port_equipment_model')
			->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
			->join('port', 'port.id_board', '=', 'board.id')
    		->whereIn('port.id', $id_port_all)
			->select(DB::raw("SUM(port_equipment_model.bw_max_port) as bw"))->get();
		$bw_service_all = DB::table('service')
			->join('service_port', 'service_port.id_service', '=', 'service.id')
			->join('port', 'port.id_lacp_port', '=', 'service_port.id_lacp_port')
    		->whereIn('port.id', $id_port_all)
    		->where('service.id', '!=', $servicio)
			->select(DB::raw("SUM(service.bw_service) as service"))->get();
    	$msj_maxi = 0;
    	$msj = 0;
    	$msj_anillo = 0;
		$utilizado = 0;
		if ($bw_service_all[0]->service != null) {
			$bw_service_all_max = $bw_service_all[0]->service;
		}
    	if ($bw_all[0]->bw != null && $bw_all[0]->bw != '') {
    		$bw_port = $bw_all[0]->bw;
    	}
    	if ($bw_port >= $bw_service) {
    		$msj = 1;
    	}
    	if ($bw_port >= $bw_service_all_max) {
    		$msj_maxi = 1;
    	}
    	if (count($anillo) > 0) {
			$bw_anillo = $anillo[0]->bw_limit;
			$equipo =DB::table('port')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->where('port.id_ring', '=', $anillo[0]->id)
				->select('equipment.id', 'equipment.id_function')->groupBy('equipment.id', 'equipment.id_function')->get();
			if (count($equipo) > 0) {
				foreach ($equipo as $val) {
					if ($val->id_function != 1) {
						$bw_ocupado =DB::table('port')
							->join('board', 'port.id_board', '=', 'board.id')
							->leftJoin('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
							->leftJoin('service_port','lacp_port.id', '=', 'service_port.id_lacp_port')
							->leftJoin('service', 'service.id', '=', 'service_port.id_service')
							->where('board.id_equipment', '=', $val->id)
							->where('service.id', '!=', $servicio)
							->select(DB::raw("SUM(service.bw_service) as bw"))->get();
						if (count($bw_ocupado) > 0) {
							$utilizado = $utilizado + $bw_ocupado[0]->bw;
						}
					}
				}
			}
			if ($utilizado + $bw_service < $bw_anillo) {
    			$msj_anillo = 1;
    		}
		}else{
			$msj_anillo = 1;
		}
    	return array('resul' => 'yes', 'datos' => $all, 'msj' => $msj, 'msj_max' => $msj_maxi, 'msj_anillo' => $msj_anillo,);
    }

    public static function port_id_new_old($port, $board){
    	$puerto = DB::table('port')
    		->where('port.id_board', '=', $board)
		    ->where('port.n_port', '=', $port)
		    ->select('port.id')->get();
		if (count($puerto)>0) {
			$id = $puerto[0]->id;
		}else{
			$port_new = new Port();
				$port_new->id_board = $board;
				$port_new->n_port = $port;
				$port_new->id_status = 2;
		    $port_new->save();
		    $id = $port_new->id;
		}
		return $id;
    }

    public function type_service(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id=$_POST['id'];
    	$service = DB::table('service')
		->leftJoin('list_service_type', 'service.id_type', '=', 'list_service_type.id')
		->where('service.id', '=', $id)
		->select('list_service_type.name','list_service_type.require_ip', 'list_service_type.require_rank')->get();
		return array('resul' => 'yes', 'datos' => $service[0],);
    }

    public function list_ip_service(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id=$_POST['id'];
    	$ip_envia = [];
    	$service_type = DB::table('service')
    		->join('list_service_type', 'service.id_type', '=', 'list_service_type.id')
    		->where('service.id', '=', $id)
    		->select('require_ip','require_rank')->get();
    	if (strtoupper($service_type[0]->require_rank) == 'SI') {
		    $ip_servi = DB::table('ip')
				->where('ip.id_service', '=', $id)
				->where('ip.type', '=', 'RED')
				->select('ip.id','ip.ip', 'ip.prefixes', 'ip.type', 'ip.id_branch')
				->groupBy('ip.id','ip.ip', 'ip.prefixes', 'ip.type', 'ip.id_branch')->get();
			foreach ($ip_servi as $value) {
				$ip_envia[] = array(
					'id' => $value->id, 
					'ip' => $value->ip.'/'.$value->prefixes, 
					'type' => 'Rango Público',
				);
			}
    	}
    	if (strtoupper($service_type[0]->require_ip) == 'SI') {
			$ip_wan = DB::table('service')
				->join('service_port', 'service_port.id_service', '=', 'service.id')
				->join('lacp_port', 'service_port.id_lacp_port', '=', 'lacp_port.id')
				->join('port', 'port.id_lacp_port', '=', 'lacp_port.id')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->join('ip', 'ip.id_equipment_wan', '=', 'equipment.id')
				->where('service.id', '=', $id)
				->select('equipment.id','ip.id','ip.ip','ip.prefixes','ip.type','ip.id_branch')
				->groupBy('equipment.id','ip.id','ip.ip','ip.prefixes','ip.type','ip.id_branch')
				->get();
			foreach ($ip_wan as $val) {
				$ip_envia[] = array(
					'id' => $val->id, 
					'ip' => $val->ip.'/'.$val->prefixes, 
					'type' => 'IP WAN',
				);
			}
		}
		return array('resul' => 'yes', 'datos' => $ip_envia,);
    }
    public function delete_ip_service(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id=$_POST['id'];
    	$IP_sele =IP::find($id);
    	$service = $IP_sele->id_service;
	    $Service_info = Service::find($service);
    	if ($IP_sele->type == 'RED') {
    		$ran_ip = ControllerIP::rango($IP_sele->ip.'/'.$IP_sele->prefixes);
			$ini_fin_ip = ControllerIP::ipv4_ini_fin($IP_sele->ip.'/'.$IP_sele->prefixes);
			$ip_array[] = array(
				'ip' => $ini_fin_ip['inicio'], 
				'rama' => $IP_sele->id_branch, 
			);
			foreach ($ran_ip as $valores) {
				$ip_array[] = array(
					'ip' => $valores, 
					'rama' => $IP_sele->id_branch, 
				);
			}
			$ip_array[] = array(
				'ip' => $ini_fin_ip['fin'],
				'rama' => $IP_sele->id_branch, 
			);
			foreach ($ip_array as $all){
				$ip_info_id = DB::table('ip')
					->where('ip.ip', '=', $all['ip'])
					->where('ip.id_branch', '=', $all['rama'])
					->select('ip.id')->get();
				$ip_mdificar =IP::find($ip_info_id[0]->id);
					if ($ip_mdificar->id_equipment == null && $ip_mdificar->id_client == null && $ip_mdificar->id_use_vlan == null) {
	    				$ip_mdificar->id_status = 1;
	    			}
			    	$ip_mdificar->id_service = null;
		    	$ip_mdificar->save();
				$recor = new Record_ip();
					$recor->id_ip = $ip_mdificar->id;
					$recor->prefixes = $ip_mdificar->prefixes;
					$recor->attribute = 'La IP fue liberada del servicio '.$Service_info->number;
					$recor->id_user= Auth::user()->id;
				$recor->save();
			}
			$msj_info = 'Libero rango IP del servicio ';
			$resul = 'yes';
    	}else{
	    	if ($IP_sele->id_equipment == null && $IP_sele->id_client == null && $IP_sele->id_use_vlan == null && $IP_sele->id_equipment_wan == null) {
	    		$IP_sele->id_status = 1;
	    		$IP_sele->id_service = null;
	    		$IP_sele->save();
	    		$msj_info = 'Libero IP WAN del servicio ';
	    		$resul = 'yes';
	    		$recor = new Record_ip();
					$recor->id_ip = $ip_mdificar->id;
					$recor->prefixes = $ip_mdificar->prefixes;
					$recor->attribute = 'La IP WAN fue liberada del servicio '.$Service_info->number;
					$recor->id_user= Auth::user()->id;
				$recor->save();
    		}else{
    			$resul = 'nop';
    		}
    	}
    	if ($resul == 'yes') {
			ControllerUser_history::store($msj_info.$Service_info->number);
    	}
    	return array('resul' => $resul, 'datos' => $service,);
    }

    public function ip_rank_new_servi(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id = $_POST['id'];
    	$servicio = $_POST['servicio'];
    	$res = 'SI';
    	$ip_sql =IP::find($id);
    	$Service_info = Service::find($servicio);
    	$ran_ip = ControllerIP::rango($ip_sql->ip.'/'.$ip_sql->prefixes);
		$ini_fin_ip = ControllerIP::ipv4_ini_fin($ip_sql->ip.'/'.$ip_sql->prefixes);
		$ip_all[] = array(
				'ip' => $ini_fin_ip['inicio'], 
				'rama' => $ip_sql->id_branch, 
			);
		foreach ($ran_ip as $valores) {
			$ip_all[] = array(
				'ip' => $valores, 
				'rama' => $ip_sql->id_branch, 
			);
		}
		$ip_all[] = array(
				'ip' => $ini_fin_ip['fin'],
				'rama' => $ip_sql->id_branch, 
		);
		foreach ($ip_all as $rank){
			$ip_indivi = DB::table('ip')
				->where('ip.ip', '=', $rank['ip'])
				->where('ip.id_branch', '=', $rank['rama'])
				->select('ip.id', 'ip.id_status')->get();
			$id_ip_all[] = $ip_indivi[0]->id;
			if ($ip_indivi[0]->id_status == 2) {
				$res = 'NO';
			}
		}
		if ($res == 'NO') {
			$resulta = 'exis';
		}else{
			foreach ($id_ip_all as $valu) {
				$ip_yes =IP::find($valu);
					$ip_yes->id_status = 2;
					$ip_yes->id_service = $servicio;
					$ip_yes->assignment = null;
				$ip_yes->save();
				$recor = new Record_ip();
					$recor->id_ip = $ip_yes->id;
					$recor->prefixes = $ip_yes->prefixes;
					$recor->attribute = 'La ip fue asignada al servicio '.$Service_info->number;
					$recor->id_user= Auth::user()->id;
				$recor->save();
			}
			ControllerUser_history::store('Agrego nuevo rango IP al servicio '.$Service_info->number);
			$resulta = 'yes';
		}
		return array('resul' => $resulta,);
    }

    public function vlan_new_servi(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$authori_status = User::authorization_status(15);
		if ($authori_status['permi'] >= 5){
	    	$vlan=$_POST['vlan'];
	    	$port=$_POST['port'];
	    	$sql =Service_Port::find($port);
	    	$validar = DB::table("service_port")
		    	->where('service_port.vlan', '=', $vlan)
		    	->where('service_port.id_lacp_port', '=', $sql->id_lacp_port)
		    	->where('service_port.id_service', '!=', $sql->id_service)
				->select('service_port.id')->get();
			if (count($validar) == 0) {
				$vlan_new =Service_Port::find($port);
					$vlan_new->vlan = $vlan;
				$vlan_new->save();
				$Service = Service::find($vlan_new->id_service);
				ControllerUser_history::store('Modifico vlan del servicio '.$Service->number);
				$resulta = array('resul' => 'yes', 'datos' => $sql->id_service,);
			}else{
				$resulta = array('resul' => 'exis',);
			}
		}else{
			$resulta = array('resul' => 'autori',);
		}
		return $resulta;
    }

    public function down_service(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$authori_status = User::authorization_status(15);
		if ($authori_status['permi'] >= 5){
	    	$id = $_POST['id'];
	    	$down = $_POST['down'];
	    	ControllerService::ip_wan_equi_servi($id);
	    	$service = Service::find($id);
	    	if ($service->status == 'ALTA') {
		    		$service->order_down = $down;
					$service->status = 'BAJA';
				$service->save();
				ControllerService::ip_port_free($id);
				ControllerUser_history::store('Baja del servicio '.$service->number);
				$resul = "yes";
	    	}else{
	    		$resul = "nop";
	    	}
			return array('resul' => $resul, );
    	}else{
    		return array('resul' => 'autori', );
    	}
    }

    public function ip_wan_equi_servi($id){
    	$equipment = DB::table("service_port")
	    	->join('port', 'service_port.id_lacp_port', '=', 'port.id_lacp_port')
	    	->join('board', 'board.id', '=', 'port.id_board')
			->where('service_port.id_service', '=', $id)
			->select('board.id_equipment')->groupBy('board.id_equipment')->get();
		foreach ($equipment as $value) {
			$validar = DB::table("board")
				->join('port', 'board.id', '=', 'port.id_board')
				->join('service_port', 'service_port.id_lacp_port', '=', 'port.id_lacp_port')
				->where('board.id_equipment', '=', $value->id_equipment)
				->select('board.id_equipment')->get();
			if (count($validar) == 0) {
				$ip_sql = DB::table("ip")
					->where('ip.id_equipment_wan', '=', $value->id_equipment)
					->select('ip.id')->get();
				foreach ($ip_sql as $valor) {
					$ip_sql= IP::find($valor->id);
					$ip_new = IP::find($valor->id);
						if ($ip_sql->id_equipment == null) {
							$ip_new->id_status = 1;
						}
						$ip_new->id_client = null;
						$ip_new->id_equipment_wan = null;
						$ip_new->assignment = null;
					$ip_new->save();
				}
			}
		}
    }

    public function ip_port_free($id){
    	$buscar_servi = DB::table("service_port")
    		->join('service', 'service_port.id_service', '=', 'service.id')
		    ->where('service_port.id_service', '=', $id)
			->select('service_port.id','service_port.id_lacp_port')->get();
		foreach ($buscar_servi as $value) {
			$id_lacp_port = $value->id_lacp_port;
			$service_old = Service_Port::find($value->id);
	        $service_old->delete();
	        $validar = DB::table("service_port")
			    ->where('service_port.id_lacp_port', '=', $id_lacp_port)
				->select('service_port.id_lacp_port')->get();
			if (count($validar) == 0) {
				$buscar = DB::table("port")
				    ->where('port.id_lacp_port', '=', $id_lacp_port)
					->select('port.id')->get();
				foreach ($buscar as $val) {
					$por = Port::find($val->id);
						$por->id_status = 2;
						$por->commentary = null;
						$por->type = null;
						$por->id_lacp_port = null;
					$por->save();
				}
			}
		}
		$buscar_ip = DB::table("ip")
		    ->where('ip.id_service', '=', $id)
			->select('ip.id','ip.id_equipment','ip.id_client','ip.id_use_vlan', 'ip.id_service')->get();
		$number_service = Service::find($id, ['number']);
		foreach ($buscar_ip as $var) {
			$ip_old = IP::find($var->id);
				if ($ip_old->id_equipment == null && $ip_old->id_equipment_wan == null) {
					$ip_old->id_status = 1;
				}
				$ip_old->id_service = null;
				$ip_old->id_client = null;
				$ip_old->assignment = null;
			$ip_old->save();
			$recor = new Record_ip();
				$recor->id_ip = $ip_old->id;
				$recor->prefixes = $ip_old->prefixes;
				$recor->attribute = 'La ip fue liberada del servicio '.$number_service->number;
				$recor->id_user= Auth::user()->id;
			$recor->save();
		}
    }

    public function cancel_service(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$authori_status = User::authorization_status(15);
		if ($authori_status['permi'] >= 5){
	    	$id=$_POST['id'];
	    	$mot=$_POST['mot'];
	    	ControllerService::ip_wan_equi_servi($id);
	    	$service = Service::find($id);
	    	if ($service->status == 'ALTA') {
					$service->status = 'CANCELAR';
					$service->list_down = $mot;
				$service->save();
				ControllerService::ip_port_free($id);
				ControllerUser_history::store('Cancelo el servicio '.$service->number);  
				$resul = "yes";
	    	}else{
	    		$resul = "nop";
	    	}
			return array('resul' => $resul, );
    	}else{
    		return array('resul' => 'autori', );
    	}
    }

    public function search_bw_service_list(){
      if (!Auth::guest() == false){ return array('resul' => 'login', );}
        $id=$_POST['id'];
        $Type = List_Service_Type::find($id);
        return array('resul' => 'yes', 'datos' => $Type,);
    }
	
	public static function service_selec(){
	    if (!Auth::guest() == false){ return array('resul' => 'login', ); }
	    $authori_status = User::authorization_status(15);
	    if ($authori_status['permi'] >= 3) {
	      	$id = $_POST['id'];
	      	$service = Service::find($id, ['number', 'bw_service']);
	      	if ($service->exists()) {
	        	$datos = $service->number;
				$bw_service = $service->bw_service;
	        	$resul = array('resul' => 'yes', 'datos' => $datos, 'bw_service'=> $bw_service);
	      	}else{
	        	$resul = array('resul' => 'nop', );
	      	}
	      	return $resul;
	    }else{
	        return array('resul' => 'autori',);
	    }
  	}

  	public function index_list_ip(){
	    if (!Auth::guest() == false){ 
	        return redirect('login')->withErrors([Lang::get('validation.login'),]);
	    }
	    $authori_status = User::authorization_status(16);
	    if ($authori_status['permi'] >= 3) {
	      	$Equipment_Model =DB::table('equipment')
			->join('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
			->leftJoin('address', 'equipment.address', '=', 'address.id')
			->leftJoin('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
			->leftJoin('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
			->join('function_equipment_model', 'equipment.id_function', '=', 'function_equipment_model.id')
			->Join('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
	        ->Join('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
	        ->leftJoin('client', 'client.id', '=', 'equipment.id_client')
	        ->leftJoin('node', 'node.id', '=', 'equipment.id_node')
	        ->leftJoin('ip', 'equipment.id', '=', 'ip.id_equipment')
	        ->select('equipment.id', 'list_mark.name as mark', 'list_equipment.name as equipment', 'equipment_model.model', 'equipment.status', 'equipment.commentary', 'function_equipment_model.name as function', 'equipment.address', 'node.node', 'node.cell_id', 'client.business_name as client', 'equipment.acronimo', 'ip.ip as admin', 'equipment.ip_wan_rpv as ip_equipment', 'equipment_model.bw_max_hw', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code', 'list_countries.name as countries', 'list_provinces.name as provinces', 'equipment_model.id as img', 'equipment.service')->orderBy('model', 'asc')->get();
	        $all =[];
	        foreach ($Equipment_Model as $value) {
	        	$dire = $value->street.' '.$value->height;
	        	if ($value->department != null) {
	        		$dire = $dire.' Depto'.$value->department;
	        	}
	        	if ($value->floor != null) {
	        		$dire = $dire.' Piso'.$value->floor;
	        	}
	        	$dire = $dire.' '.$value->location.' '.$value->provinces.' '.$value->countries;
	        	$all[] = array(
	        		'id' => $value->id, 
	        		'mark' => $value->mark, 
	        		'equipment' => $value->equipment, 
	        		'service' => $value->service, 
	        		'model' => $value->model, 
	        		'status' => $value->status, 
	        		'commentary' => $value->commentary, 
	        		'function' => $value->function, 
	        		'address' => $dire, 
	        		'node' => $value->node, 
	        		'cell_id' => $value->cell_id, 
	        		'client' => $value->client, 
	        		'acronimo' => $value->acronimo, 
	        		'admin' => $value->admin, 
	        		'ip_equipment' => $value->ip_equipment, 
	        		'bw_max_hw' => $value->bw_max_hw,  
	        		'img' => $value->img,  
	        	);
	        }
	        return datatables()->of($all)->make(true);
	        }else{
	      return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
	    }
  	}

  	public function list_ip_service_all($data){
	    if (!Auth::guest() == false){ 
	        return redirect('login')->withErrors([Lang::get('validation.login'),]);
	    }
	   	$all = [];
	   	$slq_id = DB::table('ip')->where('ip.id_service', '=', $data)->select('id')->get();
	   	foreach ($slq_id as $valor) {
	   		$id_full[] = $valor->id;
	   	}
	   	if (count($slq_id) > 0) {
	   		$all = ControllerIP::info_ip_filtro($id_full);
	    }
	    return datatables()->of($all)->make(true);
	  }

	public function getAllServices() 
	{
		// logic to get all Services goes here
		$services = Service::get()->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
		return response($services, 200);
	}
	public function getService($number)
	{
		if (Service::where('number', $number)->exists()) {
			$service = Service::where('number', $number)->get();
		
			$arraySlots = [];
			$arrayEquipos = [];
			$datos = [];
			$arrayCapacidad = [];

			$client_rs = 'N/D';

			$info = DB::table("service")
			->join('client', 'client.id', '=', 'service.id_client')
			->join('list_service_type', 'service.id_type', '=', 'list_service_type.id')
			->join('service_port', 'service_port.id_service', '=', 'service.id')
			->Join('lacp_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
			->join('port', 'port.id_lacp_port', '=', 'lacp_port.id')
			->join('board', 'port.id_board', '=', 'board.id')
			->join('equipment', 'board.id_equipment', '=', 'equipment.id')
			->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
			->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
			->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			->where('service.id', '=', $service[0]->id)
			->whereNull('lacp_port.lacp_number')
			->select('equipment.acronimo', 'board.slot', 'port.n_port', 'service.id', 'equipment.id as equipo', 'list_service_type.require_ip', 'list_label.name', 'service_port.id as s_por', 'service_port.vlan', 'lacp_port.commentary', 'port.id as port_id', 'lacp_port.id as lacp', 'ip.ip', 'ip.prefixes', 'equipment.ip_wan_rpv', 'client.business_name as razon_social', 'port_equipment_model.bw_max_port')->get();


			foreach ($info as $value) {
				$fsp_label = ControllerRing::label_por($value->slot);
				$vlan = '';
				$commentary = '';
				$port_id = '';
				$client_rs = $value->razon_social;
				
				if ($value->vlan != null) {
					$vlan = $value->vlan;
				}
				if ($value->commentary != null) {
					$commentary = $value->commentary;
				}
				if ($value->port_id != null) {
					$port_id = $value->port_id;
				}

				if(isset($value->bw_max_port)){
					array_push($arrayCapacidad, ControllerEquipment_Model::format_bw($value->bw_max_port));
				}
				array_push($arraySlots , $value->name.$fsp_label.$value->n_port);
				array_push($arrayEquipos, $value->acronimo.' - '.$value->ip.'/'.$value->prefixes);

				$datos[] = array(
					'slot' => $value->name.' '.$fsp_label, 
					'acronimo' => $value->acronimo.' - '.$value->ip.'/'.$value->prefixes, 
					'n_port' => $value->n_port, 
					'id' => $service[0]->id, 
					'port' => $value->s_por, 
					'equipo' => $value->equipo, 
					'require_ip' => $value->require_ip,
					'group' => '', 
					'id_group' => $value->lacp,
					'port_id' => $port_id, 
					'vlan' => $vlan, 
					'fsp' => $fsp_label, 
					'commentary' => $commentary,
				);
			}

			return response()->json([
				'nroService' 	=> $service[0]->number,
				'acronimos' 	=> $arrayEquipos,
				'boardSlot' 	=> $arraySlots,
				'bandwidth' 	=> $service[0]->bw_service,
				'razonSocial'	=> $client_rs,
				'capacidad'		=> $arrayCapacidad,
				'vlan' 			=> $vlan,
			]);
		}else {
			return response()->json([
			  "message" => "Numero de servicio no encontrado"
			], 404);
		}
	}
	
	public function createService(Request $request)
	{
		// logic to create a Service record goes here
		return False;
	}
	public function updateServiceVlan(Request $req)
	{
		$vlan = $req->vlan;

		//$lacp = DB::table('lacp_port')->where('lacp_number', $req->input('lacpNumber'))->get('id');
		$service = DB::table('service')->where('number', $req->input('serviceNumber'))->get();

		if(count($service)>0){
			DB::table('service_port')
              // ->where('id_lacp_port', $lacp[0]->id)
			  ->where('id_service', $service[0]->id)
              ->update(['vlan' => $vlan]);

			$resultado = "La vlan en el servicio '" . $service[0]->commentary . " ' ha sido actualizada!";

			return json_encode(array(
				'status' => 200,
				'response' => array(
					'mensaje' => $resultado
					)
				));
		}
		else{
			return json_encode(array(
				'status'=>400,
				'response'=> array(
					'mensaje' => "Los datos ingresados vlan: ". $req->input('vlan')." y service: ". $req->input('serviceNumber') . " no concuerdan con la base de datos"
				)
				));
		}
		
	}
  
	public function deleteService ($id)
	{
		// logic to delete a Service record goes here
		return False;
	}

	public function up_service(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$authori_status = User::authorization_status(15);
		if ($authori_status['permi'] >= 5){
	    	$id=$_POST['id'];
	    	$service = Service::find($id);
				$service->status = 'ALTA';
				$service->list_down = null;
			$service->save();
			ControllerUser_history::store('Alta del servicio '.$service->number); 
			return array('resul' => "yes", );
    	}else{
    		return array('resul' => 'autori', );
    	}
    }

	public static function service_details($id) {
		try {
			if (!Auth::guest() == false) return ['resul' => 'login'];
			$authori_status = User::authorization_status(15);
			if ($authori_status['permi'] < 3) return ['resul' => 'autori'];
			$service = DB::table("service")
				->leftJoin('list_service_type', 'service.id_type', '=', 'list_service_type.id')
				->leftJoin('client', 'service.id_client', '=', 'client.id')
				->leftJoin('service_port', 'service.id', '=', 'service_port.id_service')
				->leftJoin('lacp_port', 'service_port.id_lacp_port', '=', 'lacp_port.id')
				->leftJoin('port', 'lacp_port.id', '=', 'port.id_lacp_port')
				->leftJoin('board', 'port.id_board', '=', 'board.id')
				->leftJoin('equipment', 'board.id_equipment', '=', 'equipment.id')
				->where('service.id', '=', $id)
				->select('service.id_type', 'list_service_type.name', 'service.id_client', 'client.business_name', 'equipment.id as eq_id', 'equipment.id_function', 'equipment.type', 'equipment.client_management')
				->first();
			if (empty($service)) return ['resul' => 'nop', 'datos' => 'No se encontr&oacute; el servicio'];
			if ($service->id_function == 4) {
				if ($service->type == 'Ipran' && in_array($service->client_management, ['No', 'NO', 'no'])) {
					/*
					$link = DB::table('link')
						->join('node', 'link.id_node', '=', 'node.id')
						->join('equipment', 'node.id', '=', 'equipment.id_node')
						->where('equipment.id', '=', $service->eq_id)
						->select('link.id')
						->get();
					*/
					$cell_ports = DB::table('port')
						->join('board', 'port.id_board', '=', 'board.id')
						->join('equipment', 'board.id_equipment', '=', 'equipment.id')
						->where('equipment.id', '=', $service->eq_id)
						->select('port.id as port_id')
						->get();
				} else {
					$rings = DB::table('equipment')
						->join('board', 'equipment.id', '=', 'board.id_equipment')
						->join('port', 'board.id', '=', 'port.id_board')
						->where('equipment.id', '=', $service->eq_id)
						->select('port.id_ring')
						->get();
					$rids = [];
					foreach ($rings as $key => $value) $rids[] = $value->id_ring;
					$rids = array_values(array_unique(array_filter($rids)));
					$cell_eq = DB::table('equipment')
						->join('board', 'equipment.id', '=', 'board.id_equipment')
						->join('port', 'board.id', '=', 'port.id_board')
						->whereIn('port.id_ring', $rids)
						->where('equipment.id_function', '=', 4)
						->where('equipment.type', '=', 'Ipran')
						->whereIn('equipment.client_management', ['No', 'NO', 'no'])
						->select('equipment.id')
						->get();
					$cids = [];
					foreach ($cell_eq as $key => $value) $cids[] = $value->id;
					$cids = array_values(array_unique(array_filter($cids)));
					/*
					$link = DB::table('link')
						->join('node', 'link.id_node', '=', 'node.id')
						->join('equipment', 'node.id', '=', 'equipment.id_node')
						->where('equipment.id', '=', $cell_eq->id)
						->select('link.id')
						->get();
					*/
					$cell_ports = DB::table('port')
						->join('board', 'port.id_board', '=', 'board.id')
						->join('equipment', 'board.id_equipment', '=', 'equipment.id')
						->whereIn('equipment.id', $cids)
						->select('port.id as port_id')
						->get();
				}
				$pids = [];
				foreach ($cell_ports as $key => $value) $pids[] = $value->port_id;
				$pids = array_values(array_unique(array_filter($pids)));
				$uplinks = DB::table('link')
					->join('lacp_port', 'link.id_extreme_2', '=', 'lacp_port.id')
					->join('port', 'lacp_port.id', '=', 'port.id_lacp_port')
					->whereIn('port.id', $pids)
					->select('link.id as uplink_id')
					->first();
				if (empty($cell_ports) || empty($uplinks)) return ['resul' => 'nop', 'datos' => 'Servicio no vinculado a celda. Crear nueva reserva desde cero.'];
			} else {
				return ['resul' => 'nop', 'datos' => 'Servicio no vinculado a equipo. Crear nueva reserva desde cero.'];
			}
			$resul = [
				'resul' => 'yes',
				'type_id' => empty($service->id_type) ? '' : $service->id_type,
				'type_name' => empty($service->name) ? '' : $service->name,
				'client_id' => empty($service->id_client) ? '' : $service->id_client,
				'client_name' => empty($service->business_name) ? '' : $service->business_name,
				'uplink_id' => empty($uplinks->uplink_id) ? '' : $uplinks->uplink_id,
			];
			return $resul;
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e];
		}
  	}
}