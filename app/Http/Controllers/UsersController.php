<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Jarvis\Constants;
use Jarvis\User;
use Jarvis\Profile;
use Jarvis\User_history;
use Jarvis\Http\Controllers\ControllerUser_history;
use Jarvis\Http\Controllers\ConnectionLDAP;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use DB;

class UsersController extends Controller
{
	public static function store($name, $last_name, $email, $username, $img, $workgroup, $department, $password, $profil){
		$users = new User();
		  $users->name = $name;
		  $users->last_name = $last_name;
		  $users->username = $username;
		  $users->password = bcrypt($password);
		  $users->email = $email;
		  $users->url_img = $img;
		  $users->remember_token='Oa7WsF0Z1t5X7FZVZZqlDRAmiPlS8ku9v6TB4C68xhmuQ2ey6ySVEDuljAr0';
		  $users->workgroup = $workgroup;
		  $users->department = $department;
		  $users->fin_login = null;
		  $users->id_profile = $profil;
	    $users->save();
	}
// ------------Funcion para actualizar datos del usuario----------------------
	public static function update($id, $name, $last_name, $img, $workgroup, $department, $password){
		$users = User::find($id);
		    $users->name = $name;
		    $users->password = bcrypt($password);
		    $users->url_img = $img;
		    $users->workgroup = $workgroup;
		    $users->department = $department;
		    $users->fin_login = null;
	    $users->save();
	}

// ------------Funcion para registrarel cierre de sesion de usuario----------------------
	public static function fin_login(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_USER);
		if ($authori_status['permi'] >= 5){
			$id=$_POST['id'];
			$id_admin = Auth::user()->id;
		    if ($id_admin <> $id) {
		    	$users = User::find($id);
			    	$users->fin_login = Carbon::now();
		    	$users->save();
		    	$sesion = $users->session_id;
	            \Session::getHandler()->destroy($sesion);
	        	ControllerUser_history::store('expulso del sistema al usuario '.$users->name. ' '. $users->last_name);
	        	$resul = 'yes';
		    }else{
		    	$resul = 'nop';
		    }
		}else{
		   	$resul = 'autori';
		}
	    return array('resul' => $resul, );
	}

// -----------------Funcion para listar usuario---------------------------
	public function index(){
		if (!Auth::guest() == false){ return redirect('login')
			->withErrors([Lang::get('validation.login'),]);}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_USER);
		if ($authori_status['permi'] >= 3){
			return view('users.list',compact('authori_status'));
		}else{
			return redirect('home')
            ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

// -----------------Funcion para listar usuario---------------------------
	public function index_list(){
		if (!Auth::guest() == false){ return redirect('login')
			->withErrors([Lang::get('validation.login'),]);}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_USER);
		if ($authori_status['permi'] >= 3){
			$datos = [];
			$users = DB::table('users')
			->Join('profile', 'profile.id', '=', 'users.id_profile')
			->leftJoin('group_users', 'users.id', '=', 'group_users.id_user')
			->leftJoin('group_ip', 'group_ip.id', '=', 'group_users.id_group_ip')
			->where('users.username', '!=', 'ADMIN_JARVIS')
			->select('users.name', 'users.username', 'users.last_name', 'users.email', 'users.status', 'users.workgroup', 'users.fin_login', 'profile.name as profile', 'group_ip.name as group', 'users.id', 'users.updated_at')->orderBy('users.fin_login', 'desc')->get();
			foreach ($users as $value) {
				$status = 'Activado';
				if ($value->status != 1) {
					$status = 'Desactivado';
				}
				$datos[] = array(
					'name' => $value->name.' '.$value->last_name,
					'email' => $value->email,
					'workgroup' => $value->workgroup,
					'fin' => $value->fin_login,
					'inicio' => $value->updated_at,
					'profile' => $value->profile,
					'group' => $value->group,
					'status' => $status,
					'group' => $value->group,
					'id' => $value->id,
				);
			}
        	return datatables()->of($datos)->make(true);
     	}else{
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
	}
// -----------------Funcion para desactivar usuario---------------------------
	public function deactivate(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_USER);
		if ($authori_status['permi'] >= 5) {
			$id=$_POST['id'];
			$id_admin = Auth::user()->id;
			$Validar = User::find($id);
		    if ($id_admin != $id && $Validar->username != 'ADMIN_JARVIS') {
		    	$users = User::find($id);
					$users->status = 0;
				$users->save();
				ControllerUser_history::store('Desactivo al usuario '.$users->name. ' '. $users->last_name);
				$resul = 'yes';
		    }else{
		    	$resul = 'nop';
		    }
		}else{
		   	$resul = 'autori';
		}
	    return array('resul' => $resul,);
	}

