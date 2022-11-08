<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Jarvis\Http\Controllers\ControllerLacp_Port;
use Session;
use Illuminate\Support\Facades\DB;
use Exception;
use Jarvis\Port;
use Jarvis\User;
use Jarvis\Equipment;
use Jarvis\Lacp_Port;
use Jarvis\Service_Port;
use Jarvis\Board;
use Jarvis\Ring;
use Jarvis\Http\Controllers\ControllerUser_history;
use Jarvis\Http\Controllers\ControllerRing;
use Jarvis\Http\Controllers\ControllerEquipment_Model;
class ControllerPort extends Controller
{
    public function port_lanswitch_selec(){
    	if (!Auth::guest() == false){ return array('resul' => 'login', );}
		if (empty($_POST['anilo'])) return ['resul' => 'nop', 'datos' => "Debe seleccionar un anillo"];
		if (empty($_POST['placa'])) return ['resul' => 'nop', 'datos' => "Debe seleccionar una placa"];
    	$anilo = $_POST['anilo'];
    	$placa = $_POST['placa'];
		try {
			$ring = Ring::find($anilo, ['bw_limit', 'name']);
			$port_all[] = '';
			$port_bw = DB::table('port')->join('board', 'port.id_board', '=', 'board.id')
				->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->where('port.id_ring', '=', $anilo)->select('bw_max_port')->get();
			foreach ($placa as $val) {
				$dividir = explode(',', $val);
				  $port = DB::table('port_equipment_model')
				->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
				->where('port_equipment_model.id', '=', $dividir[0])
				->where('port_equipment_model.bw_max_port', '=', $port_bw[0]->bw_max_port)
				->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_port.name as type')->orderBy('port_l_i', 'asc')->get();
				if (count($port)>0) {
					if ($port_all[0] == '') { unset($port_all);}
					for ($z=$port[0]->port_l_i; $z <= $port[0]->port_l_f; $z++) {
						$fsp_label=ControllerRing::label_por($dividir[1]);
						$port_all[] = array(
							'id' =>  $dividir[0],
							'label' => $port[0]->label,
							'type' => $port[0]->type,
							'port' => $z,
							'slot' => $fsp_label,
							'pose' => $fsp_label.$z,
						);
					}
				}
			}
			if ($port_all[0] == '') {
				return array('resul' => 'nop');
			}
			$anillo_n = DB::table("equipment")
				->join('board', 'board.id_equipment', '=', 'equipment.id')
				->join('port', 'port.id_board', '=', 'board.id')
				->where('port.id_ring', '=', $anilo)
				->where('equipment.id_function', '=', 1)
				->select('port.id')
				->groupBy('port.id')->get();
			$pose_order  = array_column($port_all, 'slot');
			$port_order  = array_column($port_all, 'port');
			array_multisort($pose_order, SORT_ASC, $port_order, SORT_ASC,$port_all);
			return array('resul' => 'yes', 'datos' => $port_all, 'coun' => count($anillo_n), 'ring' => $ring, );
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => 'Error con el servidor'];
		}
	}

    public function inf_equip_port_detailed (Request $request)
    {
        if (!Auth::guest() == false){ return array('resul' => 'login', );}

        //lacp de los equipos
        $lacp_group_a = ControllerLacp_Port::all_lacp_equipmen($request->id_a);
        $lacp_group_b = ControllerLacp_Port::all_lacp_equipmen($request->id_b);

        if ($lacp_group_a && $lacp_group_b) {
            $resul = "yes";
            return array(
                'resul'  => $resul,
                'lacp_a' => $lacp_group_a,
                'lacp_b' => $lacp_group_b);
        }else{
            return $resul = "nop";
        }
    }

    public static function get_lacp_groups_of_equipment($equipment_id)
    {
        if (!Auth::guest() == false){ return array('resul' => 'login', );}

        return ControllerLacp_Port::all_lacp_equipmen($equipment_id);
    }

	public function inf_equip_port($id_dashboard = null){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		if(!empty($id_dashboard)){
			$id = $id_dashboard;
		} else{
			$id = $_POST['id'];
		}
		$equip = Equipment::find($id);
		switch ($equip->id_function) {
	    	case '1': $valida = 7; break;
	    	case '2': $valida = 8; break;
	    	case '3': $valida = 9; break;
	    	case '4': $valida = 13; break;
			case '5': $valida = 19;	break;
	    	case '6': $valida = 20;	break;
	    	case '7': $valida = 23;	break;
			//Lo mismo aca, pasa en ControllerEquipment::equipment();
			case '8': $valida = 27;	break;
			default: $valida = 23; break;

	    }
		$authori_status = User::authorization_status($valida);
		if ($authori_status['permi'] >= 3) {
			$group_all = ControllerLacp_Port::all_lacp_equipmen($id);
			$port = DB::table('port_equipment_model')
		    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
		    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		    ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		    ->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
		    ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
		    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		    ->where('board.id_equipment', '=', $id)
		    ->where('board.status', '=', 'ACTIVO')
		    ->where('list_port.name', '!=', 'ANTENA')
		    ->where('list_port.name', '!=', 'ODU')
		    ->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_module_board.name as model', 'board.id', 'board.slot', 'port_equipment_model.bw_max_port', 'list_port.name as type', 'equipment.id_function', 'equipment.status as eq_status')
		    ->groupBy('list_label.name', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_module_board.name', 'board.id', 'board.slot', 'port_equipment_model.bw_max_port', 'list_port.name', 'equipment.id_function', 'equipment.status')->orderBy('port_l_i', 'asc')->get();

            //dd($port);

		    if (count($port) > 0) {
			    foreach ($port as $value) {
			    	for ($z=$value->port_l_i; $z <= $value->port_l_f; $z++) {
			    		$adminstatus = '';
					    $fsp_label = ControllerRing::label_por($value->slot);
					    $inf = ControllerPort::inf_por_indivi_todo($value->id, $z);
					    $bw = ControllerEquipment_Model::format_bw($value->bw_max_port);
					    $id_agg_full = $equip->acronimo.'/'.$value->label.$fsp_label.$z;
					    $port_agg_info = DB::table('import_excels')->where('idagg', '=', $id_agg_full)
					    	->select('adminstatus', 'operstatus')->get();
					    if (count($port_agg_info) > 0 && $port_agg_info[0]->adminstatus != null) {
					    	$adminstatus = $port_agg_info[0]->operstatus.' - '.$port_agg_info[0]->adminstatus;
					    }
					    $port_all_inf[] = array(
					    		'id' =>  $value->id,
					    		'placa' => $value->model,
					    		'port' => $z,
					    		'status' => $inf['status'],
					    		'id_status' => $inf['id_status'],
					    		'bw' => $bw['data'].' '.$bw['signo'],
					    		'commentary' => $inf['commentary'],
					    		'slot' => $value->label.$fsp_label,
					    		'atributo' => $inf['atributo'],
					    		'posicion' => $fsp_label,
					    		'type' => $value->type,
					    		'function' => $value->id_function,
					    		'service' => $inf['service'],
					    		'agg_status' => $adminstatus,
								'connected_to' => $inf['connected_to'],
								'eq_status' => $value->eq_status
					    );
					}
			    }
			    foreach ($port_all_inf as $clave => $fila) {
				    $pose[$clave] = $fila['posicion'];
				    $por[$clave] = $fila['port'];
				}
				array_multisort($pose, SORT_ASC, $por, SORT_ASC, $port_all_inf);
			    $resul = "yes";
		    }else{
		    	$resul = "nop";
		    	$port_all_inf = '';
		    }
            //dd($port_all_inf);
		    return array('resul' => $resul, 'datos' => $port_all_inf, 'acronimo' => $equip->acronimo, 'status' => $equip->status, 'group' => $group_all, 'permi' => $authori_status['permi']);
		}else{
	        return array('resul' => 'autori', );
	    }
	}

	public static function inf_por_indivi_todo($placa, $por){
		$port = DB::table('port')
			->leftJoin('status_port', 'status_port.id', '=', 'port.id_status')
			->leftJoin('ring', 'ring.id', '=', 'port.id_ring')
			->leftJoin('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
			->leftJoin('link ex1', 'lacp_port.id', '=', 'ex1.id_extreme_1')
			->leftJoin('link', 'lacp_port.id', '=', 'link.id_extreme_2')
			->leftJoin('list_type_links', 'list_type_links.id', '=', 'link.id_list_type_links')
			->leftJoin('list_type_links type_l', 'type_l.id', '=', 'ex1.id_list_type_links')
			->leftJoin('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
			->leftJoin('service', 'service.id', '=', 'service_port.id_service')
			->leftJoin('client', 'client.id', '=', 'service.id_client')
			->leftJoin('chain', 'port.id_chain', '=', 'chain.id')
			->where('port.id_board', '=', $placa)
			->where('port.n_port', '=', $por)
		->select('port.id', 'port.commentary', 'port.type', 'status_port.name as status', 'ring.name as ring', 'service.number', 'client.business_name', 'port.connected_to', 'lacp_port.commentary as con_sevi', 'status_port.id as id_status', 'lacp_port.lacp_number', 'link.name as link', 'list_type_links.name as type_links', 'type_l.name as links_type', 'ex1.name as link1','chain.name as chain1')->get();
		$service_sql = DB::table('port')
			->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
			->Join('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
			->Join('service', 'service.id', '=', 'service_port.id_service')
			->where('port.id_board', '=', $placa)
			->where('port.n_port', '=', $por)
		->select('service.number')->groupBy('service.number')->get();
		$number = '';
		$cadena = '';
		$anillo = '';
		$lacp = '';
		$link = '';
		$equipo = '';
		$commentary = '';
		$status = 'VACANTE';
		$id_full = 0;
		$id_status = 0;
		$service = 'NO';
		$id_connected_to = null;
		foreach ($service_sql as $valor) {
			$number = $number.$valor->number.' | ';
		}
		if (count($service_sql) > 0) {
			$number = 'Servicio: '.$number;
			$number = substr($number, 0, -2);
			$service = 'SI';
		}
		if (count($port) > 0) {
			$id_full = $port[0]->id;
			$status = $port[0]->status;
			$id_status = $port[0]->id_status;
			if ($port[0]->ring != null) {
				$anillo = 'Anillo: '.$port[0]->ring.' ';
			}
			if ($port[0]->connected_to != null) {
				$id_connected_to = $port[0]->connected_to;
				$port_connected_to = DB::table('port')
					->leftJoin('board', 'board.id', '=', 'port.id_board')
					->leftJoin('port_equipment_model', 'port_equipment_model.id', '=', 'board.id_port_model')
				    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
					->leftJoin('equipment', 'equipment.id', '=', 'board.id_equipment')
					->where('port.id', '=', $port[0]->connected_to)
					->select('equipment.acronimo','list_label.name','board.slot','port.n_port')
					->get();
				if (count($port_connected_to) > 0) {
					$fsp = ControllerRing::label_por($port_connected_to[0]->slot);
					$all_port_info = $port_connected_to[0]->name.$fsp.$port_connected_to[0]->n_port;
					$equipo = 'Equipo: '.$port_connected_to[0]->acronimo.' '.$all_port_info.' ';
				}
			}
			if ($port[0]->commentary != null) {
				$commentary = $port[0]->commentary;
			}else{
				$commentary = $port[0]->con_sevi;
			}
			if ($port[0]->lacp_number != null){
				$lacp = $port[0]->lacp_number.'. ';
			}
			if ($port[0]->link != null){
				$link = $port[0]->type_links.': '.$port[0]->link.' ';
			}
			if ($port[0]->link1 != null){
				$link = $port[0]->links_type.': '.$port[0]->link1.' ';
			}
			if ($port[0]->chain1 != null){
				$cadena = 'Cadena: '.$port[0]->chain1.' ';
			}
		}
		$data = array(
				'id' => $id_full,
				'status' => $status,
				'service' => $service,
				'id_status' => $id_status,
				'commentary' => $lacp.$commentary,
				'atributo' => $anillo.$cadena.$equipo.$number.$link,
				'connected_to' => $id_connected_to
			);
		return $data;
	}

	public function reser_port_equipmen(){
		if (!Auth::guest() == false) return array('resul' => 'login', );
		$placa = $_POST['placa'];
		$vallidar = DB::table('board')
			->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
			->where('board.id', '=', $placa)
			->select('equipment.id_function')->get();
		switch ($vallidar[0]->id_function) {
			case '1': $status_valida = 7; break;
			case '2': $status_valida = 8; break;
			case '3': $status_valida = 9; break;
			case '4': $status_valida = 13; break;
			case '5': $status_valida = 19; break;
	    	case '6': $status_valida = 20; break;
	    	case '7': $status_valida = 23; break;
			case '8': $status_valida = 27; break;
		}
		$authori_status = User::authorization_status($status_valida);
		if ($authori_status['permi'] >= 3) {
			$port = $_POST['port'];
			$mot = $_POST['mot'];
			$commen = $_POST['commen'];
			$inf = ControllerPort::inf_por_indivi_todo($placa, $port);
			if ($inf['id'] != 0) {
				if ($inf['atributo'] == '') {
					$port = Port::find($inf['id']);
					$port->id_status = $mot;
					$port->commentary = $commen;
					$port->save();
					$id = $inf['id'];
					$resul = 'yes';
				} else {
					$resul = 'nop';
					$id = 0;
				}
			} else {
				$port_new = new Port();
				$port_new->id_status = $mot;
				$port_new->commentary = $commen;
				$port_new->id_board = $placa;
				$port_new->n_port = $port;
				$port_new->save();
				$id = $port_new->id;
				$resul = 'yes';
			}
			$equipo = DB::table('port')
				->Join('board', 'port.id_board', '=', 'board.id')
				->Join('status_port', 'port.id_status', '=', 'status_port.id')
				->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->where('port.id', '=', $id)
				->select('equipment.id', 'equipment.acronimo', 'board.slot', 'port.n_port', 'list_label.name', 'status_port.name as status')->get();
			if (count($equipo)>0) {
				$id_equipo = $equipo[0]->id;
				$fsp_label = ControllerRing::label_por($equipo[0]->slot);
				$msj_info = $equipo[0]->name.$fsp_label.$equipo[0]->n_port;
				ControllerUser_history::store("Modifico el estado del puerto ".$msj_info." a ".$equipo[0]->status." del equipo ".$equipo[0]->acronimo);
			} else {
				$id_equipo = 0;
			}
			return array('resul' => $resul, 'datos' => $id_equipo, );
		} else {
	        return array('resul' => 'autori',);
	    }
	}

	public function free_port_equipmen(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$placa = $_POST['placa'];
		$vallidar = DB::table('board')
		->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
		->where('board.id', '=', $placa)
		->select('equipment.id_function')->get();
		switch ($vallidar[0]->id_function) {
			case '1': $status_valida = 7; break;
			case '2': $status_valida = 8; break;
			case '3': $status_valida = 9; break;
			case '4': $status_valida = 13; break;
			case '5': $status_valida = 19; break;
			case '6': $status_valida = 20; break;
			case '7': $status_valida = 23; break;
			case '8': $status_valida = 27; break;
		}
		$authori_status = User::authorization_status($status_valida);
		if ($authori_status['permi'] >= 3) {
			$port = $_POST['port'];
			$validar = DB::table('port')
				->Join('board', 'board.id', '=', 'port.id_board')
				->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
				->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->where('port.id_board', '=', $placa)
				->where('port.n_port', '=', $port)
				->select('port.id', 'port.id_status', 'equipment.id as equipment', 'equipment.acronimo', 'board.slot', 'port.n_port', 'list_label.name')->get();
			if (count($validar) > 0 && $validar[0]->id_status != 1) {
				$port_new = Port::find($validar[0]->id);
					$port_new->id_status = 2;
					$port_new->commentary = null;
				$port_new->save();
				$resul = array('resul' => 'yes', 'datos' => $validar[0]->equipment,);
				$fsp_label = ControllerRing::label_por($validar[0]->slot);
				$msj_info = $validar[0]->name.$fsp_label.$validar[0]->n_port;
				ControllerUser_history::store("Libero el puerto ".$msj_info." del equipo ".$validar[0]->acronimo);
			}else{
				$resul = array('resul' => 'nop',);
			}
		}else{
	        $resul = array('resul' => 'autori',);
	    }
	    return $resul;
	}

	public function migracion(){
		$datos = DB::table('migra_ser_equi')->select('id_router', 'id_service')->get();
		foreach ($datos as $value) {
			$buscar = DB::table('equipment')
				->Join('board', 'equipment.id', '=', 'board.id_equipment')
				->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->where('equipment.id', '=', $value->id_router)
				->select('board.id', 'port_equipment_model.port_l_i')->get();
			if (count($buscar) > 0) {
				$validar = DB::table('port')->where('n_port', '=', $buscar[0]->port_l_i)
					->where('id_board', '=', $buscar[0]->id)->select('id', 'id_lacp_port')->get();
				if (count($validar) > 0) {
					$id_port = $validar[0]->id;
					$port_lacp = $validar[0]->id_lacp_port;
				}else{
					$port_new = new Port();
						$port_new->id_status = 1;
						$port_new->id_board = $buscar[0]->id;
						$port_new->n_port = $buscar[0]->port_l_i;
					$port_new->save();
					$id_port = $port_new->id;
					$port_lacp = null;
				}
				if ($port_lacp == null || $port_lacp == '') {
					$lacp_new = new Lacp_Port();
    					$lacp_new->group_lacp = 'NO';
					$lacp_new->save();
					$port_lacp = $lacp_new->id;
					$port_lacp_new = Port::find($id_port);
						$port_lacp_new->id_lacp_port = $port_lacp;
					$port_lacp_new->save();
				}
				$datos_service_port = DB::table('service_port')
					->where('id_service', '=', $value->id_service)
					->where('id_lacp_port', '=', $port_lacp)
					->select('id')->get();
				if (count($datos_service_port) == 0) {
					$servicios = new Service_Port();
						$servicios->id_service = $value->id_service;
						$servicios->vlan = null;
						$servicios->id_lacp_port = $port_lacp;
					$servicios->save();
				}
			}
		}
		return redirect('home');
	}

	public function commen_port_all(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$board = $_POST['board'];
		$port = $_POST['port'];
		$validar = DB::table('board')
			->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
			->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
			->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			->where('board.id', '=', $board)
			->select('equipment.acronimo', 'board.slot', 'list_label.name')->get();
		$slot = ControllerRing::label_por($validar[0]->slot);
		$acro_port = $validar[0]->acronimo.' '.$validar[0]->name.$slot.$port;
		$datos = DB::table('port')->where('id_board', '=', $board)->where('n_port', '=', $port)
			->select('id', 'commentary')->get();
		if (count($datos) > 0) {
			$data = array('id' => $datos[0]->id, 'commen' => $datos[0]->commentary,);
		}else{
			$data = array('id' => '', 'commen' => '',);
		}
		return array('resul' => 'yes', 'datos' => $data, 'acronimo' => $acro_port,);
	}

	public function insert_update_commen_port(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$board = $_POST['board'];
		$port = $_POST['port'];
		$commen = $_POST['commen'];
		$datos = DB::table('port')
			->where('id_board', '=', $board)
			->where('n_port', '=', $port)
			->select('id')->get();
		if (count($datos) > 0) {
			$port_new = Port::find($datos[0]->id);
		}else{
			$port_new = new Port();
				$port_new->id_status = 2;
				$port_new->id_board = $board;
				$port_new->n_port = $port;
		}
			$port_new->commentary = $commen;
		$port_new->save();
		$equipment = Board::find($board);
		return array('resul' => 'yes', 'datos' => $equipment->id_equipment,);
	}

	public function migrate_port_reser(){
  		if (!Auth::guest() == false){
	        return redirect('login')->withErrors([Lang::get('validation.login'),]);
	    }
	    $equipment = DB::table('equipment')->join("agg_port_relation", "equipment.acronimo", "=", "agg_port_relation.agg")
	    ->select('equipment.id', 'agg_port_relation.port', 'agg_port_relation.status', 'agg_port_relation.comentario')
	    ->groupBy('equipment.id', 'agg_port_relation.port', 'agg_port_relation.status', 'agg_port_relation.comentario')->get();
	    foreach ($equipment as $value) {
	    	$separa = explode('/', $value->port);
	    	$puerto = $separa[count($separa) - 1];
	    	$label = substr($separa[0], 0, -1);
	    	$board = DB::table('board')->join("port_equipment_model", "board.id_port_model", "=", "port_equipment_model.id")
				->join("list_label", "port_equipment_model.id_label", "=", "list_label.id")
				->where('board.id_equipment', '=', $value->id)
				->where('port_equipment_model.port_l_i', '<=', $puerto)
				->where('port_equipment_model.port_l_f', '>=', $puerto)
				->where('list_label.name', 'like', '%'.$label.'%')
				->select('board.id','list_label.name', 'board.slot')->get();
			foreach ($board as $valor) {
				$fsp_label = ControllerRing::label_por($valor->slot);
				$label_full = $valor->name.$fsp_label.$puerto;
				if ($label_full == $value->port) {
					$port_sql = DB::table('port')->select('id')->where('id_board', '=', $valor->id)
						->where('n_port', '=', $puerto)->get();
					if (count($port_sql) > 0){
						$port_new = Port::find($port_sql[0]->id);
					}else{
						$port_new = new Port();
							$port_new->id_board = $valor->id;
							$port_new->n_port = $puerto;
					}
						$port_new->id_status = $value->status;
						$port_new->commentary = $value->comentario;
					$port_new->save();
				}
			}
	    }
		return redirect('login');
  	}

  	public function detal_port_equipmen_new_all(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$board = $_POST['board'];
		$port = $_POST['port'];
		$data = [];
		$info = DB::table('board')
			->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
			->Join('port_equipment_model','board.id_port_model','=','port_equipment_model.id')
			->Join('list_label','port_equipment_model.id_label','=','list_label.id')
			->where('board.id', '=', $board)
			->select('equipment.id_function', 'board.slot', 'list_label.name')->get();
		switch ($info[0]->id_function) {
			case '1':
				$status_valida = 7;
			break;
			case '2':
				$status_valida = 8;
			break;
			case '3':
				$status_valida = 9;
			break;
			case '4':
				$status_valida = 13;
			break;
			case '5':
	    		$status_valida = 19;
	    	break;
	    	case '6':
	    		$status_valida = 20;
	    	break;
	    	case '7':
	    		$status_valida = 23;
	    	break;
		}
		$authori_status = User::authorization_status($status_valida);
		if ($authori_status['permi'] >= 3) {
			$slot = ControllerRing::label_por($info[0]->slot);
			$all_port = $info[0]->name.$slot.$port;
			$service_sql = DB::table('port')
				->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
				->Join('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
				->Join('service', 'service.id', '=', 'service_port.id_service')
				->Join('client', 'client.id', '=', 'service.id_client')
				->where('port.id_board', '=', $board)->where('port.n_port', '=', $port)
			->select('service.id', 'service.number', 'service.bw_service', 'service_port.vlan', 'client.business_name')
			->groupBy('service.id', 'service.number', 'service.bw_service', 'service_port.vlan', 'client.business_name')->get();
			foreach ($service_sql as $valor) {
				$bw = ControllerEquipment_Model::format_bw($valor->bw_service);
				$data[] = array(
					'id' => $valor->id,
					'Service' => $valor->number,
					'bw' => $bw['data'].$bw['signo'],
					'vlan' => $valor->vlan,
					'client' => $valor->business_name,
				);
			}
			return array('resul' => 'yes', 'datos' => $data, 'port' => $all_port);
		}else{
	        return array('resul' => 'autori',);
	    }
	}

	public function new_port_equipmen_lsw(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$board = $_POST['board'];
		$port = $_POST['port'];
		$data = [];
		$info = DB::table('board')
			->Join('port_equipment_model','board.id_port_model','=','port_equipment_model.id')
			->Join('list_label','port_equipment_model.id_label','=','list_label.id')
			->where('board.id', '=', $board)
			->select('board.slot', 'list_label.name','port_equipment_model.bw_max_port')->get();
		$slot = ControllerRing::label_por($info[0]->slot);
		$bw = ControllerEquipment_Model::format_bw($info[0]->bw_max_port);
		$sql = DB::table('port')->where('port.id_board', '=', $board)->where('port.n_port', '=', $port)
			->select('port.id')->groupBy('port.id')->get();
		if (count($sql) > 0) {
			$id = $sql[0]->id;
		}else{
			$port_new = new Port();
				$port_new->id_status = 2;
				$port_new->id_board = $board;
				$port_new->n_port = $port;
			$port_new->save();
			$id = $port_new->id;
		}
		$data = array(
			'id' => $id,
			'port' => $info[0]->name.$slot.$port,
			'bw' => $bw['data'].$bw['signo'],
		);
		return array('resul' => 'yes', 'datos' => $data,);
	}

	public function inf_equip_port_radio_antena_odu(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(23);
		if ($authori_status['permi'] >= 3) {
			$data = [];
			$extremos = '';
			$name = '';
			$board = $_POST['board'];
			$port = $_POST['port'];
			$info = DB::table("port")
				->leftJoin('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
				->leftJoin('link ex1', 'lacp_port.id', '=', 'ex1.id_extreme_1')
				->leftJoin('link ex2', 'lacp_port.id', '=', 'ex2.id_extreme_2')
				->where('n_port', '=', $port)->where('port.id_board', '=', $board)
				->select('port.id_odu','port.id_antena','ex1.name as ext1','ex2.name as ext2', 'ex1.id as id_ex1', 'ex2.id as id_ex2')->get();
			if (count($info)>0) {
				$extremo = DB::table('link')
				->leftJoin('port ext1', 'link.id_extreme_1', '=', 'ext1.id_lacp_port')
				->leftJoin('port ext2', 'link.id_extreme_2', '=', 'ext2.id_lacp_port')
				->leftJoin('board ext_board1', 'ext1.id_board', '=', 'ext_board1.id')
				->leftJoin('board ext_board2', 'ext2.id_board', '=', 'ext_board2.id')
				->leftJoin('equipment ext_equi1','ext_board1.id_equipment','=','ext_equi1.id')
				->leftJoin('equipment ext_equi2','ext_board2.id_equipment','=','ext_equi2.id')
				->where('link.id', '=', $info[0]->id_ex1)
				->orwhere('link.id', '=', $info[0]->id_ex2)
				->select('ext_equi1.acronimo as extre1', 'ext_equi2.acronimo as extre2')->get();
				$extremos = 'Extremo 1: '.$extremo[0]->extre1. ' <> Extremo 2: '. $extremo[0]->extre2;
				if ($info[0]->ext1 != null) { $name = 'RADIO ENLACE: '.$info[0]->ext1; }
				if ($info[0]->ext2 != null) { $name = 'RADIO ENLACE: '.$info[0]->ext2; }
				$port_info = DB::table('port_equipment_model')
			    ->join('list_label','port_equipment_model.id_label','=','list_label.id')
			    ->join('list_port','port_equipment_model.id_list_port','=','list_port.id')
			    ->join('list_module_board','port_equipment_model.id_module_board','=','list_module_board.id')
			    ->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
			    ->join('port', 'port.id_board', '=', 'board.id')
			    ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
			    ->where('port.id', '=', $info[0]->id_odu)
			    ->orwhere('port.id', '=', $info[0]->id_antena)
			    ->select('port.n_port', 'list_label.name as label', 'port_equipment_model.port_l_i', 'list_module_board.name as model',  'board.id', 'port_equipment_model.bw_max_port', 'list_port.name as type', 'equipment.id_model', 'list_port.id as id_port')
			    ->groupBy('port.n_port', 'list_label.name', 'port_equipment_model.port_l_i', 'list_module_board.name', 'board.id', 'port_equipment_model.bw_max_port', 'list_port.name', 'equipment.id_model', 'list_port.id')->orderBy('port_l_i', 'asc')->get();
			    foreach ($port_info as $value) {
			    	$bw = ControllerEquipment_Model::format_bw($value->bw_max_port);
			    	$data[] = array(
			    		'id' => $value->id,
			    		'id_model' => $value->id_model,
			    		'label' => $value->label,
			    		'model' => $value->model,
			    		'bw' => $bw['data'].$bw['signo'],
			    		'type' => $value->type,
			    		'port' => $value->n_port,
			    		'option' => $value->id_port,
			    	);
			    }
			}
			return array('resul' => 'yes', 'datos' => $data, 'name' => $name, 'extremo' => $extremos);
		}else{
	        return array('resul' => 'autori', );
	    }
	}

	public function modify_port_radio_antena_odu(Request $request){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(23);
		if ($authori_status['permi'] < 5){return array('resul' => 'autori');}
		$data = [];
		$info = DB::table('port_equipment_model')
			->join('relation_port_model','relation_port_model.id_port_equipment_model','=','port_equipment_model.id')
			->join('list_label','port_equipment_model.id_label','=','list_label.id')
			->join('list_port','port_equipment_model.id_list_port','=','list_port.id')
			->join('list_module_board','port_equipment_model.id_module_board','=','list_module_board.id')
			->where('relation_port_model.id_equipment_model', '=', $request->model)
			->where('port_equipment_model.id_list_port', '=', $request->type)
			->where('relation_port_model.status', '=', 'Activo')
			->select('list_label.name as label', 'list_module_board.name as model', 'port_equipment_model.bw_max_port', 'list_port.name as type', 'port_equipment_model.id')->get();
		foreach ($info as $value) {
			$bw = ControllerEquipment_Model::format_bw($value->bw_max_port);
			$data[] = array(
			    'id' => $request->board.','.$value->id,
			    'model' => $value->model.' '.$bw['data'].$bw['signo'],
			);
		}
		return array('resul' => 'yes', 'datos' => $data, 'type' => $info[0]->type,);
	}

	public function update_port_radio_antena_odu(Request $request){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(23);
		if ($authori_status['permi'] < 5){return array('resul' => 'autori');}
		$divi = explode(',', $request->id);
		$board = '';
		$new = Board::find($divi[0]);
			$new->id_port_model = $divi[1];
		$new->save();
		$info = DB::table('port')->leftJoin('port as if','port.id','=','if.id_odu')
			->leftJoin('port as if2','port.id','=','if2.id_antena')
			->where('port.id_board', '=', $new->id)
			->select('if.id_board as board1', 'if2.id_board as board2')->get();
		if (count($info) > 0) {
			if ($info[0]->board1 != null) {
				$board = $info[0]->board1;
			}
			if ($info[0]->board2 != null) {
				$board = $info[0]->board2;
			}
		}
		return array('resul' => 'yes', 'datos' => $board,);
	}

	public function port_migration_selec(Request $request){
    	if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$port_all[] = '';
		foreach ($request->board as $val) {
			$slot = '@';
			$dividir = explode(',', $val);
			if (count($dividir) > 1) {
				$slot = $dividir[1];
			}
		  	$port = DB::table('port_equipment_model')
		    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
		    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		    ->where('port_equipment_model.id', '=', $dividir[0])
		    ->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_port.name as type')->orderBy('port_l_i', 'asc')->get();
		    if (count($port)>0) {
		    	if ($port_all[0] == '') { unset($port_all);}
		    	for ($z=$port[0]->port_l_i; $z <= $port[0]->port_l_f; $z++) {
			    	$fsp_label=ControllerRing::label_por($dividir[1]);
			    	$port_all[] = array(
			    		'id' =>  $dividir[0].','.$z,
			    		'label' => $port[0]->label,
			    		'type' => $port[0]->type,
			    		'port' => $z,
			    		'full' => $port[0]->label.$fsp_label.$z,
			    		'slot' => $fsp_label,
			    		'slot_board' => $slot,
			    		'pose' => $fsp_label.$z,
			    	);
			    }
		    }
    	}
    	if ($port_all[0] == '') {
    		return array('resul' => 'nop');
    	}else{
			$pose_order  = array_column($port_all, 'slot');
			$port_order  = array_column($port_all, 'port');
			array_multisort($pose_order, SORT_ASC, $port_order, SORT_ASC,$port_all);
    	}
		return array('resul' => 'yes', 'datos' => $port_all);
	}

	public function relate_equip_ports() {
		if (!Auth::guest() == false) return ['resul' => 'login'];
		try {
			$data = DB::table('board')
				->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->where('board.id', $_POST['current_board_id'])
				->select('equipment.id', 'equipment.id_function', 'equipment.acronimo', 'board.slot', 'list_label.name')
				->first();
			switch ($data->id_function) {
				case '1': $status_valida = 7; break;
				case '2': $status_valida = 8; break;
				case '3': $status_valida = 9; break;
				case '4': $status_valida = 13; break;
				case '5': $status_valida = 19; break;
	    		case '6': $status_valida = 20; break;
	    		case '7': $status_valida = 23; break;
				case '8': $status_valida = 27; break;
			}
			$authori_status = User::authorization_status($status_valida);
			if ($authori_status['permi'] < 3) return ['resul' => 'autori'];

			$fsp_label = ControllerRing::label_por($data->slot);
			$current_port = $data->name.$fsp_label.$_POST['current_port_n'];

			$data2 = DB::table('board')
				->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->where('board.id', $_POST['other_board_id'])
				->select('equipment.id', 'equipment.id_function', 'equipment.acronimo', 'board.slot', 'list_label.name')
				->first();
			$fsp_label_2 = ControllerRing::label_por($data2->slot);
			$other_port = $data2->name.$fsp_label_2.$_POST['other_port_n'];

			$current_id = Port::get_id($_POST['current_board_id'], $_POST['current_port_n']);
			$other_id = Port::get_id($_POST['other_board_id'], $_POST['other_port_n']);
			DB::table('port')->where('id', $current_id)->update(['connected_to' => $other_id]);
			DB::table('port')->where('id', $other_id)->update(['connected_to' => $current_id]);

			ControllerUser_history::store("Conecto puerto $current_port de equipo $data->acronimo con puerto $other_port de equipo $data2->acronimo");
			return ['resul' => 'yes'];
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e->getMessage()];
		}
	}

	public function disconnect_port() {
		if (!Auth::guest() == false) return ['resul' => 'login'];
		try {
			$data = DB::table('port')
				->Join('board', 'port.id_board', '=', 'board.id')
				->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->where('port.id_board', $_POST['board_id'])
				->where('port.n_port', $_POST['port_n'])
				->select('port.id', 'port.connected_to', 'equipment.id_function', 'equipment.acronimo', 'board.slot', 'list_label.name')
				->first();
			switch ($data->id_function) {
				case '1': $status_valida = 7; break;
				case '2': $status_valida = 8; break;
				case '3': $status_valida = 9; break;
				case '4': $status_valida = 13; break;
				case '5': $status_valida = 19; break;
				case '6': $status_valida = 20; break;
				case '7': $status_valida = 23; break;
			}
			$authori_status = User::authorization_status($status_valida);
			if ($authori_status['permi'] < 3) return ['resul' => 'autori'];

			$other = Port::find(intval($data->connected_to));
			if (!empty($other->connected_to)) {
				$other->connected_to = null;
				$other->save();
			}
			DB::table('port')->where('id', $data->id)->update(['connected_to' => null]);

			$fsp_label = ControllerRing::label_por($data->slot);
			$msj_info = $data->name.$fsp_label.$_POST['port_n'];
			ControllerUser_history::store("Desconecto el puerto ".$msj_info." del equipo ".$data->acronimo);
			return ['resul' => 'yes'];
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e->getMessage()];
		}
	}
}
