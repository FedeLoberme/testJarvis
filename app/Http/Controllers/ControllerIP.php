<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Jarvis\Http\Controllers\ControllerUser_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Jarvis\User;
use Jarvis\IP;
use Jarvis\List_Status_IP;
use Jarvis\Record_ip;
use Jarvis\Equipment;
use Jarvis\Client;
use Jarvis\Ring;
use Jarvis\Service;
use Jarvis\Use_Vlan;
use Jarvis\Branch;
use Jarvis\Node;
use Carbon\Carbon;
use Exception;
use Error;
use GuzzleHttp\Exception\RequestException;
use Session;
use Illuminate\Support\Facades\DB;

class ControllerIP extends Controller
{
    Public static function ipv4_ini_fin($net) {
    	$separar = explode('/', $net);
	    $start = strtok($net,"/");
	    $n = 3 - substr_count($net, ".");
	    if ($n > 0)
	    {
	        for ($i = $n;$i > 0; $i--)
	            $start .= ".0";
	    }
	    $bits1 = str_pad(decbin(ip2long($start)), 32, "0", STR_PAD_LEFT);
	    $numeros = substr($bits1, 0,$separar[1]);
	    $bit = 32 - $separar[1];
	    $comple_in = '';
	    $comple_fin = '';
	    for ($i=0; $i < $bit; $i++) { 
	    	$comple_in = '0'.$comple_in;
	    	$comple_fin = $comple_fin.'1';
	    }
	    $ip = $numeros.$comple_in;
	    $ip_fin = $numeros.$comple_fin;
	    $ip_listo = array(
	    	'inicio' => long2ip(bindec($ip)), 
	    	'fin' => long2ip(bindec($ip_fin)), 
	    );
    	return $ip_listo;
	}

	Public static function rango($range){            
        $parts = explode('/',$range);
        $exponent = 32-$parts[1];
        $count = pow(2,$exponent);
        $start = ip2long($parts[0]);
        $end = $start+$count;
        $prueba = array_map('long2ip', range($start+1, $end-2) );
        return $prueba;
	}