// -----------------Funcion para activar usuario---------------------------
	public function activate(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_USER);
		if ($authori_status['permi'] >= 5) {
			$id=$_POST['id'];
			$users = User::find($id);
			    $users->status = 1;
		    $users->save();
		    ControllerUser_history::store('Activo al usuario '.$users->name. ' '. $users->last_name);
			$resul = 'yes';
		}else{
		   	$resul = 'autori';
		}
	    return array('resul' => $resul,);
	}
// ------Funcion para la vista de  modificar perfil de usuario-----
	public function profile($id){
		if (!Auth::guest() == false){ return redirect('login')
			->withErrors([Lang::get('validation.login'),]);}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_USER);
		$users = User::find($id);
		if ($authori_status['permi'] >= 5 && $users->username != 'ADMIN_JARVIS') {
			$users = User::find($id);
			$prof = User::profil_name_permi($users->id_profile, $users->id);
			$profile = Profile::all();
			return view('users.edit_profile',compact('users','profile', 'prof'));
		}else{
			return 	redirect('home')
                	->withErrors([Lang::get('validation.authori_status'),]);
		}
	}
// ----------Funcion para modificar perfil de usuario--------------
	public function update_profile(Request $request){
		if (!Auth::guest() == false){ return redirect('login')
			->withErrors([Lang::get('validation.login'),]);}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_USER);
		$Validar = User::find($request->id);
		if ($authori_status['permi'] >= 5 && $Validar->username != 'ADMIN_JARVIS') {
			$users = User::find($request->id);
				$old_profil= $users->id_profile;
			    $users->id_profile = $request->perfil;
		    $users->save();
		    $profil_old= Profile::find($old_profil);
		    $profil_new= Profile::find($request->perfil);
		    ControllerUser_history::store('Cambio de perfil al usuario '.$users->name. ' '. $users->last_name. ' de perfil '. $profil_old->name . ' a '. $profil_new->name);

		    $notification = array(
                'message' => trans('validation.msj.update'),
                'alert-type' => 'success'
            );
            return redirect('ver/usuario')->with($notification);
	    }else{
			return 	redirect('home')
                	->withErrors([Lang::get('validation.authori_status'),]);
		}
	}
