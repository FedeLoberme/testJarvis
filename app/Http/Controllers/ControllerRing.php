<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;
use Exception;
use Jarvis\Agg_Association;
use Jarvis\User;
use Jarvis\Node;
use Jarvis\Link;
use Jarvis\Port;
use Jarvis\Chain;
use Jarvis\Ring;
use Jarvis\Board;
use Jarvis\Use_Vlan;
use Jarvis\Service;
use Jarvis\IP;
use Jarvis\Lacp_Port;
use Jarvis\Service_Port;
use Jarvis\List_Use_Vlan;
use Jarvis\Equipment_Model;
use Jarvis\List_Equipment;
use Jarvis\List_Countries;
use Jarvis\List_Status_IP;
use Jarvis\Equipment;
use Jarvis\Http\Controllers\ControllerUser_history;
use Jarvis\Http\Controllers\ControllerEquipment_Model;
use Jarvis\Http\Controllers\ControllerIP;
use Redirect,Response;
use Jarvis\Http\Requests\RequestRingIpran;
use Jarvis\Http\Requests\RequestPortRing;
use Jarvis\Range_Vlan;
use stdClass;
use Error;

class ControllerRing extends Controller
{
	public function index(){
    	if (!Auth::guest() == false){
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] >= 3){
			$equipment = Equipment_Model::List();
			$confi = $equipment['confir'];
			$bw = $equipment['bw'];
			$list_vlan = List_Use_Vlan::all();
			$status = List_Status_IP::all(['id', 'name'])->where('id','!=',4);
 			$pais = List_Countries::all(['id', 'name'])->sortBy('name');
			$Equipment = Equipment::detalle_equipo(1);
			$status_port = DB::table("status_port")->select('id','name')->where('id','>',2)->orderBy('name', 'asc')->get();
			return view('anillo.list',compact('confi', 'autori_status', 'list_vlan', 'status', 'pais', 'Equipment', 'status_port', 'bw'));
		}else{
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
    }

