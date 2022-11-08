<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Port_Equipment_Model;
use Jarvis\Equipment_Model;
use Jarvis\Function_Equipment_Model;
use Jarvis\Relation_Model_Function;
use Jarvis\User;
use Jarvis\Board;
use Jarvis\Equipment;
use Jarvis\Relation_Port_Model;
use Jarvis\Http\Controllers\ControllerUser_history;
use Jarvis\Http\Controllers\ControllerRing;
use Jarvis\Http\Controllers\ControllerPort_Equipment_Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;
class ControllerBoard extends Controller
{
	public function index_equipo(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$equip = Equipment::find($id, ['id_function']);
		switch ($equip->id_function) {
	    	case '1':
	    		$valida = 7;
	    	break;
	    	case '2':
	    		$valida = 8;
	    	break;
	    	case '3':
	    		$valida = 9;
	    	break;
	    	case '4':
	    		$valida = 13;
	    	break;
			case '5':
	    		$valida = 19;
	    	break;
	    	case '6':
	    		$valida = 20;
	    	break;
	    	case '7':
	    		$valida = 23;
	    	break;
			case '8':
	    		$valida = 27;
	    	break;
	    }
    	$autori_status = User::authorization_status($valida);
		if ($autori_status['permi'] >= 3){
		  	$pla = DB::table('board')
			->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
			->Join('list_connector', 'list_connector.id','=', 'port_equipment_model.id_connector')
	        ->Join('list_module_board', 'list_module_board.id','=', 'port_equipment_model.id_module_board')
	        ->Join('equipment', 'equipment.id','=', 'board.id_equipment')
	        ->Join('list_port', 'list_port.id','=', 'port_equipment_model.id_list_port')
	        ->Join('list_label', 'list_label.id','=', 'port_equipment_model.id_label')
			->where('board.id_equipment', '=', $id)
			->where('board.status', '=', 'ACTIVO')
		    ->select( 'list_module_board.name as board', 'list_port.name as port', 'list_connector.name as connector', 'list_label.name as label', 'port_equipment_model.type_board', 'port_equipment_model.quantity', 'port_equipment_model.port_f_i', 'port_equipment_model.port_f_f', 'port_equipment_model.bw_max_port', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'port_equipment_model.id', 'board.slot', 'equipment.acronimo' )->get();
		    foreach ($pla as $value) {
		    	$slot = ControllerRing::label_por($value->slot);
		    	if ($slot != '' || $slot != null) {
		    		$slot = substr($slot, 0, -1);
		    	}
		    	$resul_placa[] = array(
		    		'board' => $value->board,
		    		'port' => $value->port,
		    		'connector' => $value->connector,
		    		'label' => $value->label,
		    		'type_board' => $value->type_board,
		    		'quantity' => $value->quantity,
		    		'port_f_i' => $value->port_f_i,
		    		'port_f_f' => $value->port_f_f,
		    		'bw_max_port' => $value->bw_max_port,
		    		'port_l_i' => $value->port_l_i,
		    		'port_l_f' => $value->port_l_f,
		    		'id' => $value->id,
		    		'acronimo' => $value->acronimo,
		    		'slot' => $slot,
		    	);
		    }
		    if (count($resul_placa) > 0) {
		    	$pose_por  = array_column($resul_placa, 'slot');
				array_multisort($pose_por, SORT_ASC, $resul_placa);
		    }
		    return array('resul' => 'yes', 'datos' => $resul_placa,);
  		}else{
      		return array('resul' => 'autori', );
      	}
	}

	public static function label_all($valor){
	    $label = '';
	    $dat = explode('#', $valor);
	    $con = count($dat);
	    $separado =$dat[$con - 1];
	    for ($i=0; $i <=($con - 2); $i++) {
	    	if ($label == '') {
	    		$label = $dat[$i];
	    	}else{
	    		$label = $label.' '.$separado.' '.$dat[$i];
	    	}
	    }
	    $resul = array(
			'divi' => $dat,
			'comple' => $label,
		);
		return $resul;
	}

