<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Jarvis\Constants;
use Session;
use DB;
use Jarvis\Equipment_Model;
use Jarvis\List_Equipment;
use Jarvis\List_Electrical_Power;
use Jarvis\List_Mark;
use Jarvis\List_Radio;
use Jarvis\List_Band;
use Jarvis\List_Connector;
use Jarvis\List_Label;
use Jarvis\List_Module_Board;
use Jarvis\List_Port;
use Jarvis\List_Down;
use Jarvis\Equipment_Location;
use Jarvis\User;
use Jarvis\List_Status_IP;
use Jarvis\List_Countries;
use Jarvis\List_Provinces;
use Jarvis\List_Service_Type;
use Jarvis\List_Type_Link;
use Jarvis\Http\Controllers\ControllerUser_history;
class ControllerList_select extends Controller
{
    public function store(){
    	if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		  // if ($autori_status['permi'] >= 10){
	    	$table=$_POST['table'];
        $name=$_POST['name'];
	    	$id=$_POST['id'];
        $pais=$_POST['pais'];
        $data = [];
	    	switch ($table){
		        case 1:
              if ($id <> 0){
                $Equipment= DB::table('list_equipment')
                ->where('list_equipment.name', '=', $name)
                ->where('list_equipment.id', '!=', $id)
                ->select('list_equipment.id')->get();
              }else{
                $Equipment= DB::table('list_equipment')
                ->where('list_equipment.name', '=', $name)
                ->select('list_equipment.id')->get();
              }
      				if (count($Equipment) > 0) {
      					return  array('resul' => 'exist',);
      				}else{
      					$msj = ControllerList_select::equipment($name, $id);
		        		$resul = DB::table('list_equipment')
      				->select('list_equipment.id','list_equipment.name')->orderBy('name', 'asc')->get();
      				}
		        break;
		        case 2:
              if ($id <> 0){
                $mark= DB::table('list_mark')
                ->where('list_mark.name', '=', $name)
                ->where('list_mark.id', '!=', $id)
                ->select('list_mark.id')->get();
              }else{
                $mark= DB::table('list_mark')
                ->where('list_mark.name', '=', $name)
                ->select('list_mark.id')->get();
              }
      				if (count($mark) > 0) {
      					return  array('resul' => 'exist',);
      				}else{
			        	$msj = ControllerList_select::mark($name, $id);
		    			$resul = DB::table('list_mark')
      				->select('list_mark.id','list_mark.name')->orderBy('name', 'asc')->get();
	    			}
		        break;
		        case 3:
              if ($id <> 0){
                $electrical= DB::table('list_electrical_power')
                ->where('list_electrical_power.name', '=', $name)
                ->where('list_electrical_power.id', '!=', $id)
                ->select('list_electrical_power.id')->get();
              }else{
                $electrical= DB::table('list_electrical_power')
                ->where('list_electrical_power.name', '=', $name)
                ->select('list_electrical_power.id')->get();
              }
      				if (count($electrical) > 0) {
      					return  array('resul' => 'exist',);
      				}else{
			        	$msj = ControllerList_select::electrical($name, $id);
	      				$resul = DB::table('list_electrical_power')
      				->select('list_electrical_power.id','list_electrical_power.name')->orderBy('name', 'asc')->get();
      				}
		        break;
		        case 4:
              if ($id <> 0){
                $radio= DB::table('list_radio')
                ->where('list_radio.name', '=', $name)
                ->where('list_radio.id', '!=', $id)
                ->select('list_radio.id')->get();
              }else{
                $radio= DB::table('list_radio')
                ->where('list_radio.name', '=', $name)
                ->select('list_radio.id')->get();
              }
      				if (count($radio) > 0) {
      					return  array('resul' => 'exist',);
      				}else{
			        	$msj = ControllerList_select::radio($name, $id);
	      				$resul = DB::table('list_radio')
      				->select('list_radio.id','list_radio.name')->orderBy('name', 'asc')->get();
      				}
		        break;
		        case 5:
              if ($id <> 0){
                $band= DB::table('list_band')
                ->where('list_band.name', '=', $name)
                ->where('list_band.id', '!=', $id)
                ->select('list_band.id')->get();
              }else{
                $band= DB::table('list_band')
                ->where('list_band.name', '=', $name)
                ->select('list_band.id')->get();
              }
      				if (count($band) > 0) {
      					return  array('resul' => 'exist',);
      				}else{
			        	$msj = ControllerList_select::band($name, $id);
	      				$resul = DB::table('list_band')
      				->select('list_band.id','list_band.name')->orderBy('name', 'asc')->get();
      				}
		        break;
		        case 6:
              if ($id <> 0){
                $band= DB::table('list_module_board')
                ->where('list_module_board.name', '=', $name)
                ->where('list_module_board.id', '!=', $id)
                ->select('list_module_board.id')->get();
                $validar= DB::table('list_module_board')
                ->join('port_equipment_model', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
                ->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->where('list_module_board.id', '=', $id)
                ->select('list_module_board.id')->get();
                if (count($validar)>0) {
                  return  array('resul' => 'utilizando',);
                }
              }else{
                $band= DB::table('list_module_board')
              ->where('list_module_board.name', '=', $name)
              ->select('list_module_board.id')->get();
              }
      				if (count($band) > 0) {
      					return  array('resul' => 'exist',);
      				}else{
			        	$msj = ControllerList_select::m_placa($name, $id);
	      				$resul = DB::table('list_module_board')
      				->select('list_module_board.id','list_module_board.name')->orderBy('name', 'asc')->get();
      				}
		        break;
		        case 7:
              if ($id <> 0){
                $band= DB::table('list_port')
                ->where('list_port.name', '=', $name)
                ->where('list_port.id', '!=', $id)
                ->select('list_port.id')->get();
              }else{
                $band= DB::table('list_port')
                ->where('list_port.name', '=', $name)
                ->select('list_port.id')->get();
              }
      				if (count($band) > 0) {
      					return  array('resul' => 'exist',);
      				}else{
			        	$msj = ControllerList_select::type_port($name, $id);
	      				$resul = DB::table('list_port')
      				->select('list_port.id','list_port.name')->orderBy('name', 'asc')->get();
      				}
		        break;
		        case 8:
              if ($id <> 0){
                $band= DB::table('list_connector')
                ->where('list_connector.name', '=', $name)
                ->where('list_connector.id', '!=', $id)
                ->select('list_connector.id')->get();
              }else{
                $band= DB::table('list_connector')
                ->where('list_connector.name', '=', $name)
                ->select('list_connector.id')->get();
              }
      				if (count($band) > 0) {
      					return  array('resul' => 'exist',);
      				}else{
			        	$msj = ControllerList_select::conector($name, $id);
	      				$resul = DB::table('list_connector')
      				->select('list_connector.id','list_connector.name')->orderBy('name', 'asc')->get();
      				}
		        break;
		        case 9:
              if ($id <> 0){
                $band= DB::table('list_label')
                ->where('list_label.name', '=', $name)
                ->where('list_label.id', '!=', $id)
                ->select('list_label.id')->get();
              }else{
                $band= DB::table('list_label')
                ->where('list_label.name', '=', $name)
                ->select('list_label.id')->get();
              }
      				if (count($band) > 0) {
      					return  array('resul' => 'exist',);
      				}else{
			        	$msj = ControllerList_select::label($name, $id);
	      				$resul = DB::table('list_label')
      				->select('list_label.id','list_label.name')->orderBy('name', 'asc')->get();
      				}
		        break;
            case 10:
              if ($id <> 0){
                $band= DB::table('list_status_ip')
                ->where('list_status_ip.name', '=', $name)
                ->where('list_status_ip.id', '!=', $id)
                ->select('list_status_ip.id')->get();
              }else{
                $band= DB::table('list_status_ip')
                ->where('list_status_ip.name', '=', $name)
                ->select('list_status_ip.id')->get();
              }
              if (count($band) > 0) {
                return  array('resul' => 'exist',);
              }else{
                $msj = ControllerList_select::list_status_IP($name, $id);
                $resul = DB::table('list_status_ip')
              ->select('list_status_ip.id','list_status_ip.name')->orderBy('name', 'asc')->get();
              }
            break;
            case 11:
              if ($id <> 0){
                $band= DB::table('list_countries')
                ->where('list_countries.name', '=', $name)
                ->where('list_countries.id', '!=', $id)
                ->select('list_countries.id')->get();
              }else{
                $band= DB::table('list_countries')
                ->where('list_countries.name', '=', $name)
                ->select('list_countries.id')->get();
              }
              if (count($band) > 0) {
                return  array('resul' => 'exist',);
              }else{
                $msj = ControllerList_select::list_pais($name, $id);
                $resul = DB::table('list_countries')
              ->select('list_countries.id','list_countries.name')->orderBy('name', 'asc')->get();
              }
            break;
            case 12:
              if ($id <> 0){
                $provin= DB::table('list_provinces')
                ->where('list_provinces.name', '=', $name)
                ->where('list_provinces.id_countries', '=', $pais)
                ->where('list_provinces.id', '!=', $id)
                ->select('list_provinces.id')->get();
              }else{
                $provin= DB::table('list_provinces')
                ->where('list_provinces.id_countries', '=', $pais)
                ->where('list_provinces.name', '=', $name)
                ->select('list_provinces.id')->get();
              }
              if (count($provin) > 0) {
                return  array('resul' => 'exist',);
              }else{
                $msj = ControllerList_select::list_provincia($name, $id, $pais);
                $resul = DB::table('list_provinces')
              ->select('list_provinces.id','list_provinces.name')->orderBy('name', 'asc')->get();
              }
            break;
            case 13:
              if ($id <> 0){
                $motivo= DB::table('list_down')
                ->where('list_down.name', '=', $name)
                ->where('list_down.id', '!=', $id)
                ->select('list_down.id')->get();
              }else{
                $motivo= DB::table('list_down')
                ->where('list_down.name', '=', $name)
                ->select('list_down.id')->get();
              }
              if (count($motivo) > 0) {
                return  array('resul' => 'exist',);
              }else{
                $msj = ControllerList_select::list_baja($name, $id);
                $resul = DB::table('list_down')
              ->select('list_down.id','list_down.name')->orderBy('name', 'asc')->get();
              }
            break;
            case 14:
              if ($id <> 0){
                $local= DB::table('equipment_location')
                ->where('equipment_location.name', '=', $name)
                ->where('equipment_location.id', '!=', $id)
                ->select('equipment_location.id')->get();
              }else{
                $local= DB::table('equipment_location')
                ->where('equipment_location.name', '=', $name)
                ->select('equipment_location.id')->get();
              }
              if (count($local) > 0) {
                return  array('resul' => 'exist',);
              }else{
                $msj = ControllerList_select::localizacion($name, $id);
                $resul = DB::table('equipment_location')
              ->select('equipment_location.id','equipment_location.name')->orderBy('name', 'asc')->get();
              }
            break;
            case 15:
              if ($id <> 0){
                $local= DB::table('list_type_links')
                ->where('list_type_links.name', '=', $name)
                ->where('list_type_links.id', '!=', $id)
                ->select('list_type_links.id')->get();
              }else{
                $local= DB::table('list_type_links')
                ->where('list_type_links.name', '=', $name)
                ->select('list_type_links.id')->get();
              }
              if (count($local) > 0) {
                return  array('resul' => 'exist',);
              }else{
                $msj = ControllerList_select::tipos_link($name, $id);
                $resul = DB::table('list_type_links')
              ->select('list_type_links.id','list_type_links.name')->orderBy('name', 'asc')->get();
              }


	      	}
	      	foreach ($resul as $value) {
	      		$data[] = array(
	      						'name' => $value->name,
	      						'id' => $value->id,
		      				);
	      	}
          ControllerUser_history::store($msj);
	      	return array('resul' => 'yes', 'datos' => $data,);
      	// }else{
      	// 	return array('resul' => 'autori', );
      	// }
    }

    public function equipment($name, $id){
      if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de equipo";
        $equipo = List_Equipment::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de equipo";
        $equipo = new List_Equipment();
      }
			 $equipo->name = $name;
		  $equipo->save();
		return $msj;
    }

