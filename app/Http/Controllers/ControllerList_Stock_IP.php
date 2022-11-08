<?php
namespace Jarvis\Http\Controllers;
use Jarvis\Http\Controllers\ControllerUser_history;
use Illuminate\Support\Facades\Validator;
use Jarvis\Http\Requests\RequestStockIP;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Jarvis\List_Stock_IP;
use Carbon\Carbon;
use Jarvis\User;
use Session;
use DB;

class ControllerList_Stock_IP extends Controller
{
    // -----------------Funcion para listar IP---------------------------
	public function index(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
    	$autori_status = User::authorization_status(16);
    	if ($autori_status['permi'] >= 10){
  			return view('admin_ip.stock.list',compact('autori_status'));
    	}else{
      		return array('resul' => 'autori', );
    	}
	}

	public function index_list(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(16);
		if ($authori_status['permi'] >= 10) {
			$stock = List_Stock_IP::all(['id', 'rank', 'status', 'use'])->sortBy('rank');
      		return datatables()->of($stock)->make(true);
    	}else{
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function search(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$autori_status = User::authorization_status(16);
		if ($autori_status['permi'] >= 3){
			$id = $_POST['id'];
			$ip = List_Stock_IP::find($id, ['rank','status','use']);
			return array('resul' => 'yes', 'datos' => $ip,);
		}else{
      		return array('resul' => 'autori', );
      	}
	}

	public function insert_update_stock_ip(RequestStockIP $request){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$autori_status = User::authorization_status(16);
		if ($autori_status['permi'] >= 10){
			$id = $request->id;
			$ip = $request->ip;
			$use = $request->use;
			$status = strtoupper($request->status);
			$validar = explode('.', $ip);
			$cantidad = count($validar);
			if ($cantidad > 4 || $cantidad < 3) {
				return array('resul' => 'error');
			}
			foreach ($validar as $value) {
				if ($value > 255) {
					return array('resul' => 'error');
				}
			}
			if ($cantidad == 3) {
				$ip = $ip.'.0';
			}
			$val_exist = DB::table('list_stock_ip') 
                ->where('rank', '=', $ip)
                ->where('status', '!=', 'OCUPADO')
                ->where('id', '!=', $id)
				->select('id')->get(); 
			if (count($val_exist) > 0) {
				return array('resul' => 'exist');
			}
			if ($id != 0) {
	      		$msj_equip = 'Modifico el Rango: ';
				$ip_sql = List_Stock_IP::find($id);
				if ($ip_sql->status === 'OCUPADO') {
					return array('resul' => 'nop');
				}
			}else{
				$msj_equip = 'Registro el Rango: ';
				$ip_sql = new List_Stock_IP();
			}
				$ip_sql->rank = $ip;
		        $ip_sql->status = $status;
		        $ip_sql->use = $use;
	      	$ip_sql->save();
			ControllerUser_history::store($msj_equip.$ip);
			return array('resul' => 'yes');
		}else{
      		return array('resul' => 'autori');
      	}
	}

	public function list_select(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(16);
		if ($authori_status['permi'] >= 10) {
			$stock = List_Stock_IP::all(['id', 'rank', 'status', 'use'])->sortBy('rank')->where('status','=', 'VACANTE');
      		return datatables()->of($stock)->make(true);
    	}else{
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
	}
}
