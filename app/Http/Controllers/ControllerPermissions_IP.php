<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Branch;
use Jarvis\User;
use Jarvis\Permissions_IP;
use Jarvis\Group_IP;
use Jarvis\Http\Controllers\ControllerUser_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use DB;
class ControllerPermissions_IP extends Controller
{
	// -----------------Funcion para listar permiso ip---------------------------
	public function index(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(16);
      	if ($authori_status['permi'] >= 10) {
			$User = User::all();
			$Branch = Branch::all();
			return view('admin_ip.permiso_especial.list',compact('User','Branch'));
		}else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}	
	}

	public function index_list(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(16);
      	if ($authori_status['permi'] >= 10) {
			$permis = DB::table('permissions_ip')
			->join('users', 'users.id', '=', 'permissions_ip.id_user')
			->join('branch', 'branch.id', '=', 'permissions_ip.id_branch')
			->whereNull('permissions_ip.id_group_ip')
			->select('permissions_ip.id','permissions_ip.permissions', 'users.name', 'users.last_name', 'branch.name as branch', 'branch.ip_rank as ip');
	        return datatables()->of($permis)->make(true);
        }else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function permission($id_group, $branch = null){
		$user_group = DB::table("branch")
		->leftJoin('permissions_ip', 'branch.id', '=', 'permissions_ip.id_branch')
		->leftJoin('group_ip', 'group_ip.id', '=', 'permissions_ip.id_group_ip')
		->leftJoin('group_users', 'group_ip.id', '=', 'group_users.id_group_ip')
		->leftJoin('users', 'users.id', '=', 'group_users.id_user')
		->leftJoin('users', 'users.id', '=', 'permissions_ip.id_user')
		->where('group_ip.id', '=', $id_group)
		->where('branch.id', '=', $branch)
		->select('branch.name','branch.ip_rank','permissions_ip.permissions', 'branch.prefixes_rank')
		->get();
		if (count($user_group) > 0) {
			$resul = $user_group[0];
		}else{
			if ($branch != null) {
				$permissions = new Permissions_IP();
					$permissions->id_group_ip = $id_group;
					$permissions->id_branch = $branch;
					$permissions->permissions = 3;
			    $permissions->save();
			    $resul = $permissions;
			}else{
				$resul = 'nop';
			}
		}
		return $resul;
	}

	public function search_group_permi(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id=$_POST['id'];
		$Branch = DB::table("branch")->where('branch.rank', '=', 'No')
		->orwhere('branch.rank', '=', 'NO')->select('*')->get();
		$group = [];
		foreach ($Branch as $value) {
			if ($value->ip_rank != null) {
				$ip = $value->ip_rank;
			}else{
				$ip ='';
			}
			$user_group = ControllerPermissions_IP::permission($id, $value->id);
			if ($user_group != 'nop') {
				$group[] = array(
					'id' => $value->id, 
					'name' => $value->name.' '.$ip, 
					'permi' => $user_group->permissions, 
				);
			}else{
				$group[] = array(
					'id' => $value->id, 
					'name' => $value->name.' '.$ip, 
					'permi' => '3', 
				);
			}
		}
	    return array('resul' => 'yes', 'datos' => $group,);
	}

	public function store_update(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
			$id =$_POST['id']; 
			$permi =$_POST['permi']; 
			foreach ($permi as $key) {
				$separar = explode('_', $key);
				$permiss_group = DB::table("permissions_ip")
					->where('permissions_ip.id_group_ip', '=', $id)
					->where('permissions_ip.id_branch', '=', $separar[0])
					->select('permissions_ip.id')->get();
				if (count($permiss_group) > 0) {
					$permissions = Permissions_IP::find($permiss_group[0]->id);
				}else{
					$permissions = new Permissions_IP();
						$permissions->id_group_ip = $id;
						$permissions->id_user = null;
				}
				    $permissions->id_branch = $separar[0];
				    $permissions->permissions = $separar[1];
		      	$permissions->save();
				$branch_rank = DB::table("branch")
					->where('branch.rank', '=', 'Si')
					->where('branch.id_branch', '=', $separar[0])
					->select('branch.id')->get();
				foreach ($branch_rank as $value) {
					$permiss_group_exis = DB::table("permissions_ip")
						->where('permissions_ip.id_group_ip', '=', $id)
						->where('permissions_ip.id_branch', '=', $value->id)
						->select('permissions_ip.id')->get();
					if (count($permiss_group_exis) > 0) {
						$permissions_rank = Permissions_IP::find($permiss_group_exis[0]->id);
					}else{
						$permissions_rank = new Permissions_IP();
							$permissions_rank->id_group_ip = $id;
					    	$permissions_rank->id_branch = $value->id;
					}
					    $permissions_rank->permissions = $separar[1];
			      	$permissions_rank->save();
				}
			}				
	      	$data = array('resul' => 'yes',);
	      	return $data;
	}

	public function store_update_especial(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$id =$_POST['id'];
		$user =$_POST['user'];
		$rama =$_POST['rama'];
		$permi_new =$_POST['permi_new'];
		if($id != 0){
			$permi = Permissions_IP::find($id);
		}else{
			$permi = new Permissions_IP();
				$permi->id_group_ip = null;
				$permi->id_user = $user;
				$permi->id_branch = $rama;
		}	    
		   	$permi->permissions = $permi_new;
		$permi->save();
		$data = array('resul' => 'yes',);
		return $data;
	}

	public function search_permiss(){
		$id =$_POST['id'];
		$permi = Permissions_IP::find($id);
		$datos = array(
			'id_user' => $permi->id_user,
			'permissions' => $permi->permissions,
			'id_branch' => $permi->id_branch, 
		);
		$data = array('resul' => 'yes', 'datos' => $datos);
		return $data;
	}
}