    public function mark($name, $id){
    	if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de marca";
        $mark = List_Mark::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de marca";
        $mark = new List_Mark();
      }
			 $mark->name = $name;
		  $mark->save();
		return $msj;
    }

    public function electrical($name, $id){
    	if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de alimentación";
        $electrical = List_Electrical_Power::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de alimentación";
        $electrical = new List_Electrical_Power();
      }
			 $electrical->name = $name;
		  $electrical->save();
		return $msj;
    }

    public function band($name, $id){
    	if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de banda";
        $band = List_Band::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de banda";
        $band = new List_Band();
      }
			 $band->name = $name;
		  $band->save();
		return $msj;
    }

    public function radio($name, $id){
    	if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de radio";
        $radio = List_Radio::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de radio";
        $radio = new List_Radio();
      }
			 $radio->name = $name;
		  $radio->save();
		return $msj;
    }

    public function m_placa($name, $id){
    	if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de modelo de placa";
        $m_placa = List_Module_Board::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de modelo de placa";
        $m_placa = new List_Module_Board();
      }
			 $m_placa->name = $name;
		  $m_placa->save();
		return $msj;
    }

    public function type_port($name, $id){
    	if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de tipo de puerto";
        $type_port = List_Port::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de tipo de puerto";
        $type_port = new List_Port();
      }
			 $type_port->name = $name;
		  $type_port->save();
		return $msj;
    }

    public function conector($name, $id){
    	if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de conector";
        $conector = List_Connector::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de conector";
        $conector = new List_Connector();
      }
			 $conector->name = $name;
		  $conector->save();
		return $msj;
    }

    public function label($name, $id){
    	if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de etiqueta";
        $label = List_Label::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de etiqueta";
        $label = new List_Label();
      }
			 $label->name = $name;
		  $label->save();
		return $msj;
    }

    public function list_status_IP($name, $id){
      if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de estado de IP";
        $label = List_Status_IP::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de estado de IP";
        $label = new List_Status_IP();
      }
       $label->name = $name;
      $label->save();
    return $msj;
    }

    public function list_pais($name, $id){
      if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de paises";
        $label = List_Countries::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de paises";
        $label = new List_Countries();
      }
       $label->name = $name;
      $label->save();
    return $msj;
    }

    public function list_provincia($name, $id, $pais){
      if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de provincia";
        $label = List_Provinces::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de provincia";
        $label = new List_Provinces();
        $label->id_countries = $pais;
      }
       $label->name = $name;
      $label->save();
    return $msj;
    }

    public function list_baja($name, $id){
      if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de motivo de baja";
        $baja = List_Down::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de motivo de baja";
        $baja = new List_Down();
      }
       $baja->name = $name;
      $baja->save();
    return $msj;
    }

    public function localizacion($name, $id){
      if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de localización";
        $local = Equipment_Location::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de localización";
        $local = new Equipment_Location();
      }
       $local->name = $name;
      $local->save();
    return $msj;
    }

    public function tipos_link($name, $id){
      if ($id<>0) {
        $msj = "Modifico el valor ".$name." del listado de tipos de link";
        $local = List_Type_Link::find($id);
      }else{
        $msj = "Registro el valor ".$name." del listado de tipos de link";
        $local = new List_Type_Link();
      }
       $local->name = $name;
      $local->save();
    return $msj;
    }
    public function equipment_list(){
    	if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Equipment::all();
    	$lis = 1;
    	$name = 'DE EQUIPO';
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		  return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function mark_list(){
    	if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Mark::all();
    	$lis = 2;
    	$name = 'DE MARCA';
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		  return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function electrical_list(){
    	if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Electrical_Power::all();
    	$lis = 3;
    	$name = 'DE ALIMENTACIÓN';
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		  return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function band_list(){
    	if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Band::all();
    	$lis = 5;
    	$name = 'DE BANDA';
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		  return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function radio_list(){
    	if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Radio::all();
    	$lis = 4;
    	$name = 'DE RADIO';
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		  return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function m_placa_list(){
    	if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Module_Board::all();
    	$lis = 6;
    	$name = 'DE MODELO DE PLACA';
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		  return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function type_port_list(){
    	if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Port::all();
    	$lis = 7;
    	$name = 'DE PUERTO';
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		  return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function conector_list(){
    	if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Connector::all();
    	$lis = 8;
    	$name = 'DE CONECTOR';
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		  return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function label_list(){
    	if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Label::all();
    	$lis = 9;
    	$name = 'DE ETIQUETA';
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		  return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function status_ip(){
      if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Status_IP::all();
      $lis = 10;
      $name = 'DE ESTADO DE LA IP';
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function pais(){
      if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Countries::all();
      $lis = 11;
      $name = 'DE PAISES';
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function provincia(){
      if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = DB::table('list_provinces')
          ->join('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
          ->select('list_provinces.id', 'list_countries.name as countries', 'list_provinces.name')->get();
      $lis = 12;
      $name = 'DE PROVINCIA';
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function motivo_baja(){
      if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Down::all();
      $lis = 13;
      $name = 'DE MOTIVO DE BAJA';
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function localizacion_list(){
      if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = Equipment_Location::all();
      $lis = 14;
      $name = 'DE LOCALIZACIÓN';
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function type_servi_list(){
      if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Service_Type::all();
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      return view('list.list_tipo_servicio',compact('autori_status', 'data'));
    }

    public function type_link_list(){
      if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
      $data = List_Type_Link::all();
      $lis = 15;
      $name = 'DE TIPOS DE LINK';
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);

      return view('list.list',compact('autori_status', 'data', 'lis', 'name'));
    }

    public function select_list_edict(){
      if (!Auth::guest() == false){ return array('resul' => 'login', );}
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      if ($autori_status['permi'] >= 5){
        $table=$_POST['list'];
        $id=$_POST['id'];
        switch ($table) {
          case 1:
            $infor = List_Equipment::find($id);
          break;
          case 2:
            $infor = List_Mark::find($id);
          break;
          case 3:
            $infor = List_Electrical_Power::find($id);
          break;
          case 4:
            $infor = List_Radio::find($id);
          break;
          case 5:
            $infor = List_Band::find($id);
          break;
          case 6:
            $infor = List_Module_Board::find($id);
          break;
          case 7:
            $infor = List_Port::find($id);
          break;
          case 8:
            $infor = List_Connector::find($id);
          break;
          case 9:
            $infor = List_Label::find($id);
          break;
          case 10:
            $infor = List_Status_IP::find($id);
          break;
          case 11:
            $infor = List_Countries::find($id);
          break;
          case 12:
            $sql_info = DB::table('list_provinces')
              ->join('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
              ->where('list_provinces.id', '=', $id)
              ->select('list_provinces.name', 'list_provinces.id', 'list_countries.name as countries','list_countries.id as id_countries')->orderBy('list_provinces.name', 'asc')->get();
            $infor = $sql_info[0];
          break;
          case 13:
            $infor = List_Down::find($id);
          break;
          case 14:
            $infor = Equipment_Location::find($id);
          break;
          case 15:
            $infor = List_Type_Link::find($id);
          break;
        }
        if ($infor <> null) {
          $data = array(
                        'resul' => 'yes',
                        'data' => $infor,
                        'table' => $table
                      );
        }else{
           $data = array(
                        'resul' => 'nop',
                      );
        }
        return $data;
      }else{
        return array('resul' => 'autori', );
      }
    }

    public function delecte_lista(){
      if (!Auth::guest() == false){ return array('resul' => 'login', );}
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      if ($autori_status['permi'] >= 5){
        $table=$_POST['table'];
        $id=$_POST['id'];
        switch ($table) {
          case 1:
            $validar=DB::table('equipment_model')->where('equipment_model.id_equipment','=',$id)
            ->select('*')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "equipo";
              $data = List_Equipment::find($id);
            }
          break;
          case 2:
            $validar=DB::table('equipment_model')->where('equipment_model.id_mark','=',$id)
            ->select('*')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "marca";
              $data = List_Mark::find($id);
            }
          break;
          case 3:
            $validar=DB::table('equipment_model')->where('equipment_model.id_electrical_power','=',$id)
            ->select('*')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "alimentación";
              $data = List_Electrical_Power::find($id);
            }
          break;
          case 4:
            $validar=DB::table('equipment_model')->where('equipment_model.id_radio','=',$id)
            ->select('*')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "radio";
              $data = List_Radio::find($id);
            }
          break;
          case 5:
            $validar=DB::table('equipment_model')->where('equipment_model.id_band','=',$id)
            ->select('*')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "banda";
              $data = List_Band::find($id);
            }
          break;
          case 6:
            $validar=DB::table('port_equipment_model')->where('port_equipment_model.id_module_board','=',$id)
            ->select('*')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "tipo de placa";
              $data = List_Module_Board::find($id);
            }
          break;
          case 7:
            $validar=DB::table('port_equipment_model')->where('port_equipment_model.id_list_port','=',$id)
            ->select('*')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "tipo de puerto";
              $data = List_Port::find($id);
            }
          break;
          case 8:
            $validar=DB::table('port_equipment_model')->where('port_equipment_model.id_connector','=',$id)
            ->select('*')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "conectores";
              $data = List_Connector::find($id);
            }
          break;
          case 9:
            $validar=DB::table('port_equipment_model')->where('port_equipment_model.id_label','=',$id)
            ->select('*')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "etiqueta";
              $data = List_Label::find($id);
            }
          break;
          case 10:
            $validar=DB::table('ip')->where('ip.id_status','=',$id)
            ->select('*')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "estado de IP";
              $data = List_Status_IP::find($id);
            }
          break;
          case 11:
            $validar = DB::table('address')
              ->where('address.id_countries', '=', $id)
              ->select('address.id')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "paises";
              $data = List_Countries::find($id);
            }
          break;
          case 12:
            $validar = DB::table('address')
              ->where('address.id_provinces', '=', $id)
              ->select('address.id')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "provincia";
              $data = List_Provinces::find($id);
            }
          break;
          case 13:
            $validar = DB::table('service')
              ->where('service.list_down', '=', $id)
              ->select('service.id')->get();
            if (count($validar) > 0) {
              $resul = "exis";
            }else{
              $resul = "yes";
              $name_table = "motivo de baja";
              $data = List_Down::find($id);
            }
          break;
          case 14:
            $resul = "yes";
            $name_table = "localización";
            $data = Equipment_Location::find($id);
          break;
          case 15:
            $resul = "yes";
            $name_table = "tipos de link";
            $data = List_Type_Link::find($id);
          break;
        }
        if ($resul == "yes") {
          ControllerUser_history::store("Elimino el valor ".$data->name." de el listado de ".$name_table);
          $data->delete();
        }
        return array('resul' => $resul,);
      }else{
        return array('resul' => 'autori', );
      }
    }

    public function list_service(){
      if (!Auth::guest() == false){ return array('resul' => 'login', );}
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      if ($autori_status['permi'] >= 5){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $ip=$_POST['ip'];
        $rango=$_POST['rango'];
        $relation=$_POST['relation'];
        $bw=$_POST['bw'];
        if ($id != 0) {
          $msj_servi = "Modifico";
          $Type = List_Service_Type::find($id);
        }else{
          if ($autori_status['permi'] >= 10){
            $msj_servi = "Registro";
            $Type = new List_Service_Type();
          }else{
            return array('resul' => 'autori', );
          }
        }
         $Type->name = $name;
         $Type->require_ip = $ip;
         $Type->require_rank = $rango;
         $Type->require_bw = $bw;
         $Type->require_related = $relation;
        $Type->save();
        ControllerUser_history::store($msj_servi." el valor ".$name." del listado de tipo de servicios");
        return array('resul' => 'yes',);
      }else{
        return array('resul' => 'autori', );
      }
    }

    public function search_list_service(){
      if (!Auth::guest() == false){ return array('resul' => 'login', );}
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      if ($autori_status['permi'] >= 5){
        $id=$_POST['id'];
        $Type = List_Service_Type::find($id);
        return array('resul' => 'yes', 'datos' => $Type,);
      }else{
        return array('resul' => 'autori', );
      }
    }

    public function delecte_lista_type_service(){
      if (!Auth::guest() == false){ return array('resul' => 'login', );}
      $autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      if ($autori_status['permi'] >= 5){
        $id=$_POST['id'];
        $validar = DB::table('list_service_type')
          ->join('service', 'service.id_type', '=', 'list_service_type.id')
          ->where('list_service_type.id', '=', $id)
          ->select('service.id')->get();
        if (count($validar) > 0) {
          $resul = "exis";
        }else{
          $data = List_Service_Type::find($id);
          ControllerUser_history::store("Elimino el valor ".$data->name." de el listado de tipo de servicios");
          $data->delete();
          $resul = "yes";
        }
        return array('resul' => $resul,);
      }else{
        return array('resul' => 'autori', );
      }
    }
}
