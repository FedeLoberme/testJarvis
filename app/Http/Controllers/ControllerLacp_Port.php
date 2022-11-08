<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Equipment_Model;
use Jarvis\Equipment;
use Jarvis\Client;
use Jarvis\IP;
use Jarvis\User;
use Jarvis\Record_ip;
use Jarvis\Port;
use Jarvis\Service;
use Jarvis\Lacp_Port;
use Jarvis\Service_Port;
use Jarvis\List_Service_Type;
use Jarvis\Http\Controllers\ControllerUser_history;
use Jarvis\Http\Controllers\ControllerAddress;
use Jarvis\Http\Controllers\ControllerEquipment_Model;
use Jarvis\Http\Controllers\ControllerRing;
use Jarvis\Http\Controllers\ControllerService;
use Jarvis\Http\Controllers\ControllerService_Port;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use DB;
class ControllerLacp_Port extends Controller
{

    public function edit_lacp(Request $request)
    {
        //id del lacp
        $lacp = intval($request->lacp);

        //limpiar todos los id_lacp_port de todos los puertos de ese lacp para despues establecer en dicho lacp los puertos que vienen en la request

        $ports_to_be_cleaned = Port::where('id_lacp_port', $lacp)->get();

        foreach ($ports_to_be_cleaned as $port){
            $port->update([
                'id_lacp_port' => null
            ]);
        }

        //establecer los ports que vienen en la request como parte del lacp
        foreach($request->ports as $req){
            $clean = explode('~', $req);
            $port = Port::all()
                ->where('n_port', $clean[0])
                ->where('id_board', $clean[1])
                ->first();

            if(isset($port)){
                $port->update([
                    'id_lacp_port' => $lacp
                ]);
            }
            else{
                //si el puerto no existe, creo un nuevo puerto
                $port               = new Port();
                $port->id_board     = $clean[1];
                $port->n_port       = $clean[0];
                $port->type         = 'SERVICE';
                $port->id_lacp_port = $lacp;
                $port->id_status    = 1;

                $port->save();
            }
        }
        return 'true';
    }

