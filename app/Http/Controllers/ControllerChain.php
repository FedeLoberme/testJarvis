<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\User_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Jarvis\Http\Controllers\ControllerIP;
use Jarvis\Http\Controllers\ControllerRing;
use Jarvis\Http\Controllers\ControllerPort;
use Jarvis\Http\Controllers\ControllerEquipment_Model;
use DB;
use Carbon\Carbon;
use Jarvis\User;
use Jarvis\Chain;
use Jarvis\Port;
use Jarvis\Equipment_Model;
use Jarvis\Http\Requests\RequestChain;
class ControllerChain extends Controller
{
    public function index(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(22);
		if ($authori_status['permi'] >= 3) {
			$equipment = Equipment_Model::List();
			return view('cadena.list',compact('authori_status', 'equipment'));
		}else{
			return redirect('home')
        ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function index_list(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(22);
		if ($authori_status['permi'] >= 3) {
			$data = [];
			$info = Chain::all();
			foreach ($info as $value) {
				$bw = ControllerEquipment_Model::format_bw($value->bw);
				$data[] = array(
					'id' => $value->id, 
					'name' => $value->name, 
					'bw' => $bw['data'].$bw['signo'], 
					'extreme_1' => $value->extreme_1, 
					'extreme_2' => $value->extreme_2, 
					'status' => $value->status, 
					'commentary' => $value->commentary, 
				);
			}
      		return datatables()->of($data)->make(true);
    	}else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function create(RequestChain $request){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(22);
		if ($authori_status['permi'] >= 10) {
			$port = $request->port;
			if ($port != null) {
				$port_info = DB::table('port')->whereIn('port.id', $port)
		    		->where('port.id_status', '!=', 2)
		    		->select('port.id')->get();
		    	if (count($port_info) == 0) {
					$bw = $request->BW * $request->max;
					$chain = new Chain;
						$chain->name = $request->name;
						$chain->extreme_1 = $request->extrem_1;
						$chain->extreme_2 = $request->extrem_2;
						$chain->bw = $bw;
						$chain->commentary = $request->commentary;
						ControllerUser_history::store("Creó la cadena ".$chain->name );
					$chain->save();
					$id = $chain->id;
					foreach ($port as $value) {
			    		$port_new = Port::find($value);
							$port_new->id_status = 1;
							$port_new->id_chain = $id;
							$port_new->type = 'CADENA';
							$port_new->save();
			    	}
					$resul = 'yes';
		    	}else{
		    		$resul = 'nop';
		    	}
			}else{
				$resul = 'port';
			}
		}else{
			$resul = 'autori';
		}
		return array('resul' => $resul,);
	}

	public function edic(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(22);
		if ($authori_status['permi'] >= 5) {
			$id = $_POST['id'];
			$chain = Chain::find($id);
			$bw = ControllerEquipment_Model::format_bw($chain->bw);
			$data = array( 
				'name' => $chain->name,
				'extreme_1' => $chain->extreme_1,
				'extreme_2' => $chain->extreme_2,
				'bw' => $bw['data'],
				'max' => $bw['logo'],
				'commentary' => $chain->commentary ,
			);
			return array('resul' => 'yes', 'data' => $data);
		}else{
			return array('resul' => 'autori', );
		}
	}

	public function update(RequestChain $request){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(22);
		if ($authori_status['permi'] >= 5) {
			$bw = $request->BW * $request->max;
			$chain = Chain::find($request->id_chain);
				$chain->name = $request->name;
				$chain->extreme_1 = $request->extrem_1;
				$chain->extreme_2 = $request->extrem_2;
				$chain->bw = $bw;
				$chain->commentary = $request->commentary;
			ControllerUser_history::store("Modificó la cadena ".$chain->name );
			$chain->save();
			return array('resul' => 'yes', );
		}else{
			return array('resul' => 'autori', );
		}
	}

	public function list_equipmen_agg(){
		if(!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$data = [];
		$info = DB::table('port')		    
		    ->join('board', 'board.id', '=', 'port.id_board')
		    ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
		    ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
		    ->leftJoin('node', 'equipment.id_node', '=', 'node.id')
		    ->where('port.id_chain', '=', $id)
		    ->select('equipment.id','equipment.acronimo','ip.ip','ip.prefixes','node.node','node.cell_id')
		   	->groupBy('equipment.id','equipment.acronimo','ip.ip','ip.prefixes','node.node','node.cell_id')->get();
		foreach ($info as $value) {
			$port_all = '';
			$info_port = DB::table('port_equipment_model')		    
			    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			    ->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
			    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
			    ->join('port', 'board.id', '=', 'port.id_board')
			    ->where('port.id_chain', '=', $id)
			    ->where('board.id_equipment', '=', $value->id)
			    ->select('port.id','port.n_port','list_label.name','board.slot')
			    ->groupBy('port.id','port.n_port','list_label.name','board.slot')->get();
			foreach ($info_port as $valor) {
				$fsp_label = ControllerRing::label_por($valor->slot);
			   	$port_all = $port_all.$valor->name.$fsp_label.$valor->n_port.'<br>';
			}
			$data[] = array(
				'id' => $value->id,
				'acronimo' => $value->acronimo, 
				'node' => '"'.$value->cell_id.'" '.$value->node, 
				'ip' => $value->ip.'/'.$value->prefixes, 
				'port' => $port_all, 
			);
		}
		return array('resul' => 'yes', 'datos' => $data,);
	}

	function search_equipmen_agg(){
		$agg =DB::table('equipment')
			->join('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
			->join('node', 'equipment.id_node', '=', 'node.id')
			->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
			->where('equipment.id_function','=', 1)
			->select('equipment.acronimo', 'equipment.id', 'equipment.status', 'ip.ip', 'ip.prefixes', 'equipment.commentary');
		return datatables()->of($agg)->make(true);
	}


	public function search_equipmen_agg_chain(){
		if(!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$data = [];
		$info = DB::table('port')		    
		    ->join('board', 'board.id', '=', 'port.id_board')
		    ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
		    ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
		    ->where('port.id_chain', '=', $id)
		    ->select('equipment.id','equipment.acronimo','ip.ip','ip.prefixes')
		   	->groupBy('equipment.id','equipment.acronimo','ip.ip','ip.prefixes')->get();
		foreach ($info as $value) {
			$data[] = array(
				'id' => $value->id,
				'acronimo' => $value->acronimo.' '.$value->ip.'/'.$value->prefixes,
			);
		}
		return array('resul' => 'yes', 'datos' => $data,);
	}



	public function port_chain(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id = $_POST['id'];
    	$port = DB::table('equipment')
		    ->join('board', 'board.id_equipment', '=', 'equipment.id')		    
		    ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
		    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
		    ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		    ->where('equipment.id', '=', $id)
		    ->where('board.status', '=', 'ACTIVO')
		    ->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'board.slot', 'list_module_board.name as model', 'board.id')->orderBy('slot', 'asc')->orderBy('port_l_i', 'asc')->get();
		foreach ($port as $val) {
			$fsp_label=ControllerRing::label_por($val->slot);
		    for ($z=$val->port_l_i; $z <= $val->port_l_f; $z++) {
		    	$status_por = DB::table('port')
			    	->Join('status_port', 'port.id_status', '=', 'status_port.id')
			    	->leftJoin('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
					->leftJoin('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
			    	->where('port.id_board', '=', $val->id)
			    	->where('port.n_port', '=', $z)
			    	->select('port.id_status','status_port.name as status', 'lacp_port.lacp_number', 'port.type', 'port.id', 'lacp_port.group_lacp', 'port.commentary')->get(); 
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
			    	'service' => $number,
			    	'id' => $z.'~'.$val->id,
			    	'board' => $val->id,
			    	'commentary' => $commentary,
			    );
		    }
		}
		$port_order  = array_column($data_mostrar, 'por_selec');
		$pose_order  = array_column($data_mostrar, 'f_s_p');
		array_multisort($pose_order, SORT_ASC, $port_order, SORT_ASC, $data_mostrar);
		return array('resul' => 'yes', 'datos' => $data_mostrar,);
    }

    public function resource_agg(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id = $_POST['id'];
    	$port = $_POST['port'];
    	foreach ($port as $value) {
    		$divi = explode('~', $value);
    		$info_port = DB::table('port')
    		->join('board', 'port.id_board', '=', 'board.id')	
    		->join('port_equipment_model', 'board.id_port_model','=','port_equipment_model.id')
		    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			->where('port.id_board', '=', $divi[1])
			->where('port.n_port', '=', $divi[0])
			->select('port.id_status','port.id','list_label.name','board.slot')->get();
			if (count($info_port)>0) {
				$fsp_label = ControllerRing::label_por($info_port[0]->slot);
				$data[] = array(
					'id' => $info_port[0]->id, 
					'port' => $info_port[0]->name.$fsp_label.$divi[0],
				);
			}else{
				$port_new = new Port();
					$port_new->id_status = 2;
					$port_new->id_board = $divi[1];
					$port_new->n_port = $divi[0];
				$port_new->save();
				$port_info = DB::table('port')
		    		->join('board', 'port.id_board', '=', 'board.id')	
		    		->join('port_equipment_model', 'board.id_port_model','=','port_equipment_model.id')
				    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
					->where('port.id_board', '=', $port_new->id_board)
					->where('port.n_port', '=', $port_new->n_port)
					->select('port.id_status','port.id','list_label.name','board.slot')->get();
				$fsp_label = ControllerRing::label_por($port_info[0]->slot);
				$data[] = array(
					'id' => $port_info[0]->id, 
					'port' => $port_info[0]->name.$fsp_label.$divi[0],
				);
			}
    	}
    	return array('resul' => 'yes', 'datos' => $data,);
    }

    public function insert_resource(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id = $_POST['id'];
    	$port = $_POST['port'];
    	$port_info = DB::table('port')->whereIn('port.id', $port)
    		->where('port.id_status', '!=', 2)
    		->select('port.id')->get();
    	if (count($port_info) == 0) {
	    	foreach ($port as $value) {
	    		$port_new = Port::find($value);
					$port_new->id_status = 1;
					$port_new->id_chain = $id;
					$port_new->type = 'CADENA';
				$port_new->save();
			#info para guardar en log
			$info_port = DB::table('port')
				->Join('board', 'port.id_board', '=', 'board.id')
				->Join('status_port', 'port.id_status', '=', 'status_port.id')
				->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->Join('chain', 'port.id_chain', '=', $id)
				->whereIn('port.id', $value)
				->select('equipment.id', 'equipment.acronimo', 'board.slot', 'port.n_port', 'list_label.name', 'status_port.name as status','chain.name as chain')->get();
			$fsp_label = ControllerRing::label_por($info_port[0]->slot);
			$msj_info = $info_port[0]->name.$fsp_label.$info_port[0]->n_port;
			ControllerUser_history::store("Modifico el estado del puerto ".$msj_info." a ".$info_port[0]->status." del equipo ".$info_port[0]->acronimo." de la cadena ".$info_port[0]->chain);
			#termina info para guardar en log
			}

    		$resul = 'yes';
    	}else{
    		$resul = 'nop';
    	}
		return array('resul' => $resul,);
    }

	public function relate_port_agg(){
		
		$id = $_POST['id'];
		$data = [];
		$info = DB::table('port')		    
		    ->join('board', 'board.id', '=', 'port.id_board')
		    ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
		    ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
		    ->leftJoin('node', 'equipment.id_node', '=', 'node.id')
		    ->where('port.id_chain', '=', $id)
		    ->select('equipment.id','equipment.acronimo','ip.ip','ip.prefixes','node.node','node.cell_id')
		   	->groupBy('equipment.id','equipment.acronimo','ip.ip','ip.prefixes','node.node','node.cell_id')->get();
		foreach ($info as $value) {
			$port_all = '';
			$info_port = DB::table('port_equipment_model')		    
			    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			    ->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
			    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
			    ->join('port', 'board.id', '=', 'port.id_board')
			    ->where('port.id_chain', '=', $id)
			    ->where('board.id_equipment', '=', $value->id)
			    ->select('port.id','port.n_port','list_label.name','board.slot')
			    ->groupBy('port.id','port.n_port','list_label.name','board.slot')->get();
			foreach ($info_port as $valor) {
				$fsp_label = ControllerRing::label_por($valor->slot);
			   	$port_all = $port_all.$valor->name.$fsp_label.$valor->n_port.'<br>';
			}
			$data[] = array(
				'id' => $value->id,
				'acronimo' => $value->acronimo, 
				'port' => $port_all, 
			);
		}
		return array('resul' => 'yes', 'datos' => $data,);
	}
	public function show_ports_agg(){
		$data = [];
		$id = $_POST['id'];
		$info = DB::table('equipment')
			->join('board', 'board.id_equipment', '=', 'equipment.id')
		    ->join('port', 'board.id', '=', 'port.id_board')
			->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
			->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		    ->where('equipment.id', '=', $id)
			->whereNotNull('port.id_chain')
		    ->select('port.id','list_label.name as label','list_port.name as port','board.slot','port.n_port','board.id as board', 'port_equipment_model.bw_max_port', 'port.connected_to')
		   	->groupBy('port.id','list_label.name','list_port.name','board.slot','port.n_port', 'board.id', 'port_equipment_model.bw_max_port', 'port.connected_to')->get();

		foreach($info as $value){
			$slot_lis = ControllerRing::label_por($value->slot);
			$inf = ControllerPort::inf_por_indivi_todo($value->board, $value->n_port);
			$bw = ControllerEquipment_Model::format_bw($value->bw_max_port);

			$data[] = array(
				'id' => $value->id,
				'tipo_puerto' => $value->port, 
				'port' => $value->label.$slot_lis.$value->n_port,
				'bw' => $bw['data'].$bw['signo'], 
				'atributo' => $inf['atributo'],
				'status' => $inf['status'],
				'id_status' => $inf['id_status'],
				'connected_to' => $value->connected_to,
			);
		}
		$prueba_data = array(
			'resul' => 'yes',
			'datos' => $data,
		);
		return $prueba_data;
	}
	public function relate_chain_ports(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(22);
		if ($authori_status['permi'] >= 5) {
				
			$puerto_a_id = $_POST['puerto_a'];
			$comment_a = $_POST['coment_a']; 
			$puerto_b_id = $_POST['puerto_b'];
			$comment_b = $_POST['coment_b'];
			
			$port_a = Port::find($puerto_a_id);
			$port_b = Port::find($puerto_b_id);
			
			$port_a->connected_to = $puerto_b_id;
			$port_a->commentary = $comment_a;
			$port_b->connected_to = $puerto_a_id;
			$port_b->commentary = $comment_b;

			#info para guardar en log
			$info_port = DB::table('port')
				->Join('board', 'port.id_board', '=', 'board.id')
				->Join('status_port', 'port.id_status', '=', 'status_port.id')
				->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->Join('chain', 'port.id_chain', '=', 'chain.id')
				->whereIn('port.id', [$port_a->id, $port_b->id])
				->select('equipment.id', 'equipment.acronimo', 'board.slot', 'port.n_port', 'list_label.name', 'status_port.name as status','chain.name as chain')->get();
				
			$fsp_label = ControllerRing::label_por($info_port[0]->slot);
			$fsp_label_aux = ControllerRing::label_por($info_port[1]->slot);
			
			ControllerUser_history::store("Relacionó el puerto ".$info_port[0]->name.$fsp_label.$info_port[0]->n_port." con el ".$info_port[1]->name.$fsp_label_aux.$info_port[1]->n_port." dentro de la cadena ".$info_port[0]->chain);
			#termina info para guardar en log

			$port_a->save();
			$port_b->save();
			
			return array('resul' => 'yes');
		}else{
			return array('resul' => 'autori', );
		}
	}
	public function delete_chain_ports(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(22);
		if ($authori_status['permi'] >= 5) {
				
			$puerto_a_id = $_POST['puerto_a'];
			$puerto_b_id = $_POST['puerto_b'];
			
			$port_a = Port::find($puerto_a_id);
			$port_b = Port::find($puerto_b_id);
			
			$port_a->connected_to = '';
			$port_a->commentary = '';
			$port_b->connected_to = '';
			$port_b->commentary = '';

			$port_a->save();
			$port_b->save();
			
			#info para guardar en log
			$info_port = DB::table('port')
				->Join('board', 'port.id_board', '=', 'board.id')
				->Join('status_port', 'port.id_status', '=', 'status_port.id')
				->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->Join('chain', 'port.id_chain', '=', 'chain.id')
				->whereIn('port.id', [$puerto_a_id, $puerto_b_id])
				->select('equipment.id', 'equipment.acronimo', 'board.slot', 'port.n_port', 'list_label.name', 'status_port.name as status','chain.name as chain')->get();
				
			$fsp_label = ControllerRing::label_por($info_port[0]->slot);
			$fsp_label_aux = ControllerRing::label_por($info_port[1]->slot);
			
			ControllerUser_history::store("Eliminó la relación del puerto ".$info_port[0]->name.$fsp_label.$info_port[0]->n_port." con el ".$info_port[1]->name.$fsp_label_aux.$info_port[1]->n_port." dentro de la cadena ".$info_port[0]->chain);
			#termina info para guardar en log
			
			return array('resul' => 'yes');
		}else{
			return array('resul' => 'autori', );
		}
	}
	public function search_chain_relations(){
		if(!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$data = [];
		$chain = Chain::find($id);
		$info = DB::table('port')		    
		    ->join('board', 'board.id', '=', 'port.id_board')
		    ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
		    ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
		    ->leftJoin('node', 'equipment.id_node', '=', 'node.id')
		    ->where('port.id_chain', '=', $id)
			->whereNotNull('port.connected_to')
		    ->select('equipment.id','equipment.acronimo','ip.ip','ip.prefixes','node.node','node.cell_id','port.commentary', 'port.connected_to', 'port.id as id_port')
		   	->groupBy('equipment.id','equipment.acronimo','ip.ip','ip.prefixes','node.node','node.cell_id', 'port.commentary', 'port.connected_to', 'port.id')->get();
		foreach ($info as $value) {
			$port_all = '';
			$info_port = DB::table('port_equipment_model')		    
			    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			    ->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
			    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
			    ->join('port', 'board.id', '=', 'port.id_board')
			    ->where('port.id_chain', '=', $id)
			    ->where('board.id_equipment', '=', $value->id)
				->where('port.id','=', $value->id_port)
				->whereNotNull('port.connected_to')
			    ->select('port.id','port.n_port','list_label.name','board.slot')
			    ->groupBy('port.id','port.n_port','list_label.name','board.slot')->get();
			foreach ($info_port as $valor) {
				$fsp_label = ControllerRing::label_por($valor->slot);
			   	$port_all = $port_all.$valor->name.$fsp_label.$valor->n_port;
			}
			$data[] = array(
				'id' => $value->id,
				'id_port' => $value->id_port,
				'acronimo' => $value->acronimo,
				'comentario' => $value->commentary,
				'conectado' => $value->connected_to,
				'port' => $port_all, 
			);
		}
		$prueba_data = array(
			'resul' => 'yes',
			'datos' => $data,
			'nombre_cadena' => $chain->name,
		);
		return $prueba_data;
	}
	public function search_equipments_chain(){
		if(!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$data = [];
		$info = DB::table('port')		    
		    ->join('board', 'board.id', '=', 'port.id_board')
		    ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
		    ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
		    ->where('port.id_chain', '=', $id)
		    ->select('equipment.id','equipment.acronimo','ip.ip','ip.prefixes', 'equipment.commentary')
		   	->groupBy('equipment.id','equipment.acronimo','ip.ip','ip.prefixes', 'equipment.commentary')->get();
		foreach ($info as $value) {
			$data[] = array(
				'id' => $value->id,
				'acronimo' => $value->acronimo,
				'ip_gestion' => $value->ip.'/'.$value->prefixes,
				'commentario' => $value->commentary,
			);
		}
		return array('resul' => 'yes', 'datos' => $data,);
	}
	public function port_chain_list(){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id = $_POST['id'];
    	$port = DB::table('equipment')
		    ->join('board', 'board.id_equipment', '=', 'equipment.id')		    
		    ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
		    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
		    ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		    ->where('equipment.id', '=', $id)
		    ->where('board.status', '=', 'ACTIVO')
		    ->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'board.slot', 'list_module_board.name as model', 'board.id')->orderBy('slot', 'asc')->orderBy('port_l_i', 'asc')->get();
		foreach ($port as $val){
			$fsp_label=ControllerRing::label_por($val->slot);
		    for ($z=$val->port_l_i; $z <= $val->port_l_f; $z++) {
		    	$status_por = DB::table('port')
			    	->Join('status_port', 'port.id_status', '=', 'status_port.id')
			    	->leftJoin('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
					->leftJoin('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
			    	->where('port.id_board', '=', $val->id)
			    	->where('port.n_port', '=', $z)
			    	->select('port.id_status','status_port.name as status', 'lacp_port.lacp_number', 'port.type', 'port.id', 'lacp_port.group_lacp', 'port.commentary', 'port.connected_to', 'port.id as id_port')->get(); 
		    	$grupos = '';
		    	$status = '2';
		    	$atributo = 'VACANTE';
		    	$name = '';
		    	$type = '';
		    	$number = '';
		    	$commentary = '';
				$connected_to = '';
				$id_port= '';
		    	if (count($status_por) > 0){
			    	$status = $status_por[0]->id_status;
			    	$atributo = $status_por[0]->status;
			    	$type = $status_por[0]->type;
					$connected_to = $status_por[0]->connected_to;
					$id_port = $status_por[0]->id_port;
		    		if ($status_por[0]->group_lacp == 'SI') {
		    			$atributo = 'LACP | '.$status_por[0]->lacp_number;
		    			$dividir_grupo = explode('-', $status_por[0]->lacp_number);
		    			$name = $dividir_grupo[1];
		    			$number = '';
						$id_port = $status_por[0]->id_port;

		    		}else{
		    			$number = ControllerService::number_service($z, $val->id);
						$id_port = $status_por[0]->id_port;
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
			    	'service' => $number,
			    	'id' => $z.','.$val->id,
			    	'board' => $val->id,
			    	'commentary' => $commentary,
					'id_port' => $id_port,
					'connected_to' => $connected_to,
			    );
		    }
		}
		$port_order  = array_column($data_mostrar, 'por_selec');
		$pose_order  = array_column($data_mostrar, 'f_s_p');
		array_multisort($pose_order, SORT_ASC, $port_order, SORT_ASC, $data_mostrar);
		return array('resul' => 'yes', 'datos' => $data_mostrar,);
    }
	
	public function add_selected_ports(){
		if(!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['chain_id'];
		$port = $_POST['ports'];
		$chain = Chain::find($id);
		foreach ($port as $value) {
			$division = explode(',', $value);
			$info_port = DB::table('port')
			->where('port.id_board', '=', $division[1])
			->where('port.n_port', '=', $division[0])
			->select('port.id_status','port.id', 'port.n_port')->get();
			if (count($info_port)>0) {
				$port_old = Port::find($info_port[0]->id);
					$port_old->id_status = 1;
					$port_old->id_chain = $id;
					$port_old->type = 'CADENA';
				$port_old->save();
				$port_id = $info_port[0]->id;
			}else{
				$port_new = new Port();
					$port_new->id_board = $division[1];
					$port_new->n_port = $division[0];
					$port_new->id_status = 1;
					$port_new->id_chain = $id;
					$port_new->type = 'CADENA';
				$port_new->save();
				$port_id = $port_new->id;
			}
			$port_info = DB::table('port')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->join('port_equipment_model', 'board.id_port_model','=','port_equipment_model.id')
				->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->join('status_port', 'port.id_status', '=', 'status_port.id')
				->where('port.id', '=', $port_id)
				->select('port.id_status','port.id', 'port.n_port', 'list_label.name','board.slot','equipment.acronimo','status_port.name as statusport')->get();
			$fsp_label = ControllerRing::label_por($port_info[0]->slot);

			$msj = $port_info[0]->name.$fsp_label.$port_info[0]->n_port;
			$msj_info = "Modifico el estado del puerto ".$msj." a ".$port_info[0]->statusport." del equipo ".$port_info[0]->acronimo." de la cadena ".$chain->name;
			ControllerUser_history::store($msj_info);
		}
		return array('resul' => 'yes');
	}
	public function delete_selected_ports(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(22);
		if ($authori_status['permi'] >= 5) {
			$selected = $_POST['selected'];
			foreach ($selected as $value) {
				$port_new = Port::find($value);
					$port_new->id_status = 2;
					$port_new->id_chain = null;
					$port_new->type = null;
				$port_new->save();
				$chain = Chain::find($id);
				$equipo = DB::table('port')
				->Join('board', 'port.id_board', '=', 'board.id')
				->Join('status_port', 'port.id_status', '=', 'status_port.id')
				->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
				->where('port.id', '=', $value)
				->select('equipment.id', 'equipment.acronimo', 'board.slot', 'port.n_port', 'list_label.name', 'status_port.name as status')->get();
				
				$fsp_label = ControllerRing::label_por($equipo[0]->slot);
				$msj_info = $equipo[0]->name.$fsp_label.$equipo[0]->n_port;
				ControllerUser_history::store("Modifico el estado del puerto ".$msj_info." a ".$equipo[0]->status." del equipo ".$equipo[0]->acronimo." de la cadena ".$chain->name);			
			}
			return array('resul' => 'yes');
		}else{
			return array('resul' => 'autori', );
		}
	}
	public function delete_all_ports_equipment_chain(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(22);
		$puertos_conectados = 0;
		if ($authori_status['permi'] >= 5) {
			$id = $_POST['id'];
			$info = DB::table('equipment')
			->join('board', 'board.id_equipment', '=', 'equipment.id')
			->oin('status_port', 'port.id_status', '=', 'status_port.id')
		    ->join('port', 'board.id', '=', 'port.id_board')
			->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
			->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		    ->where('equipment.id', '=', $id)
			->whereNotNull('port.id_chain')
		    ->select('port.id','list_label.name as label','list_port.name as port','board.slot','port.n_port','board.id as board', 'port_equipment_model.bw_max_port', 'port.connected_to', 'status_port.name as status')
		   	->groupBy('port.id','list_label.name','list_port.name','board.slot','port.n_port', 'board.id', 'port_equipment_model.bw_max_port', 'port.connected_to', 'status_port.name')->get();
			foreach ($info as $value)
			{
				if($value->connected_to != null){
					//el return corta todo el proceso y devuelve un 'exists' para el error
					$puertos_conectados++;
				}
			}
			if($puertos_conectados == 0){
				foreach($info as $value)
				{
					$port_new = Port::find($value->id);
						$port_new->id_status = 2;
						$port_new->id_chain = null;
						$port_new->type = null;
						$port_new->commentary = null;

					$port_new->save();
					$fsp_label = ControllerRing::label_por($info[0]->slot);
					$msj_info = $info[0]->name.$fsp_label.$info[0]->n_port;
					ControllerUser_history::store("Modifico el estado del puerto ".$msj_info." a ".$info[0]->status." del equipo ".$info[0]->acronimo);
				}
				return array('resul' => 'yes');
			} else{
				return array('resul' => 'Exist');
			}
		}else{
			return array('resul' => 'autori', );
		}
	}

	public function delete()
	{
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(22);
		$puertos_encontrados = 0;
		if ($authori_status['permi'] >= 5) {
			$id = $_POST['id'];
			
			$port_count = DB::table('port')->where('port.id_chain', '=', $id)
			->count();

			if($port_count == 0){
				$chain = Chain::find($id);
				ControllerUser_history::store("Elimino la cadena ".$chain->name );
				$chain->delete();
				return array('resul' => 'yes');
			}else{
				return array('resul' => 'Exist');
			}
		}else{
			return array('resul' => 'autori', );
		}
	}
}