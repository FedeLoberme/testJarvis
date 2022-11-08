<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\User;
use Jarvis\IP;
use Jarvis\Branch;
use Jarvis\Permissions_IP;
use Jarvis\Equipment_Model;
use Jarvis\User_history;
use Jarvis\List_Status_IP;
use Jarvis\List_Use_Vlan;
use Jarvis\List_Stock_IP;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Jarvis\Http\Controllers\ControllerIP;
class ControllerBranch extends Controller
{
     // -----------------Funcion para listar rama---------------------------
	public function index(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
    $autori_status = User::authorization_status(16);
    if ($autori_status['permi'] >= 3){
  		$equipment = Equipment_Model::List();
  		$confi = $equipment['confir'];
      $status = List_Status_IP::all(['id', 'name'])->where('id','!=',4);
      $vlan_all = List_Use_Vlan::all(['id', 'name']);
  		$base = DB::table("branch")->select('branch.id', 'branch.name','branch.description','branch.rank', 'branch.ip_rank')->where('branch.id_branch', '=', '0')->get();
      foreach ($base as $value) {
        $permi = ControllerBranch::permiss_branch($value->id);
        $branch_base[] = array(
          'id' => $value->id, 
          'name' => $value->name, 
          'description' => $value->description, 
          'rank' => $value->rank, 
          'ip_rank' => $value->ip_rank, 
          'permi' => $permi, 
        );
      }
  		return view('admin_ip.rama.list',compact('confi','branch_base', 'status', 'vlan_all'));
    }else{
      return array('resul' => 'autori', );
    }
	}

	public function index_list(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
    $autori_status = User::authorization_status(16);
    if ($autori_status['permi'] >= 3){
		  $branch = DB::table('branch')->select('*');
      return datatables()->of($branch)->make(true);
    }else{
      return array('resul' => 'autori', );
    }
        
	}


	public function search_rama(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		  $id=$_POST['id'];
      	$authori_status = User::authorization_status(16);
      	if ($authori_status['permi'] >= 10) {
          $branch =DB::table('branch')
          ->leftJoin('ip', 'branch.id', '=', 'ip.id_branch')
          ->where('branch.id', '=', $id)
          ->select('branch.name', 'branch.description', 'branch.rank', 'branch.id_branch', 'branch.type_ip', 'branch.ip_rank', 'branch.prefixes_rank', 'ip.id as ip_hijo')->get();
        	if ($branch <> null) {
        		$data = array(
        			'resul'=> 'yes',
			        'name' => $branch[0]->name,
			        'description' => $branch[0]->description, 
			        'rank' => $branch[0]->rank,
			        'id_padre' => $branch[0]->id_branch, 
              'ip' => $branch[0]->ip_rank,
              'prefixes' => $branch[0]->prefixes_rank,
              'type' => $branch[0]->type_ip,
              'ip_hijo' => $branch[0]->ip_hijo,
        		);
        	}else{
        		$data = array( 'resul'=> 'nop',);
        	}	
        	return $data;
      	}else{
        	return array('resul' => 'autori', );
      	}
	}