    public function select_nodo(){
    	if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] >= 3){
		  	$id=$_POST['id'];
		  	$agg =DB::table('equipment')
				->join('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
				->join('node', 'equipment.id_node', '=', 'node.id')
				->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
				->where('node.id','=', $id)
				->where('equipment.id_function','=', 1)
				->select('equipment.acronimo', 'equipment.id', 'equipment.status', 'ip.ip', 'ip.prefixes', 'equipment.commentary')->get();
			if (count($agg) > 0) {
				$data = array('resul' => 'yes', 'datos' => $agg,);
			}else{
				$data = array('resul' => 'nop',);
			}
		    return $data;
  		}else{
      		return array('resul' => 'autori', );
      	}
    }

    public function search_port_bw(){
  		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] >= 3){
		  	$id=$_POST['id'];
		  	$bw=$_POST['bw'];
		  	$port = DB::table('equipment')
		    ->join('board', 'board.id_equipment', '=', 'equipment.id')
		    ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
		    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
		    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		    ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		    ->where('equipment.id', '=', $id)
		    ->where('board.status', '=', 'ACTIVO')
		    ->where('port_equipment_model.bw_max_port', '=', $bw)
		    ->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'board.slot', 'list_module_board.name as model', 'board.id', 'list_port.name as type')->orderBy('slot', 'asc')->orderBy('port_l_i', 'asc')->get();
		    if (count($port) > 0) {
		    	$por_selec = [];
		    	$data_mostrar = [];
		    	$respuesta = 'nop';
		    	foreach ($port as $value) {
		    		$por_selec = [];
		    		for ($z=$value->port_l_i; $z <= $value->port_l_f; $z++) {
		    			$por_selec[] = $z;
		    		}
		    		$fsp_label=ControllerRing::label_por($value->slot);
		    		foreach ($por_selec as $data) {
		    			$status_sele = DB::table('port')
		    				->join('status_port', 'port.id_status', '=', 'status_port.id')
		    				->leftJoin('ring', 'port.id_ring', '=', 'ring.id')
		    				->where('port.id_board', '=', $value->id)
		    				->where('port.n_port', '=', $data)
		    				->select('port.id_status','status_port.name as status','ring.id', 'port.commentary')->get();
		    			$commentary = '';
		    			$status = '2';
		    			$status_name = 'VACANTE';
		    			if (count($status_sele) != 0) {
		    				$status = $status_sele[0]->id_status;
		    				$status_name = $status_sele[0]->status;
		    				if ($status_sele[0]->commentary != null) {
		    					$commentary = $status_sele[0]->commentary;
		    				}
		    			}
		    			if (($status == '3' /*|| $status == '2'*/) /*|| ($status_name == "EN USO" && $status_sele[0]->id == $id_anillo)*/) {
		    				$data_mostrar[] = array(
		    						'f_s_p' => $fsp_label,
		    						'por_selec' => $data,
		    						'label' => $value->label,
		    						'model' => $value->model,
		    						'id' => $value->id,
		    						'status' => $status_name,
		    						'pose' => $fsp_label.$data,
		    						'commentary' => $commentary,
		    						'type' => $value->type,
		    				);
		    				$respuesta = 'yes';
		    			}
		    		}
		    	}
		    	if (count($data_mostrar) > 0) {
		    		$pose_order  = array_column($data_mostrar, 'pose');
					array_multisort($pose_order, SORT_ASC,$data_mostrar);
		    	}
		    	$data = array(	'resul' => $respuesta,'datos' => $data_mostrar,);
		    }else{
		    	$data = array('resul' => 'nop',);
		    }
		    return $data;
  		}else{
      		return array('resul' => 'autori', );
      	}
  	}

  	public static function label_por($label){
  		$fsp_label = '';
  		if ($label != null || $label != '@@' || $label != '@') {
  			$f_s_p = explode('|', $label);
			$pose_separa = count($f_s_p) - 1;
			$separador = $f_s_p[$pose_separa];
			$fsp_label = '';
			for ($i=0; $i <= count($f_s_p) -2; $i++) {
			    if ($fsp_label == '') {
			    	$fsp_label = $f_s_p[$i].''.$separador;
			    }else{
			    	$fsp_label = $fsp_label.''.$f_s_p[$i].''.$separador;
			    }
			}
  		}
		return $fsp_label;
  	}

  	public function label_pantalla_anillo(){
		$id=$_POST['id'];
		foreach ($id as $value) {
			$divi = explode('@', $value);
			$pla = DB::table('board') ->select('board.slot', 'list_label.name as label')
				->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
        		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
			->where('board.id', '=', $divi[1])->get();
			$slot_lis = ControllerRing::label_por($pla[0]->slot);
			$data[] = array('resul' => 'yes' ,'port' => $divi[0],'board' => $divi[1], 'slot' =>  $pla[0]->label.' '.$slot_lis);
		}
		return $data;
	}

	public function insert_update_anillo(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] >= 5){
			$id_anillo =$_POST['id_anillo'];
			$nodo_al =$_POST['nodo_al'];
			$agg =$_POST['agg'];
			$dedica =$_POST['dedica'];
			$commen =$_POST['commen'];
			$type =$_POST['type'];
			$acro_lis =$_POST['acro_lis'];
			$valor_placa =$_POST['valor_placa'];
			if (count($valor_placa) == 3) {
				return array('resul' => 'port_n_mal', );
			}
			if ($id_anillo == 0) {
				$vlan_ip = $_POST['all_vlan_ip'];
				foreach ($vlan_ip as $val) {
					$separador = explode('_', $val);
					$vlan_ip_listo[] = array(
						'uso' => $separador[0],
						'vlan' => $separador[1],
						'ip' => $separador[2],
					);
					$vlan_exists = Use_Vlan::where('id_equipment', $agg)->where('vlan', $separador[1])->where('id_list_use_vlan', '<>', 7)->first();
					if (!empty($vlan_exists)) return ['resul' => 'vlan_exis'];
					if ($separador[1] > 4045) {
						return array('resul' => 'vlan', );
					}
					$exi_ip = DB::table("ip")->select('ip.id_status')
						->where('ip.id', '=', $separador[2])
						->where('ip.id_status', '!=', 1)->get();
				 	if (count($exi_ip)>0) {
						return array('resul' => 'ip_exis', );
				 	}
				}
			}
			$acro_exis = DB::table('ring')
				->where('ring.name', '=', $acro_lis)
				->where('ring.id', '!=', $id_anillo)
				->where('ring.status', '!=', 'BAJA')
				->select('ring.id')->get();
			if (count($acro_exis) > 0) {
				$data = array('resul' => 'exis');
			}else{
				$placa_sql = explode('@', $valor_placa[0]);
				$bw_real = DB::table("port_equipment_model")
					->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
					->where('board.id', '=', $placa_sql[1])
					->select('port_equipment_model.bw_max_port')->get();
				if (count($valor_placa) > 1) {
					$bw_all_ring = (count($valor_placa) * $bw_real[0]->bw_max_port) / 2;
				}else{
					$bw_all_ring = $bw_real[0]->bw_max_port;
				}
				if ($id_anillo != 0) {
					$bw_max = $_POST['n_max'] *  $_POST['max'];
					$msj_anillo = 'Modifico el anillo: ';
					$anillo = Ring::find($id_anillo);
						$anillo->bw_limit = $bw_max;
				}else{
					if ($autori_status['permi'] >= 10){
						$msj_anillo = 'Registro el anillo: ';
						$anillo = new Ring();
							$anillo->type_ring = "Metroethernet";
							$anillo->bw_limit = $bw_all_ring;
					}else{
			      		return array('resul' => 'autori', );
			      	}
				}
					$anillo->name = $acro_lis;
					$anillo->type = $type;
					$anillo->status = "ALTA";
					$anillo->dedicated = $dedica;
					$anillo->commentary = $commen;
				$anillo->save();
				$id_anillo_new = $anillo->id;
				if ($id_anillo == 0) {
					foreach ($vlan_ip_listo as $valor) {
						$Use_Vlan = new Use_Vlan();
							$Use_Vlan->vlan = $valor['vlan'];
							$Use_Vlan->id_list_use_vlan = $valor['uso'];
							$Use_Vlan->id_ring = $id_anillo_new;
							$Use_Vlan->id_equipment = $agg;
						$Use_Vlan->save();
						$ip_listo[] = array(
							'vlan' => $Use_Vlan->id,
							'ip' => $valor['ip'],
						);
					}
					foreach ($ip_listo as $key) {
						$IP_sele =IP::find($key['ip']);
						$ran_ip = ControllerIP::rango($IP_sele->ip.'/'.$IP_sele->prefixes);
						$ini_fin_ip = ControllerIP::ipv4_ini_fin($IP_sele->ip.'/'.$IP_sele->prefixes);
						$ip_vlan_individual[] = array(
							'vlan' => $key['vlan'],
							'ip' => $ini_fin_ip['inicio'],
							'rama' => $IP_sele->id_branch,
						);
						foreach ($ran_ip as $valores) {
							$ip_vlan_individual[] = array(
								'vlan' => $key['vlan'],
								'ip' => $valores,
								'rama' => $IP_sele->id_branch,
							);
						}
						$ip_vlan_individual[] = array(
							'vlan' => $key['vlan'],
							'ip' => $ini_fin_ip['fin'],
							'rama' => $IP_sele->id_branch,
						);
					}
					foreach ($ip_vlan_individual as $value_ip_vlan) {
						$buscar = DB::table("ip")->select('ip.id', 'ip.type')
							->where('ip.ip', '=', $value_ip_vlan['ip'])
							->where('ip.id_branch', '=', $value_ip_vlan['rama'])->get();
						$IP_vlan_sele =IP::find($buscar[0]->id);
							if ($buscar[0]->type == 'RED') {
								$IP_vlan_sele->id_status = 2;
							}
							$IP_vlan_sele->id_use_vlan = $value_ip_vlan['vlan'];
						$IP_vlan_sele->save();
						$msj = 'Se asigno la IP al anillo '.$acro_lis;
						ControllerIP::insert_all_record_ip($IP_vlan_sele->id, $IP_vlan_sele->prefixes, $msj);
					}
				}
				ControllerRing::insert_update_port_anillo($id_anillo, $id_anillo_new, $valor_placa, $agg);
				ControllerUser_history::store($msj_anillo.$acro_lis);
				$data = array('resul' => 'yes', 'datos' => $anillo,);
			}
			return $data;
		}else{
      		return array('resul' => 'autori', );
      	}
	}

	public function insert_update_port_anillo($id_anillo, $id, $valor_placa, $agg){
		$separar_placa = explode('@', $valor_placa[0]);
		$port_sele = DB::table('port')
		->join('board', 'port.id_board', '=', 'board.id')
		->join('equipment', 'board.id_equipment', '=', 'equipment.id')
		->where('port.id_ring', '=', $id)
		->where('equipment.id', '=', $agg)
		->select('port.id_board', 'port.n_port', 'equipment.id')->get()->toArray();
		if (count($port_sele) > 0) {
			foreach ($port_sele as $value) {
				$port_old[] =  $value->n_port.'@'. $value->id_board;
			}
			$quitar = array_diff($port_old, $valor_placa);
			$colocar = array_diff($valor_placa, $port_old);

			foreach ($quitar as $value) {
				$separar = explode('@', $value);
				$port_exis = DB::table('port')
					->join('board', 'port.id_board', '=', 'board.id')
					->where('port.id_ring', '=', $id_anillo)
					->where('port.n_port', '=', $separar[0])
					->where('board.id', '=', $separar[1])
					->where('board.id_equipment', '=', $agg)
					->select('port.id')->get();

				$port =Port::find($port_exis[0]->id);
					$port->id_status = 2;
					$port->type = null;
					$port->id_ring = null;
				$port->save();
			}
			foreach ($colocar as $key ) {
				$separar = explode('@', $key);
				$port_exis_sin_afiliar = DB::table('port')
					->join('board', 'port.id_board', '=', 'board.id')
					->where('port.n_port', '=', $separar[0])
					->where('board.id', '=', $separar[1])
					->where('board.id_equipment', '=', $agg)
					->select('port.id')->get();

				if (count($port_exis_sin_afiliar) > 0) {
					$port =Port::find($port_exis_sin_afiliar[0]->id);
						$port->id_status = 1;
						$port->type = 'ANILLO';
						$port->id_ring = $id;
					$port->save();
				}else{
					$port = new Port();
						$port->id_board = $separar[1];
						$port->n_port = $separar[0];
						$port->id_status = 1;
						$port->type = 'ANILLO';
						$port->id_ring = $id;
					$port->save();
				}
			}
		}else{
			foreach ($valor_placa as $key ) {
				$separar = explode('@', $key);
				$port_exis_sin_afiliar = DB::table('port')
					->join('board', 'port.id_board', '=', 'board.id')
					->where('port.n_port', '=', $separar[0])
					->where('board.id', '=', $separar[1])
					->where('board.id_equipment', '=', $agg)
					->select('port.id')->get();

				if (count($port_exis_sin_afiliar) > 0) {
					$port =Port::find($port_exis_sin_afiliar[0]->id);
						$port->id_status = 1;
						$port->type = 'ANILLO';
						$port->id_ring = $id;
					$port->save();
				}else{
					$port = new Port();
						$port->id_board = $separar[1];
						$port->n_port = $separar[0];
						$port->id_status = 1;
						$port->type = 'ANILLO';
						$port->id_ring = $id;
					$port->save();
				}
			}
		}
	}

	public function index_list(){
		$datos = [];
		$anillo = Ring::all();
	    foreach ($anillo as $value) {
	    	$acronimo = '';
	    	$type =
			$utilizado = 0;
			$cantidad = 0;
			if ('BAJA' != $value->status) {
	    		if ($value->type_ring === 'Ipran'){
	    			$LSW_a = DB::table('equipment')
		    			->Join('board','board.id_equipment','=','equipment.id')
		    			->Join('port','port.id_board','=','board.id')
		    			->where('port.id_ring','=',$value->id)
		    			->where('equipment.id_function', '=', 4)
		    			->where('equipment.type', '!=', 'Metroethernet')
		    			->where('equipment.client_management', '=', 'No')
		    			->select('equipment.id', 'equipment.acronimo')
						->groupBy('equipment.id', 'equipment.acronimo')->get();
		    		if (count($LSW_a) > 0) {
		    			$acronimo = $LSW_a[0]->acronimo;
						$id_equipment = $LSW_a[0]->id;
		    		}
	    		}else{
	    			$agg = DB::table('equipment')
	    				->Join('board','board.id_equipment','=','equipment.id')
	    				->Join('port','port.id_board','=','board.id')
	    				->where('port.id_ring','=',$value->id)
	    				->where('equipment.id_function', '=', 1)
	    				->select('equipment.id', 'equipment.acronimo')
						->groupBy('equipment.id', 'equipment.acronimo')->get();
		    		if (count($agg) > 0) {
		    			$acronimo = $agg[0]->acronimo;
						$id_equipment = $agg[0]->id;
		    		}
	    		}

				$cantidad = count(DB::table('board')
					->join('port', 'port.id_board', '=', 'board.id')
					->join('equipment', 'board.id_equipment', '=', 'equipment.id')
					->where('port.id_ring','=',$value->id)
					->where('equipment.id_function', '!=', 1)
					->select('id_equipment')->groupBy('id_equipment')->get());
			    $equipo = DB::table('port')
					->join('board', 'port.id_board', '=', 'board.id')
					->join('equipment', 'board.id_equipment', '=', 'equipment.id')
					->join('board as bo', 'bo.id_equipment', '=', 'equipment.id')
					->join('port as por1', 'por1.id_board', '=', 'bo.id')
					->leftJoin('lacp_port', 'lacp_port.id', '=', 'por1.id_lacp_port')
					->leftJoin('service_port','lacp_port.id','=','service_port.id_lacp_port')
					->leftJoin('service', 'service.id', '=', 'service_port.id_service')
					->where('port.id_ring', '=', $value->id)
					->where('equipment.id_function', '!=', 1)
					->select('service.bw_service', 'service.id')
					->groupBy('service.bw_service', 'service.id')->get();
				foreach ($equipo as $valore) {
					$utilizado = $utilizado + $valore->bw_service;
				}
			}
			$bw_max_anillo = ControllerEquipment_Model::format_bw($value->bw_limit);
			$util_anillo = ControllerEquipment_Model::format_bw($utilizado);
			$cap = (100 * $utilizado)/$value->bw_limit;
			$act = 'Apto';
			$percentage = round($cap, 2);
			if ($value->bw_limit >= $utilizado) {
				$libre = $value->bw_limit - $utilizado;
				$bw_libre = ControllerEquipment_Model::format_bw($libre);
				$bw_real = $bw_libre['data'].' '.$bw_libre['signo'];
			}else{
				$sobre_paso = $utilizado - $value->bw_limit;
				$bw_libre = ControllerEquipment_Model::format_bw($sobre_paso);
				$bw_real = '-'.$bw_libre['data'].' '.$bw_libre['signo'];
			}
			if ($percentage > 64 || $cantidad > 13 || 'BAJA' == $value->status) {
				$act = 'No Apto';
			}
		    $datos[] = array(
		    	'name' => $value->name,
		    	'acronimo' => $acronimo,
				'id_equipment' => $id_equipment,
		    	'type' => $value->type,
		    	'type_ring' => $value->type_ring,
		    	'status' => $value->status,
		    	'dedicated' => $value->dedicated,
		    	'bw_max_port' => $bw_max_anillo['data'].' '.$bw_max_anillo['signo'],
		    	'id' => $value->id,
		    	'cantidad' => $cantidad,
		    	'utilizado' => $util_anillo['data'].' '.$util_anillo['signo'],
		    	'libre' => $percentage.'%',
		    	'act' => $act,
		    	'number' => $percentage,
		    );
	    }
	    return datatables()->of($datos)->make(true);
	}

	public function search_anillo(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id = $_POST['id'];
      	$authori_status = User::authorization_status(11);
      	if ($authori_status['permi'] >= 3) {
      		$Ring_info = Ring::find($id, ['type_ring', 'bw_limit']);
      		$bw_max_anillo = ControllerEquipment_Model::format_bw($Ring_info->bw_limit);
      		if ($Ring_info->type_ring ==="Metroethernet") {
				$anillo = DB::table('ring')
	        		->join('port', 'port.id_ring', '=', 'ring.id')
	        		->join('board', 'port.id_board', '=', 'board.id')
	        		->join('equipment', 'board.id_equipment', '=', 'equipment.id')
	        		->join('node', 'equipment.id_node', '=', 'node.id')
	        		->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
	        		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
	        		->where('port.id_ring', '=', $id)
	        		->where('equipment.id_function', '=', 1)
	        		->select('equipment.id', 'ring.name', 'ring.type', 'ring.dedicated', 'ring.commentary', 'port.id_board', 'port.n_port', 'port_equipment_model.bw_max_port', 'board.id as board', 'equipment.acronimo as agg', 'node.node as nodo', 'equipment.id as id_agg', 'equipment.id_node as id_nodo', 'board.slot', 'list_label.name as etiqueta', 'ring.type_ring', 'node.cell_id')->get();
      		}else{
      			$anillo = DB::table('ring')
	        		->join('port', 'port.id_ring', '=', 'ring.id')
	        		->join('board', 'port.id_board', '=', 'board.id')
	        		->join('equipment', 'board.id_equipment', '=', 'equipment.id')
	        		->join('node', 'equipment.id_node', '=', 'node.id')
	        		->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
	        		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
	        		->where('port.id_ring', '=', $id)
	        		->where('equipment.id_function', '=', 4)
			    	->where('equipment.type', '=', 'Ipran')
			    	->where('equipment.client_management', '=', 'No')
	        		->select('equipment.id', 'ring.name', 'ring.type', 'ring.dedicated', 'ring.commentary', 'port.id_board', 'port.n_port', 'port_equipment_model.bw_max_port', 'board.id as board', 'equipment.acronimo as agg', 'node.node as nodo', 'equipment.id as id_agg', 'equipment.id_node as id_nodo', 'board.slot', 'list_label.name as etiqueta', 'ring.type_ring', 'node.cell_id')->get();
      		}
			$agg = [];
        	if (count($anillo) <> 0) {
        		if ($anillo[0]->type_ring == 'Ipran') {
        			$agg[] = array('name' => $anillo[0]->cell_id, );
        		}else{
	        		$agg_acronimo = DB::table('equipment')
						->join('relation_agg_acronimo', 'relation_agg_acronimo.id_equipment', '=', 'equipment.id')
						->join('agg_acronimo', 'relation_agg_acronimo.id_agg_acronimo', '=', 'agg_acronimo.id')
						->where('equipment.id', '=', $anillo[0]->id)
		        		->select('agg_acronimo.name')->get();
		        	foreach ($agg_acronimo as $val) {
		        		$agg[] = array('name' => $val->name, );
		        	}

        		}
        		foreach ($anillo as $value) {
        			$separa = explode('|', $value->slot);
        			$separador = $separa[count($separa)-1];
		    				$label = "";
		    				for ($i=0; $i <=count($separa)-2; $i++) {
			    				if ($label == "") {
			    				 	$label = $separa[$i].$separador;
			    				}else{
			    					$label = $label.$separa[$i].$separador;
			    				}
		    				}
		    		$port_value[] = array(
		    			'mostrar' => $value->etiqueta.' '.$label.$value->n_port,
		    			'data' => $value->n_port.'@'.$value->board,
		    		);
        		}
        		$divi = explode('-', $anillo[0]->name);
        		$separar = explode('_', $divi[1]);
        		$data = array(
        			'resul'=> 'yes',
			        'port' => $port_value,
			        'acro_select' => $separar[0],
			        'acro_number' => $separar[1],
			        'bw_all' => $bw_max_anillo['data'],
			        'logo' => $bw_max_anillo['logo'],
			        'node' => $anillo[0]->nodo,
			        'agg' =>  $anillo[0]->agg,
			        'dedicated' => $anillo[0]->dedicated,
			        'type' => $anillo[0]->type,
			        'commentary' => $anillo[0]->commentary,
			        'id_agg' => $anillo[0]->id_agg,
			        'id_nodo' => $anillo[0]->id_nodo,
			        'bw' => $anillo[0]->bw_max_port,
			        'acronimo' => $agg,
        		);
        	}else{
        		$data = array( 'resul'=> 'no',);
        	}
        	return $data;
      	}else{
        	return array('resul' => 'home', );
      	}
	}


	public function search_anillo_lanswitch(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id = $_POST['id'];
      	$authori_status = User::authorization_status(11);
      	if ($authori_status['permi'] >= 3) {

      		$info = Ring::find($id);
      		if ($info->type_ring != 'Metroethernet') {
      			$anillo = DB::table("equipment")
					->join('board', 'board.id_equipment', '=', 'equipment.id')
					->join('port', 'port.id_board', '=', 'board.id')
					->join('ring', 'port.id_ring', '=', 'ring.id')
					->where('ring.id', '=', $id)
					->where('equipment.id_function', '=', 4)
					->where('equipment.client_management', '=', 'No')
				->select('equipment.acronimo')->groupBy('equipment.acronimo')->get();
      		}else{
				$anillo = DB::table("equipment")
					->join('board', 'board.id_equipment', '=', 'equipment.id')
					->join('port', 'port.id_board', '=', 'board.id')
					->join('ring', 'port.id_ring', '=', 'ring.id')
					->where('ring.id', '=', $id)
					->where('equipment.id_function', '=', 1)
				->select('equipment.acronimo')->groupBy('equipment.acronimo')->get();
      		}
			$equip = DB::table("equipment")
				->join('board', 'board.id_equipment', '=', 'equipment.id')
				->join('port', 'port.id_board', '=', 'board.id')
				->join('ring', 'port.id_ring', '=', 'ring.id')
				->where('ring.id', '=', $id)
			->select('equipment.id', 'equipment.acronimo')->groupBy('equipment.id', 'equipment.acronimo')->get();
        	if (count($anillo) > 0){
        		$data = array(
        			'resul'=> 'yes',
			        'acronimo' => $anillo[0]->acronimo,
			        'name' => $info->name,
			        'type' => $info->type,
			        'equip' => $equip,
			        'coun' => count($equip),
        		);
        	}else{
        		$data = array( 'resul'=> 'no',);
        	}
        	return $data;
      	}else{
        	return array('resul' => 'home', );
      	}
	}

	public function search_vlan_ip(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id = $_POST['id'];
      	$authori_status = User::authorization_status(11);
      	if ($authori_status['permi'] >= 3) {
			$data = DB::table("use_vlan")
				->join('list_use_vlan', 'list_use_vlan.id', '=', 'use_vlan.id_list_use_vlan')
				->join('ip', 'ip.id_use_vlan', '=', 'use_vlan.id')
				->leftJoin('link', 'link.id', '=', 'use_vlan.id_frontera')
				->where('use_vlan.id_ring', '=', $id)
				->where('ip.type', '=', 'RED')
				->select('use_vlan.id','list_use_vlan.name','use_vlan.vlan','ip.ip','ip.prefixes','link.sufijo_vcid')
				->groupBy('use_vlan.id','list_use_vlan.name','use_vlan.vlan','ip.ip','ip.prefixes','link.sufijo_vcid')
				->get();
			return array('resul' => 'yes', 'datos' => $data);
		} else {
        	return array('resul' => 'autori', );
      	}
	}

	public function delete_vlan_ip(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id=$_POST['id'];
      	$authori_status = User::authorization_status(11);
      	if ($authori_status['permi'] >= 5) {
      		$libre = 0;
			$ip = DB::table("ip")->where('ip.id_use_vlan', '=', $id)
			->select('ip.id', 'ip.type', 'ip.id_status')->get();
			foreach ($ip as $key) {
				if ($key->id_status != 1 && $key->type == 'DISPONIBLE') {
					$libre = $libre + 1;
				}
			}
			if ($libre < 2) {
				foreach ($ip as $value) {
					$all_ip = IP::find($value->id);
						if ($value->type == 'RED') {
							$all_ip->id_status = 1;
							$ip_red_msj = $all_ip->ip.'/'.$all_ip->prefixes;
						}
						$all_ip->id_use_vlan = null;
					$all_ip->save();
					$msj = 'Se libero la IP del anillo';
					ControllerIP::insert_all_record_ip($all_ip->id, $all_ip->prefixes, $msj);
				}
				$vlan_info = DB::table("use_vlan")
					->join("list_use_vlan", "list_use_vlan.id", "=", "use_vlan.id_list_use_vlan")
					->join("ring", "ring.id", "=", "use_vlan.id_ring")
					->where('use_vlan.id', '=', $id)
					->select('use_vlan.vlan', 'ring.name as ring', 'list_use_vlan.name')->get();
				$msj = 'Quito Vlan de '.$vlan_info[0]->name.' '.$vlan_info[0]->vlan.' y la SubRed '.$ip_red_msj.' al anillo '.$vlan_info[0]->ring;
				ControllerUser_history::store($msj);
				$vlan = Use_Vlan::find($id);
	        	$vlan->delete();
	        	return array('resul' => 'yes', );
        	}else{
        		return array('resul' => 'Exist', );
        	}
		}else{
        	return array('resul' => 'autori', );
      	}
	}

	public function vlan_anillo_insert(){
		try {
			if (!Auth::guest() == false) return ['resul' => 'login'];
			$authori_status = User::authorization_status(11);
			if ($authori_status['permi'] < 5) return ['resul' => 'autori'];

			$id = $_POST['id'];
			$uso = $_POST['uso'];
			$vlan = $_POST['vlan'];
			$ip = $_POST['ip'];
			$anillo_info =Ring::find($id);
			$IP_sele =IP::find($ip);
			$ip_vlan_individual = ControllerIP::rango($IP_sele->ip.'/'.$IP_sele->prefixes);
			$ini_fin_ip = ControllerIP::ipv4_ini_fin($IP_sele->ip.'/'.$IP_sele->prefixes);
			$ip_vlan_individual[] = $ini_fin_ip['inicio'];
			$ip_vlan_individual[] = $ini_fin_ip['fin'];
			$buscar = DB::table("ip")->select('ip.id', 'ip.type', 'ip.id_status')
				->whereIn('ip.ip', $ip_vlan_individual)
				->where('ip.id_branch', '=', $IP_sele->id_branch)->get()->toArray();
			$info_ip = array_search(2, array_column($buscar, 'id_status'));
			if ($info_ip !== false) {
				return ['resul' => 'exit'];
			} else {
				foreach ($buscar as $value) {
					$dato_ip[] = [
						'id' => $value->id,
						'type' => $value->type,
					];
				}
			}
			$Use_Vlan = new Use_Vlan();
			$Use_Vlan->vlan = $vlan;
			$Use_Vlan->id_list_use_vlan = $uso;
			$Use_Vlan->id_ring = $id;
			$Use_Vlan->id_equipment = $_POST['id_equipment'];
			$Use_Vlan->id_frontera = $_POST['id_frontier'];
			$Use_Vlan->save();
			$id_vlan = $Use_Vlan->id;
			foreach ($dato_ip as $valor_ip) {
				$IP_vlan_sele =IP::find($valor_ip['id']);
				if ($valor_ip['type'] == 'RED') $IP_vlan_sele->id_status = 2;
				$IP_vlan_sele->id_use_vlan = $id_vlan;
				$IP_vlan_sele->save();
				$msj = 'Se asigno la IP al anillo '.$anillo_info->name;
				ControllerIP::insert_all_record_ip($IP_vlan_sele->id, $IP_vlan_sele->prefixes, $msj);
			}
			ControllerUser_history::store('Agrego Vlan y SubRed al anillo '.$anillo_info->name);
			return ['resul' => 'yes', 'datos' => $id];
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e->getMessage()];
		}
	}

	public function vlan_anillo_insert_wan_equipmen(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
      	$authori_status = User::authorization_status(11);
      	if ($authori_status['permi'] >= 5) {
      		$equipment = $_POST['id'];
      		$buscar_anillo = DB::table("board")
      			->join('port', 'port.id_board', '=', 'board.id')
      			->where('board.id_equipment', '=', $equipment)
      			->whereNotNull('port.id_ring')
      		->select('port.id_ring')->groupBy('port.id_ring')->get();
      		if (count($buscar_anillo)>0) {
				$id = $buscar_anillo[0]->id_ring;
				$uso = $_POST['uso'];
				$vlan = $_POST['vlan'];
				$ip = $_POST['ip'];
				$anillo_info = Ring::find($id);
				$IP_sele =IP::find($ip);
				$ip_vlan_individual = ControllerIP::rango($IP_sele->ip.'/'.$IP_sele->prefixes);
				$ini_fin_ip = ControllerIP::ipv4_ini_fin($IP_sele->ip.'/'.$IP_sele->prefixes);
				$ip_vlan_individual[] = $ini_fin_ip['inicio'];
				$ip_vlan_individual[] = $ini_fin_ip['fin'];
				$buscar = DB::table("ip")->select('ip.id', 'ip.type', 'ip.id_status')
					->whereIn('ip.ip', $ip_vlan_individual)
					->where('ip.id_branch', '=', $IP_sele->id_branch)->get()->toArray();
				$info_ip = array_search(2, array_column($buscar, 'id_status'));
				if ($info_ip !== false) {
					return array('resul' => 'exit',);
				}else{
					foreach ($buscar as $value) {
						$dato_ip[] = array(
							'id' => $value->id,
							'type' => $value->type,
						);
					}
				}
				$Use_Vlan = new Use_Vlan();
					$Use_Vlan->vlan = $vlan;
					$Use_Vlan->id_list_use_vlan = $uso;
					$Use_Vlan->id_ring = $id;
				$Use_Vlan->save();
				$id_vlan = $Use_Vlan->id;
				foreach ($dato_ip as $valor_ip) {
					$IP_vlan_sele =IP::find($valor_ip['id']);
						if ($valor_ip['type'] == 'RED'){ $IP_vlan_sele->id_status = 2; }
						$IP_vlan_sele->id_use_vlan = $id_vlan;
					$IP_vlan_sele->save();
					$msj = 'Se asigno la IP al anillo '.$anillo_info->name;
					ControllerIP::insert_all_record_ip($IP_vlan_sele->id,$IP_vlan_sele->prefixes,$msj);
				}
					ControllerUser_history::store('Agrego Vlan y SubRed al anillo '.$anillo_info->name);
					return array('resul' => 'yes', 'datos' => $id,);
      		}else{
      			return array('resul' => 'nop',);
      		}
		}else{
        	return array('resul' => 'autori', );
      	}
	}

	public function search_vlan_rank(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		try {
			$datos = List_Use_Vlan::find($_POST['id']);
			return ['resul' => 'yes', 'datos' => $datos->subred];
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e->getMessage()];
		}
	}

	public function delete_ring(){
		try {
			if (Auth::guest()) throw new Error('login');
			$autori_status = User::authorization_status(11);
			if ($autori_status['permi'] < 5) throw new Error('autori');

			$id = $_POST['id'];

			$equips = DB::table('port')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->where('port.id_ring', '=', $id)
				->select('equipment.id', 'equipment.id_function')
				->get();
			if (count($equips) > 1) throw new Error('El anillo tiene equipo instalado');

			if (Use_Vlan::where('id_ring', $id)->exists()) throw new Error('Este anillo tiene vlans asociadas');

			$port = DB::table('port')
				->where('port.id_ring', '=', $id)
				->select('port.id')->get();
			foreach ($port as $value) {
				$free = Port::find($value->id);
				$free->id_status = 2;
				$free->commentary = null;
				$free->connected_to = null;
				$free->type = null;
				$free->id_ring = null;
				$free->save();
			}
			
			$anillo = Ring::find($id);
			$anillo_name = $anillo->name;
			$anillo->status = "BAJA";
			$anillo->name = $anillo_name . '-BAJA';
			$anillo->save();
			ControllerUser_history::store("Le dio de baja al anillo ".$anillo->name);

			$dato_ip =DB::table('ip')
				->join('use_vlan', 'ip.id_use_vlan', '=', 'use_vlan.id')
				->where('use_vlan.id_ring', '=', $id)
				->select('ip.id', 'ip.type')->get();
			foreach ($dato_ip as $valor_ip) {
				$IP_vlan_sele = IP::find($valor_ip->id);
				if ($valor_ip->type == 'RED') $IP_vlan_sele->id_status = 1;
				$IP_vlan_sele->id_use_vlan = null;
				$IP_vlan_sele->save();
				$msj = 'Se libero la IP del anillo '.$anillo->name;
				ControllerIP::insert_all_record_ip($IP_vlan_sele->id,$IP_vlan_sele->prefixes, $msj);
			}
			return $anillo->id;
		} catch (Error $e) {
			return $e->getMessage();
		}
    }

    public function search_port_ring(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
      	$authori_status = User::authorization_status(11);
      	if ($authori_status['permi'] >= 3) {
      		$id = $_POST['id'];
        	$port_option = [];
        	$port_rign = [];
        	$info_ring = Ring::find($id);
        	if ($info_ring->type_ring != 'Metroethernet') {
        		$anillo = DB::table('ring')
	        		->join('port', 'port.id_ring', '=', 'ring.id')
	        		->join('board', 'port.id_board', '=', 'board.id')
	        		->join('equipment', 'board.id_equipment', '=', 'equipment.id')
	        		->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
	        		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
	        		->where('port.id_ring', '=', $id)
	        		->where('equipment.id_function', '=', 4)
	        		->where('equipment.client_management', '=', 'No')
	        		->select('port.id','port.n_port','board.slot','list_label.name', 'port.connected_to', 'equipment.id as equipment', 'equipment.acronimo', 'port_equipment_model.bw_max_port')->get();
        	}else{
	      		$anillo = DB::table('ring')
	        		->join('port', 'port.id_ring', '=', 'ring.id')
	        		->join('board', 'port.id_board', '=', 'board.id')
	        		->join('equipment', 'board.id_equipment', '=', 'equipment.id')
	        		->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
	        		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
	        		->where('port.id_ring', '=', $id)
	        		->where('equipment.id_function', '=', 1)
	        		->select('port.id','port.n_port','board.slot','list_label.name', 'port.connected_to', 'equipment.id as equipment', 'equipment.acronimo', 'port_equipment_model.bw_max_port')->get();
        	}
        	foreach ($anillo as $value) {
        		$fsp_label=ControllerRing::label_por($value->slot);
        		$port_rign[] = array(
        			'id' => $value->id,
        			'slot' => $value->name.$fsp_label.$value->n_port,
        			'connected' => $value->connected_to,
        			'acronimo' => $value->acronimo,
        		);
        	}
        	if (count($anillo) > 0) {
	        	$port_sele = DB::table('equipment')
	        		->join('board', 'board.id_equipment', '=', 'equipment.id')
	        		->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
	        		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
	        		->where('board.status', '!=', 'DESACTIVADO')
	        		->where('equipment.id', '=', $anillo[0]->equipment)
	        		->where('port_equipment_model.bw_max_port', '=', $anillo[0]->bw_max_port)
	        		->where('board.status', '=', 'ACTIVO')
	        		->select('port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'board.slot', 'list_label.name as label', 'board.id')->get();
	        	foreach ($port_sele as $valor) {
	        		$fsp_label = ControllerRing::label_por($valor->slot);
	        		$all_port = [];
	        		for ($z=$valor->port_l_i; $z <= $valor->port_l_f; $z++) {
	        			$all_port[] = $z;
	        		}
	        		$port_sql = DB::table('port')
		        		->where('id_board', '=', $valor->id)->whereIn('n_port', $all_port)
		        		->select('id_status','n_port')->get()->toArray();
		        	foreach ($all_port as $val_port) {
		        		$status_port = 2;
		        		$info_port = array_search($val_port, array_column($port_sql, 'n_port'));
		        		if ($info_port !== false) {
	        				$status_port = $port_sql[$info_port]->id_status;
		        		}
		    			$port_option[] = array(
		        			'port' => $valor->label.$fsp_label.$val_port,
		        			'data' => $valor->id.'~'.$val_port,
		        			'slot' => $fsp_label,
		        			'por' => $val_port,
		        			'status' => $status_port,
	        			);
		        	}
		    	}
	        	$slot_order  = array_column($port_option, 'slot');
	        	$port_order  = array_column($port_option, 'por');
				array_multisort($slot_order, SORT_ASC, $port_order, SORT_ASC,$port_option);
        	}
			return array('resul' => 'yes', 'datos' => $port_rign, 'option' => $port_option,);
      	}else{
        	return array('resul' => 'autori', );
      	}
	}

	public function update_port_ring(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
      	$authori_status = User::authorization_status(11);
      	if ($authori_status['permi'] >= 3) {
      		$id = $_POST['id'];
      		$valor = $_POST['valor'];
      		$validar='yes';
      		$datos = [];
      		$port_new = [];
      		$port_old = [];
      		$NewPort = [];
      		foreach ($valor as $value) {
      			$divi = explode('~', $value);
      			$info_port =DB::table('port')
					->where('port.id_board', '=', $divi[2] )
					->where('port.n_port', '=', $divi[3] )
					->select('port.id', 'port.id_status')->get();
				if (count($info_port) > 0) {
					$status = $info_port[0]->id_status;
      				$port_id = $info_port[0]->id;
				}else{
					$port_new_ring = new Port();
						$port_new_ring->id_board = $divi[2];
						$port_new_ring->n_port = $divi[3];
						$port_new_ring->id_status = 2;
					$port_new_ring->save();
					$status = $port_new_ring->id_status;
      				$port_id = $port_new_ring->id;
				}
				$port_new[] = array(
					'id' => $port_id,
					'status' => $status,
					'old' => $divi[0],
				);
				$port_old[] = $divi[0];
      		}

      		foreach ($port_new as $N => $val) {
      			$info_port = array_search($val['id'], $port_old);
      			if ($val['status'] != 2 && $val['status'] != 3 && $info_port === false) {
      				return array('resul' => 'nop');
      			}
      			if (count($NewPort) > 0) {
      				$info_port_new = array_search($val['id'], array_column($NewPort, 'id'));
      				if ($info_port_new !== false) {
      					return array('resul' => 'exist');
      				}
      			}

      			$info_data = Port::find($val['old']);
      			$NewPort[] = array(
      				'id' => $val['id'],
					'status' =>$val['status'],
					'old' => $val['old'],
					'commentary' => $info_data->commentary,
					'connected_to' => $info_data->connected_to,
				);
      		}

			foreach ($NewPort as $dat) {
		      	$free = Port::find($dat['old']);
					$free->id_status = 2;
					$free->commentary = null;
					$free->connected_to = null;
					$free->type = null;
					$free->id_ring = null;
				$free->save();
	      	}
	      	foreach ($NewPort as $inf) {
	      		$por_new = Port::find($inf['id']);
					$por_new->id_status = 1;
					$por_new->commentary = $inf['commentary'];
					$por_new->connected_to = $inf['connected_to'];
					$por_new->type = 'ANILLO';
					$por_new->id_ring = $id;
				$por_new->save();
	      	}
	      	$anillo_info = Ring::find($id);
	      	ControllerUser_history::store('Modifico los puerto para el anillo '.$anillo_info->name);
			return array('resul' => 'yes',);
      	}else{
        	return array('resul' => 'autori', );
      	}
	}

	public function service_anillo($id){
		if (!Auth::guest() == false){
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] >= 3){
			$data = [];
			$equipment = DB::table('port')
				->join('board', 'port.id_board', '=', 'board.id')
	        	->join('equipment', 'board.id_equipment', '=', 'equipment.id')
	        	->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
				->where('port.id_ring', '=', $id)
				->where('equipment.id_function', '!=', 1)
				->select('equipment.id','equipment.acronimo','ip.ip','ip.prefixes')->groupBy('equipment.id','equipment.acronimo','ip.ip','ip.prefixes')->get();
			foreach ($equipment as $value) {
				$service = ControllerRing::sql_service_all($value->id);
				foreach ($service as $valor) {
					$bw_max = ControllerEquipment_Model::format_bw($valor->bw_service);
					$data[] = array(
						'equipment' => $value->id,
						'acronimo' => $value->acronimo.' - '.$value->ip.'/'.$value->prefixes,
						'service' => $valor->id,
						'number' => $valor->number,
						'name' => $valor->name,
						'client' => '"'.$valor->acronimo.'" '.$valor->business_name,
						'bw' => $bw_max['data'].' '.$bw_max['signo'],
					);
				}
			}
			return datatables()->of($data)->make(true);
		}else{
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function service_anillo_agg($id){
		if (!Auth::guest() == false){
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$autori_status = User::authorization_status(7);
		if ($autori_status['permi'] >= 3){
			$data = [];
			$id_ring = [];
			$Ring = DB::table('equipment')
	        	->join('board', 'board.id_equipment', '=', 'equipment.id')
				->join('port', 'port.id_board', '=', 'board.id')
				->where('equipment.id', '=', $id)
				->where('port.id_ring', '!=', null)
				->select('port.id_ring')->groupBy('port.id_ring')->get();
			foreach ($Ring as $key) { $id_ring[] = $key->id_ring; }
			if (count($id_ring) > 0) {
				$equipment = DB::table('port')
					->join('board', 'port.id_board', '=', 'board.id')
		        	->join('equipment', 'board.id_equipment', '=', 'equipment.id')
		        	->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
					->wherein('port.id_ring', $id_ring)
					->select('equipment.id','equipment.acronimo','ip.ip','ip.prefixes')->groupBy('equipment.id','equipment.acronimo','ip.ip','ip.prefixes')->get();
			}else{
				$equipment = DB::table('port')
					->join('board', 'port.id_board', '=', 'board.id')
		        	->join('equipment', 'board.id_equipment', '=', 'equipment.id')
		        	->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
					->where('equipment.id', $id)
					->select('equipment.id','equipment.acronimo','ip.ip','ip.prefixes')->groupBy('equipment.id','equipment.acronimo','ip.ip','ip.prefixes')->get();
			}
			foreach ($equipment as $value) {
				$service = ControllerRing::sql_service_all($value->id);
				foreach ($service as $valor) {
					$bw_max = ControllerEquipment_Model::format_bw($valor->bw_service);
					$data[] = array(
						'equipment' => $value->id,
						'acronimo' => $value->acronimo.' - '.$value->ip.'/'.$value->prefixes,
						'service' => $valor->id,
						'number' => $valor->number,
						'name' => $valor->name,
						'client' => '"'.$valor->acronimo.'" '.$valor->business_name,
						'bw' => $bw_max['data'].' '.$bw_max['signo'],
					);
				}
			}
			return datatables()->of($data)->make(true);
		}else{
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	function sql_service_all($id){
		$service = DB::table('port')
			->join('board', 'port.id_board', '=', 'board.id')
			->join('lacp_port', 'port.id_lacp_port', '=', 'lacp_port.id')
			->join('service_port', 'service_port.id_lacp_port', '=', 'lacp_port.id')
			->join('service', 'service_port.id_service', '=', 'service.id')
			->join('list_service_type', 'service.id_type', '=', 'list_service_type.id')
			->leftJoin('client', 'service.id_client', '=', 'client.id')
			->where('board.id_equipment', '=', $id)
			->select('service.id','service.number','service.bw_service','list_service_type.name','client.acronimo','client.business_name')->groupBy('service.id','service.number','service.bw_service','list_service_type.name', 'client.acronimo','client.business_name')->get();
		return $service;
	}

	public function acronimo_anillo(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] >= 3){
			$id = $_POST['id'];
			$acronimo = $_POST['acronimo'];
			$ring = DB::table('ring')->where("name","=",$acronimo)->where("id","!=",$id)->get();
			if (count($ring) > 0) {
				$msj = 'El acronimo existe';
			}else{
				$msj = 'El acronimo es nuevo';
			}
			return array('resul' => 'yes', 'datos' => $msj,);
  		}else{
      		return array('resul' => 'autori', );
      	}
	}

	public function selec_anillo_ip(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id = $_POST['id'];
		$ring = Ring::find($id);
		return array('resul' => 'yes', 'datos' => $ring,);
	}

	public function list_ip_ring_all($data){
	    if (!Auth::guest() == false){
	        return redirect('login')->withErrors([Lang::get('validation.login'),]);
	    }
	  	$all = [];
	   	$slq_id = DB::table('ip')->join('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
	   		->where('use_vlan.id_ring','=',$data)->select('ip.id')->get();
	    foreach ($slq_id as $valor) {
	      	$id_full[] = $valor->id;
	    }
	    if (count($slq_id) > 0) {
	      	$all = ControllerIP::info_ip_filtro($id_full);
	    }
	    return datatables()->of($all)->make(true);
  	}

  	public function migrate_ring(){
	    $relation=DB::table('db_link')->join('link', 'link.name', '=', 'db_link.name')
	    	->join('ip', 'ip.ip', '=', 'db_link.ip_ext1')
	    	->join('equipment', 'equipment.id', '=', 'ip.id_loopback')
	    	->join('board', 'equipment.id', '=', 'board.id_equipment')
	    	->join('port_equipment_model', 'port_equipment_model.id', '=', 'board.id_port_model')
	    	->join('port', 'port.id_board', '=', 'board.id')
	    	->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
	    	->where('port_equipment_model.id_list_port','=', 61)
	    	->select('db_link.acro_ext1', 'db_link.acro_ext2', 'db_link.ext2', 'link.id as link', 'equipment.acronimo', 'equipment.id', 'port.id as id_port', 'list_label.name', 'port.id_lacp_port')->get();
	    foreach ($relation as $value) {
			$sql = Link::find($value->link);
				$sql->id_extreme_1 = $value->id_lacp_port;
			$sql->save();
	    }
	    return redirect('login');
  	}

  	public function migrate_ring_bw_full(){
	    $sql = DB::table('puerto_nuevo')->select('*')->get();
	    foreach ($sql as $value) {
	    	$label = '';
	    	$puerto = '';
	    	$separa = explode('/', $value->port);
	    	$puerto = $separa[count($separa) - 1];
	    	$label = substr($separa[0], 0, -1);
	    	if(is_numeric($puerto)) {
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
						$port_sql = DB::table('port')->select('id', 'id_lacp_port')->where('id_board', '=', $valor->id)
							->where('n_port', '=', $puerto)->get();
						if (count($port_sql) > 0){
							$id_port = $port_sql[0]->id;
							$id_lacp_port = $port_sql[0]->id_lacp_port;
						}else{
							$port_new = new Port();
								$port_new->id_board = $valor->id;
								$port_new->n_port = $puerto;
								$port_new->id_status = 2;
							$port_new->save();
							$id_port = $port_new->id;
							$id_lacp_port = '';
						}
						if ($id_lacp_port == null || $id_lacp_port == '') {
							$lacp_new = new Lacp_Port();
		    					$lacp_new->group_lacp = 'NO';
							$lacp_new->save();
							$id_lacp_port = $lacp_new->id;
						}
						$port_update = Port::find($port_sql[0]->id);
							$port_update->id_status = 1;
							$port_update->type = 'LINK';
							$port_update->id_lacp_port = $id_lacp_port;
						$port_update->save();
						$link = Link::find($value->id_link);
							$link->id_extreme_2 = $id_lacp_port;
						$link->save();
					}
				}
			}
	    }
   		return redirect('login');
  	}

  	public function migrate_ring_port(){
	    $ring = DB::table('db_link')
	    	->join('equipment ext1', 'db_link.acro_ext1', '=', 'ext1.acronimo')
	    	->join('equipment ext2', 'db_link.acro_ext2', '=', 'ext2.acronimo')
	    	->join('board as bo_ext1', 'bo_ext1.id_equipment', '=', 'ext1.id')
	    	->join('board as bo_ext2', 'bo_ext2.id_equipment', '=', 'ext2.id')
	    	->join('port_equipment_model as model1', 'model1.id', '=', 'bo_ext1.id_port_model')
	    	->join('port_equipment_model as model2', 'model2.id', '=', 'bo_ext2.id_port_model')
	    	->join('link', 'link.name', '=', 'db_link.name')
	    	->join('ip as ip_exte1', 'ip_exte1.id_loopback', '=', 'ext1.id')
	    	->join('ip as ip_exte2', 'ip_exte2.id_loopback', '=', 'ext2.id')
	    	->where('model1.id_list_port', '=', 61)
	    	->orwhere('model2.id_list_port', '=', 61)
	    	->where('model1.id_list_port', '=', 61)
	    	->select('link.name','ext1.id as extre1','ext2.id as extre2','link.id', 'bo_ext1.id as id_bo_ext1', 'bo_ext2.id as id_bo_ext2','model1.id_list_port as port1','model2.id_list_port as port2', 'db_link.ip_ext1','db_link.ip_ext2', 'ip_exte1.ip as ext_ip1','ip_exte2.ip as ext_ip2')->get();
	    foreach ($ring as $value) {
	    	if ($value->port1 == 61 && $value->ip_ext1 == $value->ext_ip1) {
	    		$sql1 = DB::table('port')->where('n_port', '=', 1)->select('id', 'id_lacp_port')->where('id_board', '=', $value->id_bo_ext1)->get();
	    		if (count($sql1) == 0) {
		    		$lacp_new = new Lacp_Port();
			    		$lacp_new->group_lacp = 'NO';
					$lacp_new->save();
					$port_lacp = $lacp_new->id;
		    		$port_new = new Port();
						$port_new->id_board = $value->id_bo_ext1;
						$port_new->n_port = 1;
						$port_new->id_status = 1;
						$port_new->id_lacp_port = $port_lacp;
						$port_new->type = 'Celda';
					$port_new->save();
		    	}else{
		    		if ($sql1[0]->id_lacp_port == null) {
		    			$lacp_new = new Lacp_Port();
				    		$lacp_new->group_lacp = 'NO';
						$lacp_new->save();
						$port_lacp = $lacp_new->id;
						$port_new = Port::find($sql1[0]->id);
							$port_new->id_status = 1;
							$port_new->type = 'Celda';
							$port_new->id_lacp_port = $port_lacp;
						$port_new->save();
		    		}else{
		    			$port_lacp = $sql1[0]->id_lacp_port;
		    		}
		    	}
		    	$link_new = Link::find($value->id);
					$link_new->id_extreme_1 = $port_lacp;
				$link_new->save();
	    	}

	    	if ($value->port2 == 61 && $value->ip_ext2 == $value->ext_ip2) {
	    		$sql2 = DB::table('port')->where('n_port', '=', 1)->select('id', 'id_lacp_port')->where('id_board', '=', $value->id_bo_ext2)->get();
	    		if (count($sql2) == 0) {
		    		$lacp_new = new Lacp_Port();
			    		$lacp_new->group_lacp = 'NO';
					$lacp_new->save();
					$lacp2 = $lacp_new->id;
		    		$port_new = new Port();
						$port_new->id_board = $value->id_bo_ext2;
						$port_new->n_port = 1;
						$port_new->id_status = 1;
						$port_new->id_lacp_port = $lacp2;
						$port_new->type = 'Cliente';
					$port_new->save();
		    	}else{
		    		if ($sql2[0]->id_lacp_port == null) {
		    			$lacp_new = new Lacp_Port();
				    		$lacp_new->group_lacp = 'NO';
						$lacp_new->save();
						$lacp2 = $lacp_new->id;
						$port_new = Port::find($sql2[0]->id);
							$port_new->id_status = 1;
							$port_new->type = 'Cliente';
							$port_new->id_lacp_port = $lacp2;
						$port_new->save();
		    		}else{
		    			$lacp2 = $sql2[0]->id_lacp_port;
		    		}
		    	}
		    	$link_new = Link::find($value->id);
					$link_new->id_extreme_1 = $lacp2;
				$link_new->save();
	    	}

	    }
		return redirect('login');
  	}

  	public function select_nodo_lsw_ipran($id){
    	if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] < 3){ return array('resul'=>'autori'); }
		$data = [];
		$lsw =DB::table('equipment')
			->join('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
			->join('node', 'equipment.id_node', '=', 'node.id')
			->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
			->where('node.id','=', $id)->where('equipment.id_function','=', 4)->where('equipment.type','=', 'Ipran')
			->select('equipment.acronimo', 'equipment.id', 'equipment.status', 'ip.ip', 'ip.prefixes', 'equipment.commentary', 'equipment.client_management')->get();
		foreach ($lsw as $value) {
			if ($value->client_management == 'NO' || $value->client_management == 'No') {
				$data[] = array(
					'acronimo' => $value->acronimo,
					'id' => $value->id,
					'status' => $value->status,
					'ip' => $value->ip,
					'commentary' => $value->commentary,
				);
			}
		}
		return datatables()->of($data)->make(true);
    }

    public function search_port_bw_ring_ipran(){
  		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] >= 3){
		  	$id=$_POST['id'];
		  	$bw=$_POST['bw'];
		  	$id_anillo=$_POST['id_anillo'];
		  	$port = DB::table('equipment')
		    ->join('board', 'board.id_equipment', '=', 'equipment.id')
		    ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
		    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
		    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		    ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
		    ->where('equipment.id', '=', $id)
		    ->where('board.status', '=', 'ACTIVO')
		    ->where('port_equipment_model.bw_max_port', '=', $bw)
		    ->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'board.slot', 'list_module_board.name as model', 'board.id', 'list_port.name as type')->orderBy('slot', 'asc')->orderBy('port_l_i', 'asc')->get();
		    if (count($port) > 0) {
		    	$por_selec = [];
		    	$data_mostrar = [];
		    	$respuesta = 'nop';
		    	foreach ($port as $value) {
		    		$por_selec = [];
		    		for ($z=$value->port_l_i; $z <= $value->port_l_f; $z++) {
		    			$por_selec[] = $z;
		    		}
		    		$fsp_label=ControllerRing::label_por($value->slot);
		    		foreach ($por_selec as $data) {
		    			$status_sele = DB::table('port')
		    				->join('status_port', 'port.id_status', '=', 'status_port.id')
		    				->leftJoin('ring', 'port.id_ring', '=', 'ring.id')
		    				->where('port.id_board', '=', $value->id)
		    				->where('port.n_port', '=', $data)
		    				->select('port.id_status','status_port.name as status','ring.id', 'port.commentary')->get();
		    			$commentary = '';
		    			$status = '2';
		    			$status_name = 'VACANTE';
		    			if (count($status_sele) != 0) {
		    				$status = $status_sele[0]->id_status;
		    				$status_name = $status_sele[0]->status;
		    				if ($status_sele[0]->commentary != null) {
		    					$commentary = $status_sele[0]->commentary;
		    				}
		    			}
		    			$data_mostrar[] = array(
		    				'f_s_p' => $fsp_label,
		    				'por_selec' => $data,
		    				'label' => $value->label,
		    				'model' => $value->model,
		    				'id' => $value->id,
		    				'status' => $status_name,
		    				'id_status' => $status,
		    				'pose' => $fsp_label.$data,
		    				'commentary' => $commentary,
		    				'type' => $value->type,
		    			);
		    			$respuesta = 'yes';
		    		}
		    	}
		    	if (count($data_mostrar) > 0) {
		    		$pose_order  = array_column($data_mostrar, 'pose');
					array_multisort($pose_order, SORT_ASC,$data_mostrar);
		    	}
		    	$data = array(	'resul' => $respuesta,'datos' => $data_mostrar,);
		    }else{
		    	$data = array('resul' => 'nop',);
		    }
		    return $data;
  		}else{
      		return array('resul' => 'autori', );
      	}
  	}

  	public function CreateRingIpran(RequestRingIpran $request){
		try {
			$autori_status = User::authorization_status(11);
			if ($autori_status['permi'] < 5){
				return array('resul' => 'autori',);
			}
			$vlan = ControllerRing::ValidateVlan($request->vlan_all);
			if ($vlan == 'nop') {
				return array('resul' => 'ip_exis', );
			}
			$acro_exis = DB::table('ring')
				->where('name','=',$request->ipran_acro)->where('id','!=',$request->id)
				->where('status','!=','BAJA')->select('id')->get();
			if (count($acro_exis) > 0) {
				return array('resul' => 'exis',);
			}
			$placa_sql = explode('@', $request->port[0]);
			$bw_real = DB::table("port_equipment_model")
				->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
				->where('board.id', '=', $placa_sql[1])
				->select('port_equipment_model.bw_max_port')->get();
			if (count($request->port) > 1) {
				$bw_all_ring = (count($request->port) * $bw_real[0]->bw_max_port) / 2;
			} else {
				$bw_all_ring = $bw_real[0]->bw_max_port;
			}
			if ($request->id != 0) {
				$msj_anillo = 'Modifico el anillo: ';
				$anillo = Ring::find($request->id);
			} else {
				if ($autori_status['permi'] < 10) {
					return array('resul' => 'autori', );
				}
				$msj_anillo = 'Registro el anillo: ';
				$anillo = new Ring();
				$anillo->type_ring = "Ipran";
			}
			$anillo->name = $request->ipran_acro;
			$anillo->type = $request->type;
			$anillo->bw_limit = $bw_all_ring;
			$anillo->status = "ALTA";
			$anillo->dedicated = $request->dedica;
			$anillo->commentary = $request->commen;
			$anillo->save();
			$id_anillo_new = $anillo->id;
			Self::port_ring_ipran_new($anillo->id, $request->port, $request->lsw);
			Self::vlan_ipran_new($vlan, $request->ipran_acro, $id_anillo_new, $request->lsw);
			return array('resul' => 'yes');
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e->getMessage()];
		}
  	}

  	public static function vlan_ipran_new($vlan_ip_listo, $acro, $id_ring, $id_equipment){
  		foreach ($vlan_ip_listo as $valor) {
			$Use_Vlan = new Use_Vlan();
			$Use_Vlan->vlan = $valor['vlan'];
			$Use_Vlan->id_list_use_vlan = $valor['uso'];
			$Use_Vlan->id_ring = $id_ring;
			$Use_Vlan->id_equipment = $id_equipment;
			$Use_Vlan->save();
			$ip_listo[] = array(
				'vlan' => $Use_Vlan->id,
				'ip' => $valor['ip'],
			);
		}
		foreach ($ip_listo as $key) {
			$IP_sele =IP::find($key['ip']);
			$ran_ip = ControllerIP::rango($IP_sele->ip.'/'.$IP_sele->prefixes);
			$ini_fin_ip = ControllerIP::ipv4_ini_fin($IP_sele->ip.'/'.$IP_sele->prefixes);
			$ip_vlan_individual[] = array(
				'vlan' => $key['vlan'],
				'ip' => $ini_fin_ip['inicio'],
				'rama' => $IP_sele->id_branch,
			);
			foreach ($ran_ip as $valores) {
				$ip_vlan_individual[] = array(
					'vlan' => $key['vlan'],
					'ip' => $valores,
					'rama' => $IP_sele->id_branch,
				);
			}
			$ip_vlan_individual[] = array(
				'vlan' => $key['vlan'],
				'ip' => $ini_fin_ip['fin'],
				'rama' => $IP_sele->id_branch,
			);
		}
		foreach ($ip_vlan_individual as $value_ip_vlan) {
			$buscar = DB::table("ip")->select('ip.id', 'ip.type')
				->where('ip.ip', '=', $value_ip_vlan['ip'])
				->where('ip.id_branch', '=', $value_ip_vlan['rama'])->get();
			$IP_vlan_sele =IP::find($buscar[0]->id);
			if ($buscar[0]->type == 'RED') {
				$IP_vlan_sele->id_status = 2;
			}
			$IP_vlan_sele->id_use_vlan = $value_ip_vlan['vlan'];
			$IP_vlan_sele->save();
			$msj = 'Se asigno la IP al anillo '.$acro;
			ControllerIP::insert_all_record_ip($IP_vlan_sele->id, $IP_vlan_sele->prefixes, $msj);
		}
  	}

  	public static function ValidateVlan($vlan_ip){
  		$vlan = [];
		foreach ($vlan_ip as $val) {
			$separador = explode('_', $val);
			$vlan[] = array(
				'uso' => $separador[0],
				'vlan' => $separador[1],
				'ip' => $separador[2],
			);
			if ($separador[1] > 4045) {
				return array('resul' => 'vlan', );
			}
			$exi_ip = DB::table("ip")->select('ip.id_status')
				->where('ip.id', '=', $separador[2])
				->where('ip.id_status', '!=', 1)->get();
			if (count($exi_ip)>0) {
				return 'nop';
			}
		}
		return $vlan;
  	}

  	public static function port_ring_ipran_new($id, $valor_placa, $equip){
		$port_sele = DB::table('port')
			->join('board', 'port.id_board', '=', 'board.id')
			->join('equipment', 'board.id_equipment', '=', 'equipment.id')
			->where('port.id_ring', '=', $id)
			->where('equipment.id', '=', $equip)
			->select('port.id_board', 'port.n_port', 'port.id')->get();
		foreach ($port_sele as $value) {
			$port =Port::find($value->id);
				$port->id_status = 2;
				$port->type = null;
				$port->id_ring = null;
			$port->save();
		}
		foreach ($valor_placa as $val) {
			$divi = explode('@', $val);
			$port_exis_sin_afiliar = DB::table('port')
				->join('board', 'port.id_board', '=', 'board.id')
				->where('port.n_port', '=', $divi[0])
				->where('board.id', '=', $divi[1])
				->where('board.id_equipment', '=', $equip)
				->select('port.id')->get();
			if (count($port_exis_sin_afiliar) > 0) {
				$port =Port::find($port_exis_sin_afiliar[0]->id);
			}else{
				$port = new Port();
					$port->id_board = $divi[1];
					$port->n_port = $divi[0];
			}
				$port->id_status = 1;
				$port->type = 'ANILLO';
				$port->id_ring = $id;
			$port->save();
		}
	}

	public function index_list_Metroethernet(){
		$datos = [];
		$anillo = DB::table('ring')
	    	->Join('port','port.id_ring','=','ring.id')
	    	->Join('board','port.id_board','=','board.id')
	    	->Join('equipment','board.id_equipment','=','equipment.id')
	    	->where('equipment.id_function', '=', 1)
	    	->where('ring.status', '!=', 'BAJA')
	    	->where('ring.type_ring', '!=', 'Ipran')
	    	->select('ring.id', 'ring.name', 'ring.status', 'ring.type', 'ring.dedicated', 'ring.commentary', 'ring.bw_limit', 'ring.type_ring', 'equipment.acronimo')->groupBy('ring.id', 'ring.name', 'ring.status', 'ring.type', 'ring.dedicated', 'ring.commentary', 'ring.bw_limit', 'ring.type_ring', 'equipment.acronimo')->get();
	    foreach ($anillo as $value) {
	    	$type =
			$utilizado = 0;
			$cantidad = 0;
			$cantidad = count(DB::table('board')
				->join('port', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->where('port.id_ring','=',$value->id)
				->where('equipment.id_function', '!=', 1)
				->select('id_equipment')->groupBy('id_equipment')->get());
			$equipo = DB::table('port')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->join('board as bo', 'bo.id_equipment', '=', 'equipment.id')
				->join('port as por1', 'por1.id_board', '=', 'bo.id')
				->leftJoin('lacp_port', 'lacp_port.id', '=', 'por1.id_lacp_port')
				->leftJoin('service_port','lacp_port.id','=','service_port.id_lacp_port')
				->leftJoin('service', 'service.id', '=', 'service_port.id_service')
				->where('port.id_ring', '=', $value->id)
				->where('equipment.id_function', '!=', 1)
				->select('service.bw_service', 'service.id')
				->groupBy('service.bw_service', 'service.id')->get();
			foreach ($equipo as $valore) {
				$utilizado = $utilizado + $valore->bw_service;
			}
			$bw_max_anillo = ControllerEquipment_Model::format_bw($value->bw_limit);
			$util_anillo = ControllerEquipment_Model::format_bw($utilizado);
			$cap = (100 * $utilizado)/$value->bw_limit;
			$act = 'Apto';
			$percentage = round($cap, 2);
			if ($value->bw_limit >= $utilizado) {
				$libre = $value->bw_limit - $utilizado;
				$bw_libre = ControllerEquipment_Model::format_bw($libre);
				$bw_real = $bw_libre['data'].' '.$bw_libre['signo'];
			}else{
				$sobre_paso = $utilizado - $value->bw_limit;
				$bw_libre = ControllerEquipment_Model::format_bw($sobre_paso);
				$bw_real = '-'.$bw_libre['data'].' '.$bw_libre['signo'];
			}
			if ($percentage > 64 || $cantidad > 13 || 'BAJA' == $value->status) {
				$act = 'No Apto';
			}
		    $datos[] = array(
		    	'name' => $value->name,
		    	'acronimo' => $value->acronimo,
		    	'type' => $value->type,
		    	'type_ring' => $value->type_ring,
		    	'status' => $value->status,
		    	'dedicated' => $value->dedicated,
		    	'bw_max_port' => $bw_max_anillo['data'].' '.$bw_max_anillo['signo'],
		    	'id' => $value->id,
		    	'cantidad' => $cantidad,
		    	'utilizado' => $util_anillo['data'].' '.$util_anillo['signo'],
		    	'libre' => $percentage.'%',
		    	'act' => $act,
		    	'number' => $percentage,
		    );
	    }
	    return datatables()->of($datos)->make(true);
	}

	public function index_list_Ipran(){
		$datos = [];
		$anillo = DB::table('ring')->where('ring.status', '!=', 'BAJA')->select('ring.id', 'ring.name', 'ring.status', 'ring.type', 'ring.dedicated', 'ring.commentary', 'ring.bw_limit', 'ring.type_ring')->groupBy('ring.id', 'ring.name', 'ring.status', 'ring.type', 'ring.dedicated', 'ring.commentary', 'ring.bw_limit', 'ring.type_ring')->get();
	    foreach ($anillo as $value) {
	    	$type = '';
			$utilizado = 0;
			$cantidad = 0;
			$acronimo = '';
			$info_equip = DB::table('port')
		    	->Join('board','port.id_board','=','board.id')
		    	->Join('equipment','board.id_equipment','=','equipment.id')
		    	->where('equipment.id_function', '=', 4)
		    	->where('port.id_ring', '=', $value->id)
		    	->where('equipment.client_management', '=', 'No')
		    	->select('equipment.acronimo')->get();
		    if (count($info_equip)>0) {
		    	$acronimo = $info_equip[0]->acronimo;
		    }

			$cantidad = count(DB::table('board')
				->join('port', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->where('port.id_ring','=',$value->id)
				->where('equipment.id_function', '!=', 1)
				->select('id_equipment')->groupBy('id_equipment')->get());
			$equipo = DB::table('port')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->join('board as bo', 'bo.id_equipment', '=', 'equipment.id')
				->join('port as por1', 'por1.id_board', '=', 'bo.id')
				->leftJoin('lacp_port', 'lacp_port.id', '=', 'por1.id_lacp_port')
				->leftJoin('service_port','lacp_port.id','=','service_port.id_lacp_port')
				->leftJoin('service', 'service.id', '=', 'service_port.id_service')
				->where('port.id_ring', '=', $value->id)
				->where('equipment.id_function', '!=', 1)
				->select('service.bw_service', 'service.id')
				->groupBy('service.bw_service', 'service.id')->get();
			foreach ($equipo as $valore) {
				$utilizado = $utilizado + $valore->bw_service;
			}
			$bw_max_anillo = ControllerEquipment_Model::format_bw($value->bw_limit);
			$util_anillo = ControllerEquipment_Model::format_bw($utilizado);
			$cap = (100 * $utilizado)/$value->bw_limit;
			$act = 'Apto';
			$percentage = round($cap, 2);
			if ($value->bw_limit >= $utilizado) {
				$libre = $value->bw_limit - $utilizado;
				$bw_libre = ControllerEquipment_Model::format_bw($libre);
				$bw_real = $bw_libre['data'].' '.$bw_libre['signo'];
			}else{
				$sobre_paso = $utilizado - $value->bw_limit;
				$bw_libre = ControllerEquipment_Model::format_bw($sobre_paso);
				$bw_real = '-'.$bw_libre['data'].' '.$bw_libre['signo'];
			}
			if ($percentage > 64 || $cantidad > 13 || 'BAJA' == $value->status) {
				$act = 'No Apto';
			}
		    $datos[] = array(
		    	'name' => $value->name,
		    	'acronimo' => $acronimo,
		    	'type' => $value->type,
		    	'type_ring' => $value->type_ring,
		    	'status' => $value->status,
		    	'dedicated' => $value->dedicated,
		    	'bw_max_port' => $bw_max_anillo['data'].' '.$bw_max_anillo['signo'],
		    	'id' => $value->id,
		    	'cantidad' => $cantidad,
		    	'utilizado' => $util_anillo['data'].' '.$util_anillo['signo'],
		    	'libre' => $percentage.'%',
		    	'act' => $act,
		    	'number' => $percentage,
		    );
	    }
	    return datatables()->of($datos)->make(true);
	}

	public function search_ring_lanswitch_ipran(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id = $_POST['id'];
      	$authori_status = User::authorization_status(11);
      	if ($authori_status['permi'] >= 3) {
			$anillo = DB::table("equipment")
				->join('board', 'board.id_equipment', '=', 'equipment.id')
				->join('port', 'port.id_board', '=', 'board.id')
				->join('ring', 'port.id_ring', '=', 'ring.id')
				->where('ring.id', '=', $id)
				->where('equipment.id_function', '=', 4)
	    		->where('equipment.client_management', '=', 'No')
			->select('ring.id', 'equipment.acronimo','ring.name','ring.type')->groupBy('ring.id', 'equipment.acronimo','ring.name','ring.type')->get();
			$equip = DB::table("equipment")
				->join('board', 'board.id_equipment', '=', 'equipment.id')
				->join('port', 'port.id_board', '=', 'board.id')
				->join('ring', 'port.id_ring', '=', 'ring.id')
				->where('ring.id', '=', $id)
			->select('equipment.id', 'equipment.acronimo')->groupBy('equipment.id', 'equipment.acronimo')->get();
        	if (count($anillo) > 0){
        		$data = array(
        			'resul'=> 'yes',
			        'acronimo' => $anillo[0]->acronimo,
			        'name' => $anillo[0]->name,
			        'type' => $anillo[0]->type,
			        'equip' => $equip,
			        'coun' => count($equip),
        		);
        	}else{
        		$data = array( 'resul'=> 'no',);
        	}
        	return $data;
      	}else{
        	return array('resul' => 'home', );
      	}
	}

	public function BwRingRadioService(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$lsw = $_POST['lsw'];
		$resul = 'Si';
		$service = Service::find($_POST['service'], 'bw_service');
		$bw_service = $service->bw_service;
		$bw_ring = 0;
		$info = DB::table("equipment")
			->join('board', 'board.id_equipment', '=', 'equipment.id')
			->join('port', 'port.id_board', '=', 'board.id')
			->join('ring', 'port.id_ring', '=', 'ring.id')
			->where('equipment.id', '=', $lsw)
			->select('ring.bw_limit', 'port.id_ring', 'equipment.client_management', 'equipment.type')
			->groupBy('ring.bw_limit', 'port.id_ring', 'equipment.client_management', 'equipment.type')
			->get();
		if (count($info)>0) {
			$bw_ring = $info[0]->bw_limit;
			$ring = $info[0]->id_ring;
			$equip_all[] = $lsw;
			$equip = DB::table("equipment")
			->join('board', 'board.id_equipment', '=', 'equipment.id')
			->join('port', 'port.id_board', '=', 'board.id')
			->join('ring', 'port.id_ring', '=', 'ring.id')
			->where('ring.id', '=', $ring)
			->select('equipment.id', 'equipment.client_management', 'equipment.type')
			->groupBy('equipment.id', 'equipment.client_management', 'equipment.type')
			->get();
			foreach ($equip as $value) {
				$equip_all[] = $value->id;
			}
			$bw = DB::table("equipment")
			->join('board', 'board.id_equipment', '=', 'equipment.id')
			->join('port', 'port.id_board', '=', 'board.id')
			->join('service_port', 'service_port.id_lacp_port', '=', 'port.id_lacp_port')
			->join('service', 'service_port.id_service', '=', 'service.id')
			->whereIn('equipment.id', $equip_all)
			->where('service.id', '!=', $_POST['service'])
			->select('service.id', 'service.bw_service')
			->groupBy('service.id', 'service.bw_service')->get();
			foreach ($bw as $val) {
				$bw_service = $bw_service + $val->bw_service;
			}
		}
		if ($bw_ring != 0 && $bw_service > $bw_ring ) {
			$resul = 'No';
		}
		$real = $bw_ring - $bw_service;
		return array('resul'=> 'yes', 'ring'=> $resul,'bw_ring'=> $real,);
	}

	//traer todo los puerto de los anillo para agregar o quitar//
	public function PortRingAll(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] < 5){
			return array('resul'=> 'autori');
		}
		$id = $_POST['id'];
		$port = [];
		$info = Ring::find($id);
		if ($info->type_ring == 'Metroethernet') {
			$anillo = DB::table('ring')
	        	->join('port', 'port.id_ring', '=', 'ring.id')
	        	->join('board', 'port.id_board', '=', 'board.id')
	        	->join('equipment', 'board.id_equipment', '=', 'equipment.id')
	        	->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
	        	->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
	        	->where('port.id_ring', '=', $id)
	        	->where('equipment.id_function', '=', 1)
	        	->select('port.id', 'port.id_board', 'port.n_port', 'port_equipment_model.bw_max_port', 'board.id as board', 'equipment.acronimo', 'board.slot', 'list_label.name as etiqueta', 'equipment.id as equip')->get();
      	}else{
	        $anillo = DB::table('ring')
        		->join('port', 'port.id_ring', '=', 'ring.id')
        		->join('board', 'port.id_board', '=', 'board.id')
        		->join('equipment', 'board.id_equipment', '=', 'equipment.id')
        		->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
        		->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
        		->where('port.id_ring', '=', $id)
        		->where('equipment.id_function', '=', 4)
		    	->where('equipment.type', '!=', 'Metroethernet')
		    	->where('equipment.client_management', '=', 'No')
        		->select('port.id', 'port.id_board', 'port.n_port', 'port_equipment_model.bw_max_port', 'board.id as board', 'equipment.acronimo', 'board.slot', 'list_label.name as etiqueta', 'equipment.id as equip')->get();
      	}

      	foreach ($anillo as $value) {
      		$fsp_label=ControllerRing::label_por($value->slot);
      		$port[] = array(
      			'id' => $value->id,
      			'equip' => $value->equip,
      			'acronimo' => $value->acronimo,
      			'bw' => $value->bw_max_port,
      			'port' => $value->etiqueta.$fsp_label.$value->n_port,
      		);
      	}

      	return array('resul'=> 'yes', 'datos'=> $port, 'ring' => $info,);
	}

	public function PortRingDelete(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] < 5){
			return array('resul'=> 'autori');
		}
		$id = $_POST['id'];
		$port_new = Port::find($id);
			$port_new->id_status = 2;
			$port_new->commentary = null;
			$port_new->connected_to = null;
			$port_new->type = null;
			$port_new->id_uplink = null;
			$port_new->id_ring = null;
			$port_new->id_lacp_port = null;
		$port_new->save();
		return array('resul'=> 'yes',);
	}

	public function PortRingNetList(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$autori_status = User::authorization_status(11);
		if ($autori_status['permi'] < 5){
			return array('resul'=> 'autori');
		}
		$id = $_POST['id'];
		$info = Ring::find($id);

		if ($info->type_ring === 'Metroethernet') {
			$equip = DB::table('ring')
	        	->join('port', 'port.id_ring', '=', 'ring.id')
	        	->join('board', 'port.id_board', '=', 'board.id')
	        	->join('equipment', 'board.id_equipment', '=', 'equipment.id')
	        	->where('port.id_ring', '=', $id)
	        	->where('equipment.id_function', '=', 1)
	        	->select('equipment.id', 'equipment.acronimo')->groupBy('equipment.id', 'equipment.acronimo')->get();
      	}else{
	        $equip = DB::table('ring')
        		->join('port', 'port.id_ring', '=', 'ring.id')
        		->join('board', 'port.id_board', '=', 'board.id')
        		->join('equipment', 'board.id_equipment', '=', 'equipment.id')
        		->where('port.id_ring', '=', $id)
        		->where('equipment.id_function', '=', 4)
		    	->where('equipment.type', '!=', 'Metroethernet')
		    	->where('equipment.client_management', '=', 'No')
        		->select('equipment.id', 'equipment.acronimo')->groupBy('equipment.id', 'equipment.acronimo')->get();
      	}

      	$port_all = [];

		$port = DB::table('port_equipment_model')
			->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
		    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
		    ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
		    ->where('board.id_equipment', '=', $equip[0]->id)
		    ->where('board.status', '=', 'ACTIVO')
		    ->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_port.name as type', 'board.slot', 'board.id', 'port_equipment_model.bw_max_port')->orderBy('port_l_i', 'asc')->get();

		$info = DB::table('port')
	        ->join('board', 'port.id_board', '=', 'board.id')
	        ->where('board.id_equipment', '=', $equip[0]->id)
	        ->select('port.id_status', 'board.id', 'port.n_port')->get();

		foreach ($port as $val) {

			$bw_max = ControllerEquipment_Model::format_bw($val->bw_max_port);
			$fsp_label = ControllerRing::label_por($val->slot);
		    for ($z=$val->port_l_i; $z <= $val->port_l_f; $z++) {

		    	$info = DB::table('port')->where('id_board', '=', $val->id)->where('n_port', '=', $z)
		    		->select('id_status')->get();
				if (count($info) > 0) {
					if ($info[0]->id_status == 2 ||  $info[0]->id_status == 3) {
						$port_all[] = array(
				    		'id' =>  $val->id.','.$z,
				    		'port' => $val->label.$fsp_label.$z,
				    		'type' => $val->type,
				    		'n_port' => $z,
				    		'bw' => $bw_max['data'].' '.$bw_max['signo'],
				    		'slot' => $fsp_label,
				    	);
					}
				}else{
					$port_all[] = array(
			    		'id' =>  $val->id.','.$z,
			    		'port' => $val->label.$fsp_label.$z,
			    		'type' => $val->type,
			    		'n_port' => $z,
			    		'bw' => $bw_max['data'].' '.$bw_max['signo'],
			    		'slot' => $fsp_label,
			    	);
				}
			}

    	}

    	if (count($port_all) > 0) {
		    $pose_order  = array_column($port_all, 'slot');
		    $port_order  = array_column($port_all, 'n_port');
			array_multisort($pose_order, SORT_ASC,$port_order, SORT_ASC, $port_all);
		}

      	return array('resul'=> 'yes', 'datos' => $port_all, 'acronimo' => $equip[0]->acronimo,);
	}

	public function PortRingNewInsert(RequestPortRing $request){

		$info = DB::table('port')->where('port.id_board', '=', $request->board)
			->where('port.n_port', '=', $request->port)->select('port.id_status', 'port.id')->get();
	    if (count($info) > 0) {

	    	if ($info[0]->id_status == 2 ||  $info[0]->id_status == 3) {
	    		$port_new = Port::find($info[0]->id);
					$port_new->id_status = 1;
					$port_new->type = 'ANILLO';
					$port_new->id_ring = $request->ring;
				$port_new->save();
	    	}else{
	    		return array('resul'=> 'nop');
	    	}

	    }else{
	    	$port_new = new Port();
				$port_new->id_board = $request->board;
				$port_new->n_port = $request->port;
				$port_new->id_status = 1;
				$port_new->type = 'ANILLO';
				$port_new->id_ring = $request->ring;
			$port_new->save();
	    }
		return array('resul'=> 'yes');
	}

	public function has_frontier($id_list_use_vlan){
		try {
			$vlan_type = List_Use_Vlan::find($id_list_use_vlan);
			if ($vlan_type->behavior == 1) return ['resul' => 'yes'];
			return ['resul' => 'nop'];
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public static function next_free_vlan($id_list_use_vlan, $id_equipment, $id_frontier = 0, $last_display = 0) {
		try {
			$behavior = List_Use_Vlan::where("id", $id_list_use_vlan)->pluck("behavior")->first();
			if ($behavior == 1) {
				$service_vlans = List_Use_Vlan::where("behavior", $behavior)
					->pluck("id")
					->toArray();
				$range = DB::table("range_vlan")
					->whereIn("id_list_use_vlan", $service_vlans)
					->whereIn("id_equipment", [$id_equipment, 0])
					->select("range_from", "range_until")
					->get();
				$used = Use_Vlan::where('id_frontera', $id_frontier)
					->pluck("vlan")
					->toArray();
			} else {
				$range = DB::table("range_vlan")
					->where("id_list_use_vlan", $id_list_use_vlan)
					->whereIn("id_equipment", [$id_equipment, 0])
					->select("range_from", "range_until")
					->get();
				$used = Use_Vlan::where("id_list_use_vlan", $id_list_use_vlan)
					->whereIn("id_equipment", [$id_equipment, 0])
					->pluck("vlan")
					->toArray();
			}
			$free_vlans = [];

			foreach ($range as $r) {
				for ($i = $r->range_from; $i <= $r->range_until; $i++) {
					if (!in_array($i, $used)) {
						$free_vlans[] = str_pad($i, 4, '0', STR_PAD_LEFT);
					}
				}
			}
			return ['resul' => 'yes', 'datos' => ''];
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e->getMessage()];
		}
	}

	public static function has_ls_radio_vlan($vlan = []) {
		$found_ls_vlan = false;
		$found_radio_vlan = false;
		foreach ($vlan as $v) {
			$separador = explode('_', $v);
			if ($separador[0] === '1' && $separador[1] != '0') $found_ls_vlan = true;
			if ($separador[0] === '2' && $separador[1] != '0') $found_radio_vlan = true;
		}
		if ($found_ls_vlan == true && $found_radio_vlan == true) return true;
		return false;
	}

	public function get_free_vlans($id_list_use_vlan, $id_equipment, $id_frontier = 0) {
		try {
			$behavior = List_Use_Vlan::where("id", $id_list_use_vlan)->pluck("behavior")->first();

			if ($behavior == 1) {

				$service_vlans = List_Use_Vlan::where("behavior", $behavior)
					->pluck("id")
					->toArray();
				$range = DB::table("range_vlan")
					->whereIn("id_list_use_vlan", $service_vlans)
					->whereIn("id_equipment", [$id_equipment, 0])
					->select("range_from", "range_until")
					->get();
				$ring = DB::table('equipment')
					->join('board', 'board.id_equipment', '=', 'equipment.id')
					->join('port', 'port.id_board', '=', 'board.id')
					->join('ring', 'ring.id', '=', 'port.id_ring')
					->where('equipment.id', '=', $id_equipment)
					->select('ring.id')
					->first();
				$used = Use_Vlan::where('id_frontera', $id_frontier)
					->where('id_ring', $ring->id)
					->select('id', 'vlan')
					->get();

				if (count($used)>0) {
					foreach ($used as $u) $u->vlan = str_pad($u->vlan, 4, '0', STR_PAD_LEFT);
					return ['resul' => 'yes', 'datos' => $used];
				} else {
					$free = [];
					foreach ($range as $r) {
						for ($i = $r->range_from; $i <= $r->range_until; $i++) {
							$free[] = str_pad($i, 4, '0', STR_PAD_LEFT);
						}
					}
					return ['resul' => 'yes', 'datos' => $free];
				}

			} else if ($behavior == 2) {

				$range = DB::table("range_vlan")
					->where("id_list_use_vlan", $id_list_use_vlan)
					->whereIn("id_equipment", [$id_equipment, 0])
					->select("range_from", "range_until")
					->get();
				$used = Use_Vlan::whereNotIn("id_list_use_vlan", [1, 2, 3, 4, 5, 6])
					->where("id_equipment", $id_equipment)
					->pluck("vlan")
					->toArray();

			} else {

				$range = DB::table("range_vlan")
					->where("id_list_use_vlan", $id_list_use_vlan)
					->whereIn("id_equipment", [$id_equipment, 0])
					->select("range_from", "range_until")
					->get();
				$used = Use_Vlan::whereNotIn("id_list_use_vlan", [7, 8])
					->where("id_equipment", $id_equipment)
					->pluck("vlan")
					->toArray();

			}
			$free_vlans = [];

			foreach ($range as $r) {
				for ($i = $r->range_from; $i <= $r->range_until; $i++) {
					if (!in_array($i, $used)) {
						$free_vlans[] = str_pad($i, 4, '0', STR_PAD_LEFT);
					}
				}
			}
			return ['resul' => 'yes', 'datos' => $free_vlans];
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e->getMessage()];
		}
	}

	public function get_frontiers($srv_type_id, $service_bw, $ring_id, $agg_id, $multihome) {
		try {
			$multihome = json_decode($multihome);

			$agg_assoc = DB::table('agg_association')
				->where('id_agg', $agg_id)
				->first();
			if (empty($agg_assoc)) return ['resul' => 'nop', 'datos' => 'No se encontraron PE/PEI asociaciados a este agregador'];

			if ($srv_type_id == 15 && !$multihome) {
				$ext1_eq_key = 'home_pei';
				$ext1_eq_value = $agg_assoc->id_home_pei;
			} else if ($srv_type_id == 15 && $multihome) {
				$ext1_eq_key = 'multihome_pei';
				$ext1_eq_value = $agg_assoc->id_multihome_pei;
			} else if (($srv_type_id == 20 || $srv_type_id == 24) && !$multihome) {
				$ext1_eq_key = 'home_pe';
				$ext1_eq_value = $agg_assoc->id_home_pe;
			} else if (($srv_type_id == 20 || $srv_type_id == 24) && $multihome) {
				$ext1_eq_key = 'multihome_pe';
				$ext1_eq_value = $agg_assoc->id_multihome_pe;
			} else {
				return ['resul' => 'nop', 'datos' => 'Tipo de servicio no válido'];
			}

			$frts = DB::table('link')
				->join('lacp_port', 'link.id_extreme_1', '=', 'lacp_port.id')
				->join('port', 'lacp_port.id', '=', 'port.id_lacp_port')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->join('agg_association', 'equipment.id', '=', "agg_association.id_$ext1_eq_key")
				->where('link.id_list_type_links', '=', 1)
				->where('link.status', '=', 'ALTA')
				->where("agg_association.id_$ext1_eq_key", '=', $ext1_eq_value)
				->select('link.id as id_frt',
					'link.name as frt',
					'link.bw_limit',
					'link.commentary as name_frt',
					"agg_association.id_$ext1_eq_key",
					"equipment.acronimo as acr_$ext1_eq_key",
					//"link.interface_identification_1 as interface_$ext1_eq_key",
					"lacp_port.commentary as interface_$ext1_eq_key")
				->distinct()
				->get();
			if (count($frts)<1) return ['resul' => 'nop', 'datos' => 'No se encontraron fronteras habilitadas'];

			$frts_with_vlan = [];
			$frts_without_vlan = [];
			foreach ($frts as $frt) {
				$frt->bw_occu = Link::get_occupancy($frt->id_frt);
				$frt->available_bw = $frt->bw_limit - $frt->bw_occu;
				$bw_limit = ControllerEquipment_Model::format_bw($frt->bw_limit);
				$bw_occu = ControllerEquipment_Model::format_bw($frt->bw_occu);
				$frt->bw_limit = $bw_limit['data'].' '.$bw_limit['signo'];
				$frt->bw_occu = $bw_occu['data'].' '.$bw_occu['signo'];
				if ($frt->available_bw >= $service_bw) {
					if (Use_Vlan::where('id_frontera', $frt->id_frt)->where('id_ring', $ring_id)->exists()) $frts_with_vlan[] = $frt;
					else $frts_without_vlan[] = $frt;
				}
			}
			usort($frts_with_vlan, function($a, $b) { if ($a->available_bw == $b->available_bw) { return 0; } return ($a->available_bw < $b->available_bw) ? -1 : 1; });
			usort($frts_without_vlan, function($a, $b) { if ($a->available_bw == $b->available_bw) { return 0; } return ($a->available_bw < $b->available_bw) ? -1 : 1; });
			$frts_list = array_merge($frts_with_vlan, $frts_without_vlan);
			return ['resul' => 'yes', 'datos' => $frts_list];
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e->getMessage()];
		}
	}

	public function ring_agg_by_equipment($id) {
		try {
			$data = [];

			$ring = DB::table('equipment')
				->join('board', 'board.id_equipment', '=', 'equipment.id')
				->join('port', 'port.id_board', '=', 'board.id')
				->join('ring', 'ring.id', '=', 'port.id_ring')
				->where('equipment.id', '=', $id)
				->select('ring.id', 'ring.name')
				->first();

			$agg = DB::table('ring')
				->join('port', 'ring.id', '=', 'port.id_ring')
				->join('board', 'port.id_board', '=', 'board.id')
				->join('equipment', 'board.id_equipment', '=', 'equipment.id')
				->where('equipment.id_function', '=', 1)
				->where('ring.id', '=', $ring->id)
				->select('equipment.id', 'equipment.acronimo', 'equipment.type')
				->first();

			$data['ring_id'] = $ring->id;
			$data['ring_name'] = $ring->name;
			$data['agg_id'] = $agg->id;
			$data['agg_acronimo'] = $agg->acronimo;
			$data['agg_type'] = $agg->type;

			return ['resul' => 'yes', 'datos' => $data];
		} catch (Exception $e) {
			return ['resul' => 'nop', 'datos' => $e->getMessage()];
		}

	}
}