    public function insert_lacp_port(){
        if (!Auth::guest() == false){ return array('resul' => 'login', ); }
        $authori_status = User::authorization_status(15);
        if ($authori_status['permi'] >= 5) {
            $id=$_POST['id'];
            $comen=$_POST['come'];
            $por_ip = [];
            foreach ($id as $value) {
                $dividir = explode('~', $value);
                $id_port = ControllerService_Port::id_port($dividir[0], $dividir[1]);
                //$id_port = Port::get_id($dividir[1], $dividir[0], 1, 'SERVICIO');
                $por_ip[] = $id_port;
            }
            $equipment = DB::table("port")
                ->Join('board', 'board.id', '=', 'port.id_board')
                ->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
                ->where('port.id', '=', $id_port)
                ->select('equipment.id', 'equipment.acronimo')->get();
            $sql = DB::table("lacp_port")
                ->Join('port', 'lacp_port.id', '=', 'port.id_lacp_port')
                ->whereIn('port.id', $por_ip)
                ->select('lacp_port.id', 'lacp_port.lacp_number')
                ->groupBy('lacp_port.id', 'lacp_port.lacp_number')->get();
            $vali_cantidad = count($sql);
            switch ($vali_cantidad) {
                case '0':
                    for ($i=1; $i <= 100 ; $i++) {
                        $acronimo = 'Grupo-'.$i;
                        $group = DB::table("port")
                            ->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
                            ->Join('board', 'board.id', '=', 'port.id_board')
                            ->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
                            ->where('lacp_port.lacp_number', '=', $acronimo)
                            ->where('equipment.id', '=', $equipment[0]->id)
                            ->select('lacp_port.id')->get();
                        if (count($group) == 0) {
                            $i = 100;
                        }
                    }
                    $new_lacp = new Lacp_Port();
                    $new_lacp->lacp_number = $acronimo;
                    $new_lacp->commentary = $comen;
                    $new_lacp->group_lacp = 'SI';
                    $new_lacp->save();
                    $id_lacp = $new_lacp->id;
                    foreach ($por_ip as $valor) {
                        $port =Port::find($valor);
                        $port->id_status = 1;
                        $port->id_lacp_port = $id_lacp;
                        $port->save();
                    }
                    ControllerLacp_Port::dupli_service($id_lacp);
                    break;
                case '1':
                    if ($sql[0]->lacp_number == null || $sql[0]->lacp_number == '') {
                        for ($i=1; $i <= 100 ; $i++) {
                            $acronimo = 'Grupo-'.$i;
                            $group = DB::table("port")
                                ->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
                                ->Join('board', 'board.id', '=', 'port.id_board')
                                ->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
                                ->where('lacp_port.lacp_number', '=', $acronimo)
                                ->where('equipment.id', '=', $equipment[0]->id)
                                ->select('lacp_port.id')->get();
                            if (count($group) == 0) {
                                $i = 100;
                            }
                        }
                        $lacp_update = Lacp_Port::find($sql[0]->id);
                        $lacp_update->lacp_number = $acronimo;
                        $lacp_update->group_lacp = 'SI';
                        $new_lacp->commentary = $comen;
                        $lacp_update->save();
                        $id_lacp = $lacp_update->id;
                    }
                    foreach ($por_ip as $valor) {
                        $port =Port::find($valor);
                        $port->id_status = 1;
                        $port->id_lacp_port = $id_lacp;
                        $port->save();
                    }
                    ControllerLacp_Port::dupli_service($id_lacp);
                    break;
                default:
                    $id_lacp = $sql[0]->id;
                    $lacp_sql = Lacp_Port::find($id_lacp);
                    if ($lacp_sql->group_lacp == 'NO') {
                        for ($i=1; $i <= 100 ; $i++) {
                            $acronimo = 'Grupo-'.$i;
                            $group = DB::table("port")
                                ->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
                                ->Join('board', 'board.id', '=', 'port.id_board')
                                ->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
                                ->where('lacp_port.lacp_number', '=', $acronimo)
                                ->where('equipment.id', '=', $equipment[0]->id)
                                ->select('lacp_port.id')->get();
                            if (count($group) == 0) {
                                $i = 100;
                            }
                        }
                        $lacp_update = Lacp_Port::find($id_lacp);
                        $lacp_update->lacp_number = $acronimo;
                        $lacp_update->group_lacp = 'SI';
                        $new_lacp->commentary = $comen;
                        $lacp_update->save();
                    }
                    $id_old_group = [];
                    foreach ($sql as $old) {
                        if ($old->id != $id_lacp) {
                            $id_old_group[] = $old->id;
                        }
                    }
                    $id_group_service = DB::table("service_port")
                        ->select('service_port.id')
                        ->whereIn('service_port.id_lacp_port', $id_old_group)->get();
                    foreach ($por_ip as $valor) {
                        $port =Port::find($valor);
                        $port->id_status = 1;
                        $port->id_lacp_port = $id_lacp;
                        $port->save();
                    }
                    foreach ($id_group_service as $val) {
                        $ser_port =Service_Port::find($val->id);
                        $ser_port->id_lacp_port = $id_lacp;
                        $ser_port->save();
                    }
                    foreach ($id_old_group as $value) {
                        $service = Lacp_Port::find($value);
                        $service->delete();
                    }
                    ControllerLacp_Port::dupli_service($id_lacp);
                    break;
            }
            $lacp_sql_info = Lacp_Port::find($id_lacp);
            ControllerUser_history::store("Registro el grupo LACP ".$lacp_sql_info->lacp_number.' del equipo '.$equipment[0]->acronimo);
            return array('resul' => 'yes', );
        }else{
            return array('resul' => 'autori', );
        }
    }

    public function dupli_service($id){
        $servi_dupli = [];
        $servi_search = [];
        $id_service_dupli = DB::table("service_port")
            ->Join('service', 'service.id', '=', 'service_port.id_service')
            ->select('service_port.id', 'service.id as servi')
            ->where('service_port.id_lacp_port', '=' , $id)->get();
        foreach ($id_service_dupli as $todo) {
            if (!in_array($todo->servi, $servi_search)) {
                $servi_search[] = $todo->servi;
            }else{
                $servi_dupli[] = $todo->id;
            }
        }
        foreach ($servi_dupli as $quitar) {
            $service = Service_Port::find($quitar);
            $service->delete();
        }
    }