	public function insert_update_rama(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$rama_new=$_POST['rama_new'];
		$rango=$_POST['rango'];
		$descrit_new=$_POST['descrit_new'];
		$id_rama=$_POST['id_rama'];
		$padre=$_POST['padre'];
    $type=$_POST['type'];
    $ip_rama=$_POST['ip_rama'];
    $pre=$_POST['pre'];
    $ip_edi="No";
    $permiso = ControllerIP::permissions_branch($padre);
    if ($permiso >= 5){
      if ($rango == 'Si'){ 
        $buscar = 'No'; 
        $existe = DB::table("branch")->select('branch.id')
          ->where('branch.id_branch', '=', $padre)
          ->where('branch.ip_rank', '=', $ip_rama)
          ->where('branch.id', '!=', $id_rama)
          ->where('branch.rank', '=', 'Si')->get();
        if (count($existe) > 0) {
          return array( 'resul'=> 'exis',);
        }
      }else{ 
        $buscar = 'Si'; 
      }
      $relat = DB::table("branch")->select('branch.id')
        ->where('branch.id_branch', '=', $padre)
        ->where('branch.rank', '=', $buscar)->get();
      if (count($relat) > 0 && $padre != '0') {
        return array( 'resul'=> 'impo',);
      }
        	if ($id_rama != 0) {
            $relation_exit = DB::table("ip")->select('ip.id')
            ->where('ip.id_branch', '=', $id_rama)->get();
            if (count($relation_exit) == 0) {
              $ip_edi="Si";
            }
        		$branch =Branch::find($id_rama);
        	}else{
            if ($permiso >= 10){
        		  $branch = new Branch();
            }else{
              return array( 'resul'=> 'autori',);
            }
            $branch->rank = $rango;
            $branch->id_branch = $padre;  
        	}
			    $branch->name = strtoupper($rama_new); 
			    $branch->description = $descrit_new; 
          if (($id_rama == 0 && $rango == 'Si') || ($ip_edi == 'Si' && $rango == 'Si')) {
            $ip_ini_fin = ControllerIP::ipv4_ini_fin($ip_rama.'/'.$pre);
            $branch->type_ip = $type; 
            $branch->ip_rank = $ip_ini_fin['inicio']; 
            $branch->prefixes_rank = $pre; 
          }
	    	$branch->save();
        if ($rango == 'Si'){ 
          $search_stock = DB::table('list_stock_ip')->select('id')
            ->where('rank', '=', $ip_rama)->where('status', '!=', 'OCUPADO')->get();
            if (count($search_stock) > 0) {
              $ip_stock = List_Stock_IP::find($search_stock[0]->id);
                $ip_stock->status = 'OCUPADO';
              $ip_stock->save();
            }
        }
        if ($id_rama == 0) {
          $permissions_real = DB::table('permissions_ip')
          ->where('permissions_ip.id_branch', '=', $padre)
          ->select('permissions_ip.permissions', 'permissions_ip.id_user as user', 'permissions_ip.id_group_ip as grupo')->orderBy('permissions', 'desc')->get();
          foreach ($permissions_real as $permission) {
            $permissions = new Permissions_IP();
              $permissions->id_group_ip = $permission->grupo;
              $permissions->id_user = $permission->user;
              $permissions->id_branch = $branch->id;
              $permissions->permissions = $permission->permissions;
            $permissions->save();
          }
        }
        	if ($branch <> null) {
        		$data = array(
              'resul'=> 'yes',
        			'ip'=> $branch->id,
        		);
        	}else{
        		$data = array( 'resul'=> 'nop',);
        	}	
        	return $data;
      	}else{
        	return array('resul' => 'autori', );
      	}
	}

	public function ver_mas_rama(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$authori_status = User::authorization_status(16);
    if ($authori_status['permi'] >= 3) {
      $branch_lis = []; $all_branch_full = []; $id_branch_all = [];
      $id = $_POST['id'];
      $branch_all = Branch::find($id);
			$branch = DB::table("branch")->where('branch.id_branch', '=', $id)
			->select('branch.id', 'branch.name','branch.description','branch.rank', 'branch.ip_rank', 'branch.prefixes_rank')->orderBy('branch.name', 'asc')->get();
      foreach ($branch as $key) {
        $id_branch_all[] = $key->id;
        $ip_rank = ''; $mascar = '';
        if ($key->ip_rank != null && $key->ip_rank != '') {
          $ip_rank = $key->ip_rank;
          $mascar = '/'.$key->prefixes_rank;
        }
          $branch_lis[] = array(
            'id' => $key->id,
            'name' => $key->name,
            'description' => $key->description,
            'rank' => $key->rank,
            'ip_rank'=> $ip_rank,
            'barra'=> $mascar,
          );
      }
      $relation_all = DB::table("branch")->select('branch.id', 'branch.id_branch','branch.rank')
        ->whereIn('branch.id_branch', $id_branch_all)->get()->toArray();
      $permi = ControllerBranch::permiss_branch_all_full($id_branch_all);
      foreach ($branch_lis as $value) {
        $hijo = '0'; $padre = '0';
        $info_branch = array_search($value['id'], array_column($permi, 'branch'));
        if (count($relation_all) > 0) {
          $info_relation = array_search($value['id'], array_column($relation_all, 'id_branch'));
          if ($info_relation !== false) {
            $padre = '1';
            if ($relation_all[$info_relation]->rank == 'Si') {
              $hijo = '1';
            }
          }
        }
        $all_branch_full[] = array(
          'id' => $value['id'],
          'name' => $value['name'],
          'description' => $value['description'],
          'rank' => $value['rank'],
          'hijo' => $hijo,
          'padre' => $padre,
          'ip_rank'=> $value['ip_rank'],
          'barra'=> $value['barra'],
          'permi'=> $permi[$info_branch]['permissions'],
          'color' => '',
        );
      }
      if (count($all_branch_full) > 0) {
        $name_ramas  = array_column($all_branch_full, 'name');
        $ip_ramas  = array_column($all_branch_full, 'ip_rank');
        array_multisort($name_ramas, SORT_ASC, $ip_ramas, SORT_ASC, $all_branch_full);
      }
      if (count($branch) <> 0) {
        		$data = array(
        			'resul'=> 'yes',
              'datos'=> $all_branch_full,
              'canti'=> count($all_branch_full) - 1,
        			'es_rango'=> $branch_all->rank,
              'actual' => $branch_all,
              'permi' => Auth::user()->id,
        		);
      }else{
        $data = array( 'resul'=> 'nop',);
      }	
        	return $data;
    }else{
      return array('resul' => 'autori', );
    }	
	}

