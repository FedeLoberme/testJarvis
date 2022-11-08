<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Http\Controllers\ControllerUser_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use DB;
use Jarvis\Uplink;
use Jarvis\User;
use Jarvis\Node;
use Jarvis\Equipment_Model;
use Jarvis\Link;

class ControllerUplink extends Controller
{
	// -----------------Funcion para listar Uplink---------------------------
	public function index(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(12);
		$nodo = Node::all();
		$equipment = Equipment_Model::List();
		if ($authori_status['permi'] >= 3) {
			return view('uplink.list',compact('authori_status','nodo', 'equipment'));
		}else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function index_list(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(12);
		if ($authori_status['permi'] >= 3) {
			$uplink = Link::where('id_list_type_links', 3)->get();
        return datatables()->of($uplink)->make(true);
        }else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}




	public function insert_update_uplink(){
		$id=$_POST['id'];
		$nodo_al=$_POST['nodo_al'];
		$uplink=$_POST['uplink'];
		$equipment_sat=$_POST['equipment_sat'];
		$ip_gestion=$_POST['ip_gestion'];
		$por_sar=$_POST['por_sar'];
		$mtr_tag=$_POST['mtr_tag'];
		$cus_tag=$_POST['cus_tag'];
		$vlan=$_POST['vlan'];
		$bw=$_POST['bw'];
		if ($id != 0) {
        		$uplin =Uplink::find($id);
        	}else{
        		$uplin = new Uplink();
              
        	}
	        	$uplin->name =strtoupper($uplink);
	            $uplin->bw_maximum = $bw;
			    $uplin->id_node = $uplink; 
			    $uplin->sar_equipment = $equipment_sat; 
			    $uplin->sar_ip = $ip_gestion;
	            $uplin->sar_port = $por_sar;
			    $uplin->mt = $mtr_tag;
			    $uplin->ct = $cus_tag; 
			    $uplin->vlan = $vlan; 
	    	$uplin->save();
dd($uplin->id);

	}

	public function select_uplink(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id=$_POST['id'];
      	$authori_status = User::authorization_status(12);
      	if ($authori_status['permi'] >= 3) {
			$uplink =Uplink::find($id);
        
        		$data = array(
        			'resul'=> 'yes',
			        'datos' => $uplink,
        		);
        		
        	return $data;
      	}else{
			return array('resul' => 'autori', );
      	}
	}
}