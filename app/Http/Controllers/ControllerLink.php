<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Jarvis\Http\Requests\RequestLink;
use Jarvis\Equipment_Model;
use Jarvis\List_Type_Link;
use Jarvis\Link;
use Carbon\Carbon;
use Exception;
use Jarvis\Equipment;
use Jarvis\User;
use Jarvis\Port;
use Jarvis\Node;
class ControllerLink extends Controller
{
    public function index(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(26);
		if ($authori_status['permi'] >= 3) {
			$equipment = Equipment_Model::List();
			$type_link = List_Type_Link::all();
			return view('link.list',compact('authori_status', 'type_link', 'equipment'));
		}else{
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function index_list(){
		if(!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(26);
		if ($authori_status['permi'] >= 3) {
			$data = [];
			$info = DB::table('link')
				->join('list_type_links','link.id_list_type_links','=','list_type_links.id')
				->leftJoin('node', 'link.id_node', '=', 'node.id')
				->select('link.id','node.cell_id','node.node','list_type_links.name as type','link.name','link.bw_limit','link.commentary')->get();
			foreach ($info as $value) {
				$bw = ControllerEquipment_Model::format_bw($value->bw_limit);
				$data[] = array(
					'id' => $value->id,
					'commentary' => $value->commentary,
					'type' => $value->type,
					'name' => $value->name,
					'node' => $value->cell_id.' '.$value->node,
					'bw' => $bw['data'].' '.$bw['signo'],
				);
			}
			return datatables()->of($data)->make(true);
		}else{
			return array('resul' => 'autori', );
		}
	}

	public function index_ipran(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(26);
		if ($authori_status['permi'] >= 3) {
			$equipment = Equipment_Model::List();
			$type_link = List_Type_Link::all();
			return view('link.list_ipran',compact('authori_status', 'type_link', 'equipment'));
		}else{
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function index_list_ipran()
	{
		if (!Auth::guest() == false) {
			return array('resul' => 'login',);
		}
		$authori_status = User::authorization_status(26);
		if ($authori_status['permi'] >= 3) {
			$data = [];
			$info = DB::table('link')
				->join('list_type_links', 'link.id_list_type_links', '=', 'list_type_links.id')
				->leftJoin('node', 'link.id_node', '=', 'node.id')
				->leftJoin('port','port.id_lacp_port','=','link.id_extreme_2')
				->leftJoin('board', 'port.id_board', '=', 'board.id')
				->leftJoin('equipment', 'equipment.id', '=', 'board.id_equipment')
				->where('id_list_type_links', '=', 3)
				->select('link.id', 'link.id_extreme_2', 'node.cell_id', 'node.node', 'node.type as node_type','node.contract_date','list_type_links.name as type', 'link.name', 'link.bw_limit', 'link.commentary', 'link.status','equipment.acronimo')->get();
			foreach ($info as $value) {
				$status_node= "APTA";
				$acronimo_name = "No Asociado";
				if($value->node_type != "PROPIO"){
					if($value->contract_date != null){
						$date = Carbon::parse($value->contract_date);
						$now = Carbon::now();
						$diff = $date->diffInDays($now);
						if($diff < 730){
							$status_node = 'NO APTA';
						}
					}
				}
				if($value->acronimo != null){
					$acronimo_name = $value->acronimo;
				}
				$bw_count_link = ControllerLink::bw_count_link($value->id);
				$bw_reserved = ControllerEquipment_Model::format_bw($bw_count_link[0]);
				$bw_available = ControllerEquipment_Model::format_bw($bw_count_link[1]);
				$bw_used = ControllerEquipment_Model::format_bw($bw_count_link[2]);
				$bw = ControllerEquipment_Model::format_bw($value->bw_limit);
				
				$data[] = array(
					'id' => $value->id,
					'commentary' => $value->commentary,
					'type' => $value->type,
					'name' => $value->name,
					'equipment' => $acronimo_name,
					'link_status' => $value->status,
					'node' => $value->cell_id . ' ' . $value->node,
					'node_status' => $status_node,
					'bw' => $bw['data'] . ' ' . $bw['signo'],
					'bw_remanente' => $bw_available['data'] . ' ' . $bw_available['signo'],
					'bw_used' => $bw_used['data'] . ' ' . $bw_used['signo'],
					'bw_reservado' => $bw_reserved['data'] . ' ' . $bw_reserved['signo'],
				);
			}
			return datatables()->of($data)->make(true);
		} else {
			return array('resul' => 'autori',);
		}
	}
	
	public function uplink_by_equipment() {
		if (!Auth::guest() == false) {
			return array('resul' => 'login',);
		}
		$authori_status = User::authorization_status(26);
		if ($authori_status['permi'] >= 3) {
			$data = [];
			$id_node = DB::table('equipment')->where('id', $_POST['id_equip'])->select('id_node')->get();
			$link = DB::table('link')
				->join('list_type_links', 'link.id_list_type_links', '=', 'list_type_links.id')
				->leftJoin('node', 'link.id_node', '=', 'node.id')
				->where([
					['id_list_type_links', '=', 3], 
					['id_node', '=', $id_node[0]->id_node],
					['id_extreme_2', '=', null]
					])
				->select('link.id', 'node.cell_id', 'node.node', 'list_type_links.name as type', 'link.name', 'link.bw_limit', 'link.commentary')->get();
			foreach ($link as $value) {
				$bw_count_link = ControllerLink::bw_count_link($value->id);
				$bw_reserved = ControllerEquipment_Model::format_bw($bw_count_link[0]);
				$bw_available = ControllerEquipment_Model::format_bw($bw_count_link[1]);
				$bw = ControllerEquipment_Model::format_bw($value->bw_limit);
				$data[] = array(
					'id' => $value->id,
					'commentary' => $value->commentary,
					'type' => $value->type,
					'name' => $value->name,
					'node' => $value->cell_id . ' ' . $value->node,
					'bw' => $bw['data'] . ' ' . $bw['signo'],
					'bw_remanente' => $bw_available['data'] . ' ' . $bw_available['signo'],
					'bw_reservado' => $bw_reserved['data'] . ' ' . $bw_reserved['signo'],
				);
			}
			return datatables()->of($data)->make(true);
		} else {
			return array('resul' => 'autori',);
		}
	}

	public function insert_update_link(RequestLink $request){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$authori_status = User::authorization_status(26);
		if ($authori_status['permi'] >= 3) {
			$bw = $request->n_max * $request->max_link;
			if ($request->id == 0) {
				$new_link = new Link();
			}else{
				$new_link = Link::find($request->id);
			}
				$new_link->name = $request->name;
				$new_link->bw_limit = $bw;
				$new_link->id_list_type_links = $request->type;
				$new_link->commentary = $request->commentary;
				$new_link->id_node = $request->nodo;
				$new_link->status = 'ALTA';
			$new_link->save();
			return array('resul' => 'yes',);
		}else{
			return array('resul' => 'autori', );
		}
    }
    public function edic_info()
	{
		if (!Auth::guest() == false) {
			return array('resul' => 'login',);
		}
		$autori_status = User::authorization_status(26);
		if ($autori_status['permi'] >= 3) {
			$info = DB::table('link')
				->join('list_type_links', 'link.id_list_type_links', '=', 'list_type_links.id')
				->Join('node', 'link.id_node', '=', 'node.id')
				->where('link.id', '=', $_POST['id'])
				->select('link.id', 'node.id as id_node', 'node.cell_id', 'node.node', 'list_type_links.id as type', 'link.name', 'link.bw_limit', 'link.commentary')->get();
			$bw = ControllerEquipment_Model::format_bw($info[0]->bw_limit);
			$data[] = array(
				'id' => $info[0]->id,
				'commentary' => $info[0]->commentary,
				'type' => $info[0]->type,
				'name' => $info[0]->name,
				'id_node' => $info[0]->id_node,
				'node' => $info[0]->cell_id . ' ' . $info[0]->node,
				'bw_limit' => $bw['data'],
				'bw_limit_logo' => $bw['signo'],
			);
			return array('resul' => 'yes', 'datos' => $data);
		} else {
			return array('resul' => 'autori',);
		}
	}

  	public function select_list_node($id){
		if(!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(26);
		if ($authori_status['permi'] >= 3) {
			$data = [];
			$info = DB::table('link')
				->join('list_type_links','link.id_list_type_links','=','list_type_links.id')
				->Join('node', 'link.id_node', '=', 'node.id')
				->where('node.id', '=', $id)
				->whereNull('link.id_extreme_2')
				->select('link.id','node.cell_id','node.node','list_type_links.name as type','link.name','link.bw_limit','link.commentary')->get();
			foreach ($info as $value) {
				$bw = ControllerEquipment_Model::format_bw($value->bw_limit);
				$data[] = array(
					'id' => $value->id,
					'commentary' => $value->commentary,
					'type' => $value->type,
					'name' => $value->name,
					'node' => $value->cell_id.' '.$value->node,
					'bw' => $bw['data'].' '.$bw['signo'],
				);
			}
			return datatables()->of($data)->make(true);
		}else{
			return array('resul' => 'autori', );
		}
	}

	public static function link_selec(){
	    if (!Auth::guest() == false){ return array('resul' => 'login', ); }
	    $authori_status = User::authorization_status(26);
	    if ($authori_status['permi'] >= 3) {
		    $id = $_POST['id'];
		    $Link = DB::table('link')
				->join('list_type_links','link.id_list_type_links','=','list_type_links.id')
				->where('link.id', '=', $id)
				->select('list_type_links.name as type','link.name')->get();
		    if (count($Link) > 0) {
		        $datos = $Link[0]->name.' '.$Link[0]->type;
		        $resul = array('resul' => 'yes', 'datos' => $datos,);
		    }else{
		        $resul = array('resul' => 'nop', );
		    }
		    return $resul;
	    }else{
	       return array('resul' => 'autori',);
	    }
  	}

  	public function port_lsw_selec_link(){
    	if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(26);
	    if ($authori_status['permi'] < 3) return array('resul' => 'autori',);
    	$placa = $_POST['placa'];
    	$port_all = [];
		foreach ($placa as $val) {
			$dividir = explode(',', $val);
		  	$port = DB::table('port_equipment_model')		    
			    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
			    ->where('port_equipment_model.id', '=', $dividir[0])
			    ->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_port.name as type', 'port_equipment_model.bw_max_port')->orderBy('port_l_i', 'asc')->get();
		    if (count($port) > 0) {
			    $bw_max = ControllerEquipment_Model::format_bw($port[0]->bw_max_port);
		    	for ($z=$port[0]->port_l_i; $z <= $port[0]->port_l_f; $z++) {
			    	$fsp_label = ControllerRing::label_por($dividir[1]); 
			    	$port_all[] = array(
			    		'id' =>  $dividir[0], 
			    		'label' => $port[0]->label,  
			    		'type' => $port[0]->type,  
			    		'port' => $z,
			    		'bw_port' => $bw_max['data'].' '.$bw_max['signo'],
			    		'slot' => $fsp_label,
			    		'pose' => $fsp_label.$z, 
			    	);
			    }
		    }
    	}
    	if (count($port_all) == 0) {
    		return array('resul' => 'nop');
    	}
		$pose_order  = array_column($port_all, 'slot');
		$port_order  = array_column($port_all, 'port');
		array_multisort($pose_order, SORT_ASC, $port_order, SORT_ASC,$port_all);
		return array('resul' => 'yes', 'datos' => $port_all);
	}

	public function port_lanswitch_link(){
		if (!Auth::guest() == false) return array('resul' => 'login', );
		$authori_status = User::authorization_status(26);
	    if ($authori_status['permi'] < 3) return array('resul' => 'autori',);
		$id = $_POST['id'];
		$port_all = [];
		$data = [];
		try {
			$port = DB::table('port_equipment_model')		    
			->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
			->join('board', 'port_equipment_model.id', '=', 'board.id_port_model')
			->join('port', 'board.id', '=', 'port.id_board')
			->join('link', 'port.id_lacp_port', '=', 'link.id_extreme_2')
			->where('board.id_equipment', '=', $id)
			->select('port.id', 'list_label.name as label', 'port_equipment_model.bw_max_port', 'link.name', 'board.slot', 'port.n_port')->get();
			$bw_max = ControllerEquipment_Model::format_bw($port[0]->bw_max_port);
			$fsp_label = ControllerRing::label_por($port[0]->slot); 
			$data = array(
				'id' => $port[0]->id,
				'port' => $port[0]->label.$fsp_label.$port[0]->n_port,
				'bw' => $bw_max['data'].' '.$bw_max['signo'],
				'name' => $port[0]->name,
			);
			$port_info = DB::table('port_equipment_model')		    
				->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
				->join('board', 'port_equipment_model.id', '=', 'board.id_port_model')
				->where('board.id_equipment', '=', $id)
				->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_port.name as type', 'port_equipment_model.bw_max_port', 'board.slot', 'board.id')->orderBy('port_l_i', 'asc')->get();
			foreach ($port_info as $value) {
				$bw_max_new = ControllerEquipment_Model::format_bw($value->bw_max_port);
				$fsp = ControllerRing::label_por($value->slot); 
				for ($z=$value->port_l_i; $z <= $value->port_l_f; $z++) {
					$status = 2;
					$validar=DB::table('port')->where('id_board','=',$value->id)->where('n_port','=',$z)
						->select('id_status')->get();
					if (count($validar) > 0) {
						$status = $validar[0]->id_status;
					}
					$port_all[] = array(
						'id' =>  $value->id,
						'type' => $value->type,  
						'port' => $value->label.$fsp.$z,
						'n_port' =>$z,
						'status' =>$status,
						'bw_port' => $bw_max_new['data'].' '.$bw_max_new['signo'],
					);
				}
			}
		} catch (Exception $e) {
			return ['resul' => 'nop', 'exception' => $e->getMessage()];
		}
		return array('resul' => 'yes', 'port_old' => $data, 'datos' => $port_all,);
	}

	public function port_new_link_lsw(){
		if (!Auth::guest() == false) return array('resul' => 'login', );
		$authori_status = User::authorization_status(26);
	    if ($authori_status['permi'] < 3) return array('resul' => 'autori',);
		$id = $_POST['id'];
		$port = $_POST['port'];
		$divi = explode(',', $port);
		$port_sql = DB::table('board')
			->join('port', 'board.id', '=', 'port.id_board')
			->join('link', 'port.id_lacp_port', '=', 'link.id_extreme_2')
			->where('board.id_equipment', '=', $id)
			->select('port.id as port', 'link.id as link', 'port.id_lacp_port')->get();
		$update = Port::find($port_sql[0]->port);
			$update->id_status = 2;
			$update->type = null;
			$update->id_lacp_port = null;
		$update->save();
		$info_port = DB::table('port')->where('id_board', '=', $divi[0])->where('n_port', '=', $divi[1])
			->select('id')->get();
		if (count($info_port) == 0) {
			$new = new Port();
				$new->id_board = $divi[0];
				$new->n_port = $divi[1];
				$new->id_status = 1;
				$new->type = 'LINK';
				$new->id_lacp_port = $port_sql[0]->id_lacp_port;
			$new->save();
		}else{
			$new = Port::find($info_port[0]->id);
				$new->id_status = 1;
				$new->type = 'LINK';
				$new->id_lacp_port = $port_sql[0]->id_lacp_port;
			$new->save();
		}
		return array('resul' => 'yes');
	}

	public function acronimo_link(){
		if (!Auth::guest() == false) return array('resul' => 'login', );
		$authori_status = User::authorization_status(26);
	    if ($authori_status['permi'] < 3) return array('resul' => 'autori',);
		$id = $_POST['id'];
		$info = Node::find($id, ['cell_id']);
		for ($i=1; $i < 100; $i++) { 
			$name = $info->cell_id.'-'.$i;
			$info_acro = count(DB::table('link')->where('name', '=', $name)->select('id')->get());
			if ($info_acro == 0) {
				$i = 101;
			}
		}
		return array('resul' => 'yes', 'datos' => $name);
	}
	public function delete(){
		//Funcion para ver si tiene reservas asociadas o servicios
		if (!Auth::guest() == false) return array('resul' => 'login', );
		$authori_status = User::authorization_status(26);
	    if ($authori_status['permi'] < 3) return array('resul' => 'autori',);
		$id = $_POST['id'];
		$link_info = ControllerLink::bw_count_link($id);
		$info = Node::find($id, ['cell_id']);
		$quantity_reserves = count(DB::table('reserves')->where('id_link', '=', $id)->select('id')->get());
		if($quantity_reserves > 0){
			return array('resul' => 'reserve');
		}
		if($link_info[2] > 0){
			return array('resul' => 'service');
		}
		$link = Link::find($id);
			$link->status = 'BAJA';
			$link->save();
		return array('resul' => 'yes');
	}
	static function bw_count_link($id)
	{
		$bw_pre_reserve = 0;
		$bw_link_limit = 0;
		$bw_service = 0;
		$bw_anillo = 0;
		$bw_remanent = 0;
		$link = Link::find($id);
		$bw_link_limit = $link->bw_limit;
		$id_equipos = [];
		$id_service =[];
		if($link->id_extreme_2 != null){
			$equipo =  DB::table('port')
			->join('board', 'board.id', '=', 'port.id_board')
			->join('equipment', 'board.id_equipment', '=', 'equipment.id')
			->where('port.id_lacp_port', '=', $link->id_extreme_2)
			->select('equipment.id')->get()->toArray();
			foreach ($equipo as $val) {
					$id_equipos[] = $val->id;
				}
				$ring_equipment = DB::table('board')
				->join('port', 'port.id_board','=','board.id')
				->join('port as por1', 'por1.id_ring','=','port.id_ring')
				->join('board as boar1', 'boar1.id', '=', 'por1.id_board')
				->join('equipment','equipment.id','=','boar1.id_equipment')
				->whereIn('board.id_equipment', $id_equipos)
				->select('equipment.id')->groupBy('equipment.id')->get();
				foreach ($ring_equipment as $value) {
					$servi = DB::table('equipment')
					->join('board', 'board.id_equipment', '=', 'equipment.id')		    
					->join('port', 'port.id_board', '=', 'board.id')
					->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
					->Join('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
					->join('service', 'service_port.id_service', '=', 'service.id')
					->where('equipment.id', '=', $value->id)
					->select('service.id','service.bw_service','equipment.id as equipment')->groupBy('service.id', 'service.bw_service','equipment.id')->get();
					#quizas aca habria que agregar un isset, como esta en info_bw_equipment()
					if(isset($servi)){
						foreach($servi as $valor){
							$id_service[] = $valor->id;
							$bw_anillo += $valor->bw_service;
						}
					}
				}
			}
			$info_equipos = DB::table('board')
				->join('port', 'board.id', '=', 'port.id_board')
				->join('service_port', 'service_port.id_lacp_port', '=', 'port.id_lacp_port')
				->join('service', 'service.id', '=', 'service_port.id_service')
				->whereIn('board.id_equipment', $id_equipos)
				->select('service.id', 'service.bw_service')
				->groupBy('service.id', 'service.bw_service')->get();
			
			foreach ($info_equipos as $value) {
				if(in_array($value->id, $id_service)){

				} else {
					$bw_service += $value->bw_service;
				}
			}

		$bw_used = $bw_service + $bw_anillo;

		$reserve = DB::table('reserves')
			->where('id_link', '=', $id)
			->where('status', '=', 'VIGENTE')
			->select('reserves.bw_reserve')->get();
		if (count($reserve) > 0) {
			foreach ($reserve as $val) {
				$bw_pre_reserve += $val->bw_reserve;
			}
		}
		$bw_remanent = $bw_link_limit - $bw_pre_reserve - $bw_used;
		return array($bw_pre_reserve, $bw_remanent, $bw_used);
	}

	public function service_by_uplink($id) {
		try {
			if (!Auth::guest() == false) return ['resul' => 'login'];
			$authori_status = User::authorization_status(26);
			if ($authori_status['permi'] < 3) return ['resul' => 'autori'];
	
			$uplink_equips = [];
			$cell = DB::table('link')
				->join('lacp_port', 'link.id_extreme_2', '=', 'lacp_port.id')
				->join('port', 'lacp_port.id', '=', 'port.id_lacp_port')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->where('link.id', '=', $id)
				->select('equipment.id as equip_id', 'equipment.id_function as equip_fn', 'equipment.client_management')
				->first();
			if (empty($cell)) return ['resul' => 'yes', 'datos' => ''];
			$uplink_equips[] = $cell->equip_id;
	
			$cell_ports = DB::table('port')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->where('equipment.id', '=', $cell->equip_id)
				->select('port.id as port_id')
				->get();
			$cpts = [];
			foreach ($cell_ports as $key => $value) $cpts[] = $value->port_id;
	
			$rings = DB::table('port')
				->join('ring', 'port.id_ring', '=', 'ring.id')
				->whereIn('port.id', $cpts)
				->select('ring.id as ring_id')
				->get();
			$rgs = [];
			foreach ($rings as $key => $value) $rgs[] = $value->ring_id;
	
			$ring_equips = DB::table('ring')
				->join('port', 'ring.id', '=', 'port.id_ring')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->whereIn('ring.id', $rgs)
				->select('equipment.id as equip_id', 'equipment.id_function as equip_fn', 'equipment.client_management')
				->get();
			foreach ($ring_equips as $r) if (!in_array($r->equip_id, $uplink_equips)) $uplink_equips[] = $r->equip_id;
	
			$result = [];
			foreach ($uplink_equips as $e) {
				$_POST['id'] = $e;
				$s = ControllerEquipment::service_equipmen();
				foreach ($s['datos'] as $dat) {
					$result[] = $dat;
				}
			}
			return ['resul' => 'yes', 'datos' => $result];
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e->getMessage()];
		}
		
	}

	public function list_frontier($id_equip){
		try {
			if (!Auth::guest() == false) return ['resul' => 'login'];
			$authori_status = User::authorization_status(26);
			if ($authori_status['permi'] < 3) return ['resul' => 'autori'];
	
			$data = [];
			//$eq = Equipment::find($id_equip);
			$info = DB::table('link')
				->leftJoin('node', 'link.id_node', '=', 'node.id')
				->where('id_list_type_links', 1)
				->select('link.id','link.name','node.cell_id','node.node','link.bw_limit','link.commentary','link.status','link.tecnologia','link.sufijo_vcid')
				->get(); // Falta relacionar a la frontera con el PE/PEI
			foreach ($info as $value) {
				$bw = ControllerEquipment_Model::format_bw($value->bw_limit);
				$value->name = str_pad($value->name, 3, '0', STR_PAD_LEFT);
				$data[] = [
					'id' => $value->id,
					'name' => $value->name,
					'node' => $value->cell_id.' '.$value->node,
					'bw' => $bw['data'].' '.$bw['signo'],
					'commentary' => $value->commentary,
					'status' => $value->status,
					'sufijo_vcid' => $value->sufijo_vcid,
					'tecnologia' => $value->tecnologia
				];
			}
			return datatables()->of($data)->make(true);
		} catch (Exception $e) {
			throw $e->getMessage();
		}
	}
}