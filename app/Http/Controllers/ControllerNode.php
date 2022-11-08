<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;
use Jarvis\User;
use Jarvis\IP;
use Jarvis\Node;
use Jarvis\Equipment_Model;
use Jarvis\Use_Vlan;
use Jarvis\List_Equipment;
use Jarvis\List_Countries;
use Jarvis\List_Use_Vlan;
use Jarvis\Client;
use Jarvis\Http\Requests\RequestUseVlanNode;
use Jarvis\Http\Controllers\ControllerUser_history;
use Jarvis\Http\Controllers\ControllerAddress;
use Jarvis\Http\Controllers\ControllerIP;
class ControllerNode extends Controller
{
    public function index(){
    	if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(10);
		if ($authori_status['permi'] < 3) {
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
		$pais = List_Countries::all(['id', 'name'])->sortBy('name');
		$list_vlan = List_Use_Vlan::all();
		return view('nodo.list',compact('authori_status', 'pais', 'list_vlan'));
    }
    public function index_list(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(10);
		if ($authori_status['permi'] >= 3) {
			$node_all = [];
			$nodo = DB::table('node')
				->leftJoin('address', 'node.address', '=', 'address.id')
				->leftJoin('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
				->leftJoin('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
				->select('node.id', 'node.cell_id', 'node.node', 'node.contract_date', 'node.type', 'node.owner', 'node.commentary', 'address.location', 'address.street', 'address.postal_code', 'list_countries.name as countries', 'list_provinces.name as provinces', 'node.status', 'address.height', 'address.floor', 'address.department')->get();
			foreach ($nodo as $value) {
				$dire = $value->countries.' '.$value->provinces.' '.$value->location.' '.$value->street.' '.$value->height;
				$apt_node= "SI";
				if ($value->type != "PROPIO") {
					if ($value->contract_date != null) {
						$expiry_date = date('Y-m-d', strtotime('+2 years'));
						if (strtotime($value->contract_date) <= strtotime($expiry_date)) $apt_node = 'NO';
					}
				}
	        	if ($value->floor != null) $dire = $dire.' Piso'.$value->floor;
	        	if ($value->department != null) $dire = $dire.' Depto'.$value->department;
				$node_all[] = array(
					'id' => $value->id, 
					'cell_id' => $value->cell_id, 
					'node' => $value->node, 
					'contract_date' => $value->contract_date, 
					'type' => $value->type, 
					'owner' => $value->owner, 
					'commentary' => $value->commentary, 
					'status' => $value->status,
					'apt_node' => $apt_node,
					'dire' => $dire,  
				);
			}
        return datatables()->of($node_all)->make(true);
        }else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function sele_anillo_list(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(10);
		if ($authori_status['permi'] >= 3) {
			$node_all = [];
			$nodo = DB::table('node')
			->Join('equipment', 'equipment.id_node', '=', 'node.id')
			->leftJoin('address', 'node.address', '=', 'address.id')
			->leftJoin('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
			->leftJoin('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
			->select('node.id', 'node.cell_id', 'node.node', 'node.contract_date', 'node.type', 'node.owner', 'node.commentary', 'address.location', 'address.street', 'address.postal_code', 'list_countries.name as countries', 'list_provinces.name as provinces', 'node.status', 'address.height', 'address.floor', 'address.department')->groupBy('node.id', 'node.cell_id', 'node.node', 'node.contract_date', 'node.type', 'node.owner', 'node.commentary', 'address.location', 'address.street', 'address.postal_code', 'list_countries.name', 'list_provinces.name', 'node.status', 'address.height', 'address.floor', 'address.department')->get();
			foreach ($nodo as $value) {
				$dire = $value->countries.' '.$value->provinces.' '.$value->location.' '.$value->street.' '.$value->height;
	        	if ($value->floor != null) {
	        		$dire = $dire.' Piso'.$value->floor;
	        	}
	        	if ($value->department != null) {
	        		$dire = $dire.' Depto'.$value->department;
	        	}
				$node_all[] = array(
					'id' => $value->id, 
					'cell_id' => $value->cell_id, 
					'node' => $value->node, 
					'contract_date' => $value->contract_date, 
					'type' => $value->type, 
					'owner' => $value->owner, 
					'commentary' => $value->commentary, 
					'status' => $value->status, 
					'dire' => $dire,  
				);
			}
        return datatables()->of($node_all)->make(true);
        }else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function select_nodo(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id=$_POST['id'];
      	$authori_status = User::authorization_status(10);
      	if ($authori_status['permi'] >= 3) {
			$nodo = Node::find($id);
        	if ($nodo <> null) {
        		if ($nodo->contract_date != null) {
        			$fecha = date("Y-m-d", strtotime($nodo->contract_date));
        		}else{
        			$fecha = '';
        		}
        		$data = array(
        			'resul'=> 'yes',
			        'cell_id' => $nodo->cell_id,
			        'nodo' => $nodo->node, 
			        'commentary' => $nodo->commentary, 
			        'address' => $nodo->address, 
			        'contract_date' => $fecha, 
			        'type' => $nodo->type, 
			        'owner' => $nodo->owner, 
			        'status' => $nodo->status, 
        		);
        	}else{
        		$data = array( 'resul'=> 'nop',);
        	}	
        	return $data;
      	}else{
        	return array('resul' => 'home', );
      	}
	}

	public function insert_update_nodo(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$authori_status = User::authorization_status(10);
      	if ($authori_status['permi'] >= 5) {
			$id_nodo=$_POST['id_nodo'];
			$cell_id=$_POST['cell_id'];
			$address=$_POST['address'];
			$contract_date=$_POST['date'];
			$commen=$_POST['commen'];
			$nodo=$_POST['nodo'];
			$type=$_POST['type'];
			$propi=$_POST['propi'];
			$status=$_POST['status'];
			$nodo_exis = DB::table('node')->where('node.cell_id', '=', $cell_id)->where('node.id', '!=', $id_nodo)->select('node.id')->get();
			
			if (count($nodo_exis) > 0) return $data = array('resul' => 'exis', );
			
			if ($id_nodo != 0) {
	        	$msj_nodo = 'Modifico el nodo ';
	        	$datos = Node::find($id_nodo);
		    } else {
				if ($authori_status['permi'] < 10) return array('resul' => 'autori');
				$msj_nodo = 'Registro el nodo ';
			    $datos = new Node();
		    }
		    if ($type == 'PROPIO') {
		        $datos->owner = 'CLARO';
		        $datos->contract_date = null;
		    } else {
		    	$datos->contract_date = $contract_date;	
		        $datos->owner = $propi;	
		    }
 			$datos->type = $type;
	        $datos->cell_id = $cell_id;
	        $datos->address = $address;
	        $datos->node = $nodo;
	        $datos->commentary = $commen;
	        $datos->status = $status;
	      	$datos->save();
	      	if ($datos <> null) {
				ControllerUser_history::store($msj_nodo.$nodo." (".$cell_id.")");
	      		$nodos = DB::table('node')->select('node.node', 'node.cell_id', 'node.address', 'node.id')->get();
	        	$data = array('resul' => 'yes', 'datos' => $nodos,); 
		    }else{
		    	$data =  array('resul' => 'nop', ); 
		    }
		    return $data;
		}else{
        	return array('resul' => 'autori', );
      	}
	}

	public function nodo_select(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$authori_status = User::authorization_status(10);
      	if ($authori_status['permi'] >= 3) {
			$nodo = DB::table('node')->select('cell_id', 'node','id')->get();
			if (count($nodo) <> 0) {
	        	$data = array('resul' => 'yes', 'datos' => $nodo, ); 
		    }else{
		    	$data =  array('resul' => 'nop', ); 
		    }
		    return $data;
		}else{
        	return array('resul' => 'home', );
      	}
	}

	public function cometarios(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id=$_POST['id'];
		$authori_status = User::authorization_status(10);
      	if ($authori_status['permi'] >= 3) {
			$nodo = DB::table('node')->select('node.node', 'node.commentary')->where('node.id', '=', $id)->get();
			if (count($nodo) <> 0 && $nodo[0]->commentary != null) {
	        	$data = array('resul' => 'yes', 'name' => $nodo[0]->node, 'commen' => $nodo[0]->commentary, ); 
		    }else{
		    	$data =  array('resul' => 'nop', ); 
		    }
		    return $data;
		}else{
        	return array('resul' => 'autori', );
      	}
	}

	public static function node_selec(){
	    if (Auth::guest()) return ['resul' => 'login'];

	    $authori_status = User::authorization_status(10);
		if ($authori_status['permi'] < 3) return ['resul' => 'autori'];

		$id = $_POST['id'];
		$node = Node::find($id, ['cell_id', 'node', 'status']);
		if (!$node->exists() || $node->status != 'OPERATIVO') return ['resul' => 'nop'];

		$datos = $node->cell_id.' '.$node->node;
		$resul = ['resul' => 'yes', 'datos' => $datos, 'cell_id' => $node->cell_id];
		return $resul;
	}

  	public function acronimo_port_lsw(){
    	if (!Auth::guest() == false){ return redirect('login')->withErrors([Lang::get('validation.login'),]); }
		$id = $_POST['id'];
    	$node = Node::find($id, ['cell_id', 'node']);
    	for ($i=1; $i < 100 ; $i++) { 
    		$n = $i;
    		if ($i < 10) { $n = '0'.$i; }
    		$name = $node->cell_id.'SW'.$n;
    		$Validator = DB::table('equipment')->where('acronimo','=',$name)->select('id')->get();
    		if (count($Validator) == 0) {
    			$i=101;
    		}
    	}
		return array('resul' => 'yes', 'datos' => $name);
    }

    public function search_vlan_ip(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id = $_POST['id'];
      	$authori_status = User::authorization_status(10);
      	if ($authori_status['permi'] >= 3) {
			$data = DB::table("use_vlan")
				->join('list_use_vlan', 'use_vlan.id_list_use_vlan', '=', 'list_use_vlan.id')
				->join('ip', 'ip.id_use_vlan', '=', 'use_vlan.id')
				->where('use_vlan.id_node', '=', $id)
				->where('ip.type', '=', 'RED')
				->select('use_vlan.id','list_use_vlan.name','use_vlan.vlan','ip.ip','ip.prefixes')
				->groupBy('use_vlan.id','list_use_vlan.name','use_vlan.vlan','ip.ip','ip.prefixes')->get();
			return array('resul' => 'yes', 'datos' => $data);	
		}else{
        	return array('resul' => 'autori', );
      	}
	}

	public function vlan_ip_nodo_insert(RequestUseVlanNode $request){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
      	$authori_status = User::authorization_status(10);
      	if ($authori_status['permi'] < 5) {
      		return array('resul' => 'autori',);
      	}

		$info_node = Node::find($request->id);
		$IP_sele = IP::find($request->ip);

		$ip_individual = ControllerIP::rango($IP_sele->ip.'/'.$IP_sele->prefixes);
		$ini_fin_ip = ControllerIP::ipv4_ini_fin($IP_sele->ip.'/'.$IP_sele->prefixes);
		$ip_individual[] = $ini_fin_ip['inicio'];
		$ip_individual[] = $ini_fin_ip['fin'];

		$buscar = DB::table("ip")->select('ip.id', 'ip.type', 'ip.id_status')
			->whereIn('ip.ip', $ip_individual)->where('ip.id_branch', '=', $IP_sele->id_branch)->get()->toArray();
		
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
			$Use_Vlan->vlan = $request->vlan;
			$Use_Vlan->id_list_use_vlan = $request->uso;
			$Use_Vlan->id_node = $request->id;
		$Use_Vlan->save();
		$id_vlan = $Use_Vlan->id;

		foreach ($dato_ip as $valor_ip) {

			$IP_vlan_sele = IP::find($valor_ip['id']);
				if ($valor_ip['type'] == 'RED'){ $IP_vlan_sele->id_status = 2; }
				$IP_vlan_sele->id_use_vlan = $id_vlan;
			$IP_vlan_sele->save();

			$msj = 'Se asigno la IP al sitio '.$info_node->cell_id.' '.$info_node->node;
			ControllerIP::insert_all_record_ip($IP_vlan_sele->id,$IP_vlan_sele->prefixes,$msj);
		}

		ControllerUser_history::store('Agrego Vlan y SubRed al sitio '.$info_node->cell_id.' '.$info_node->node);
		return array('resul' => 'yes', 'datos' => $request->id);	
	}

	public function delete_vlan_ip_nodo(Request $request){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
      	$authori_status = User::authorization_status(10);
      	if ($authori_status['permi'] >= 5) {
      		$libre = 0;
			$ip = DB::table("ip")->where('ip.id_use_vlan', '=', $request->id)
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
					$msj = 'Se libero la IP del Sitio';
					ControllerIP::insert_all_record_ip($all_ip->id, $all_ip->prefixes, $msj);
				}
				$vlan_info = DB::table("use_vlan")
					->join("list_use_vlan", "list_use_vlan.id", "=", "use_vlan.id_list_use_vlan")
					->join("node", "node.id", "=", "use_vlan.id_node")
					->where('use_vlan.id', '=', $request->id)
					->select('use_vlan.vlan', 'node.cell_id', 'list_use_vlan.name', 'node.id')->get();
				$node = $vlan_info[0]->id;
				$msj = 'Quito Vlan de '.$vlan_info[0]->name.' '.$vlan_info[0]->vlan.' y la SubRed '.$ip_red_msj.' al sitio '.$vlan_info[0]->cell_id;
				ControllerUser_history::store($msj);

				$vlan = Use_Vlan::find($request->id);
	        	$vlan->delete();
	        	
	        	return array('resul' => 'yes', 'datos' => $node);
        	}else{
        		return array('resul' => 'Exist', );
        	}
		}else{
        	return array('resul' => 'autori', );
      	}
	}

	public function search_equipments_node(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id=$_POST['id'];
		$data=[];
		$authori_status = User::authorization_status(10); ////////////////////permisos
      	if ($authori_status['permi'] >= 3) {
			$nodo = DB::table('node')->select('node.id', 'node.node')->where('node.id', '=', $id)->get();
			$equipments = DB::table('equipment')->where('id_node', '=', $nodo[0]->id)->get();
			if (count($equipments) <> 0 && $equipments[0]->acronimo != null) {
				foreach ($equipments as $value) {
					$cliente='';
					if($value->id_client != 0){
						$client = Client::find($value->id_client);
						$cliente = $client->business_name;
					}
					$data[] = array(
						'acronimo' => $value->acronimo,
						'client' => $cliente,
						'type' => $value->type,
						'status' => $value->status,
						'service' => $value->service,
						'commentary' => $value->commentary,
					);
				}
			return array('resul' => 'yes', 'data' => $data, 'node_name' => $nodo[0]->node);
			
		    }else{
		    	$data =  array('resul' => 'nop', ); 
		    }
		    return $data;
		}else{
        	return array('resul' => 'autori', );
      	}
	}

}