  public function permiss_branch($id){
    if (!Auth::guest() == false){ return array('resul' => 'login', ); }
    $user = 0; $group = 0;
    $permiss_group=DB::table("permissions_ip")
      ->Join('group_ip', 'group_ip.id', '=', 'permissions_ip.id_group_ip')
      ->Join('group_users', 'group_ip.id', '=', 'group_users.id_group_ip')
      ->where('group_users.id_user', '=', Auth::user()->id)
      ->where('permissions_ip.id_branch', '=', $id)
      ->select('permissions_ip.permissions')->get();
    $permiss_user=DB::table("permissions_ip")
      ->where('permissions_ip.id_user', '=', Auth::user()->id)
      ->where('permissions_ip.id_branch', '=', $id)
      ->select('permissions_ip.permissions')->get();
    if (count($permiss_group)> 0) { $group = $permiss_group[0]->permissions; }
    if (count($permiss_user)> 0) { $user = $permiss_user[0]->permissions; }
    if ($group > $user) {
      $permi = $group;
    }else{
      $permi =$user;
    }
    return $permi;
  }

  public function permiss_branch_all_full($id){
    if (!Auth::guest() == false){ return array('resul' => 'login', ); }
    $user = 0; $group = 0;
    $all = [];
    $permiss_group = DB::table("permissions_ip")
      ->Join('group_ip', 'group_ip.id', '=', 'permissions_ip.id_group_ip')
      ->Join('group_users', 'group_ip.id', '=', 'group_users.id_group_ip')
      ->where('group_users.id_user', '=', Auth::user()->id)
      ->whereIn('permissions_ip.id_branch', $id)
      ->select('permissions_ip.id_branch', 'permissions_ip.permissions')->get()->toArray();
    $permiss_user = DB::table("permissions_ip")
      ->where('permissions_ip.id_user', '=', Auth::user()->id)
      ->whereIn('permissions_ip.id_branch', $id)
      ->select('permissions_ip.id_branch', 'permissions_ip.permissions')->get()->toArray();
    foreach ($id as $value) {
      $info_group = array_search($value, array_column($permiss_group, 'id_branch'));
      if ($info_group !== false) {
        $group = $permiss_group[$info_group]->permissions;
      }
      if (count($permiss_user)> 0) {
        $info_user = array_search($value, array_column($permiss_user, 'id_branch'));
        if ($info_user !== false) {
          $user = $permiss_group[$info_user]->permissions;
        }
      }
      if ($group > $user) {
        $permi = $group;
      }else{
        $permi =$user;
      }
      $all[] = array(
        'branch' => $value,
        'permissions' => $permi,
      );
    }
    return $all;
  }

