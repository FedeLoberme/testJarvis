<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Constants;
use Jarvis\Http\Requests\RequestPort_Equipment_Model;
use Jarvis\Port_Equipment_Model;
use Jarvis\Equipment_Model;
use Jarvis\List_Equipment;
use Jarvis\List_Connector;
use Jarvis\List_Label;
use Jarvis\List_Module_Board;
use Jarvis\List_Port;
use Jarvis\User;
use Jarvis\List_Mark;
use Jarvis\Http\Controllers\ControllerEquipment_Model;
use Jarvis\Http\Controllers\ControllerUser_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use DB;
class ControllerPort_Equipment_Model extends Controller
{
// -----------------Funcion para registra agregar puerto--------------------
	public function crear($id=null){
      	if (!Auth::guest() == false){ return redirect('login')
      ->withErrors([Lang::get('validation.login'),]);}
      $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      $authori_status_port = User::authorization_status(6);
      	if ($authori_status['permi'] >= 5 || $authori_status_port['permi'] >= 3){
      		if ($id == null) {
      			$id = 0;
      			$equipm = 0;
      		}else{
      			$data_equipment = Equipment_Model::data_equipment($id);
      			$equipm = $data_equipment[0];
      		}
		$equipment = Equipment_Model::List();
		$list_connector=DB::table('List_Connector')->orderBy('name', 'asc')->get();
		$list_label=DB::table('List_Label')->orderBy('name', 'asc')->get();
		$list_module_board=DB::table('List_Module_Board')->orderBy('name', 'asc')->get();
		$list_port=DB::table('List_Port')->orderBy('name', 'asc')->get();
			$selection = array(
								'connector' =>$list_connector ,
								'label' =>$list_label ,
								'module_board' =>$list_module_board,
								'list_port' =>$list_port,
							);
	      $por= Port_Equipment_Model::port();
	      $port_exi[]= '';
	      $port[]='';
	      foreach ($por as $por){
	      	$bw=ControllerEquipment_Model::format_bw($por->bw_max_port);
	      	$bw_final = $bw['data'].' '.Lang::get('equipment_model.bw.'.$bw['logo']);
	      	$relation = Port_Equipment_Model::relation($por->id, $id);
	      	if (count($relation) > 0) {
	      		if ($relation[0]->description_label <> null) {
		      		$fsp= ControllerPort_Equipment_Model::fsp($relation[0]->description_label);
		      		$fsp_full = '';
		      		foreach ($fsp as $value) {
		      			$pocicion= $value['let'].'('.$value['min'].'-'.$value['max'].')';
		      			if ($fsp_full == '') {
		      				$fsp_full = $pocicion;
		      			}else{
		      				$fsp_full = $fsp_full.' '.$fsp[0]['sep'].' '.$pocicion;
		      			}
		      		}
	      		}else{
	      			$fsp_full = 'No Aplica';
	      		}
	      		$rela = $relation[0]->id;
	      		$status = $relation[0]->status;
	      		$port_exi[] = array(
	      		'quantity' => $por->quantity,
		      	'port_f_i' => $por->port_f_i,
		      	'port_f_f' => $por->port_f_f,
		      	'f_s_p' =>$fsp_full,
		      	't_port' => $por->port,
		      	'connector' => $por->connector,
		      	'bw_max_port' => $bw_final,
		      	'label' => $por->label,
		        'port_l_i' => $por->port_l_i,
		        'port_l_f' => $por->port_l_f,
		        'module_board' => $por->board,
		        'type_board' => $por->type_board,
		        'id' => $por->id,
		        'relation' => $rela,
		        'status' => $status,
	      		);
	      	}else{
	      		$rela = 'nop';
	      		$status = 'nop';
	      			$port[] = array(
			      		'quantity' => $por->quantity,
				      	'port_f_i' => $por->port_f_i,
				      	'port_f_f' => $por->port_f_f,
				      	't_port' => $por->port,
				      	'connector' => $por->connector,
				      	'bw_max_port' => $bw_final,
				      	'label' => $por->label,
				        'port_l_i' => $por->port_l_i,
				        'port_l_f' => $por->port_l_f,
				        'module_board' => $por->board,
				        'type_board' => $por->type_board,
				        'id' => $por->id,
				        'relation' => $rela,
				        'status' => $status,
	      			);
	      	}
	      }

	    return view('equipment_model.selec',compact('equipment', 'authori_status', 'id', 'port', 'port_exi', 'authori_status_port','selection','equipm'));
     	}else{
     		return 	redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
     	}
  	}