    public static function get_ports_data_of_specific_lacp_port($id)
    {
        return DB::table('port')
            ->join('board', 'port.id_board', '=', 'board.id')
            ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
            ->where('port.id_lacp_port', '=', $id)
            ->select('slot', 'n_port', 'list_module_board.name as model', 'list_label.name as label', 'id_board')->get();
    }

    public static function all_lacp_equipmen($id){
        $data = [];
        $group = DB::table("port")
            ->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
            ->Join('board', 'board.id', '=', 'port.id_board')
            ->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
            ->where('equipment.id', '=', $id)
            ->where('lacp_port.group_lacp', '=', 'SI')
            ->select('lacp_port.id','lacp_port.lacp_number','lacp_port.commentary')->groupBy('lacp_port.id','lacp_port.lacp_number','lacp_port.commentary')->get();
        foreach ($group as $value) {
            $buscar = DB::table('port')
                ->join('board', 'port.id_board', '=', 'board.id')
                ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
                ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
                ->select('slot', 'n_port', 'list_label.name as name', 'list_module_board.name as model', 'id_board')
                ->where('port.id_lacp_port', '=', $value->id)
                ->select('port.n_port', 'board.slot', 'list_label.name', 'port_equipment_model.bw_max_port')->get();
            $port_all = '';
            $bw_lacp_pure = 0;
            foreach ($buscar as $val) {
                $fsp_label = ControllerRing::label_por($val->slot);
                $port_all = $port_all.$val->name.$fsp_label.$val->n_port.' ';
                $bw_lacp_pure += $val->bw_max_port;
            }
            $bw_port_all = ControllerEquipment_Model::format_bw($bw_lacp_pure);
            $atri = DB::table('service')
                ->join('service_port', 'service_port.id_service', '=', 'service.id')
                ->where('service_port.id_lacp_port', '=', $value->id)
                ->select('service.number')->get();
            $atributo = '';
            foreach ($atri as $key) {
                $atributo = $atributo.$key->number.' ';
            }
            $data[] = array(
                'id' => $value->id,
                'port' => $port_all,
                'lacp_number' => $value->lacp_number,
                'bw_lacp_group' => $bw_port_all['data'].$bw_port_all['signo'],
                'bw_lacp_pure' => $bw_lacp_pure,
                'commentary' => $value->commentary,
                'atributo' => $atributo,
            );
        }
        return $data;
    }

    public function delecte_lacp_equipmen(){
        if (!Auth::guest() == false){ return array('resul' => 'login', ); }
        $id = $_POST['id'];
        $Validator = DB::table('service')
            ->join('service_port', 'service_port.id_service', '=', 'service.id')
            ->where('service_port.id_lacp_port', '=', $id)
            ->select('service.number')->get();
        if (count($Validator) == 0) {
            $buscar = DB::table('port')
                ->join('board', 'port.id_board', '=', 'board.id')
                ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
                ->where('port.id_lacp_port', '=', $id)
                ->select('port.id', 'equipment.id as equipment')->get();
            foreach ($buscar as $value) {
                $port_new = Port::find($value->id);
                $port_new->id_status = 2;
                $port_new->id_lacp_port = null;
                $port_new->commentary = null;
                $port_new->save();
            }
            $service = Lacp_Port::find($id);
            $service->delete();
            $resul = array('resul' => 'yes', 'datos' => $buscar[0]->equipment,);
        }else{
            $resul = array('resul' => 'exis',);
        }
        return $resul;
    }
    public function port_new_lacp_search(){
        if (!Auth::guest() == false){ return array('resul' => 'login', ); }
        $id = $_POST['id'];

        $resul = array('resul' => 'yes', 'datos' => $buscar[0]->equipment,);
        $resul = array('resul' => 'exis',);
        return $resul;
    }
    public function port_delecte_lacp_search(){
        if (!Auth::guest() == false){ return array('resul' => 'login', ); }
        $group = $_POST['group'];
        $por = DB::table('port')
            ->Join('board', 'port.id_board', '=', 'board.id')
            ->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->Join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
            ->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->where('port.id_lacp_port', '=', $group)
            ->select('port.id', 'port.n_port','board.slot', 'list_module_board.name as model', 'list_label.name as label','board.id as board')->get();
        foreach ($por as $value) {
            $slot=ControllerRing::label_por($value->slot);
            $number = ControllerService::number_service($value->n_port, $value->board);
            $datos[] = array(
                'id' => $value->id,
                'n_port' => $value->n_port,
                'pose' => $slot,
                'slot' => $value->label.$slot,
                'model' => $value->model,
                'service' => $number,
            );
        }
        if (count($datos) > 0) {
            $pose_order  = array_column($datos, 'pose');
            $port_order  = array_column($datos, 'n_port');
            array_multisort($pose_order, SORT_ASC, $port_order, SORT_ASC,$datos);
        }
        return array('resul' => 'yes', 'datos' => $datos,);
    }