// ----------Funcion para bucar todo los permiso del perfil--------------
	public static function authori(){
		if (!Auth::guest() == false){ return redirect('login')
			->withErrors([Lang::get('validation.login'),]);
		}else{
			$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_USER);
			$Perfil = User::authorization_status(Constants::APPLICATION_TYPE_PERFIL);
			$Historial = User::authorization_status(Constants::APPLICATION_TYPE_HISTORIAL);
			$Clientes = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
			$Modelo = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
			$Puerto = User::authorization_status(6);
			$AGG = User::authorization_status(7);
			$CPE = User::authorization_status(8);
			$PE = User::authorization_status(9);
			$Nodo = User::authorization_status(10);
			$Anillo = User::authorization_status(11);
			$Uplin = User::authorization_status(12);
			$LanSwitch = User::authorization_status(13);
			$Direccion = User::authorization_status(14);
			$Servivio = User::authorization_status(15);
			$IP = User::authorization_status(16);
			$Importar = User::authorization_status(17);
			$Lista = User::authorization_status(18);
			$Dm = User::authorization_status(19);
			$Pei = User::authorization_status(20);
			$APN = User::authorization_status(21);
			$CADENA = User::authorization_status(22);
			$RADIO = User::authorization_status(23);
			$LINK = User::authorization_status(24);
			$Reservas = User::authorization_status(25);
			$Uplink_ipran = User::authorization_status(26);
			$sar = User::authorization_status(27);
			$Vlan_Rangos = User::authorization_status(28);
			$Frontera = User::authorization_status(29);
			$Asociacion_Agg = User::authorization_status(30);
			$Ledzite = User::authorization_status(31);
			$authori = array(
				'Usuarios' => $authori_status['permi'],
				'Perfil' => $Perfil['permi'],
				'Historial' => $Historial['permi'],
				'Clientes' => $Clientes['permi'],
				'Modelo' => $Modelo['permi'],
				'Puerto' => $Puerto['permi'],
				'AGG' => $AGG['permi'],
				'CPE' => $CPE['permi'],
				'PE' => $PE['permi'],
				'Nodo' => $Nodo['permi'],
				'Anillo' => $Anillo['permi'],
				'Uplin' => $Uplin['permi'],
				'LanSwitch' => $LanSwitch['permi'],
				'Direccion' => $Direccion['permi'],
				'Servivio' => $Servivio['permi'],
				'ip' => $IP['permi'],
				'Importar' => $Importar['permi'],
				'Lista' => $Lista['permi'],
				'Dm' => $Dm['permi'],
				'Pei' => $Pei['permi'],
				'APN' => $APN['permi'],
				'CADENA' => $CADENA['permi'],
				'RADIO' => $RADIO['permi'],
				'LINK' => $LINK['permi'],
				'Reservas' => $Reservas['permi'],
				'Uplink_ipran' => $Uplink_ipran['permi'],
				'SAR' => $sar['permi'],
				'Vlan_Rangos' => $Vlan_Rangos['permi'],
				'Frontera' => $Frontera['permi'],
				'Asociacion_Agg' => $Asociacion_Agg['permi'],
				'Ledzite' => $Ledzite['permi'],
			);
			return $authori;
		}
	}
// ----------Funcion para redirecionar si esta logueado--------------
	public static function authori_login(){
		if (!Auth::guest() == false){
			return redirect('login');
		}else{
			return redirect('/home');
		}
	}
// ----------Funcion para saber si esta tiene una seccion abierta--------------
	public function consul(){
    	$username=$_POST['username'];
    	$pass=$_POST['password'];
		@$validation_users = ConnectionLDAP::Ldap($username, $pass);
		switch ($validation_users['exists']) {
		 	case '10':
		 		$users=DB::table('users')->select('id', 'fin_login')->where('USERNAME', '=', $username)->get();
            if (count($users) > 0){
                if ($users[0]->fin_login == null) {
					$datos = array('resul' => $users[0]->id, );
            	}else{
					$datos = array('resul' => 'nop', );
            	}
            }else{
				$datos = array('resul' => 'sin', );
            }
		 	break;
		 	case '30':
		 		$datos = array('resul' => 'nada', );
		 	break;
		 	case '50':
		 		$datos = array('resul' => 'connection', );
		 	break;
		}
		if ($username == 'ADMIN_JARVIS') {
		 	$datos = array('resul' => 'nop', );
		}
		return $datos;
	}

	public function authori_ajax(){
		if (!Auth::guest() == false){ return redirect('login')
			->withErrors([Lang::get('validation.login'),]);}
    	$cod=$_POST['cod'];

		$authori_status = User::authorization_status($cod);

		$authori = array(
			'permiso' => $authori_status['permi'],
		);
		return $authori;
	}
}

