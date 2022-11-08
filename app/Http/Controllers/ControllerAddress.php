<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Address;
use Jarvis\Constants;
use Jarvis\User;
use Jarvis\Client;
use Jarvis\Equipment_Model;
use Jarvis\List_Service_Type;
use Jarvis\List_Countries;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Jarvis\Http\Requests\RequestAddress;
use Jarvis\Http\Controllers\ControllerEquipment_Model;
use Jarvis\Http\Controllers\ControllerUser_history;
use DB;
use Carbon\Carbon;
class ControllerAddress extends Controller
{
	// -----------------Funcion para listar dirrecones---------------------------
	public function index(){
		if (!Auth::guest() == false){
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_DIRECCION);
		if ($authori_status['permi'] >= 3) {
			$pais = List_Countries::all(['id', 'name'])->sortBy('name');
			$list_service = List_Service_Type::all(['id', 'name'])->sortBy('name');
			$equipment = Equipment_Model::List();
			$bw = $equipment['bw'];
			return view('direccion.list',compact('authori_status', 'pais','list_service','bw'));
		}else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function index_list(){
		if (!Auth::guest() == false){
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(14);
		if ($authori_status['permi'] >= 3) {
			$direccion = DB::table('address')
				->join('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
				->join('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
				->select('address.id', 'list_countries.name as countries', 'list_provinces.name as provinces', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code')
				->orderBy('countries', 'asc');
        	return datatables()->of($direccion)->make(true);
        }else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

    public function insert_update_address(RequestAddress $request){
    	if(!Auth::guest() == false){ return array('resul' => 'login', );}
    	$authori_status = User::authorization_status(14);
		if ($authori_status['permi'] >= 3) {
	    	$id = $request->input('id');
	    	$countries = $request->input('pais');
			$provinces = $request->input('provin');
			$location = $request->input('local');
			$street = $request->input('calle');
			$height = $request->input('altura');
			$floor = $request->input('piso');
			$department = $request->input('apartamento');
			$postal_code = $request->input('postal');
			$direccion = DB::table('address')
				->where('address.id_provinces', '=', $provinces)
				->where('address.location', '=', $location)
				->where('address.street', '=', $street)
				->where('address.height', '=', $height)
				->where('address.floor', '=', $floor)
				->where('address.department', '=', $department)
				->where('address.postal_code', '=', $postal_code)
				->where('address.id', '!=', $id)
			->select('address.id')->get();
			if (count($direccion) == 0) {
				if ($id != 0) {
	    			$direc =Address::find($id);
	    			$msj_historial = 'Modifico dirección';
		    	}else{
		    		$direc = new Address();
		    		$msj_historial = 'Registro dirección';
		    	}
	        	$direc->id_provinces = $provinces;
	        	$direc->location = $location;
	        	$direc->street = $street;
	        	$direc->height = $height;
	        	$direc->floor = $floor;
	        	$direc->department = $department;
	        	$direc->postal_code = $postal_code;
				$direc->save();
				ControllerUser_history::store($msj_historial);
				$direcc = ControllerAddress::all_address();
				$resul = 'yes';
			}else{
				$resul = 'no';
				$direcc = '';
			}
	    	return array('resul' => $resul, 'datos' => $direcc );
		}else{
			return array('resul' => 'autori', );
		}
    }

    public function search_address(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id = $_POST['id'];
      	$authori_status = User::authorization_status(14);
      	if ($authori_status['permi'] >= 3) {
          	$direc = DB::table('address')
				->join('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
				->where('address.id', '=', $id)
				->select('address.id', 'list_provinces.id_countries', 'list_provinces.id as provinces', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code')->get();
        	return array( 'resul'=> 'yes', 'datos'=> $direc[0],);
      	}else{
        	return array('resul' => 'autori', );
      	}
	}

	public static function all_address(){
		$direccion = DB::table('address')
				->join('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
				->join('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
				->select('address.id', 'list_countries.name as countries', 'list_provinces.name as provinces', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code')
				->orderBy('countries', 'asc')->get();
		if (count($direccion)>0) {
				foreach ($direccion as $value) {
					$direcc[] = array(
						'id' => $value->id,
						'direccion' => $value->countries.' '.$value->provinces.' '.$value->location.' '.$value->street.' '.$value->height.' '.$value->floor.' '.$value->department.' '.$value->postal_code,
					);
				}
		}else{
			$direcc[] = array(
					'id' => 0,
					'direccion' => '',
			);
		}
		return $direcc;
	}

	public function address_content_search($id){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$authori_status = User::authorization_status(14);
      	if ($authori_status['permi'] >= 3) {
      		$data = [];
      		$service = DB::table('service')
      			->leftJoin('client', 'service.id_client', '=', 'client.id')
      			->leftJoin('list_service_type', 'service.id_type', '=', 'list_service_type.id')
      			->leftJoin('service_port', 'service_port.id_service', '=', 'service.id')
      			->leftJoin('lacp_port', 'service_port.id_lacp_port', '=', 'lacp_port.id')
      			->leftJoin('port', 'port.id_lacp_port', '=', 'lacp_port.id')
      			->leftJoin('board', 'port.id_board', '=', 'board.id')
      			->leftJoin('equipment', 'board.id_equipment', '=', 'equipment.id')
      			->where('service.id_address_a', '=', $id)
      			->orWhere('service.id_address_b', '=', $id)
      			->Where('service.status', '=', 'ALTA')
				->select('service.number','service.bw_service' , 'client.business_name', 'client.acronimo', 'equipment.acronimo as equipment', 'list_service_type.name', 'equipment.id')->groupby('service.number','service.bw_service' , 'client.business_name', 'client.acronimo', 'equipment.acronimo', 'list_service_type.name', 'equipment.id')->get();
				foreach ($service as $value) {
					$bw = ControllerEquipment_Model::format_bw($value->bw_service);
					$data[] = array(
						'number' => $value->number,
						'business_name' => $value->business_name,
						'acronimo' => $value->acronimo,
						'equipment' => $value->equipment,
						'name' => $value->name,
						'bw' => $bw['data'].' '.$bw['signo'],
						'id' => $value->id,
					);
				}
			return datatables()->of($data)->make(true);
      	}else{
        	return array('resul' => 'autori',);
      	}
	}

	public function list_provinces_sele(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id=$_POST['id'];
		$data = DB::table('list_provinces')
			->where('list_provinces.id_countries', '=', $id)
			->select('list_provinces.name', 'list_provinces.id')->get();
		return array( 'resul'=> 'yes', 'datos' => $data);
	}

	public static function address_selec(){
		if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$authori_status = User::authorization_status(14);
      	if ($authori_status['permi'] >= 3) {
			$id = $_POST['id'];
			$direccion = DB::table('address')
				->join('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
				->join('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
				->where('address.id', '=', $id)
				->select('address.id', 'list_countries.name as countries', 'list_provinces.name as provinces', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code')
					->orderBy('countries', 'asc')->get();
			if (count($direccion) > 0) {
				$direcc = $direccion[0]->countries.' '.$direccion[0]->provinces.' '.$direccion[0]->location.' '.$direccion[0]->street.' '.$direccion[0]->height.' '.$direccion[0]->floor.' '.$direccion[0]->department;
				$resul = array('resul' => 'yes', 'datos' => $direcc,);
			}else{
				$resul = array('resul' => 'nop', );
			}
			return $resul;
		}else{
        	return array('resul' => 'autori',);
      	}
	}
}