    public function resource_service_edit(){
        if (!Auth::guest() == false){ return array('resul' => 'login', ); }
        $id = $_POST['id'];
        $servi = $_POST['servi'];
        $port_exist = [];
        $port_full = [];
        $ip_full = [];
        $service = DB::table('service')
            ->Join('service_port', 'service_port.id_service', '=', 'service.id')
            ->Join('list_service_type', 'service.id_type', '=', 'list_service_type.id')
            ->Join('port', 'port.id_lacp_port', '=', 'service_port.id_lacp_port')
            ->Join('board', 'port.id_board', '=', 'board.id')
            ->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
            ->leftJoin('ip', 'ip.id_equipment_wan', '=', 'equipment.id')
            ->where('service.id', '=', $servi)
            ->where('service_port.id_lacp_port', '=', $id)
            ->select('service.id as service', 'service.number', 'service_port.vlan', 'list_service_type.require_ip', 'list_service_type.require_rank', 'list_service_type.require_bw', 'list_service_type.require_related', 'equipment.acronimo', 'equipment.id', 'ip.ip', 'ip.prefixes', 'ip.id as id_ip')
            ->groupBy('service.id','service.number', 'service_port.vlan', 'list_service_type.require_ip', 'list_service_type.require_rank', 'list_service_type.require_bw', 'list_service_type.require_related', 'equipment.acronimo', 'equipment.id', 'ip.ip', 'ip.prefixes', 'ip.id')->get();
        if (count($service) > 0) {
            if ($service[0]->ip != null && $service[0]->ip != '') {
                $ip_full = array(
                    'id' => $service[0]->id,
                    'ip' => $service[0]->ip.'/'.$service[0]->prefixes,
                );
            }
            $port = DB::table('port')
                ->Join('board', 'port.id_board', '=', 'board.id')
                ->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
                ->where('port.id_lacp_port', '=', $id)
                ->select('port.id', 'port.n_port','board.slot', 'list_label.name as label','board.id as board', 'board.id_equipment')->get();
            foreach ($port as $value) {
                $fsp_label = ControllerRing::label_por($value->slot);
                $port_exist[] = array(
                    'id' => $value->id,
                    'port' => $value->label.$fsp_label.$value->n_port,
                );
            }
            $port_all = DB::table('board')
                ->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
                ->where('board.id_equipment', '=', $port[0]->id_equipment)
                ->select('board.slot', 'list_label.name as label','board.id as board', 'port_equipment_model.port_l_i','port_equipment_model.port_l_f')->get();
            foreach ($port_all as $valor) {
                $label = ControllerRing::label_por($value->slot);
                for ($i = $valor->port_l_i; $i < $valor->port_l_f + 1; $i++) {
                    $port_real = $valor->label.$label.$i;
                    $port_full[] = array(
                        'port' => $valor->board.'|'.$i,
                        'all' => $port_real,
                    );
                }
            }
        }
        return array('resul' => 'yes', 'port_exist' => $port_exist, 'service' => $service, 'port_full' => $port_full, 'ip' => $ip_full);
    }