  	public static function fsp($data){
  		if ($data != null) {
	  		$etapa1= explode('#', $data);
		    foreach ($etapa1 as $value) {
		    	$etapa2 = explode('%', $value);
		    	$fin[] = array(
		    		'let' => $etapa2[0],
		    		'min' => $etapa2[1],
		    		'max' => $etapa2[2],
		    		'sep' => $etapa2[3],
		    	);
		    }
  		}else{
  			$fin[] = array(
  				'let' => '',
		    	'min' => '',
		    	'max' => '',
		    	'sep' => '',
		    );
  		}
	    return $fin;
  	}

// -----------------Funcion para buscar puerto---------------------------
	public function port(){
      	if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id=$_POST['id'];
      	$authori_status = User::authorization_status(6);
      	if ($authori_status['permi'] >= 5) {
        	$port =Port_Equipment_Model::find($id);
      $bw_max = ControllerEquipment_Model::format_bw($port->bw_max_port);
        	if ($port <> null) {
        		$data = array(
        			'resul'=> 'yes',
			        'id' => $port->id,
			        'quantity' => $port->quantity,
			        'porf_f_i' => $port->port_f_i,
			        'port_f_f' => $port->port_f_f,
			        't_port' => $port->id_list_port,
			        'connector' => $port->id_connector,
			        'bw_max_port' =>$bw_max['data'],
			        'bw_max_port_logo' =>$bw_max['logo'],
			        'label' => $port->id_label,
			        'port_l_i' => $port->port_l_i,
			        'port_l_f' => $port->port_l_f,
			        'module_board' => $port->id_module_board,
			        'type_board' => $port->type_board,
			        'cod_sap' => $port->cod_sap,
        		);
        	}else{
        		$data = 'no';
        	}
        	return $data;
      	}else{
        	return $data = 'home';
      	}
  	}

  	public function insert_update_placa(RequestPort_Equipment_Model $request){
  		if (!Auth::guest() == false){ return $data = array('resul' => 'login', ); }
      	$authori_status = User::authorization_status(6);
		if ($authori_status['permi'] >= 5){
			$bw_max_n = $request->input('n_max');
			$bw_max = $request->input('max');
			$m_placa =$request->input('m_placa');
			$type_placa =$request->input('type_placa');
			$canti =$request->input('canti');
			$pfi =$request->input('pfi');
			$pff =$request->input('pff');
			$type_port =$request->input('type_port');
			$conector =$request->input('conector');
			$label =$request->input('label');
			$pli =$request->input('pli');
			$plf =$request->input('plf');
			$id =$request->input('id');
			$sap =$request->input('sap');
			$bw_max_port = $bw_max_n * $bw_max;
			$exist = Port_Equipment_Model::exists($canti, $pfi, $pff, $type_port, $conector, $bw_max_port, $label, $pli, $plf, $m_placa, $type_placa, $id);
			if (count($exist) <> 0) {
				$data = array('resul' => 'exist', );
			}else{
				if ($id != 0) {
					$pla = DB::table('board')
						->where('board.id_port_model', '=', $id) ->select('board.id')->get();
					if (count($pla) == 0) {
						$msj_placa = 'Modifico el modelo de placa ';
						$port = Port_Equipment_Model::find($id);
					}else{
						return array('resul' => "utilizando", );
					}
				}else{
					if ($authori_status['permi'] >= 10){
						$msj_placa = 'Registro el modelo de placa ';
						$port = new Port_Equipment_Model();
						$port->id_module_board = $m_placa;
					}else{
						return array('resul' => 'authori',);
					}
				}
				    $port->type_board = $type_placa;
				    $port->quantity = $canti;
				    $port->port_f_i = $pfi;
				    $port->port_f_f = $pff;
				    $port->id_list_port = $type_port;
				    $port->id_connector = $conector;
				    $port->bw_max_port = $bw_max_port;
				    $port->id_label = $label;
				    $port->port_l_i = $pli;
				    $port->port_l_f = $plf;
				    $port->cod_sap = $sap;
			    $port->save();
			    $info_board = List_Module_Board::find($port->id_module_board);
			    ControllerUser_history::store($msj_placa.$info_board->name);
			    $data = array('resul' => "yes", );
			}
		}else{
			$data = array('resul' => 'authori',);
		}
		return $data;
  	}


  	// -----------------Funcion para registra equipo--------------------