	public function buscar_placa(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id=$_POST['id'];
		$datos_old = [];
		$datos = [];
		$equipment =Equipment::find($id);
		switch ($equipment->id_function) {
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
			case '8':
	    		$status_valida = 27;
	    	break;
		}
		$autori_status = User::authorization_status($status_valida);
		if ($autori_status['permi'] >= 5){
			$new_board = DB::table('equipment')
				->Join('equipment_model', 'equipment_model.id','=', 'equipment.id_model')
				->leftJoin('relation_port_model', 'equipment_model.id','=', 'relation_port_model.id_equipment_model')
				->leftJoin('port_equipment_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
				->leftJoin('list_connector', 'list_connector.id','=', 'port_equipment_model.id_connector')
		        ->leftJoin('list_module_board', 'list_module_board.id','=', 'port_equipment_model.id_module_board')
		        ->leftJoin('list_port', 'list_port.id','=', 'port_equipment_model.id_list_port')
		        ->leftJoin('list_label', 'list_label.id','=', 'port_equipment_model.id_label')
				->where('equipment.id', '=', $id)
				->where('relation_port_model.status', '=', 'Activo')
				->where('port_equipment_model.type_board', '!=', 'ONBOARD')
				->select( 'list_module_board.name as board', 'list_port.name as port', 'list_connector.name as connector', 'list_label.name as label', 'port_equipment_model.type_board', 'port_equipment_model.quantity', 'port_equipment_model.port_f_i', 'port_equipment_model.port_f_f', 'port_equipment_model.bw_max_port', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'port_equipment_model.id', 'relation_port_model.description_label', 'equipment.id_model', 'equipment.id as equipo', 'relation_port_model.id as relation', 'equipment.id_function')->get();
			foreach ($new_board as $valor) {
				$bw_full = ControllerEquipment_Model::format_bw($valor->bw_max_port);
				$fsp = ControllerPort_Equipment_Model::fsp($valor->description_label);
				$pose = '';
				foreach ($fsp as $val) {
					$pose = $pose.$val['let'].'('.$val['min'].'-'.$val['max'].') '.$val['sep'].' ';
				}
				$pose = substr($pose, 0, -2);
				$datos_old[] = array(
					'board' => $valor->board,
					'port' => $valor->port,
					'connector' => $valor->connector,
					'label' => $valor->label,
					'type_board' => $valor->type_board,
					'quantity' => $valor->quantity,
					'port_f_i' => $valor->port_f_i,
					'port_f_f' => $valor->port_f_f,
					'bw_max_port' => $bw_full['data'].$bw_full['signo'],
					'port_l_i' => $valor->port_l_i,
					'port_l_f' => $valor->port_l_f,
					'slot' => $pose,
					'id' => $valor->id,
					'relation' => $valor->relation,
				);
			}
			$placa = DB::table('board')
				->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->Join('list_connector', 'list_connector.id','=', 'port_equipment_model.id_connector')
		        ->Join('list_module_board', 'list_module_board.id','=', 'port_equipment_model.id_module_board')
		        ->Join('equipment', 'equipment.id','=', 'board.id_equipment')
		        ->Join('list_port', 'list_port.id','=', 'port_equipment_model.id_list_port')
		        ->Join('list_label', 'list_label.id','=', 'port_equipment_model.id_label')
				->where('equipment.id', '=', $id)
				->where('board.status', '=', 'ACTIVO')
			    ->select( 'list_module_board.name as board', 'list_port.name as port', 'list_connector.name as connector', 'list_label.name as label', 'port_equipment_model.type_board', 'port_equipment_model.quantity', 'port_equipment_model.port_f_i', 'port_equipment_model.port_f_f', 'port_equipment_model.bw_max_port', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'board.slot', 'equipment.acronimo', 'board.id')->get();
			foreach ($placa as $value) {
				$fsp_label = ControllerRing::label_por($value->slot);
				$bw = ControllerEquipment_Model::format_bw($value->bw_max_port);
				if ($fsp_label != '') {
					$fsp_label = substr($fsp_label, 0, -1);
				}
				$datos[] = array(
					'id' => $value->id,
					'board' => $value->board,
					'type_board' => $value->type_board,
					'quantity' => $value->quantity,
					'port_f_i' => $value->port_f_i,
					'port_f_f' => $value->port_f_f,
					'port' => $value->port,
					'connector' => $value->connector,
					'bw' => $bw['data'].$bw['signo'],
					'label' => $value->label,
					'slot' => $fsp_label,
					'port_l_i' => $value->port_l_i,
					'port_l_f' => $value->port_l_f,
				);
			}
			if (count($datos) > 0) {
				$pose_slot  = array_column($datos, 'slot');
				$pose_por  = array_column($datos, 'port_l_i');
				array_multisort($pose_slot, SORT_ASC, $pose_por, SORT_ASC, $datos);
			}
			$resul = array(
				'resul' => 'yes',
				'acronimo' => $equipment->acronimo,
				'datos' => $datos,
				'datos_full' => $datos_old,
			);
		}else{
	      	$resul = array('resul' => 'autori', );
	    }
      	return $resul;
	}

	public function sele_board_new(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$board=$_POST['board'];
		$relation=$_POST['relation'];
		$port_model =Relation_Port_Model::find($relation);
		if ($port_model->id_port_equipment_model == $board) {
			$fsp = ControllerPort_Equipment_Model::fsp($port_model->description_label);
			$resul = array('resul' => 'yes', 'datos' => $fsp,);
		}else{
			$resul = array('resul' => 'nop', );
		}
		return $resul;
	}

	public function inser_board_new(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$valor=$_POST['valor'];
		$separar=$_POST['separar'];
		$equi=$_POST['equi'];
		$board=$_POST['board'];
		$equipment =Equipment::find($equi);
		switch ($equipment->id_function) {
			case '1':
				$status_permi = 7;
			break;
			case '2':
				$status_permi = 8;
			break;
			case '3':
				$status_permi = 9;
			break;
			case '4':
				$status_permi = 13;
			break;
            default:
                $status_permi = 5;
		}
		$status = User::authorization_status($status_permi);
		if ($status['permi'] >= 5){
			$fsp = '';
			foreach ($valor as $val) {
				if ($fsp == '') {
					$fsp = $val.'|';
				}else{
					$fsp = $fsp.$val.'|';
				}
			}
			$fsp_full = $fsp.$separar;
			$board_sql = DB::table('board')
				->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->where('board.id_equipment', '=', $equi)
				->where('board.slot', '=', $fsp_full)
				->where('board.status', '=', 'ACTIVO')
				->select('id_equipment', 'id_port_model', 'slot', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'port_equipment_model.id_module_board', 'port_equipment_model.id_label')->get();
			$Validator = 'yes';
			if (count($board_sql) > 0) {
				$placa =Port_Equipment_Model::find($board);
				foreach ($board_sql as $pla) {
					if ($pla->id_module_board == $placa->id_module_board) {
						if ($pla->port_l_i > $placa->port_l_i && $pla->port_l_f > $placa->port_l_i){
							$Vali = 0;
						}else{
							if ($pla->id_label != $placa->id_label) {
								$Vali = 0;
							}else{
								if ($pla->port_l_i < $placa->port_l_f && $pla->port_l_f < $placa->port_l_f) {
									$Vali = 0;
								}else{
									$Vali = 1;
								}
							}
						}
					}else{
						$Vali = 1;
					}
					if ($Vali == 1) {
						$Validator = 'no';
					}
				}
			}
			if ($Validator == 'yes') {
				$buscar_sql = DB::table('board')
					->where('board.id_equipment', '=', $equi)
					->where('board.id_port_model', '=', $board)
					->where('board.status', '!=', 'ACTIVO')
					->select('board.id')->get();
				if (count($buscar_sql) > 0) {
					$pla_new = Board::find($buscar_sql[0]->id);
				}else{
					$pla_new = new Board();
					    $pla_new->id_equipment = $equi;
					    $pla_new->id_port_model = $board;
				}
					$pla_new->status = 'ACTIVO';
					$pla_new->slot = $fsp_full;
			   	$pla_new->save();
				$board_info = DB::table('board')
					->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
					->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
					->Join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
					->where('board.id', '=', $pla_new->id)
					->select('equipment.acronimo', 'board.slot', 'list_module_board.name')->get();
				$fsp_label = ControllerRing::label_por($board_info[0]->slot);
				$msj_info = "Agrego la placa ".$board_info[0]->name." al equipo ".$board_info[0]->acronimo." en la posición ".$fsp_label.'p';
				ControllerUser_history::store($msj_info);
				$resul = array('resul' => 'yes',);
			}else{
				$resul = array('resul' => 'nop',);
			}
		}else{
			$resul = array('resul' => 'autori', );
		}
		return $resul;
	}

	public function sele_board_update(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$board=$_POST['id'];
		$port = DB::table('board')
				->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->join('relation_port_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
				->where('board.id', '=', $board)
				->select('relation_port_model.description_label')->get();
		if (count($port) > 0) {
			$fsp = ControllerPort_Equipment_Model::fsp($port[0]->description_label);
			$placa = Board::find($board);
			$pose = [];
			if ($placa->slot != null && $placa->slot != '') {
				$f_s_p = explode('|', $placa->slot);
				$cantidad = count($f_s_p) - 2;
				for ($i=0; $i <= $cantidad ; $i++) {
					$pose[] = array('valor' => $f_s_p[$i], );
				}
			}
			$resul = array('resul' => 'yes', 'datos' => $fsp, 'pose' => $pose,);
		}else{
			$resul = array('resul' => 'nop', );
		}
		return $resul;
	}

	public function pose_board_update(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$valor=$_POST['valor'];
		$separar=$_POST['separar'];
		$id=$_POST['id'];
		$board_data = DB::table('board')
				->join('equipment', 'board.id_port_model', '=', 'equipment.id')
				->where('board.id', '=', $id)
				->select('board.*', 'equipment.id_function')->get();
		switch ($board_data[0]->id_function) {
			case '1':
				$equi = 7;
			break;
			case '2':
				$equi = 8;
			break;
			case '3':
				$equi = 9;
			break;
			case '4':
				$equi = 13;
			break;
			case '5':
	    		$equi = 19;
	    	break;
	    	case '6':
	    		$equi = 20;
	    	break;
		}
		$status = User::authorization_status($equi);
		if ($status['permi'] >= 5){
			$fsp = '';
			foreach ($valor as $val) {
				if ($fsp == '') {
					$fsp = $val.'|';
				}else{
					$fsp = $fsp.$val.'|';
				}
			}
			$fsp_full = $fsp.$separar;
			if ($board_data[0]->slot != $fsp_full) {
				$board_sql = DB::table('board')
				->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
				->where('board.id_equipment', '=', $board_data[0]->id_equipment)
				->where('board.slot', '=', $fsp_full)
				->select('id_equipment', 'id_port_model', 'slot', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'port_equipment_model.id_module_board')->get();
				$Validator = 'yes';
				if (count($board_sql) > 0) {
					$placa =Port_Equipment_Model::find($board_data[0]->id_port_model);
					foreach ($board_sql as $pla) {
						if ($pla->id_module_board == $placa->id_module_board) {
							if ($pla->port_l_i > $placa->port_l_i && $pla->port_l_f > $placa->port_l_i){
								$Vali = 0;
							}else{
								if ($pla->port_l_i < $placa->port_l_f && $pla->port_l_f < $placa->port_l_f) {
									$Vali = 0;
								}else{
									$Vali = 1;
								}
							}
						}else{
							$Vali = 1;
						}
						if ($Vali == 1) {
							$Validator = 'no';
						}
					}
				}
				if ($Validator == 'yes') {
					$pla_upda = Board::find($id);
					$id_sql = DB::table('board')
						->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
						->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
						->Join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
						->where('board.id_equipment', '=', $pla_upda->id_equipment)
						->where('board.slot', '=', $pla_upda->slot)
						->where('board.status', '=', $pla_upda->status)
						->select('board.id','board.slot','list_module_board.name','equipment.acronimo')->get();
					foreach ($id_sql as $sql) {
						$pla_pose_new = Board::find($sql->id);
							$pla_pose_new->slot = $fsp_full;
			      		$pla_pose_new->save();
					}
					$fsp_label_old = ControllerRing::label_por($id_sql[0]->slot);
					$fsp_label_new = ControllerRing::label_por($fsp_full);
			   		$msj_info = "Modifico la posición de ".$fsp_label_old."p a ".$fsp_label_new."p a la placa ".$id_sql[0]->name." del equipo ".$id_sql[0]->acronimo;
					ControllerUser_history::store($msj_info);
					$resul = array('resul' => 'yes', 'datos' => $board_data[0]->id_equipment,);
				}else{
					$resul = array('resul' => 'nop',);
				}
			}else{
				$resul = array('resul' => 'exist', );
			}
		}else{
			$resul = array('resul' => 'autori', );
		}
		return $resul;
	}

	public function delecte_board(){
		if (Auth::guest()) return ['resul' => 'login'];
		$validar = 'yes';
		$port_sql = DB::table('board')
			->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
			->leftJoin('port', 'port.id_board', '=', 'board.id')
			->where('board.id', '=', $_POST['id'])
			->select('port.id_status', 'port.id_ring', 'equipment.id_function', 'equipment.id', 'equipment.acronimo')->get();
		switch ($port_sql[0]->id_function) {
			case '1': $status_valida = 7; break;
			case '2': $status_valida = 8; break;
			case '3': $status_valida = 9; break;
			case '4': $status_valida = 13; break;
			case '5': $status_valida = 19; break;
	    	case '6': $status_valida = 20; break;
			case '7': $status_valida = 23; break;
			case '8': $status_valida = 27; break;
		}
		$autori_status = User::authorization_status($status_valida);
		if ($autori_status['permi'] >= 5){

			foreach ($port_sql as $value) {
				if ($value->id_status == null) {
					$id_status = 2;
				}else{
					$id_status = $value->id_status;
				}
				if ($id_status != 2 || $value->id_ring != null) {
					$validar = 'no';
				}
			}
			if ($validar === 'yes') {
				$pla_upda = Board::find($_POST['id']);
					$pla_upda->status = 'DESACTIVADO';
			   	$pla_upda->save();
			   	$board_info = DB::table('board')
					->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
					->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
					->Join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
					->where('board.id', '=', $pla_upda->id)
					->select('equipment.acronimo', 'board.slot', 'list_module_board.name')->get();
				$fsp_label = ControllerRing::label_por($board_info[0]->slot);
			   	$msj_info = "Quito la placa ".$board_info[0]->name." del equipo ".$board_info[0]->acronimo." que estaba en la posición ".$fsp_label.'p';
				ControllerUser_history::store($msj_info);
			   $resul = array('resul' => 'yes',  'datos' => $pla_upda->id_equipment,);
			}else{
				$resul = array('resul' => 'nop', );
			}
		}else{
	      	$resul = array('resul' => 'autori', );
	    }
		return $resul;
	}
}