    public function resource_service_modificar(){
        if (!Auth::guest() == false){ return array('resul' => 'login', ); }
        $authori_status = User::authorization_status(15);
        if ($authori_status['permi'] >= 5){
            $id_servicio = $_POST['id_servicio'];
            $lacp = $_POST['lacp'];
            $ip_admin = $_POST['ip_admin'];
            $port = $_POST['port'];
            $vlan = $_POST['vlan'];
            $equip = $_POST['equip'];
            $port_sql = DB::table('port')
                ->join('board', 'board.id', '=', 'port.id_board')
                ->where('port.id_lacp_port','=',$lacp)
                ->select('port.id', 'board.id_equipment')->get();
            if ($ip_admin != '') {
                $ip_edic =	IP::find($ip_admin);
            }
            if ($ip_admin == '' || $ip_edic->id_status == 1 || ($ip_edic->id_status == 1 && $ip_edic->id_equipment_wan == $equip )) {
                $servi_sql = DB::table('service_port')
                    ->where('service_port.id_lacp_port','=',$lacp)
                    ->where('service_port.id_service','=',$id_servicio)
                    ->select('service_port.id')->get();
                $service = Service_Port::find($servi_sql[0]->id);
                $service->delete();
                foreach ($port_sql as $value) {
                    $port_edic = Port::find($value->id);
                    $port_edic->id_status = 2;
                    $port_edic->commentary = null;
                    $port_edic->type = null;
                    $port_edic->id_lacp_port = null;
                    $port_edic->save();
                }
                $Lacp_Port_edic = Lacp_Port::find($lacp);
                $Lacp_Port_edic->delete();
                foreach ($port as $valor) {
                    $port_edic_sql = Port::find($valor);
                    if ($port_edic_sql->id_lacp_port== null || $port_edic_sql->id_lacp_port==''){
                        $insert_lacp= new Lacp_Port();
                        $insert_lacp->group_lacp = 'NO';
                        $insert_lacp->save();
                        $id_lacp = $insert_lacp->id;
                        $edic_sql_por = Port::find($valor);
                        $edic_sql_por->id_status = 2;
                        $edic_sql_por->type = 'SERVICIO';
                        $edic_sql_por->id_lacp_port = $id_lacp;
                        $edic_sql_por->save();
                    }else{
                        $id_lacp = $port_edic_sql->id_lacp_port;
                    }
                    $ser_por= new Service_Port();
                    $ser_por->id_lacp_port = $id_lacp;
                    $ser_por->id_service = $id_servicio;
                    $ser_por->vlan = $vlan;
                    $ser_por->save();
                }
                $ip_free = DB::table('ip')
                    ->where('ip.id_equipment_wan','=',$equip)
                    ->select('ip.id')->get();
                foreach ($ip_free as $val) {
                    $ip_edic_free = IP::find($val->id);
                    $ip_edic_free->id_status = 1;
                    $ip_edic_free->id_equipment_wan = null;
                    $ip_edic_free->id_service = null;
                    $ip_edic_free->save();
                }
                if ($ip_admin != '') {
                    $ip_edic_sql = IP::find($ip_admin);
                    $ip_edic_sql->id_status = 2;
                    $ip_edic_sql->id_equipment_wan = $equip;
                    $ip_edic_sql->id_service = $id_servicio;
                    $ip_edic_sql->save();
                }
                return array('resul' => 'yes',);
            }else{
                return array('resul' => 'ip_exi',);
            }
        }else{
            return array('resul' => 'autori',);
        }
    }

    public function commen_port_all(){
        if (!Auth::guest() == false){ return array('resul' => 'login', );}

        $group = $_POST['group'];
        $Lacp = Lacp_Port::find($group);

        return array('resul' => 'yes', 'datos' => $Lacp->commentary, 'acronimo' => $Lacp->lacp_number,);
    }

    public function insert_update_commen_group(){
        if (!Auth::guest() == false){ return array('resul' => 'login', );}

        $port_new = Lacp_Port::find($_POST['group']);
        $port_new->commentary = $_POST['commen'];
        $port_new->save();

        return array('resul' => 'yes');
    }

}