  	public function inf_equip(){
  		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		if ($autori_status['permi'] >= 3){
	  		$id= $_POST['id'];
			$port_info_existe = DB::table('port_equipment_model')
	      	->join('relation_port_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
	      	->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
	      	->join('list_connector', 'port_equipment_model.id_connector', '=', 'list_connector.id')
	      	->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
	      	->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		 	->where('relation_port_model.id_equipment_model', '=', $id)
		 	->select('port_equipment_model.quantity', 'port_equipment_model.port_f_i', 'port_equipment_model.port_f_f', 'list_port.name as port', 'list_connector.name as connector', 'port_equipment_model.bw_max_port', 'list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_module_board.name as module_board', 'port_equipment_model.type_board','relation_port_model.id', 'relation_port_model.status', 'relation_port_model.description_label as fsp', 'list_label.name as label')->get();
		 	$contar = count($port_info_existe);
		 	$port_info_exi = [];
			foreach ($port_info_existe as $value) {
			 		$bw=ControllerEquipment_Model::format_bw($value->bw_max_port);
			 		$port_info_exi[] = array(
			 			'contar' => $contar,
			 			'quantity' => $value->quantity ,
			 			'port_f_i' => $value->port_f_i ,
			 			'port_f_f' => $value->port_f_f ,
			 			'port' => $value->port ,
			 			'connector' => $value->connector ,
			 			'bw_max_port' => $bw['data'].$bw['signo'],
			 			'label' => $value->label ,
			 			'port_l_i' => $value->port_l_i ,
			 			'port_l_f' => $value->port_l_f ,
			 			'type_board' => $value->type_board ,
			 			'module_board' => $value->module_board ,
			 			'id' => $value->id ,
			 			'status' => $value->status ,
			 			'fsp' => $value->fsp ,
			 		);
			}
			$data = array('resul' => 'yes', 'datos' => $port_info_exi,);
      	}else{
      		$data = array('resul' => 'autori', );
      	}
      	return $data;
	}

	public function index(){
      	$authori_status = User::authorization_status(6);
		$por= Port_Equipment_Model::port();
		$equipment = Equipment_Model::List();
		$list_connector=DB::table('List_Connector')->orderBy('name', 'asc')->get();
		$list_label=DB::table('List_Label')->orderBy('name', 'asc')->get();
		$list_module_board=DB::table('List_Module_Board')->orderBy('name', 'asc')->get();
		$list_port=DB::table('List_Port')->orderBy('name', 'asc')->get();
		$selection = array(
							'connector' =>$list_connector ,
							'label' =>$list_label ,
							'module_board' =>$list_module_board,
							'list_port' =>$list_port,
						);
		return view('equipment_model.list_placa',compact('equipment', 'authori_status','selection'));
	}

	public function index_list(){
		$port_all = [];
		$port = DB::table('port_equipment_model')
		->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		->join('list_connector', 'port_equipment_model.id_connector', '=', 'list_connector.id')
		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
      ->select('list_module_board.name as module_board', 'port_equipment_model.type_board', 'port_equipment_model.quantity','port_equipment_model.port_f_i','port_equipment_model.port_f_f', 'list_port.name as port', 'list_connector.name as connector', 'port_equipment_model.bw_max_port', 'list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'port_equipment_model.id')->get();
      	foreach ($port as $value) {
	      	$bw = ControllerEquipment_Model::format_bw($value->bw_max_port);
	      	$port_all[] = array(
	      		'module_board' => $value->module_board,
	      		'type_board' => $value->type_board,
	      		'quantity' => $value->quantity,
	      		'port_f_i' => $value->port_f_i,
	      		'port_f_f' => $value->port_f_f,
	      		'port' => $value->port,
	      		'connector' => $value->connector,
				//'bw_max_port' => $value->bw_max_port,
	      		'bw_max_port' => $bw['data'].' '.$bw['signo'],
	      		'label' => $value->label,
	      		'port_l_i' => $value->port_l_i,
	      		'port_l_f' => $value->port_l_f,
	      		'id' => $value->id,
	      	);
      	}
      return datatables()->of($port_all)->make(true);
	}

	public function type_board_name(){
		$id= $_POST['id'];
		$port =Port_Equipment_Model::find($id);
		$resul = array(	'resul' => 'yes',
						'name' => $port->type_board, );
		return $resul;
	}

	public function add_port($id = null){
		if ($id == null) {
			$id= $_POST['equi_alta'];
		}
		$port = DB::table('port_equipment_model')
		->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
		->join('relation_port_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
		->where('port_equipment_model.type_board', '!=', 'ONBOARD')
		->where('port_equipment_model.status', '=', 'ALTA')
		->where('relation_port_model.status', '=', 'Activo')
		->where('relation_port_model.id_equipment_model', '=', $id)
		->select('list_module_board.name as module_board', 'port_equipment_model.type_board', 'port_equipment_model.quantity', 'list_port.name as port', 'port_equipment_model.bw_max_port', 'list_label.name as label','port_equipment_model.id', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f')->get();
		$con =count($port);
		if ($con > 0) {
			foreach ($port as $value) {
				$datos[] = array(
					'contar' => $con,
					'id' => $value->id,
					'board' => $value->module_board,
					'type_board' => $value->type_board,
					'quantity' => $value->quantity,
					'port' => $value->port,
					'bw_max_port' => $value->bw_max_port,
					'label' => $value->label,
					'port_i' => $value->port_l_i,
					'port_f' => $value->port_l_f,
				);
			}
		}else{
			$datos[] = array('contar' => 0,);
		}
		return $datos;
	}

	public function add_port_ONBOARD(){
		$id= $_POST['equi_alta'];
		$port = DB::table('port_equipment_model')
		->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
		->join('relation_port_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
		->where('port_equipment_model.type_board', '=', 'ONBOARD')
		->where('relation_port_model.status', '=', 'Activo')
		->where('port_equipment_model.status', '=', 'ALTA')
		->where('relation_port_model.id_equipment_model', '=', $id)
		->select('list_module_board.name as module_board', 'port_equipment_model.type_board', 'port_equipment_model.quantity', 'list_port.name as port', 'port_equipment_model.bw_max_port', 'list_label.name as label','port_equipment_model.id', 'relation_port_model.description_label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f')->get();
		$con =count($port);
		$board = ControllerPort_Equipment_Model::add_port($id);
		if ($board[0]['contar'] > 0) {
			$placas = 'yes';
		}else{
			$placas = 'nop';
		}
		if ($con > 0) {
			$label = '';
			foreach ($port as $value) {

				if ($value->description_label != null) {
					$face = explode('#', $value->description_label);
					$lab = "";
					foreach ($face as $val) {
						$array = explode('%', $val);
						$lab = $lab.''.$array[1].'|';
					}
					$sacar = explode('%', $face[0]);
					$label_listo = $lab.''.$sacar[3];


				}else{
					$label_listo = '@|@';
				}
				$datos[] = array(
					'otras' => $placas,
					'contar' => $con,
					'id' => $value->id,
					'board' => $value->module_board,
					'type_board' => $value->type_board,
					'quantity' => $value->quantity,
					'port' => $value->port,
					'bw_max_port' => $value->bw_max_port,
					'label' => $label_listo,
					'label2' => $value->label,
					'port_l_i' =>$value->port_l_i,
					'port_l_f' =>$value->port_l_f,
				);
			}
		}else{
			$datos[] = array('contar' => 0, 'otras' => $placas,);
		}
		return $datos;
	}

	public function list_port_occupied($id_model){
		if (!Auth::guest()==false){return redirect('login')->withErrors([Lang::get('validation.login'),]);}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		if ($authori_status['permi'] >= 5){
			$relation = DB::table('port_equipment_model')
	            ->Join('list_connector', 'list_connector.id', '=', 'port_equipment_model.id_connector')
	            ->Join('list_port', 'list_port.id', '=', 'port_equipment_model.id_list_port')
	            ->Join('list_label', 'list_label.id', '=', 'port_equipment_model.id_label')
	            ->Join('list_module_board', 'list_module_board.id', '=', 'port_equipment_model.id_module_board')
			->Join('relation_port_model', 'port_equipment_model.id', '=', 'relation_port_model.id_port_equipment_model')
	            ->Join('equipment_model', 'equipment_model.id', '=', 'relation_port_model.id_equipment_model')
	            ->where('equipment_model.id', '=', $id_model)
	            ->select('port_equipment_model.quantity', 'port_equipment_model.port_f_i', 'port_equipment_model.port_f_f', 'port_equipment_model.bw_max_port', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'port_equipment_model.type_board', 'relation_port_model.description_label', 'list_connector.name as connector', 'list_port.name as port', 'list_label.name as label', 'list_module_board.name as board', 'relation_port_model.id', 'relation_port_model.status');
	        return datatables()->of($relation)->make(true);
		}else{
     		return 	redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
     	}
	}

	public function list_port_free($id_model){
		if (!Auth::guest()==false){return redirect('login')->withErrors([Lang::get('validation.login'),]);}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		if ($authori_status['permi'] >= 5){
			$port_occupide = DB::table('relation_port_model')->where('id_equipment_model', '=', $id_model)->select('id_port_equipment_model')->get();
			if (count($port_occupide)>0) {
				foreach ($port_occupide as $value) {
					$port_all[] = $value->id_port_equipment_model;
				}
			}else{
				$port_all[] = 0;
			}
			$por = DB::table('port_equipment_model')
	            ->Join('list_connector', 'list_connector.id', '=', 'port_equipment_model.id_connector')
	            ->Join('list_port', 'list_port.id', '=', 'port_equipment_model.id_list_port')
	            ->Join('list_label', 'list_label.id', '=', 'port_equipment_model.id_label')
	            ->Join('list_module_board', 'list_module_board.id', '=', 'port_equipment_model.id_module_board')
	            ->whereNotIn('port_equipment_model.id', $port_all)
	            ->select('port_equipment_model.quantity', 'port_equipment_model.port_f_i', 'port_equipment_model.port_f_f', 'port_equipment_model.bw_max_port', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'port_equipment_model.type_board', 'list_connector.name as connector', 'list_port.name as port', 'list_label.name as label', 'list_module_board.name as board', 'port_equipment_model.id')->get();
	        $port_all_data = [];
	        foreach ($por as $valor) {
	        	$bw_libre = ControllerEquipment_Model::format_bw($valor->bw_max_port);
	        	$port_all_data[] = array(
	        		'quantity' => $valor->quantity,
	        		'port_f_i' => $valor->port_f_i,
	        		'port_f_f' => $valor->port_f_f,
	        		'bw_max_port' => $bw_libre['data'].' '.$bw_libre['signo'],
	        		'port_l_i' => $valor->port_l_i,
	        		'port_l_f' => $valor->port_l_f,
	        		'type_board' => $valor->type_board,
	        		'connector' => $valor->connector,
	        		'port' => $valor->port,
	        		'label' => $valor->label,
	        		'board' => $valor->board,
	        		'id' => $valor->id,
	        	);
	        }
	        return datatables()->of($port_all_data)->make(true);
		}else{
     		return 	redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
     	}
	}

	public function BoardRadioAll(){
	    if (!Auth::guest() == false){ return array('resul' => 'login', ); }
	    $id = $_POST['id'];
	    $antena = [];
	    $odu = [];
	    $Equipment = Equipment_Model::find($id,['id_mark']);
	    $Board = DB::table('port_equipment_model')
	      ->join('relation_port_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
	      ->join('list_port', 'port_equipment_model.id_list_port','=','list_port.id')
	      ->join('list_module_board', 'port_equipment_model.id_module_board','=','list_module_board.id')
	      ->join('list_connector', 'port_equipment_model.id_connector','=','list_connector.id')
	      ->join('list_label', 'port_equipment_model.id_label','=','list_label.id')
	      ->join('list_module_board', 'port_equipment_model.id_module_board','=','list_module_board.id')
	      ->where('relation_port_model.id_equipment_model', '=', $id)
	      ->select('port_equipment_model.quantity', 'port_equipment_model.port_f_i', 'port_equipment_model.port_f_f', 'list_port.name as port', 'list_connector.name as connector', 'port_equipment_model.bw_max_port', 'list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_module_board.name as module_board', 'port_equipment_model.type_board','port_equipment_model.id', 'relation_port_model.status', 'relation_port_model.description_label as fsp', 'list_label.name as label', 'list_module_board.name as board')->get();
	    foreach ($Board as $value) {
	    	$bw = ControllerEquipment_Model::format_bw($value->bw_max_port);
	    	if ($value->port == 'ANTENA' || $value->port == 'ANTENA 15G 60') {
	    		$antena[] = array(
					'id' => $value->id.','.$value->port_l_i,
					'port' => $value->board,
					'bw' => $bw['data'].$bw['signo'],
				);
	    	}
	    	if ($value->port == 'ODU') {
	    		$odu[] = array(
					'id' => $value->id.','.$value->port_l_i,
					'port' => $value->board,
					'bw' => $bw['data'].$bw['signo'],
				);
	    	}
	    }
	    $datos = array(
	    	'antena' => $antena,
	    	'odu' => $odu,
	    );
	    return array('resul' => 'yes', 'datos' => $datos, 'mark' => $Equipment->id_mark,);
	}
}



