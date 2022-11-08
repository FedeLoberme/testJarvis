<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Jarvis\User;
use Jarvis\Group_IP;
use Jarvis\Http\Controllers\ControllerUser_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use DB;
class ControllerGroup_IP extends Controller
{
    // -----------------Funcion para listar grupo ip---------------------------
	public function index(){
		if (!Auth::guest() == false){
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(16);
      	if ($authori_status['permi'] >= 10) {
			return view('admin_ip.grupo.list');
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
              //fix
            if(DB::table('group_ip')->where('name', 'AGERGACION IP')->first()){
                DB::table('group_ip')->where('name', 'AGERGACION IP')->update([
                   'name' => 'AGREGACIÓN IP'
                ]);
            }
            //fix
			$group = DB::table('group_ip')->select('*');

        	return datatables()->of($group)->make(true);
		}else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function insert_update_group(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$name=$_POST['name'];
		$id=$_POST['id'];
        if ($id != 0){
        	$group = Group_IP::find($id);
        }else{
        	$group = new Group_IP();
        }
        $group->name = $name;
	    $group->save();
	    return array('resul' => 'yes',);
	}

	public function search_group(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id=$_POST['id'];
		$group = Group_IP::find($id);
		$dato = array('name' =>$group->name ,);
        return $dato;
	}
}
