<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Jarvis\Constants;
use Jarvis\Http\Requests\RequestEquipment_Model;
use Jarvis\Port_Equipment_Model;
use Jarvis\Equipment_Model;
use Jarvis\List_Equipment;
use Jarvis\List_Electrical_Power;
use Jarvis\List_Mark;
use Jarvis\List_Radio;
use Jarvis\List_Band;
use Jarvis\Function_Equipment_Model;
use Jarvis\Relation_Model_Function;
use Jarvis\User;
use Jarvis\Http\Controllers\ControllerUser_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;
class ControllerEquipment_Model extends Controller
{
// -----------------Funcion para listar inventario---------------------------
	public function index(){
		if (!Auth::guest() == false){ return redirect('login')
			->withErrors([Lang::get('validation.login'),]);}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		if ($authori_status['permi'] >= 3){
      $equipment = Equipment_Model::List();
      $equip = DB::table('list_equipment')->orderBy('name', 'asc')->get();
      $equi_mark = DB::table('list_mark')->orderBy('name', 'asc')->get();
      $electrical_power = DB::table('list_electrical_power')->orderBy('name', 'asc')->get();
      $radio = DB::table('list_radio')->orderBy('name', 'asc')->get();
      $band = DB::table('list_band')->orderBy('name', 'asc')->get();
      $function = Function_Equipment_Model::all();
			return view('equipment_model.list',compact('authori_status','equipment','equip', 'equi_mark', 'electrical_power', 'radio', 'band','function'));
		}else{
			return 	redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

  public function index_list(){
    if (!Auth::guest() == false){
           return redirect('login')->withErrors([Lang::get('validation.login'),]);
    }
    $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
    if ($authori_status['permi'] >= 3) {
      $Equipment_Model = DB::table('equipment_model')
      ->join('list_equipment', 'equipment_model.id_equipment', '=', 'list_equipment.id')
      ->join('list_mark', 'equipment_model.id_mark', '=', 'list_mark.id')
      ->select('list_equipment.name', 'list_mark.name as mark', 'equipment_model.model', 'equipment_model.description', 'equipment_model.id');
        return datatables()->of($Equipment_Model)->make(true);
        }else{
      return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
    }
  }

    public function all_equipment(RequestEquipment_Model $request){
      $id_editar = $request->input('id_editar');
      $equipo1 = $request->input('equipo');
      $equipo_nom = $request->input('nom_equipo');
      $marca = $request->input('marca');
      $modelo = strtoupper($request->input('modelo'));
      $sap = $request->input('sap');
      $status = $request->input('status');
      $descri = $request->input('descri');
      $alimenta = $request->input('alimenta');
      $modulo = $request->input('modulo');
      $image = $request->input('image');
      $funtion = $request->input('funtion');
      $full = $request->input('full');
      $multi = $request->input('multi');
      $dual = $request->input('dual');
      $radio = $request->input('radio');
      $banda = $request->input('banda');
      $equipo_n = $request->input('equipo_n');
      $maxi = $request->input('max');
      $n_max = $request->input('n_max');
      $encrip = $request->input('encrip');
      $n_encrip = $request->input('n_encrip');
      $licen = $request->input('licen');
      $n_licen = $request->input('n_licen');
      $bw_max = $maxi * $n_max;
      $bw_encrip = $encrip * $n_encrip;
      $bw_licen = $licen * $n_licen;
      $equi = str_replace(' ', '', $equipo_nom);
      $mark = str_replace(' ', '', $marca);
      $mod = str_replace(' ', '', $modelo);
      $num = rand(0, 1000);
      if($request->hasFile('image')) {
        $file = $request->file('image');
        $name = $equi.'-'.$mark.'-'.$mod.'-'.$num.'.'.$file->getClientOriginalExtension();
        $image['filePath'] = $name;
        $file->move(public_path().'/img/equipo/', $name);
        $filename = $name;
      }else{
        $filename = null;
      }
      $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      if (($equipo1 == 0 && $authori_status['permi'] >= 5) || ($equipo1 != 0 && $authori_status['permi'] >= 10)) {
        $exis = Equipment_Model::exists_inventory($equipo1, $marca, $modelo, $id_editar, $alimenta);
        if (count($exis) <> 0) {
          $notification = array(
                      'message' => trans('equipment_model.exis'),
                      'alert-type' => 'error'
                  );
          return redirect('ver/inventario')->with($notification);
        }
        switch ($equipo1){
          case '1':
            $id = ControllerEquipment_Model::router($equipo1, $marca, $modelo, $sap, $status, $descri, $bw_max, $bw_licen, $alimenta, $dual, $multi, $modulo, $bw_encrip, $full, $filename, $id_editar);
          break;
          case '2':
            $id = ControllerEquipment_Model::radio($equipo1, $marca, $modelo, $sap, $status, $descri, $bw_max, $bw_licen, $alimenta, $banda, $radio, $modulo, $filename, $id_editar);
          break;
          case '3':
            $id = ControllerEquipment_Model::lanswitch($equipo1, $marca, $modelo, $sap, $status, $descri, $bw_max, $alimenta, $modulo, $filename, $id_editar);
          break;
          default:
            $id = ControllerEquipment_Model::general($equipo1, $marca, $modelo, $sap, $status, $descri, $bw_max, $bw_licen, $alimenta, $dual, $multi, $modulo, $bw_encrip, $full, $filename, $banda, $radio, $id_editar);
          break;
        }
        if ($id_editar == 0) {
          foreach ($funtion as $value) {
            ControllerEquipment_Model::register_funtion($id, $value);
          }
          $notification = array(
                    'message' => trans('validation.msj.yes'),
                    'alert-type' => 'success'
                );
          return redirect('crear/puerto'.'/'.$id )->with($notification);
        }else{
          ControllerEquipment_Model::update_function($id_editar, $funtion);
          $notification = array(
                    'message' => trans('validation.msj.update'),
                    'alert-type' => 'success'
                );
          return redirect('ver/inventario')->with($notification);
        }
      }else{
        return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
      }
    }

// -----------------Funcion para registra router--------------------
    public function router($equipo1, $marca, $modelo, $sap, $status, $descri, $max, $licen, $alimenta, $dual, $multi, $modulo, $encrip, $full, $filename, $id){
      if ($id != 0) {
        $msj_equip = 'Modifico el modelo de router: ';
        $equipo = Equipment_Model::find($id);
      }else{
        $msj_equip = 'Registro el modelo de router: ';
        $equipo = new Equipment_Model();
      }
        $equipo->id_equipment = $equipo1;
        $equipo->id_mark = $marca;
        $equipo->model = $modelo;
        $equipo->cod_sap = $sap;
        $equipo->status = $status;
        $equipo->description = $descri;
        $equipo->bw_max_hw = $max;
        $equipo->bw_bas_lic = $licen;
        $equipo->id_electrical_power = $alimenta;
        $equipo->dual_stack = $dual;
        $equipo->multivrf = $multi;
        $equipo->module_slots = $modulo;
        $equipo->bw_encriptado = $encrip;
        $equipo->full_table = $full;
        if ($filename != null) {
          $equipo->img_url = $filename;
        }
      $equipo->save();
      $id = $equipo->id;
      ControllerUser_history::store($msj_equip.$modelo);
      return $id;
    }

// -----------------Funcion para registra radio--------------------
    public function radio($equipo1, $marca, $modelo, $sap, $status, $descri, $max, $licen, $alimenta, $banda, $radio, $modulo, $filename, $id){
      if ($id != 0) {
        $msj_equip = 'Modifico el modelo de radio: ';
        $equipo = Equipment_Model::find($id);
      }else{
        $msj_equip = 'Registro el modelo de radio: ';
        $equipo = new Equipment_Model();
      }
        $equipo->id_equipment = $equipo1;
        $equipo->id_mark = $marca;
        $equipo->model = $modelo;
        $equipo->cod_sap = $sap;
        $equipo->status = $status;
        $equipo->description = $descri;
        $equipo->bw_max_hw = $max;
        $equipo->bw_bas_lic = $licen;
        $equipo->id_electrical_power = $alimenta;
        $equipo->id_band = $banda;
        $equipo->id_radio = $radio;
        $equipo->module_slots = $modulo;
        if ($filename != null) {
          $equipo->img_url = $filename;
        }
      $equipo->save();
      $id = $equipo->id;
      ControllerUser_history::store($msj_equip.$modelo);
      return $id;
    }

// -----------------Funcion para registra lanswitch-----------------
    public function lanswitch($equipo1, $marca, $modelo, $sap, $status, $descri, $max, $alimenta, $modulo, $filename, $id){
      if ($id != 0) {
        $msj_equip = 'Modifico el modelo de lanswitch: ';
        $equipo = Equipment_Model::find($id);
      }else{
        $msj_equip = 'Registro el modelo de lanswitch: ';
        $equipo = new Equipment_Model();
      }
        $equipo->id_equipment = $equipo1;
        $equipo->id_mark = $marca;
        $equipo->model = $modelo;
        $equipo->cod_sap = $sap;
        $equipo->status = $status;
        $equipo->description = $descri;
        $equipo->bw_max_hw = $max;
        $equipo->id_electrical_power = $alimenta;
        $equipo->module_slots = $modulo;
        if ($filename != null) {
          $equipo->img_url = $filename;
        }
      $equipo->save();
      $id = $equipo->id;
      ControllerUser_history::store($msj_equip.$modelo);
      return $id;
    }

    // -----------------Funcion para registra nuevo equipo general--------------------
    public function general($equipo1, $marca, $modelo, $sap, $status, $descri, $max, $licen, $alimenta, $dual, $multi, $modulo, $encrip, $full, $filename, $banda, $radio, $id){
      if ($id != 0) {
        $msj_equip = 'Modifico el modelo: ';
        $equipo = Equipment_Model::find($id);
      }else{
        $msj_equip = 'Registro el modelo: ';
        $equipo = new Equipment_Model();
      }
        $equipo->id_equipment = $equipo1;
        $equipo->id_mark = $marca;
        $equipo->model = $modelo;
        $equipo->cod_sap = $sap;
        $equipo->status = $status;
        $equipo->description = $descri;
        $equipo->bw_max_hw = $max;
        $equipo->bw_bas_lic = $licen;
        $equipo->id_electrical_power = $alimenta;
        $equipo->dual_stack = $dual;
        $equipo->multivrf = $multi;
        $equipo->id_band = $banda;
        $equipo->id_radio = $radio;
        $equipo->module_slots = $modulo;
        $equipo->bw_encriptado = $encrip;
        $equipo->full_table = $full;
        if ($filename != null) {
          $equipo->img_url = $filename;
        }
      $equipo->save();
      $id = $equipo->id;
      ControllerUser_history::store($msj_equip.$modelo);
      return $id;
    }

// -----------------Funcion para registra agregar puerto--------------------
    public function port($id){
      if (!Auth::guest() == false){ return redirect('login')
      ->withErrors([Lang::get('validation.login'),]);}
      $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      if ($authori_status['permi'] >= 3) {
        $equipment = Equipment_Model::List();
        return view('equipment_model.selec',compact('equipment', 'authori_status', 'id'));
      }else{
        return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
      }
    }

// -----------------Funcion para buscar modelo--------------------
    public function search_model(){
      if (!Auth::guest() == false){ return array('resul' => 'login', ); }
      $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      if ($authori_status['permi'] >= 5) {
        $id=$_POST['id'];
        $resul = Equipment_Model::find($id);
        $equipment = List_Equipment::find($resul->id_equipment);
        $bw_max_hw = ControllerEquipment_Model::format_bw($resul->bw_max_hw);
        $bw_bas_lic = ControllerEquipment_Model::format_bw($resul->bw_bas_lic);
        $bw_encriptado = ControllerEquipment_Model::format_bw($resul->bw_encriptado);
        $equipo = array(
                    'id' => $resul->id,
                    't_equipo' => $resul->id_equipment,
                    't_n_equipo' =>$equipment->name,
                    'marca' => $resul->id_mark,
                    'model' => $resul->model,
                    'cod_sap' => $resul->cod_sap,
                    'status' => $resul->status,
                    'description' => $resul->description,
                    'bw_max_hw' => $bw_max_hw['data'],
                    'bw_max_hw_logo' => $bw_max_hw['logo'],
                    'bw_bas_lic' => $bw_bas_lic['data'],
                    'bw_bas_lic_logo' => $bw_bas_lic['logo'],
                    'electrical_power_supply' => $resul->id_electrical_power,
                    'dual_stack' => $resul->dual_stack,
                    'banda' => $resul->id_band,
                    't_radio' => $resul->id_radio,
                    'multivrf' => $resul->multivrf,
                    'model_slots' => $resul->module_slots,
                    'bw_encriptado' => $bw_encriptado['data'],
                    'bw_encriptado_logo' => $bw_encriptado['logo'],
                    'full_table' => $resul->full_table,
                    'img_url' => $resul->img_url,
                  );
        return $equipo;
      }else{
        return array('resul' => 'autori', );
      }
    }

    // -----------------Funcion para detalle de modelo--------------------
    public function search_model_detal(){
      if (!Auth::guest() == false){ return array('resul' => 'login', ); }
      $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
      if ($authori_status['permi'] >= 5) {
        $id=$_POST['id'];
        $detal = DB::table('equipment_model')
            ->leftJoin('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
            ->leftJoin('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
            ->leftJoin('list_electrical_power', 'list_electrical_power.id', '=', 'equipment_model.id_electrical_power')
            ->leftJoin('list_band', 'list_band.id', '=', 'equipment_model.id_band')
            ->leftJoin('list_radio', 'list_radio.id', '=', 'equipment_model.id_radio')
            ->where('equipment_model.id', '=', $id)
            ->select('equipment_model.model', 'equipment_model.cod_sap', 'equipment_model.status', 'equipment_model.description', 'equipment_model.bw_max_hw', 'equipment_model.bw_bas_lic', 'equipment_model.dual_stack', 'equipment_model.multivrf', 'equipment_model.module_slots', 'equipment_model.bw_encriptado', 'equipment_model.full_table','list_mark.name as mark', 'list_electrical_power.name as power', 'list_band.name as band', 'list_radio.name as radio','list_equipment.id', 'list_equipment.name as equipment')->get();
        $bw_max_hw = ControllerEquipment_Model::format_bw($detal[0]->bw_max_hw);
        $bw_bas_lic = ControllerEquipment_Model::format_bw($detal[0]->bw_bas_lic);
        $bw_encriptado = ControllerEquipment_Model::format_bw($detal[0]->bw_encriptado);
        $equipo = array(
                    'id' => $detal[0]->id,
                    'equipo' => $detal[0]->equipment,
                    'marca' => $detal[0]->mark,
                    'model' => $detal[0]->model,
                    'cod_sap' => $detal[0]->cod_sap,
                    'status' => $detal[0]->status,
                    'description' => $detal[0]->description,
                    'bw_max_hw' => $bw_max_hw['data'].' '.$bw_max_hw['signo'],
                    'bw_bas_lic' => $bw_bas_lic['data'].' '.$bw_bas_lic['signo'],
                    'electrical_power_supply' => $detal[0]->power,
                    'dual_stack' => $detal[0]->dual_stack,
                    'banda' => $detal[0]->band,
                    't_radio' => $detal[0]->radio,
                    'multivrf' => $detal[0]->multivrf,
                    'model_slots' => $detal[0]->module_slots,
                    'bw_encriptado' => $bw_encriptado['data'].' '.$bw_encriptado['signo'],
                    'full_table' => $detal[0]->full_table,
                  );
        return array('resul' => 'yes', 'datos' => $equipo,);
      }else{
        return array('resul' => 'autori', );
      }
    }

// -----------------Funcion para carcular el BW--------------------
  public static function format_bw($kbytes) {
    $kbytes = intval($kbytes);
    if ($kbytes >= 1048576) {
      $data = number_format($kbytes/1048576, 2, '.', '');
      $logo = '1048576';
      $signo = 'Gbps';
    } elseif ($kbytes >= 1024) {
      $data = number_format($kbytes/1024, 2, '.', '');
      $logo = '1024';
      $signo = 'Mbps';
    } elseif (empty($kbytes)) {
      $data = '0';
      $logo = '1';
      $signo = 'Kbps';
    } else {
      $data = number_format($kbytes, 2, '.', '');
      $logo = '1';
      $signo = 'Kbps';
    }
    return ['logo' => $logo, 'data' => $data, 'signo' => $signo];
  }

    public function validation_equipment(){
    $equipo=$_POST['equipo'];
    $marca=$_POST['marca'];
    $modelo=$_POST['modelo'];
    $id=$_POST['id'];
    $alimenta=$_POST['alimenta'];
    $exis = Equipment_Model::exists_inventory($equipo, $marca, $modelo, $id, $alimenta);
    if (count($exis) > 0) {
      $resul = array('resul' =>'yes' , );
    }else{
      $resul = array('resul' =>'nop' , );
    }
    return $resul;
  }

  public function ver_img(){
    if (!Auth::guest() == false){ return array('resul' => 'login', );}
    $id=$_POST['id'];
    $Equipment_Model = DB::table('equipment_model')
      ->where('equipment_model.id', '=', $id)
      ->select('equipment_model.img_url')->get();
    if ($Equipment_Model[0]->img_url == null) {
        $img = array('img' =>'unico.png' , );
    }else{
      $img = array('img' =>$Equipment_Model[0]->img_url, );
    }
    return $img;
  }

  public function register_funtion($id_equipment, $id_funtion){
        $funtion = new Relation_Model_Function();
        $funtion->id_equipment_model = $id_equipment;
        $funtion->id_equipment_model = $id_equipment;
        $funtion->id_function_equipment_model = $id_funtion;
        $funtion->status = 'Activo';
        $funtion->save();
      if ($funtion <> null) {
        $id = $funtion->id;
      }else{
        $id = 0;
      }
      return $id;
    }

    public function function_model(){
      $id=$_POST['id'];
      $function = Relation_Model_Function::function_relation($id);
      $contar = count($function);
      $data= '';
      foreach ($function as $value) {
        if ($data == '') {
          $data = $value->id;
        }else{
          $data = $data.','.$value->id;
        }
      }
      $aqui = array('datos' => $data, );
      return $aqui;
    }

    public function update_function($id, $funtions){
      $function = Relation_Model_Function::function_relation($id);
      foreach ($function as $value) {
        $function_old[] =$value->id;
      }
      $quitar = array_diff($function_old, $funtions);
      $colocar = array_diff($funtions, $function_old);
      foreach ($quitar as $qui) {
        $relation = Relation_Model_Function::relation($qui, $id);
        $funtion = Relation_Model_Function::find($relation[0]->id);
          $funtion->status = 'Inhabilitado';
        $funtion->save();
      }
      foreach ($colocar as $col) {
        $relati = Relation_Model_Function::relation($col, $id);
        if (count($relati) > 0) {
          $funtion_new = Relation_Model_Function::find($relati[0]->id);
            $funtion_new->status = 'Activo';
          $funtion_new->save();
        }else{
          ControllerEquipment_Model::register_funtion($id, $col);
        }
      }
    }

  public static function model_selec(){
    if (!Auth::guest() == false){ return array('resul' => 'login', ); }
      $id = $_POST['id'];
      $model = DB::table('equipment_model')
            ->Join('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
            ->Join('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
            ->leftJoin('import_st_excels', 'import_st_excels.codsap', '=', 'equipment_model.cod_sap')
            ->where('equipment_model.id', '=', $id)
            ->select('equipment_model.model', 'list_mark.name as mark', 'list_equipment.name as equipment', 'import_st_excels.stock_benavidez')->get();
      if (count($model) > 0) {
        $datos = $model[0]->model.' '.$model[0]->mark.' '.$model[0]->equipment;
        $resul = array('resul' => 'yes', 'datos' => $datos, 'stock' => $model[0]->stock_benavidez,);
      }else{
        $resul = array('resul' => 'nop', );
      }
      return $resul;
  }

  public function PortRadioAll(){
    if (!Auth::guest() == false){ return array('resul' => 'login', ); }
    $id = $_POST['modelo'];
    $radio = $_POST['radio'];
    $datos = [];
    $Board = DB::table('port_equipment_model')
      ->join('relation_port_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
      ->join('list_port', 'port_equipment_model.id_list_port','=','list_port.id')
      ->join('list_connector', 'port_equipment_model.id_connector','=','list_connector.id')
      ->join('list_label', 'port_equipment_model.id_label','=','list_label.id')
      ->join('list_module_board', 'port_equipment_model.id_module_board','=','list_module_board.id')
      ->where('relation_port_model.id_equipment_model', '=', $id)
      ->where('list_port.name', '!=', 'ANTENA')
      ->where('list_port.name', '!=', 'IF')
      ->where('list_port.name', '!=', 'ODU')
      ->where('list_port.name', '!=', 'ANTENA 15G 60')
      ->select('port_equipment_model.quantity', 'port_equipment_model.port_f_i', 'port_equipment_model.port_f_f', 'list_port.name as port', 'list_connector.name as connector', 'port_equipment_model.bw_max_port', 'list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_module_board.name as module_board', 'port_equipment_model.type_board','port_equipment_model.id', 'relation_port_model.status', 'relation_port_model.description_label as fsp', 'list_label.name as label')->get();
    foreach ($Board as $valor) {
      $fsp = ControllerPort_Equipment_Model::fsp($valor->fsp);
      $bw = ControllerEquipment_Model::format_bw($valor->bw_max_port);
      for ($i = $valor->port_l_i; $i < $valor->port_l_f + 1; $i++) {
        $info = ControllerEquipment_Model::InfoPortRadio($i, $valor->id, $radio);
        $datos[] = array(
          'id' => $valor->id.','.$i,
          'type' => $valor->port,
          'atributo' => $info['atributo'],
          'status' => $info['status'],
          'id_status' => $info['id_status'],
          'bw' => $bw['data'].' '.Lang::get('equipment_model.bw.'.$bw['logo']),
          'port' => $valor->label.' '.$fsp[0]['min'].$fsp[0]['sep'].$i,
        );
      }
    }
    return array('resul' => 'yes', 'datos' => $datos,);
  }

  public function PortIfRadioAll(){
    if (!Auth::guest() == false){ return array('resul' => 'login', ); }
    $id = $_POST['modelo'];
    $radio = $_POST['radio'];
    $datos = [];
    $Board = DB::table('port_equipment_model')
      ->join('relation_port_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
      ->join('list_port', 'port_equipment_model.id_list_port','=','list_port.id')
      ->join('list_connector', 'port_equipment_model.id_connector','=','list_connector.id')
      ->join('list_label', 'port_equipment_model.id_label','=','list_label.id')
      ->join('list_module_board', 'port_equipment_model.id_module_board','=','list_module_board.id')
      ->where('relation_port_model.id_equipment_model', '=', $id)
      ->where('list_port.name', '=', 'IF')
      ->select('port_equipment_model.quantity', 'port_equipment_model.port_f_i', 'port_equipment_model.port_f_f', 'list_port.name as port', 'list_connector.name as connector', 'port_equipment_model.bw_max_port', 'list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'list_module_board.name as module_board', 'port_equipment_model.type_board','port_equipment_model.id', 'relation_port_model.status', 'relation_port_model.description_label as fsp', 'list_label.name as label')->get();
    foreach ($Board as $valor) {
      $fsp = ControllerPort_Equipment_Model::fsp($valor->fsp);
      $bw = ControllerEquipment_Model::format_bw($valor->bw_max_port);
      for ($i = $valor->port_l_i; $i < $valor->port_l_f + 1; $i++) {
        $info = ControllerEquipment_Model::InfoPortRadio($i, $valor->id, $radio);
        $datos[] = array(
          'id' => $valor->id.','.$i,
          'type' => $valor->port,
          'atributo' => $info['atributo'],
          'status' => $info['status'],
          'id_status' => $info['id_status'],
          'bw' => $bw['data'].' '.Lang::get('equipment_model.bw.'.$bw['logo']),
          'port' => $valor->label.' '.$fsp[0]['min'].$fsp[0]['sep'].$i,
        );
      }
    }
    return array('resul' => 'yes', 'datos' => $datos,);
  }

  public function InfoPortRadio($port, $board, $equip){
    $status = 'VACANTE';
    $id_status = '';
    $atributo = '';
    if ($equip > 0) {
      $data = DB::table('board')->where('id_equipment','=',$equip)->where('id_port_model','=',$board)
        ->select('id')->get();
      if (count($data) > 0) {
        $inf = ControllerPort::inf_por_indivi_todo($data[0]->id, $port);
        $status = $inf['status'];
        $id_status = $inf['id_status'];
        $atributo = $inf['atributo'];
      }
    }
    return array('status' => $status, 'id_status' => $id_status, 'atributo' => $atributo,);
  }
}