  public function search_ip_branch(){
    $atributo = $_POST['atributo'];
    $data_ip = [];
    switch ($atributo) {
      case '1':
        $anillo = $_POST['anillo'];
        $ip_sql = DB::table("ip")->join('use_vlan', 'use_vlan.id', '=', 'ip.id_use_vlan')
          ->where('use_vlan.id_ring','=',$anillo)->select('id_branch')->groupby('id_branch')->get();
        if (count($ip_sql) > 0) {
          foreach ($ip_sql as $value) {
            $id_branch_all[] = $value->id_branch;
          }
          $data_ip = ControllerBranch::search_info_branch($id_branch_all);
        }
      break;
      case '2':
        $client = $_POST['client'];
        $ip_sql = DB::table("ip")->where('id_client','=',$client)
          ->select('id_branch')->groupby('id_branch')->get();
        $ip_sql_all = DB::table("ip")->join('service', 'ip.id_service', '=', 'service.id')
        ->where('service.id_client','=',$client)
          ->select('id_branch')->groupby('id_branch')->get();
        if (count($ip_sql) > 0 || count($ip_sql_all) > 0) {
          foreach ($ip_sql as $value) {
            $id_branch_all[] = $value->id_branch;
          }
          foreach ($ip_sql_all as $val) {
            $id_branch_all[] = $val->id_branch;
          }
          $data_ip = ControllerBranch::search_info_branch($id_branch_all);
        }
      break;
      case '3':
        $equip = $_POST['equip'];
        $ip_sql = DB::table("ip")->where('id_equipment','=',$equip)
          ->orwhere('id_equipment_wan','=',$equip)->select('id_branch')->groupby('id_branch')->get();
        if (count($ip_sql) > 0) {
          foreach ($ip_sql as $value) {
            $id_branch_all[] = $value->id_branch;
          }
          $data_ip = ControllerBranch::search_info_branch($id_branch_all);
        }
      break;
      case '4':
        $ip = $_POST['ip'];
        $branch=DB::table("branch")->select('id','name','type_ip','ip_rank','prefixes_rank')
          ->where('rank','=','Si')->get();
        foreach ($branch as $value) {
          $ini_fin_ip = ControllerIP::ipv4_ini_fin($value->ip_rank.'/'.$value->prefixes_rank);
          if (ip2long($ini_fin_ip['inicio'])<=ip2long($ip) && ip2long($ini_fin_ip['fin'])>=ip2long($ip)){
            $permi = ControllerBranch::permiss_branch($value->id);
            $data_ip[] = array(
              'id' => $value->id, 
              'name' => $value->name, 
              'ip_rank' => $value->type_ip, 
              'barra' => $value->prefixes_rank,  
              'ip' => $value->ip_rank, 
              'prefixes' => $value->prefixes_rank, 
              'permi' => $permi, 
            );
          }
        }
      break;
      case '5':
        $servicio = $_POST['servicio'];
        $ip_sql = DB::table("ip")->where('id_service','=',$servicio)
          ->select('id_branch')->groupby('id_branch')->get();
        if (count($ip_sql) > 0) {
          foreach ($ip_sql as $value) {
            $id_branch_all[] = $value->id_branch;
          }
          $data_ip = ControllerBranch::search_info_branch($id_branch_all);
        }
      break;
    }
    return array('resul' => 'yes', 'datos' => $data_ip,);
  }

  public function search_info_branch($id_branch){
    $data_ip = [];
    $branch=DB::table("branch")->select('id','name','type_ip','ip_rank','prefixes_rank')
      ->whereIn('id',$id_branch)->get();
    foreach ($branch as $value) {
      $permi = ControllerBranch::permiss_branch($value->id);
      $data_ip[] = array(
        'id' => $value->id, 
        'name' => $value->name, 
        'ip_rank' => $value->type_ip, 
        'barra' => $value->prefixes_rank,  
        'ip' => $value->ip_rank, 
        'prefixes' => $value->prefixes_rank, 
        'permi' => $permi, 
      );
    }
    return $data_ip;
  }

  public function detal_branch(){
    if (!Auth::guest() == false){ return array('resul' => 'login', );}
    $autori_status = User::authorization_status(16);
    if ($autori_status['permi'] >= 3){
      $id = $_POST['id'];
      $branch = Branch::find($id);
      $all[] = array(
        'id' => $branch->id,
        'rama' => $branch->name.' '.$branch->ip_rank.'/'.$branch->prefixes_rank,
      );
      while ($branch->id_branch != 0) {
        $branch = Branch::find($branch->id_branch);
        $all[] = array(
          'id' => $branch->id,
          'rama' => $branch->name,
        );
      }
      $n_id  = array_column($all, 'id');
      array_multisort($n_id, SORT_ASC, $all);
      return array('resul' => 'yes', 'datos' => $all,);
    }else{
      return array('resul' => 'autori', );
    }
  }

  public function DelecteBranch(Request $request){
    if (!Auth::guest() == false){ return array('resul' => 'login', );}
    $id = $request->id;
    $ip = DB::table("ip")->where('id_branch','=',$id)->select('id','type')
      ->get()->toArray();
    foreach ($ip as $value) {
      if ($value->type != 'SIN ASIGNAR') {
        return array('resul' => 'nop', );
      }
    }
    foreach ($ip as $val) {
      $note = Ip::find($val->id)->delete();
    }
    $sql_dele = Branch::find($id);
      $branch = $sql_dele->id_branch;
    $sql_dele->delete();
    return array('resul' => 'yes', 'datos' => $branch,);
  }
}
