<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Jarvis\Branch;
use Jarvis\User;
use Jarvis\Group_IP;
use Jarvis\Group_Users;
use Jarvis\Http\Controllers\ControllerUser_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use DB;
class ControllerGroup_Users extends Controller
{
    public function search_group_user(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id = $_POST['id'];
		$group = Group_IP::find($id, ['name']);
		$group_sin_asignar = ControllerGroup_Users::user_sin_group();
		$group_asignado = ControllerGroup_Users::user_group($id);
	    return array(
	    	'resul' => 'yes', 
	    	'derecha' => $group_sin_asignar, 
	    	'izquierda' => $group_asignado, 
	    	'group' => $group->name
	    );
	}

	public function user_group($id_group){
		$user_group = DB::table("group_users")
		->join('users', 'group_users.id_user', '=', 'users.id')
		->where('group_users.id_group_ip', '=', $id_group)
		->where('users.username', '!=', 'ADMIN_JARVIS')
		->select('group_users.id','users.name','users.last_name')
		->get();
		return $user_group;
	}

	public function user_sin_group(){
		$sin_group = DB::table("users")->select('users.id', 'users.name','users.last_name')
        ->where('users.status', '=', 1)
        ->where('users.username', '!=', 'ADMIN_JARVIS')
        ->whereNotIn('users.id',function($query) {
        $query->select('id_user')->from('group_users');})->get();
		return $sin_group;
	}

	public function store(){
		$user = $_POST['user'];
		$group = $_POST['group'];
		$user_new = new Group_Users();
			$user_new->id_group_ip = $group;
			$user_new->id_user = $user;
		$user_new->save();
		return array('resul' => 'yes', );
	}

	public function delete_user(){
		$id = $_POST['id'];
		$Users = Group_Users::find($id);
			$Group = $Users->id_group_ip;
        $Users->delete();
        return array('resul' => 'yes', 'id' => $Group,);
	}
}