	Public function ver_rengo(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(16);
		if ($autori_status['permi'] >= 3){
			$id = $_POST['id'];
			$relation = DB::table('branch')->where('branch.id', '=', $id)
				->select('branch.ip_rank', 'branch.prefixes_rank','branch.name')->get();
			$ip_base = $relation[0]->ip_rank.'/'.$relation[0]->prefixes_rank;
			$ran_ip = ControllerIP::rango($ip_base);
			$ini_fin_ip = ControllerIP::ipv4_ini_fin($ip_base);
			$all[] = $ini_fin_ip['inicio'];
			$all = array_merge($all, $ran_ip);
			$all[] = $ini_fin_ip['fin'];
			$extra = DB::table('ip')
				->Join('list_status_ip', 'list_status_ip.id', '=', 'ip.id_status')
				->leftJoin('equipment', 'equipment.id', '=', 'ip.id_equipment')
				->leftJoin('client', 'client.id', '=', 'ip.id_client')
				->leftJoin('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
				->leftJoin('ring', 'ring.id', '=', 'use_vlan.id_ring')
				->leftJoin('node', 'node.id', '=', 'use_vlan.id_node')
				->leftJoin('service', 'service.id', '=', 'ip.id_service')
				->leftJoin('equipment equi', 'equi.id', '=', 'ip.id_equipment_wan')
				->where('ip.id_branch', '=', $id)
				->select('list_status_ip.name as status_name', 'list_status_ip.id as id_status', 'ip.id', 'ip.prefixes', 'ip.ip', 'equipment.acronimo as equipment', 'client.business_name as client', 'ip.type', 'ip.id_use_vlan', 'ring.name as anillo', 'use_vlan.vlan', 'service.number','ip.assignment', 'equi.acronimo as wan', 'node.cell_id')->get()->toArray();
			foreach ($all as $valores) {
				$info_ip = array_search($valores, array_column($extra, 'ip'));
				if ($info_ip === false) {
					$status = 'SIN ASIGNAR';
					$status_id = '0';
					$atributo = '';
					$subnet = '';
					$id_rango = 0;
					$type ='DISPONIBLE';
				}else{
					$wan = '';
					$name_equipment = '';
					$name_anillo = '';
					$name_client = '';
					$name_service = '';
					$assignment = '';
					$name_nodo = '';
						if ($extra[$info_ip]->anillo != null) {
							$name_anillo = 'Anillo: '.$extra[$info_ip]->anillo. ' Vlan:'.$extra[$info_ip]->vlan;
						}
						if ($extra[$info_ip]->cell_id != null) {
							$name_nodo = 'Sitio: '.$extra[$info_ip]->cell_id. ' Vlan:'.$extra[$info_ip]->vlan;
						}
						if ($extra[$info_ip]->wan != null) {
							$wan = ' Equipo: '.$extra[$info_ip]->wan;
						}
						if ($extra[$info_ip]->equipment != null) {
							$name_equipment = ' Equipo: '.$extra[$info_ip]->equipment;
						}
						if ($extra[$info_ip]->client != null) {
							$name_client = ' Cliente: '.$extra[$info_ip]->client;
						}
						if ($extra[$info_ip]->number != null) {
							$name_service = ' Servicio: '.$extra[$info_ip]->number;
						}
						if ($extra[$info_ip]->assignment != null) {
							$assignment = ' Asignación: '.$extra[$info_ip]->assignment;
						}
						$status = $extra[$info_ip]->status_name;
						$status_id = $extra[$info_ip]->id_status;
						$type = $extra[$info_ip]->type;
						$atributo= $name_nodo.$name_anillo.$wan.$name_equipment.$name_service.$name_client.$assignment;
						if ($extra[$info_ip]->prefixes != null) {
							$subnet = $extra[$info_ip]->prefixes;
						}else{
							$subnet = '';
						}
						$id_rango = $extra[$info_ip]->id;
				}
				$info_red = ControllerIP::info_ip_red($valores, $id, $type, $subnet);
				$data[] = array(
						'status' => $status, 
						'status_id' => $status_id,
						'ip' => $valores, 
						'atributo' => $atributo, 
						'subnet' => $subnet, 
						'id_rango' => $id_rango,
						'type' => $type,
						'info_red' => $info_red,
					);
			}
			$permiso = ControllerIP::validar_permiso_rama($id);
			$datos = array(
				'resul' => 'yes', 
				'datas' => $data, 
				'inicio' => $ini_fin_ip['inicio'], 
				'fin' => $ini_fin_ip['fin'], 
				'barra' => $relation[0]->prefixes_rank,
				'nombre' => $relation[0]->name, 
				'permiso' => $permiso, 
			);
			return $datos;
		}else{
      		return array('resul' => 'autori', );
      	}
	}

	public function info_ip_red($ip, $branch, $type, $subnet){
		$resul = 'SI';
		if ($type == 'RED') {
			$rango = ControllerIP::rango($ip.'/'.$subnet);
			$info = DB::table('ip')->where('id_branch', '=', $branch)->whereIn('ip', $rango)
				->where('id_status', '!=', 1)->select('id')->get();
			if (count($info) >0) {
				$resul = 'NO';
			}
		}
		return $resul;
	}

	Public function info_ip($id, $ip){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(16);
		if ($autori_status['permi'] >= 3){
			$extra = DB::table('ip')
			->Join('list_status_ip', 'list_status_ip.id', '=', 'ip.id_status')
			->leftJoin('equipment', 'equipment.id', '=', 'ip.id_equipment')
			->leftJoin('client', 'client.id', '=', 'ip.id_client')
			->leftJoin('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
			->leftJoin('ring', 'ring.id', '=', 'use_vlan.id_ring')
			->leftJoin('service', 'service.id', '=', 'ip.id_service')
			->where('ip.id_branch', '=', $id)
			->where('ip.ip', '=', $ip)
			->select('list_status_ip.name as status_name', 'list_status_ip.id as id_status', 'ip.id', 'ip.prefixes', 'equipment.acronimo as equipment', 'client.business_name as client', 'ip.type', 'ip.id_use_vlan', 'ring.name as anillo', 'use_vlan.vlan', 'service.number', 'ip.assignment')->get();
			if (count($extra)>0) {
				$resul = $extra[0];
			}else{
				$resul = 'No';
			}
			return $resul;
		}else{
      		return array('resul' => 'autori', );
      	}
	}

	Public function mostar_subred_eliminar(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id=$_POST['id'];
		$permiso = ControllerIP::permissions_branch($id);
		$data = [];
		if ($permiso >= 5){
			$rango_ip = DB::table('ip')
				->select('ip.ip','ip.prefixes','ip.id_status', 'ip.id')
				->where('ip.id_branch', '=', $id)
				->where('ip.type', '=', 'RED')
				->orderBy('ip', 'asc')->get();
			foreach ($rango_ip as $value) {
				$separar_ip = explode('.', $value->ip);
				$data[] = array(
					'ip' => $value->ip, 
					'prefixes' => $value->prefixes, 
					'id_status' => $value->id_status, 
					'id' => $value->id, 
					'ip_3' => $separar_ip['2'],
					'ip_4' => $separar_ip['3'],
				);
			}
			$rango_32 = DB::table('ip')
				->select('ip.ip','ip.prefixes','ip.id_status', 'ip.id')
				->where('ip.id_branch', '=', $id)
				->where('ip.prefixes', '=', '32')
				->orderBy('ip', 'asc')->get();
			foreach ($rango_32 as $valor) {
				$separar_ip = explode('.', $valor->ip);
				$data[] = array(
					'ip' => $valor->ip, 
					'prefixes' => $valor->prefixes, 
					'id_status' => $valor->id_status, 
					'id' => $valor->id, 
					'ip_all_full' => $ip_all_full,
					'ip_3' => $separar_ip['2'],
					'ip_4' => $separar_ip['3'], 
				);
			}
			if (count($data) > 0) {
				$ip_3  = array_column($data, 'ip_3');
				$ip_4  = array_column($data, 'ip_4');
				array_multisort($ip_3, SORT_ASC, $ip_4, SORT_ASC, $data);
				$datos = array('resul' => 'yes', 'datos' => $data,);
			}else{
				$datos = array('resul' => 'No', );
			}
			return $datos;
		}else{
      		return array('resul' => 'autori', );
      	}
	}

	Public function insert_update_sub_red(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id_red = $_POST['id_red'];
    	$permiso = ControllerIP::permissions_branch($id_red);
		if ($permiso >= 5){
			$ip = $_POST['ip'];
			$mask = $_POST['mask'];
			$ip_completa = $ip.'/'.$mask;
			$status = $_POST['status'];
			$respuesta = 'No';
			$red = DB::table('branch')->select('branch.ip_rank', 'branch.prefixes_rank')->where('branch.id', '=', $id_red)->get();
			$rango = ControllerIP::rango($red[0]->ip_rank.'/'.$red[0]->prefixes_rank);
			$ini_fin_red = ControllerIP::ipv4_ini_fin($red[0]->ip_rank.'/'.$red[0]->prefixes_rank);
			$ini_fin = ControllerIP::ipv4_ini_fin($ip_completa);
			if($ini_fin['inicio'] != $ip){
				return array('resul' => 'regla', );
			}
			if (in_array($ip, $rango) || $red[0]->ip_rank == $ip) {
				if ($mask == 32) {
					if ($ini_fin_red['inicio'] == $ip || $ini_fin_red['fin'] == $ip) {
						return array('resul' => 'regla', );
					}else{
						$rela_ip = DB::table('ip')
						->where('ip.id_branch', '=', $id_red)
						->where('ip.ip', '=', $ip)
						->where('ip.id_status', '!=', 4)
						->select('ip.id')->get();
						if (count($rela_ip) > 0 ) {
							$respuesta = 'Si';
						}else{
							$rango_insert[] = $ip;
						}
					}
				}else{
		            $rango_insert[] = $ini_fin['inicio'];
		            $rango_calculo = ControllerIP::rango($ip.'/'.$mask);
		            foreach ($rango_calculo as $key ) {
		            	 $rango_insert[] = $key;
		            }
		            $rango_insert[] = $ini_fin['fin'];
		            foreach ($rango_insert as $value) {
		            	$rela_ip = DB::table('ip')
						->where('ip.id_branch', '=', $id_red)
						->where('ip.ip', '=', $value)
						->where('ip.id_status', '!=', 4)
						->select('ip.id')->get();
						
						if (count($rela_ip) > 0 ) {
							$respuesta = 'Si';
						}
		            }
				}
	            if ($respuesta === 'No') {
	            	foreach ($rango_insert as $val) {
	            		$id_atributo = '0';
	            		$exis = DB::table('ip')
	            		->where('ip.id_branch', '=', $id_red)
						->where('ip.ip', '=', $val)
						->select('ip.id')->get();
						if (count($exis) > 0) {
							$ip_new = IP::find($exis[0]->id);
						}else{
							$ip_new = new IP();
							$ip_new->id_branch = $id_red;
							$ip_new->ip = $val;
						}
						$ip_new->prefixes = $mask;
						if ($val == $ini_fin_red['fin']) {
							$ip_new->id_status = 4;
						}else{
							if ($mask != 32) {
								switch ($val) {
								    case $rango_insert[0]:
								        $ip_new->type = 'RED';
								    break;
								    case $rango_insert[1]:
								        $ip_new->type = 'GATEWAY';
								    break;
								    case $ini_fin['fin']:
								        $ip_new->type = 'BROADCAST';
								    break;
								    default:
								       $ip_new->type = 'DISPONIBLE';
								    break;
								}
							}else{
								$ip_new->type = 'DISPONIBLE';
							}
						}
							$ip_new->id_status = $status;
		                $ip_new->save();
	                }
	                return array('resul' => 'yes', );
	            }else{
	            	return array('resul' => 'mal_rango', );
	            }        
	        }else{
	            return array('resul' => 'incorrecto', );
	        }
	    }else{
      		return array('resul' => 'autori', );
    	}    
	}

	Public function subred_eliminar(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id=$_POST['id'];
		$rango_red = DB::table('ip')->select('ip.id_branch','ip.ip','ip.prefixes','ip.id_status')
			->where('ip.id', '=', $id)->orderBy('ip', 'desc')->get();
		if (count($rango_red) > 0) {
	    	$permiso = ControllerIP::permissions_branch($rango_red[0]->id_branch);
			if ($permiso >= 5){
				$respuesta = 'Si';
				$ini_fin_ip = ControllerIP::ipv4_ini_fin($rango_red[0]->ip .'/'.$rango_red[0]->prefixes);
				if ($rango_red[0]->prefixes == 32) {
					$data_general[] = array(
							'ip' => $rango_red[0]->ip, 
							'prefixes' => $rango_red[0]->prefixes, 
							'status' => $rango_red[0]->id_status, 
							'id' => $id,  
						);
				}else{
					$all[] = $ini_fin_ip['inicio'];
					$ran_ip = ControllerIP::rango($rango_red[0]->ip .'/'.$rango_red[0]->prefixes);
					foreach ($ran_ip as $value) {
						$all[] = $value;
					}
					$all[] = $ini_fin_ip['fin'];
					foreach ($all as $key) {
						$rango_ip = DB::table('ip')
							->where('ip.id_branch', '=', $rango_red[0]->id_branch)
							->where('ip.ip', '=', $key)
							->select('ip.ip','ip.prefixes','ip.id_status', 'ip.id')->get();
						$data_general[] = array(
							'ip' => $rango_ip[0]->ip, 
							'prefixes' => $rango_ip[0]->prefixes, 
							'status' => $rango_ip[0]->id_status, 
							'id' => $rango_ip[0]->id,  
						);
					}
				}
				foreach ($data_general as $val) {
					if ($val['status'] != 1 && $val['ip'] != $ini_fin_ip['fin'] && $val['ip'] != $ini_fin_ip['inicio'] && $val['ip'] != $ran_ip[0]){
						$respuesta = 'No';
					}		
				}
				if($respuesta == 'No'){
					$datos = array('resul' => 'relation', );
				}else{
					foreach ($data_general as $eli){
						$ip = IP::find($eli['id']);
							$mask_old = $ip->prefixes;
							$ip->prefixes = null;
							$ip->id_status = 4;
							$ip->prefixes = null;
							$ip->type = 'SIN ASIGNAR';
							$ip->id_equipment = null;
							$ip->id_client = null;
							$ip->id_service = null;
						$ip->save();
						$recor_ip = new Record_ip();
					    	$recor_ip->id_ip = $eli['id'];
					    	$recor_ip->prefixes = $mask_old;
					    	$recor_ip->attribute = 'Se libero la ip';
					    	$recor_ip->id_user= Auth::user()->id;
					    $recor_ip->save();
					}
					$datos = array('resul' => 'yes');
				}				
			}else{
				$datos = array('resul' => 'autori', );
			}
			return $datos;
		}else{
      		return array('resul' => 'No', );
      	}
	}

	Public function ip_extracion(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(16);
		if ($autori_status['permi'] >= 3){
			$id=$_POST['id'];
			$ip = IP::find($id);
			if ($ip != null) {
				$datos = array('resul' => 'yes', 'ip' => $ip->ip, 'barra' => $ip->prefixes, 'branch_id' => $ip->id_branch);
			}else{
				$datos = array('resul' => 'exis', );
			}
			return $datos;
		}else{
      		return array('resul' => 'autori', );
      	}
	}

	Public function detalle_ip(){
		$id = $_POST['id'];
		$ip = DB::table('ip')
			->Join('record_ip', 'ip.id', '=', 'record_ip.id_ip')
			->Join('users', 'users.id', '=', 'record_ip.id_user')
			->where('ip.id', '=', $id)
			->select('ip.ip', 'record_ip.prefixes','record_ip.attribute', 'record_ip.id', 'users.name', 'users.last_name', 'record_ip.created_at as fecha')->orderBy('record_ip.created_at', 'Desc')->get();
			$data = array('resul' => 'yes', 'datos' => $ip,);
		return $data;
	}

	Public function buscar_ip_admin_lanswitch(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$ip_new = [];
		$ip = DB::table('ip')
			->Join('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
			->Join('list_use_vlan', 'list_use_vlan.id', '=', 'use_vlan.id_list_use_vlan')
			->Join('ring', 'ring.id', '=', 'use_vlan.id_ring')
			->leftJoin('equipment', 'equipment.id', '=', 'ip.id_equipment')
			->where('ring.id', '=', $id)
			->where('list_use_vlan.id', '=', 1)
			->select('ip.id', 'ip.ip', 'ip.prefixes','ip.type', 'list_use_vlan.name as uso', 'use_vlan.vlan', 'ring.name', 'ip.id_status', 'equipment.acronimo', 'ring.name')->orderBy('id', 'asc')->orderBy('ip', 'asc')->get();
		$agg = DB::table('ring')
			->Join('port', 'port.id_ring', '=', 'ring.id')
			->join('board', 'port.id_board', '=', 'board.id')
			->join('equipment', 'board.id_equipment', '=', 'equipment.id')
			->where('ring.id', '=', $id)
			->where('equipment.id_function', '=', 1)
			->select('equipment.acronimo', 'ring.name')
			->groupBy('equipment.acronimo', 'ring.name')->get();

		$lsw = DB::table('ring')
			->Join('port', 'port.id_ring', '=', 'ring.id')
			->join('board', 'port.id_board', '=', 'board.id')
			->join('equipment', 'board.id_equipment', '=', 'equipment.id')
			->where('ring.id', '=', $id)
			->where('equipment.id_function', '=', 4)
			->where('equipment.client_management', '=', 'No')
			->select('equipment.acronimo', 'ring.name')
			->groupBy('equipment.acronimo', 'ring.name')->get();

		foreach ($ip as $value) {
			if ($value->acronimo == null) {
				switch ($value->type) {
					case 'RED':
						$equipment = (count($agg) > 0) ? $agg[0]->name : $lsw[0]->name;
					break;
					case 'GATEWAY':
						$equipment = (count($agg) > 0) ? $agg[0]->name : $lsw[0]->name;
					break;
					default:
						$equipment = '';
					break;
				}
			}else{
				$equipment = $value->acronimo;
			}
			$ip_new[] = array(
				'id' => $value->id, 
				'ip' => $value->ip.'/'.$value->prefixes, 
				'ip_api_status' => '',
				'type' => $value->type, 
				'uso' => $value->uso, 
				'vlan' => $value->vlan, 
				'name' => $value->name, 
				'id_status' => $value->id_status, 
				'acronimo' => $equipment, 
			);
		}
		return array('resul' => 'yes', 'datos' => $ip_new,);
	}

	Public function _admin_lanswitch(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$ip_new = [];
		$ring = DB::table('ring')
			->Join('port', 'port.id_ring', '=', 'ring.id')
			->join('board', 'port.id_board', '=', 'board.id')
			->where('board.id_equipment', '=', $id)
			->select('ring.id')->groupBy('ring.id')->get();
		if (count($ring) > 0) {
			$ip = DB::table('ip')
				->Join('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
				->Join('list_use_vlan', 'list_use_vlan.id', '=', 'use_vlan.id_list_use_vlan')
				->Join('ring', 'ring.id', '=', 'use_vlan.id_ring')
				->join('port', 'port.id_ring', '=', 'ring.id')
				->join('board', 'port.id_board', '=', 'board.id')
				->leftJoin('equipment', 'ip.id_equipment_wan', '=', 'equipment.id')
				->where('ring.id', '=', $ring[0]->id)
				->where('list_use_vlan.id', '=', 3)
				->select('ip.id', 'ip.ip', 'ip.prefixes','ip.type', 'list_use_vlan.name as uso', 'use_vlan.vlan', 'ring.name', 'ip.id_status', 'equipment.acronimo', 'ring.id as id_ring')
				->groupBy('ip.id', 'ip.ip', 'ip.prefixes','ip.type', 'list_use_vlan.name', 'use_vlan.vlan', 'ring.name', 'ip.id_status', 'equipment.acronimo', 'ring.id')
				->orderBy('id', 'asc')->orderBy('ip', 'asc')->get();
			foreach ($ip as $value) {
				$equipment = '';
				if ($value->acronimo != null) {
					$equipment = $value->acronimo;
				}
				$ip_new[] = array(
					'id' => $value->id, 
					'ip' => $value->ip.'/'.$value->prefixes, 
					'type' => $value->type, 
					'uso' => $value->uso, 
					'vlan' => $value->vlan, 
					'name' => $value->name, 
					'id_status' => $value->id_status, 
					'acronimo' => $equipment, 
				);
			}
			return array('resul' => 'yes', 'datos' => $ip_new,);
		}else{
			$resul = 'nop';
		}
	}

	Public function buscar_ip_wan_admin_cpe(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$ip_new = [];
		$ip = DB::table('ip')
			->Join('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
			->Join('list_use_vlan', 'list_use_vlan.id', '=', 'use_vlan.id_list_use_vlan')
			->Join('ring', 'ring.id', '=', 'use_vlan.id_ring')
			->leftJoin('equipment', 'equipment.id', '=', 'ip.id_equipment')
			->where('ring.id', '=', $id)
			->where('list_use_vlan.id', '=', 3)
			->select('ip.id', 'ip.ip', 'ip.prefixes','ip.type', 'list_use_vlan.name as uso', 'use_vlan.vlan', 'ring.name', 'ip.id_status', 'equipment.acronimo')->orderBy('id', 'asc')->orderBy('ip', 'asc')->get();
		$agg = DB::table('ring')
			->Join('port', 'port.id_ring', '=', 'ring.id')
			->join('board', 'port.id_board', '=', 'board.id')
			->join('equipment', 'board.id_equipment', '=', 'equipment.id')
			->where('ring.id', '=', $id)
			->where('equipment.id_function', '=', 1)
			->select('equipment.acronimo', 'ring.name')
			->groupBy('equipment.acronimo', 'ring.name')->get();
		foreach ($ip as $value) {
			if ($value->acronimo == null) {
				switch ($value->type) {
					case 'RED':
						$equipment = $agg[0]->name;
					break;
					case 'GATEWAY':
						$equipment = $agg[0]->acronimo;
					break;
					default:
						$equipment = '';
					break;
				}
			}else{
				$equipment = $value->acronimo;
			}
			$ip_new[] = array(
				'id' => $value->id, 
				'ip' => $value->ip.'/'.$value->prefixes, 
				'type' => $value->type, 
				'uso' => $value->uso, 
				'vlan' => $value->vlan, 
				'name' => $value->name, 
				'id_status' => $value->id_status, 
				'acronimo' => $equipment, 
			);
		}
		return array('resul' => 'yes', 'datos' => $ip_new,);
	}

	Public function libera_ip(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$atributo = $_POST['atributo'];
		$permiso = ControllerIP::validar_permiso($id[0]);
		if ($permiso >= 5) {
			foreach ($id as $value) {
				$sql_vali = IP::find($value);
				$ip = IP::find($value);
				switch ($atributo) {
					case '1':
						$ip->id_equipment = null;
						$ip->id_equipment_wan = null;
						if ($sql_vali->id_client == null && $sql_vali->id_service == null && $sql_vali->assignment == null) {
							$ip->id_status = 1;
						}
						$msj_sql = DB::table('equipment')->select('id','acronimo')
							->where('id', '=', $sql_vali->id_equipment)
							->orwhere('id', '=', $sql_vali->id_equipment_wan)->get();
						$msj = 'El equipo '.$msj_sql[0]->acronimo.' libero la ip';
					break;
					case '2':
						$ip->id_client = null;
						if ($sql_vali->id_equipment == null && $sql_vali->id_service == null && $sql_vali->assignment == null) {
							$ip->id_status = 1;
						}
						$msj_sql = Client::find($sql_vali->id_client);
						$msj = 'El cliente '.$msj_sql->business_name.' libero la ip';
					break;
					case '3':
						$ip->id_service = null;
						if ($sql_vali->id_equipment == null && $sql_vali->id_client == null && $sql_vali->assignment == null) {
							$ip->id_status = 1;
						}
						$msj_sql = Service::find($sql_vali->id_service);
						$msj = 'El servicio '.$msj_sql->number.' libero la ip';
					break;
					case '4':
						$ip->assignment = null;
						if ($sql_vali->id_equipment == null && $sql_vali->id_client == null && $sql_vali->id_service == null) {
							$ip->id_status = 1;
						}
						$msj = 'La asignación '.$sql_vali->assignment.' libero la ip';
					break;
					case '5':
						$ip->id_status = 1;
						$ip->id_equipment = null;
						$ip->id_client = null;
						$ip->id_service = null;
						$ip->assignment = null;
						$ip->id_equipment_wan = null;
						$msj = 'Se libero la ip';
					break;
				}
				$ip->save();
				$recor_ip = new Record_ip();
				   	$recor_ip->id_ip = $value;
				   	$recor_ip->prefixes = $ip->prefixes;
				   	$recor_ip->attribute = $msj;
				   	$recor_ip->id_user = Auth::user()->id;
				$recor_ip->save();
			}
			return array('resul' => 'yes', 'datos' => $sql_vali->id_branch,);
		}else{
			return array('resul' => 'autori', );
		}
	}

	Public function asignar_ip(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$opcion = $_POST['type'];
		$atributo = $_POST['atributo'];
		$type_ip = $_POST['type_ip'];
		$permiso = ControllerIP::validar_permiso($id);
		if ($permiso >= 5) {
			$id_ip_old = ''; 
			$branch = 0; 
			switch ($opcion) {
				case '1':
					$sql = Equipment::find($atributo);
					$ip = IP::find($id);
						$ip->id_status = 2;
						if ($type_ip == 'WAN') {
							$ip->id_equipment_wan = $sql->id;
						}else{
							$ip->id_equipment = $sql->id;
						}
					$ip->save();
					$barra = $ip->prefixes;
					$msj = ' al equipo: '.$sql->acronimo;
				break;
				case '2':
					$sql = Client::find($atributo);
					$ip = IP::find($id);
						$ip->id_status = 2;
						$ip->id_client = $sql->id;
					$ip->save();
					$barra = $ip->prefixes;
					$msj = ' al Cliente: '.$sql->business_name;
				break;
				case '3':
					$sql = Service::find($atributo);
					$ip = IP::find($id);
						$ip->id_status = 2;
						$ip->id_service = $sql->id;
					$ip->save();
					$barra = $ip->prefixes;
					$msj = ' al Servicio: '.$sql->number;
				break;
				case '4':
					$ip = IP::find($id);
						$ip->id_status = 2;
						$ip->assignment = $atributo;
					$ip->save();
					$barra = $ip->prefixes;
					$msj = ': '.$atributo;
				break;
			}
				$recor_ip = new Record_ip();
				   $recor_ip->id_ip = $id;
				   $recor_ip->prefixes = $barra;
				   $recor_ip->attribute = 'Se asigno la ip'.$msj;
				   $recor_ip->id_user= Auth::user()->id;
				$recor_ip->save();
				$id_ip = DB::table('ip')->where('ip.id', '=', $id)
					->select('ip.id_branch')->get();
				$branch = $id_ip[0]->id_branch;
			return array('resul' => 'yes', 'datos' => $branch,);
		}else{
			return array('resul' => 'autori', );
		}
	}

	Public static function validar_permiso($ip){
		$group = 0;
		$user = 0;
		$permi_group = DB::table('ip')
			->Join('branch', 'branch.id', '=', 'ip.id_branch')
			->Join('permissions_ip', 'branch.id', '=', 'permissions_ip.id_branch')
			->Join('group_ip', 'group_ip.id', '=', 'permissions_ip.id_group_ip')
			->Join('group_users', 'group_ip.id', '=', 'group_users.id_group_ip')
			->where('group_users.id_user', '=', Auth::user()->id)
			->where('ip.id', '=', $ip)
			->select('permissions_ip.permissions')->get();
		if (count($permi_group) > 0) {
			$group = $permi_group[0]->permissions;
		}
		$permi_user = DB::table('ip')
			->Join('branch', 'branch.id', '=', 'ip.id_branch')
			->Join('permissions_ip', 'branch.id', '=', 'permissions_ip.id_branch')
			->where('permissions_ip.id_user', '=', Auth::user()->id)
			->where('ip.id', '=', $ip)
			->select('permissions_ip.permissions')->get();
		if (count($permi_user) > 0) {
			$user = $permi_user[0]->permissions;
		}
		if ($group > $user) {
			$permi = $group;
		}else{
			$permi = $user;
		}
		return $permi;
	}

	Public function asignar_ip_grupo(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$opcion = $_POST['type'];
		$atributo = $_POST['atributo'];
		$permiso = ControllerIP::validar_permiso($id[0]);
		if ($permiso >= 5) {
			switch ($opcion) {
				case '1':
					$sql = Equipment::find($atributo);
					foreach ($id as $valor) {
						$ip = IP::find($valor);
							$ip->id_status = 2;
							$ip->id_equipment = $sql->id;
						$ip->save();
						$msj = 'Se asigno la ip al equipo: '.$sql->acronimo;
						ControllerIP::Record_ip_all($valor, $ip->prefixes, $msj);
					}
				break;
				case '2':
					$sql = Client::find($atributo);
					foreach ($id as $valor) {
						$ip = IP::find($valor);
							$ip->id_status = 2;
							$ip->id_client = $sql->id;
						$ip->save();
						$msj = 'Se asigno la ip al Cliente: '.$sql->business_name;
						ControllerIP::Record_ip_all($valor, $ip->prefixes, $msj);
					}
				break;
				case '3':
					$sql = Service::find($atributo);
					foreach ($id as $valor) {
						$ip = IP::find($valor);
							$ip->id_status = 2;
							$ip->id_service = $sql->id;
							$ip->assignment = null;
						$ip->save();
						$msj = 'La ip fue asignada al servicio '.$sql->number;
						ControllerIP::Record_ip_all($valor, $ip->prefixes, $msj);
					}
				case '4':
					foreach ($id as $valor) {
						$ip = IP::find($valor);
							$ip->id_status = 2;
							$ip->assignment = $atributo;
						$ip->save();
						$msj = 'Se asigno la ip: '.$atributo;
						ControllerIP::Record_ip_all($valor, $ip->prefixes, $msj);
					}
				break;
			}
			return array('resul' => 'yes', 'datos' => $ip->id_branch,);
		}else{
			return array('resul' => 'autori', );
		}
	}

	Public function Record_ip_all($ip, $barra, $msj){
		$recor_ip = new Record_ip();
			$recor_ip->id_ip = $ip;
			$recor_ip->prefixes = $barra;
			$recor_ip->attribute = $msj;
			$recor_ip->id_user = Auth::user()->id;
		$recor_ip->save();
	}

	Public function status_ip(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$status = $_POST['status'];
		$permiso = ControllerIP::validar_permiso($id);
		if ($permiso >= 5) {
				$ip = IP::find($id);
				if ($ip->id_status != 2) {
					$ip->id_status = $status;
					$ip->save();
					$status_ip_sql = List_Status_IP::find($status);
					$recor_ip = new Record_ip();
					   	$recor_ip->id_ip = $id;
					   	$recor_ip->prefixes = $ip->prefixes;
					   	$recor_ip->attribute = 'Se cambio el estado de la ip a '.$status_ip_sql->name;
					   	$recor_ip->id_user = Auth::user()->id;
					$recor_ip->save();
					$resul = 'yes';
				}else{
					$resul = 'nop';
				}
			$id_ip = DB::table('ip')->where('ip.id', '=', $id[0])
			->select('ip.id_branch')->get();
			return array('resul' => $resul, 'datos' => $id_ip[0]->id_branch,);
		}else{
			return array('resul' => 'autori', );
		}
	}

	// Public function search_attribute(){
	// 	if (!Auth::guest() == false){ return array('resul' => 'login', );}
	// 	$attribute = $_POST['attribute'];
	// 	$datos = [];
	// 	if ($attribute != 4) {
	//         switch ($attribute) {
	//         	case '1':
	//         		$datos = DB::table('equipment')
	// 				->join('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
	// 				->leftJoin('address', 'equipment.address', '=', 'address.id')
	// 				->leftJoin('list_countries', 'address.id_countries', '=', 'list_countries.id')
	// 				->leftJoin('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
	// 				->join('function_equipment_model', 'equipment.id_function', '=', 'function_equipment_model.id')
	// 				->Join('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
	// 		        ->Join('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
	// 		        ->leftJoin('client', 'client.id', '=', 'equipment.id_client')
	// 		        ->leftJoin('node', 'node.id', '=', 'equipment.id_node')
	// 		        ->leftJoin('ip', 'equipment.id', '=', 'ip.id_equipment')
	// 				->where('equipment.status', '!=', 'BAJA')
	// 		        ->select('equipment.id', 'list_mark.name as mark', 'list_equipment.name as equipment', 'equipment_model.model', 'equipment.status', 'equipment.commentary', 'function_equipment_model.name as function', 'equipment.address', 'node.node', 'node.cell_id', 'client.business_name as client', 'equipment.acronimo', 'ip.ip as admin', 'equipment.ip_wan_rpv as ip_equipment', 'equipment_model.bw_max_hw', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code', 'list_countries.name as countries', 'list_provinces.name as provinces')->orderBy('model', 'asc')->get();
	//         	break;
	//         	case '2':
	//         		$datos = DB::table('client')->select('*')->get();
	//         	break;
	//         	case '3':
	//         		$datos = DB::table('service')
	// 				->leftJoin('list_service_type', 'service.id_type', '=', 'list_service_type.id')
	// 				->leftJoin('client', 'client.id', '=', 'service.id_client')
	// 				->select('client.business_name', 'list_service_type.name', 'service.number', 'service.bw_service', 'service.order_high', 'service.order_down', 'service.created_at', 'service.id', 'list_service_type.require_ip', 'service.status')->orderBy('service.created_at', 'desc')->get();
	//         	break;
	//         }
 //        }
 //        return array('resul' => 'yes', 'datos' => $datos,);
	// }

	Public static function validar_permiso_rama($rama){
		$group = 0;
		$user = 0;
		$permi_group = DB::table('ip')
			->Join('branch', 'branch.id', '=', 'ip.id_branch')
			->Join('permissions_ip', 'branch.id', '=', 'permissions_ip.id_branch')
			->Join('group_ip', 'group_ip.id', '=', 'permissions_ip.id_group_ip')
			->Join('group_users', 'group_ip.id', '=', 'group_users.id_group_ip')
			->where('group_users.id_user', '=', Auth::user()->id)
			->where('branch.id', '=', $rama)
			->select('permissions_ip.permissions')->get();
		if (count($permi_group) > 0) {
			$group = $permi_group[0]->permissions;
		}
		$permi_user = DB::table('ip')
			->Join('branch', 'branch.id', '=', 'ip.id_branch')
			->Join('permissions_ip', 'branch.id', '=', 'permissions_ip.id_branch')
			->where('permissions_ip.id_user', '=', Auth::user()->id)
			->where('branch.id', '=', $rama)
			->select('permissions_ip.permissions')->get();
		if (count($permi_user) > 0) {
			$user = $permi_user[0]->permissions;
		}
		if ($group > $user) {
			$permi = $group;
		}else{
			$permi = $user;
		}
		return $permi;
	}

	function ip_wan_equipment(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$ip = [];
		$info_ip = DB::table('ip')
			->where('id_equipment_wan','=', $id)
			->select('id', 'ip', 'prefixes')->get();
		if (count($info_ip)>0) {
			$ip = $info_ip[0];
		}
		$equi = Equipment::find($id, ['ip_wan_rpv']);
		return array('resul' => 'yes', 'datos' => $ip, 'equi_ip' => $equi,);
	}

	Public static function permissions_branch($id){
		$permiso_individual = 0;
		$permiso_grupal = 0;
    	$validar_group = DB::table('permissions_ip')
    		->Join('group_ip', 'group_ip.id', '=', 'permissions_ip.id_group_ip')
    		->Join('group_users', 'group_ip.id', '=', 'group_users.id_group_ip')
    		->where('permissions_ip.id_branch', '=', $id)
    		->where('group_users.id_user', '=', Auth::user()->id)
    		->select('permissions_ip.permissions')->get();
    	$validar_permiso = DB::table('permissions_ip')
    		->where('permissions_ip.id_branch', '=', $id)
    		->where('permissions_ip.id_user', '=', Auth::user()->id)
    		->select('permissions_ip.permissions')->get();
    	if (count($validar_group) > 0) {
    		$permiso_grupal = $validar_group[0]->permissions;
    	}
    	if (count($validar_permiso) > 0) {
    		$permiso_individual = $validar_permiso[0]->permissions;
    	}
    	if ($permiso_individual > $permiso_grupal) {
    		$permiso = $permiso_individual;
    	}else{
    		$permiso = $permiso_grupal;
    	}
    	return $permiso;
	}

	Public function all_subred(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$id = $_POST['id'];
    	$ip_rango_full = [];
    	$ip_vali_sql = [];
		$permiso = ControllerIP::permissions_branch($id);
		if ($permiso >= 5){
    		$mask = $_POST['mask'];
    		$branch = Branch::find($id);
    		$ip = $branch->ip_rank;
    		$prefixes = $branch->prefixes_rank;
    		$ip_base = $ip.'/'.$mask;
    		$ini_fin = ControllerIP::ipv4_ini_fin($ip_base);
    		$separa = explode('.', $ini_fin['fin']);
    		$fin_ip = $separa['3'];
    		$ip_data = [];
    		$ip_data[] = array(
					'id' => $id, 
					'mask' => $mask, 
					'red' => $ini_fin['inicio'], 
					'fin' => $ini_fin['fin'], 
				);
			while ($fin_ip <= 254) {
	    		$ip_bin = ip2long ($ini_fin['fin']);
	    		$ip_bin = $ip_bin + 1;
	    		$ip_full = long2ip($ip_bin);
	    		$ip_base = $ip_full.'/'.$mask;
    			$ini_fin = ControllerIP::ipv4_ini_fin($ip_base);
    			$separa = explode('.', $ini_fin['fin']);
    			$fin_ip = $separa['3'];
				$ip_data[] = array(
					'id' => $id, 
					'mask' => $mask, 
					'red' => $ini_fin['inicio'], 
					'fin' => $ini_fin['fin'], 
				);
    		}
    		foreach ($ip_data as $value) {
    			unset($ip_vali_sql);
    			unset($ip_rango_full);
				if ($mask != 32) {
					$type = 'RED';
				}else{
					$type = 'DISPONIBLE';
				}
				$ip_rango_full[] = array('ip' => $value['red'], 'type' => $type,);
				$ip_vali_sql[] = array($value['red']);
				if ($mask != 32) {
					$rango = ControllerIP::rango( $value['red'].'/'.$mask);
					foreach ($rango as $val) {
						$type = 'DISPONIBLE';
						if ($rango[0] == $val) {
							$type = 'GATEWAY';
						}
						$ip_vali_sql[] = array($val);
						$ip_rango_full[] = array('ip' => $val,'type' => $type,);
					}
					$ip_vali_sql[] = array($value['fin']);
					$ip_rango_full[] = array('ip' => $value['fin'], 'type' => 'BROADCAST',);
				}
				$ip_validar_fin = DB::table('ip')
					->where('id_branch','=', $id)
					->where('id_status','!=', 4)
					->whereIn('ip', $ip_vali_sql)
					->select('id')->get();
				if (count($ip_validar_fin) == 0) {
					foreach ($ip_rango_full as $valor) {
						$exis = DB::table('ip')
					        ->where('ip.id_branch', '=', $id)
							->where('ip.ip', '=', $valor['ip'])
							->select('ip.id')->get();
						if (count($exis) > 0) {
							$ip_new = IP::find($exis[0]->id);
						}else{
							$ip_new = new IP();
							$ip_new->id_branch = $id;
							$ip_new->ip = $valor['ip'];
						}
							$ip_new->prefixes = $mask;
							$ip_new->type = $valor['type'];
							$ip_new->id_status = 1;
						$ip_new->save();
					}
				}
    		}
    		return array('resul' => 'yes',);
		}else{
      		return array('resul' => 'autori',);
      	}
	}

	Public function buscar_ip_wan_lanswitch(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id = $_POST['id'];
		$ip_new = [];
		$id_rign = 0;
		$id_node = 0;
		$info_equip = Equipment::find($id, ['type','id_node']);
		if ($info_equip->type == 'Ipran') {
			if ($info_equip->id_node != null && $info_equip->id_node != '') {
				$id_node = $info_equip->id_node;
			}else{
				$info_nodo = DB::table('ring')->Join('port', 'ring.id', '=', 'port.id_ring')
					->Join('board', 'board.id', '=', 'port.id_board')
					->Join('port as por', 'por.id_ring', '=', 'port.id_ring')
					->Join('board as pla', 'pla.id', '=', 'por.id_board')
					->Join('equipment', 'pla.id_equipment', '=', 'equipment.id')
					->where('board.id_equipment', '=', $id)
					->where('equipment.type', '=', 'Ipran')
					->whereNotNull('equipment.id_node')
					->select('equipment.id_node')->get();
				if (count($info_nodo) > 0) {
					$id_node = $info_nodo[0]->id_node;
				}
			}
			$ip = DB::table('ip')
				->Join('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
				->Join('list_use_vlan', 'list_use_vlan.id', '=', 'use_vlan.id_list_use_vlan')
				->Join('node', 'node.id', '=', 'use_vlan.id_node')
				->leftJoin('equipment', 'ip.id_equipment_wan', '=', 'equipment.id')
				->where('node.id', '=', $id_node)
				->where('list_use_vlan.id', '=', 3)
				->select('ip.id', 'ip.ip', 'ip.prefixes','ip.type', 'list_use_vlan.name as uso', 'use_vlan.vlan', 'node.cell_id as name', 'node.node', 'ip.id_status', 'equipment.acronimo')->orderBy('id', 'asc')->groupBy('ip.id', 'ip.ip', 'ip.prefixes','ip.type', 'list_use_vlan.name', 'use_vlan.vlan', 'node.cell_id', 'ip.id_status', 'equipment.acronimo', 'node.node')->orderBy('ip', 'asc')->get();
				foreach ($ip as $value) {
					if ($value->acronimo == null) {
						switch ($value->type) {
							case 'RED':
								$equipment = $ip[0]->name.' '.$ip[0]->node;
							break;
							case 'BROADCAST':
								$equipment = 'BROADCAST';
							break;
							case 'GATEWAY':
								$equipment = 'GATEWAY';
							break;
							default:
								$equipment = '';
							break;
						}
					}else{
						$equipment = $value->acronimo;
					}
					$ip_new[] = array(
						'id' => $value->id, 
						'ip' => $value->ip.'/'.$value->prefixes, 
						'type' => $value->type, 
						'uso' => $value->uso, 
						'vlan' => $value->vlan, 
						'name' => $value->name, 
						'id_status' => $value->id_status, 
						'acronimo' => $equipment, 
					);
				}
			$resul = 'yes';
		}else{
			$ring = DB::table('ring')
				->Join('port', 'port.id_ring', '=', 'ring.id')
				->join('board', 'port.id_board', '=', 'board.id')
				->where('board.id_equipment', '=', $id)
				->select('ring.id')->groupBy('ring.id')->get();
			if (count($ring) > 0) {
				$ip = DB::table('ip')
					->Join('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
					->Join('list_use_vlan', 'list_use_vlan.id', '=', 'use_vlan.id_list_use_vlan')
					->Join('ring', 'ring.id', '=', 'use_vlan.id_ring')
					->Join('port', 'port.id_ring', '=', 'ring.id')
					->leftJoin('equipment', 'ip.id_equipment_wan', '=', 'equipment.id')
					->where('ring.id', '=', $ring[0]->id)
					->where('list_use_vlan.id', '=', 3)
					->select('ip.id', 'ip.ip', 'ip.prefixes','ip.type', 'list_use_vlan.name as uso', 'use_vlan.vlan', 'ring.name', 'ip.id_status', 'equipment.acronimo')->orderBy('id', 'asc')->groupBy('ip.id', 'ip.ip', 'ip.prefixes','ip.type', 'list_use_vlan.name', 'use_vlan.vlan', 'ring.name', 'ip.id_status', 'equipment.acronimo')->orderBy('ip', 'asc')->get();
				$id_rign = $ring[0]->id;
				foreach ($ip as $value) {
					if ($value->acronimo == null) {
						switch ($value->type) {
							case 'RED':
								$equipment = $ip[0]->name;
							break;
							case 'BROADCAST':
								$equipment = 'BROADCAST';
							break;
							case 'GATEWAY':
								$equipment = 'GATEWAY';
							break;
							default:
								$equipment = '';
							break;
						}
					}else{
						$equipment = $value->acronimo;
					}
					$ip_new[] = array(
						'id' => $value->id, 
						'ip' => $value->ip.'/'.$value->prefixes, 
						'type' => $value->type, 
						'uso' => $value->uso, 
						'vlan' => $value->vlan, 
						'name' => $value->name, 
						'id_status' => $value->id_status, 
						'acronimo' => $equipment, 
					);
				}
				$resul = 'yes';
			}else{
				$resul = 'nop';
			}		
		}
		return array('resul' => $resul, 'datos' => $ip_new, 'ring' => $id_rign,);
	}

	Public static function info_ip_filtro($id){
		$all = [];
		$extra = DB::table('ip')
			->Join('list_status_ip', 'list_status_ip.id', '=', 'ip.id_status')
			->leftJoin('equipment', 'equipment.id', '=', 'ip.id_equipment')
			->leftJoin('client', 'client.id', '=', 'ip.id_client')
			->leftJoin('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
			->leftJoin('ring', 'ring.id', '=', 'use_vlan.id_ring')
			->leftJoin('service', 'service.id', '=', 'ip.id_service')
			->whereIn('ip.id', $id)
			->select('list_status_ip.name as status_name', 'list_status_ip.id as id_status', 'ip.id', 'ip.ip', 'ip.prefixes', 'equipment.acronimo as equipment', 'client.business_name as client', 'ip.type', 'ip.id_use_vlan', 'ring.name as anillo', 'use_vlan.vlan', 'service.number', 'ip.assignment', 'ip.type', 'ip.id_branch')->get();
		foreach ($extra as $value) {
			$name_equipment = '';
			$name_anillo = '';
			$name_client = '';
			$name_service = '';
			$assignment = '';
			if ($value->anillo != null) { $name_anillo = 'Anillo: '.$value->anillo. ' Vlan:'.$value->vlan; }
			if ($value->equipment != null) { $name_equipment = ' Equipo: '.$value->equipment; }
			if ($value->client != null) { $name_client = ' Cliente: '.$value->client; }
			if ($value->number != null) { $name_service = ' Servicio: '.$value->number; }
			if ($value->assignment != null) { $assignment = ' Asignación: '.$value->assignment; }
			$atributo= $name_anillo.$name_equipment.$name_service.$name_client.$assignment;
		    $all[] = array(
		    	'id' => $value->id,
		    	'ip' => $value->ip.'/'.$value->prefixes,
		    	'id_status' => $value->id_status,
		    	'status' => $value->status_name,
		    	'atributo' => $atributo,
		    	'type' => $value->type,
		    	'branch' => $value->id_branch,
		    );
		}
		return $all;
	}

	public function list_ip_all($data){
	    if (!Auth::guest() == false){ 
	        return redirect('login')->withErrors([Lang::get('validation.login'),]);
	    }
	   	$all = [];
	   	$slq_id = DB::table('ip')->where('ip.ip', '=', $data)->select('id')->get();
	   	foreach ($slq_id as $valor) {
	   		$id_full[] = $valor->id;
	   	}
	   	if (count($slq_id) > 0) {
	   		$all = ControllerIP::info_ip_filtro($id_full);
	    }
	    return datatables()->of($all)->make(true);
  	}

  	public function list_sub_red_all($data, $dato){
	    if (!Auth::guest() == false){ 
	        return redirect('login')->withErrors([Lang::get('validation.login'),]);
	    }
	   	$all = [];
	   	$id = [];
	   	$slq_id = DB::table('branch')->where('id_branch', '=',$dato)->select('id', 'rank')->get();
	   	if (count($slq_id) > 0) {
	   		$id_branch = [];
	   		foreach ($slq_id as $value) {
	   			if ($value->rank != 'No') {
	   				$id[] = $value->id;
	   			}else{
	   				$id_branch[] = $value->id;
	   			}
	   		}
	   		while (count($id_branch) != 0) {
	    		$slq=DB::table('branch')->whereIn('id_branch',$id_branch)->select('id','rank')->get();
	    		$id_branch = [];
	    		foreach ($slq as $val) {
		   			if ($val->rank != 'No') {
		   				$id[] = $val->id;
		   			}else{
		   				$id_branch[] = $val->id;
		   			}
		   		}
    		}
	   	}
	   	$datos = DB::table('ip')->whereIn('id_branch',$id)->where('id_status','=',$data)
	   		->where('type','=','RED')->select('id')->get();
	   	if (count($datos) > 0) {
	   		foreach ($datos as $valor) {
	   			$id_full[] = $valor->id;
	   		}
	   		$all = ControllerIP::info_ip_filtro($id_full);
	   	}
	    return datatables()->of($all)->make(true);
  	}

  	public static function insert_all_record_ip($ip, $barra, $msj){
  		$recor_ip = new Record_ip();
			$recor_ip->id_ip = $ip;
			$recor_ip->prefixes = $barra;
			$recor_ip->attribute = $msj;
			$recor_ip->id_user = Auth::user()->id;
		$recor_ip->save();
  	}

  	public function asignar_red_all(){
  		$id = $_POST['id'];
  		$atributo = $_POST['atributo'];
  		$type_vlan = $_POST['type_vlan'];
  		$vlan = $_POST['vlan'];
  		$anilo_id = $_POST['anilo_id'];
  		$client = $_POST['client'];
  		$asignar = $_POST['asignar'];
  		$servicio = $_POST['servicio'];
  		$node = $_POST['node'];
  		$ip_all = IP::find($id);
  		$all = ControllerIP::rango($ip_all->ip.'/'.$ip_all->prefixes);
		$ini_fin_ip = ControllerIP::ipv4_ini_fin($ip_all->ip.'/'.$ip_all->prefixes);
		$all[] = $ini_fin_ip['inicio'];
		$all[] = $ini_fin_ip['fin'];
		$data = DB::table('ip')->whereIn('ip',$all)->where('id_branch','=',$ip_all->id_branch)
	   		->select('id','type', 'id_status')->get();
	   	$validation = 'SI';
	   	foreach ($data as $value) {
	   		if ($value->id_status == 1 || Auth::user()->id == 1) {
	   			$info[] = array('id' => $value->id, 'type' => $value->type,);	
	   		}else{
	   			$validation = 'No';

	   		}
	   	}
	   	if ($validation == 'SI') {
	   		if ($atributo == '1' || $atributo == '6') {
	   			if ($atributo == '1') {
		   			$info_vla = DB::table('use_vlan')->where('vlan','=',$vlan)->select('id')
				  		->where('id_list_use_vlan','=',$type_vlan)->where('id_ring','=',$anilo_id)->get();
				  	if (count($info_vla) > 0) {
				  		$id_vlan_all = $info_vla[0]->id;
				  	}else{
				  		$Use_Vlan = new Use_Vlan();
							$Use_Vlan->vlan = $vlan;
							$Use_Vlan->id_list_use_vlan = $type_vlan;
							$Use_Vlan->id_ring = $anilo_id;
						$Use_Vlan->save();
						$id_vlan_all = $Use_Vlan->id;
				  	}
	   			}else{
	   				$info_vla = DB::table('use_vlan')->where('vlan','=',$vlan)->select('id')
				  		->where('id_list_use_vlan','=',$type_vlan)->where('id_node','=',$node)->get();
				  	if (count($info_vla) > 0) {
			  			$id_vlan_all = $info_vla[0]->id;
				  	}else{
				  		$Use_Vlan = new Use_Vlan();
							$Use_Vlan->vlan = $vlan;
							$Use_Vlan->id_list_use_vlan = $type_vlan;
							$Use_Vlan->id_node = $node;
						$Use_Vlan->save();
						$id_vlan_all = $Use_Vlan->id;
				  	}
	   			}
	   		}
	   		foreach ($info as $valor) {
	   			$update = IP::find($valor['id']);
	   				if (($atributo == '1' || $atributo == '6') && $valor['type'] === 'RED' ) {
			  			$update->id_status = 2;
			  		}
			  		switch ($atributo) {
			  			case '1':	  				
			  				$update->id_use_vlan = $id_vlan_all;
			  				$sql_msj = Ring::find($anilo_id);
			  				$msl_ip = 'Se asignó la IP al anillo '.$sql_msj->name;
			  			break;
			  			case '2':
			  				$update->id_client = $client;
			  				$sql_msj = Client::find($client);
			  				$msl_ip = 'Se asignó la IP al cliente '.$sql_msj->business_name;
			  			break;
			  			case '4':
			  				$update->assignment = $asignar;
			  				$msl_ip = 'Se asignó la IP a '.$asignar;
			  			break;
			  			case '5':
			  				$update->id_service = $servicio;
			  				$update->id_status = 2;
			  				$sql_msj = Service::find($servicio);
			  				$msl_ip = 'La ip fue asignada al servicio '.$sql_msj->number;
			  			break;
			  			case '6':	  				
			  				$update->id_use_vlan = $id_vlan_all;
			  				$sql_msj = Node::find($node);
			  				$msl_ip = 'Se asignó la IP a la celda CELL ID '.$sql_msj->cell_id.' Acronimo '.$sql_msj->node;
			  			break;
			  		}
		  		$update->save();
		  		ControllerIP::insert_all_record_ip($update->id, $update->prefixes, $msl_ip);
	   		}
	   		$resul = 'yes';
	   	}else{
	   		$resul = 'nop';
	   	}
	   	return array('resul' => $resul, 'datos' => $ip_all->id_branch,);
  	}

  	public function liberar_red_all(){
		$id = $_POST['id'];
		$ip_all = IP::find($id);
	  	$all = ControllerIP::rango($ip_all->ip.'/'.$ip_all->prefixes);
		$ini_fin_ip = ControllerIP::ipv4_ini_fin($ip_all->ip.'/'.$ip_all->prefixes);
		$all[] = $ini_fin_ip['inicio'];
		$all[] = $ini_fin_ip['fin'];
		$data =DB::table('ip')->whereIn('ip',$all)->where('id_branch','=',$ip_all->id_branch)
		   	->select('id','type', 'id_status')->get();
		$validation = 'SI';
	   	foreach ($data as $value) {
	   		if ($value->id_status == 3 || $value->id_status == 1) {
	   			$info[] = array('id' => $value->id, 'type' => $value->type,);	
	   		}else{
	   			$validation = 'No';
	   		}
	   	}
	   	if ($validation == 'SI') {
	   		foreach ($info as $valor) {
	   			$update = IP::find($valor['id']);
			  		$update->id_status = 1;
			  		$update->id_use_vlan = null;
			  		$update->id_client = null;
			  		$update->assignment = null;
			  		$update->id_service = null;
			  		$update->id_equipment_wan = null;
		  		$update->save();
	   		}
	   		$resul = 'yes';
		}else{
			$resul = 'nop';
		}
		return array('resul' => $resul,);
	}

	public function ip_wan_by_vlan($vlan_id){
		if (Auth::guest()) return ['resul' => 'login'];
		$ip_new = [];
		$ip = DB::table('ip')
			->Join('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
			->Join('list_use_vlan', 'list_use_vlan.id', '=', 'use_vlan.id_list_use_vlan')
			->Join('ring', 'ring.id', '=', 'use_vlan.id_ring')
			->Join('port', 'port.id_ring', '=', 'ring.id')
			->leftJoin('equipment', 'ip.id_equipment_wan', '=', 'equipment.id')
			->where('use_vlan.id', '=', $vlan_id)
			->select('ip.id', 'ip.ip', 'ip.prefixes','ip.type', 'list_use_vlan.name as uso', 'use_vlan.vlan', 'ring.name', 'ip.id_status', 'equipment.acronimo')
			->groupBy('ip.id', 'ip.ip', 'ip.prefixes','ip.type', 'list_use_vlan.name', 'use_vlan.vlan', 'ring.name', 'ip.id_status', 'equipment.acronimo')
			->orderBy('ip', 'asc')->get();

		foreach ($ip as $value) {
			if ($value->acronimo != null) $equipment = $value->acronimo;
			else {
				switch ($value->type) {
					case 'RED': $equipment = $ip[0]->name; break;
					case 'BROADCAST': $equipment = $value->type; break;
					case 'GATEWAY': $equipment = $value->type; break;
					default: $equipment = ''; break;
				}
			}
			$ip_new[] = [
				'id' => $value->id, 
				'ip' => $value->ip.'/'.$value->prefixes, 
				'type' => $value->type, 
				'uso' => $value->uso, 
				'vlan' => $value->vlan, 
				'name' => $value->name, 
				'id_status' => $value->id_status, 
				'acronimo' => $equipment, 
			];
		}
		return ['resul' => 'yes', 'datos' => $ip_new];
	}

	/**
	 * Arma listado de IPs (las ip del rango) a partir de los datos de una ip subnet
	 */
	public static function ip_by_subnet($subnet_ip, $subnet_prefix, $branch_id) {
		try {
			if (Auth::guest()) return ['resul' => 'login'];
			$ip_list = [];
			$range_lenght = 2 ** (32 - $subnet_prefix);
			$range_start = strrev(strtok(strrev($subnet_ip), '.'));
			$group = IP::get_group($subnet_ip);
			
			for ($i = $range_start+1; $i < $range_start+$range_lenght-1; $i++) { 
				$ip = $group . '.' . strval($i);

				$used_ip = DB::table('ip')
					->leftJoin('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
					->leftJoin('ring', 'ring.id', '=', 'use_vlan.id_ring')
					->leftJoin('port', 'port.id_ring', '=', 'ring.id')
					->leftJoin('equipment', 'ip.id_equipment_wan', '=', 'equipment.id')
					->where('ip.ip', '=', $ip)
					->where('ip.id_branch', '=', $branch_id)
					->select('ip.id', 'ip.ip', 'ip.prefixes', 'ip.type', 'ip.id_status', 'ip.id_branch', 'ring.name', 'equipment.acronimo')
					->first();
				
				if (!empty($used_ip)) {
					if (empty($used_ip->acronimo)) {
						switch ($used_ip->type) {
							case 'RED': $used_ip->acronimo = $used_ip->name; break;
							case 'BROADCAST': $used_ip->acronimo = $used_ip->type; break;
							case 'GATEWAY': $used_ip->acronimo = $used_ip->type; break;
							default: $used_ip->acronimo = ''; break;
						}
					}
					$ip_list[] = $used_ip;
				} else {
					throw new Error('Hay IPs no registradas en esta subnet');
					/*
					$new_ip = new IP;
					$new_ip->ip = $ip;
					$new_ip->prefixes = $subnet_prefix;
					$new_ip->type = 'DISPONIBLE';
					$new_ip->acronimo = '';
					$new_ip->id_status = 1; // Convertirlo en cadena para que quede igual a las ips existentes?
					$new_ip->id_branch = $branch_id;
					$ip_list[] = $new_ip;
					*/
				}
			}
			return $ip_list;
		} catch (Error $e) {
			return $e->getMessage();
		}
	}

	public function assigned_ip_wan($equip_id, $vlan_id){
		try {
			if (Auth::guest()) return ['resul' => 'login'];
			$ip = IP::where('ip.id_equipment_wan', '=', $equip_id)
				->where('ip.id_use_vlan', '=', $vlan_id)
				->select('ip.id', 'ip.ip', 'ip.prefixes')
				->first();
			if (empty($ip)) return ['resul' => 'nop', 'datos' => 'No hay ips registradas para esta vlan'];
			return ['resul' => 'yes', 'datos' => $ip];
		} catch (Exception $e) {
			return $e;
		}
	}
}