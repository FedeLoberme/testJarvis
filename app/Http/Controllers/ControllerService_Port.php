<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Constants;
use Jarvis\Equipment;
use Jarvis\IP;
use Jarvis\User;
use Jarvis\Record_ip;
use Jarvis\Port;
use Jarvis\Service;
use Jarvis\Lacp_Port;
use Jarvis\Reserve;
use Jarvis\Service_Port;
use Jarvis\Http\Controllers\ControllerUser_history;
use \Jarvis\Http\Controllers\ControllerLacp_Port;
use Jarvis\Http\Controllers\ControllerRing;
use Jarvis\Http\Controllers\ControllerService;
use Illuminate\Support\Facades\Auth;
use Exception;
use Error;
use Illuminate\Support\Facades\DB;
use Jarvis\Asignacion_Servicio_Vlan;
use Jarvis\Use_Vlan;
use Jarvis\Link;

class ControllerService_Port extends Controller
{
    public function insert_update_resources(){
        $id_servivio = $_POST['id_servicio'];
        $ip_admin = $_POST['ip_admin'];
        $port = $_POST['port'];
        $ip_rank = $_POST['ip_rank'];
        $vlan = $_POST['vlan'];
        $equip = $_POST['equip'];
        $group_id = [];
        $bw_port_all = 0;
        if(isset($_POST['reserve']) && $_POST['reserve'] != '' && $_POST['reserve'] != ' ' ){
            $Service_info = Service::find($id_servivio);
            $reserve = Reserve::find($_POST['reserve']);
            $reserve->status = 'ASIGNADO';
            $reserve->id_service = $id_servivio;
            $reserve->save();
            ControllerUser_history::store("Asigno la reserva #".$reserve->number_reserve ." al servicio ".$Service_info->number);
        }
        foreach ($port as $value) {
            $id_group = ControllerService_Port::id_lacp($value);
            $group_id[] = $id_group;
        }
        foreach ($group_id as $bw_port) {
            $bw_all= DB::table('port_equipment_model')
                ->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->join('port', 'port.id_board', '=', 'board.id')
                ->join('lacp_port', 'port.id_lacp_port', '=', 'lacp_port.id')
                ->where('lacp_port.id', '=', $bw_port)
                ->select(DB::raw("SUM(port_equipment_model.bw_max_port) as bw"))->get();
            if($bw_all[0]->bw != null) {
                $bw_port_all = $bw_port_all + $bw_all[0]->bw;
            }
        }
        $type = DB::table("service")
            ->join('list_service_type', 'service.id_type', '=', 'list_service_type.id')
            ->where('service.id', '=', $id_servivio)
            ->select('list_service_type.require_ip', 'list_service_type.require_rank','service.number', 'service.bw_service')->get();
        if($type[0]->bw_service <= $bw_port_all){
            $bw_bajo = 0;
        }else{
            $bw_bajo = 1;
        }
        if ($type[0]->require_ip == 'SI' && $ip_admin != 0) {
            $validar_ip = IP::find($ip_admin);
            if ($validar_ip->id_equipment_wan != $equip && $ip_admin != '') {
                if ($validar_ip->id_status != 1) {
                    return array('resul' => 'ip_exi' );
                }
                if ($validar_ip->id_use_vlan == '' || $validar_ip->id_use_vlan == null) {
                    return array('resul' => 'ip_ring' );
                }
                $ip_wan_equi = DB::table("ip")->select('ip.id')
                    ->where('ip.id_equipment_wan','=',$equip)->get();
                if (count($ip_wan_equi) == 0) {
                    $ip = IP::find($ip_admin);
                    $ip->id_status = 2;
                    $ip->id_service = $id_servivio;
                    $ip->id_equipment_wan = $equip;
                    $ip->save();
                    $equip_data = Equipment::find($equip);
                    $recor = new Record_ip();
                    $recor->id_ip = $ip_admin;
                    $recor->prefixes = $ip->prefixes;
                    $recor->attribute = 'El Equipo: '.$equip_data->acronimo.' seleccino la ip wan';
                    $recor->id_user= Auth::user()->id;
                    $recor->save();
                }
            }
        }
        if ($type[0]->require_rank == 'SI' && ($ip_rank != 0 || $ip_rank != '')) {
            $rango = 'yes';
            $IP_sele =IP::find($ip_rank);
            $ran_ip = ControllerIP::rango($IP_sele->ip.'/'.$IP_sele->prefixes);
            $ini_fin_ip = ControllerIP::ipv4_ini_fin($IP_sele->ip.'/'.$IP_sele->prefixes);
            $ip_array[] = array(
                'ip' => $ini_fin_ip['inicio'],
                'rama' => $IP_sele->id_branch,
            );
            foreach ($ran_ip as $valores) {
                $ip_array[] = array(
                    'ip' => $valores,
                    'rama' => $IP_sele->id_branch,
                );
            }
            $ip_array[] = array(
                'ip' => $ini_fin_ip['fin'],
                'rama' => $IP_sele->id_branch,
            );
            foreach ($ip_array as $value_ip) {
                $buscar = DB::table("ip")->select('ip.id', 'ip.id_status')
                    ->where('ip.ip', '=', $value_ip['ip'])
                    ->where('ip.id_branch', '=', $value_ip['rama'])->get();
                $ip_full[] = array('ip' => $buscar[0]->id, );
                if ($buscar[0]->id_status != 1) {
                    $rango = 'NO';
                }
            }
            if ($rango == 'NO') {
                return array('resul' => 'rank_exi' );
            }else{
                foreach ($ip_full as $valore) {
                    $IP_sele =IP::find($valore['ip']);
                    $IP_sele->id_status = 2;
                    $IP_sele->id_service = $id_servivio;
                    $IP_sele->id_equipment_wan = null;
                    $IP_sele->save();
                    $recor = new Record_ip();
                    $recor->id_ip = $IP_sele->id;
                    $recor->prefixes = $IP_sele->prefixes;
                    $recor->attribute = 'La ip fue asignada al servicio '.$type[0]->number;
                    $recor->id_user= Auth::user()->id;
                    $recor->save();
                }
            }
        }
        foreach ($group_id as $por_lacp){
            $servi_exi = DB::table("service_port")
                ->where('service_port.id_lacp_port', '=', $por_lacp)
                ->where('service_port.id_service', '=', $id_servivio)
                ->select('service_port.id')->get();
            if (count($servi_exi) == 0) {
                $servicios = new Service_Port();
                $servicios->id_service = $id_servivio;
                $servicios->vlan = $vlan;
                $servicios->id_lacp_port = $por_lacp;
                $servicios->save();
            }
        }
        $Service_info = Service::find($id_servivio);
        ControllerUser_history::store("Agrego recurso al servicio ".$Service_info->number);
        return array('resul' => 'yes', 'datos' =>$bw_bajo );
    }

    public static function id_port($port, $placa, $type = 'SERVICIO', $id_status = 1){
        try {
            $puerto = DB::table("port")
                ->where('port.id_board', '=', $placa)
                ->where('port.n_port', '=', $port)
                ->select('port.id')->get();
            if (count($puerto)>0) {
                $id = $puerto[0]->id;
            } else {
                $port_new = new Port();
                $port_new->id_board = $placa;
                $port_new->n_port = $port;
                $port_new->id_status = $id_status;
                $port_new->type = $type;
                $port_new->save();
                $id = $port_new->id;
            }
            return $id;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function id_lacp($port_id){
        $port = Port::find($port_id);
        if ($port->id_lacp_port != null && $port->id_lacp_port != '') {
            $lacp_id = $port->id_lacp_port;
        }else{
            $lacp_new = new Lacp_Port();
            $lacp_new->group_lacp = 'NO';
            $lacp_new->save();
            $lacp_id = $lacp_new->id;
            $port_new = Port::find($port_id);
            $port_new->id_lacp_port = $lacp_id;
            $port_new->id_status = 1;
            $port_new->save();
        }
        return $lacp_id;
    }

    public function service_port_list(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $id = $_POST['id'];
        $datos = [];
        $info = DB::table("service")
            ->join('list_service_type', 'service.id_type', '=', 'list_service_type.id')
            ->join('service_port', 'service_port.id_service', '=', 'service.id')
            ->Join('lacp_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
            ->join('port', 'port.id_lacp_port', '=', 'lacp_port.id')
            ->join('board', 'port.id_board', '=', 'board.id')
            ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
            ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
            ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->where('service.id', '=', $id)
            ->whereNull('lacp_port.lacp_number')
            ->select('equipment.acronimo', 'board.slot', 'port.n_port', 'service.id', 'equipment.id as equipo', 'list_service_type.require_ip', 'list_label.name', 'service_port.id as s_por', 'service_port.vlan', 'lacp_port.commentary', 'port.id as port_id', 'lacp_port.id as lacp', 'ip.ip', 'ip.prefixes', 'equipment.ip_wan_rpv')
            ->groupBy('equipment.acronimo','board.slot','port.n_port','service.id','equipment.id', 'list_service_type.require_ip','list_label.name','service_port.id', 'service_port.vlan','lacp_port.commentary','port.id','lacp_port.id','ip.ip','ip.prefixes','equipment.ip_wan_rpv')->get();
        foreach ($info as $value) {
            $fsp_label = ControllerRing::label_por($value->slot);
            $vlan = '';
            $commentary = '';
            $port_id = '';
            $ip_real = $value->ip_wan_rpv;
            if ($value->vlan != null) {
                $vlan = $value->vlan;
            }
            if ($value->commentary != null) {
                $commentary = $value->commentary;
            }
            if ($value->port_id != null) {
                $port_id = $value->port_id;
            }
            if ($value->ip != null && $value->ip != '') {
                $ip_real = $value->ip.'/'.$value->prefixes;
            }
            $datos[] = array(
                'slot' => $value->name.' '.$fsp_label,
                'acronimo' => $value->acronimo.' - '.$ip_real,
                'n_port' => $value->n_port,
                'id' => $id,
                'port' => $value->s_por,
                'equipo' => $value->equipo,
                'require_ip' => $value->require_ip,
                'group' => '',
                'id_group' => $value->lacp,
                'port_id' => $port_id,
                'vlan' => $vlan,
                'fsp' => $fsp_label,
                'commentary' => $commentary,
            );
        }
        $info_group = DB::table("service")
            ->join('list_service_type', 'service.id_type', '=', 'list_service_type.id')
            ->join('service_port', 'service_port.id_service', '=', 'service.id')
            ->Join('lacp_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
            ->join('port', 'port.id_lacp_port', '=', 'lacp_port.id')
            ->join('board', 'port.id_board', '=', 'board.id')
            ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
            ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
            ->where('service.id', '=', $id)
            ->where('lacp_port.group_lacp', '=', 'SI')
            ->select('equipment.acronimo', 'equipment.id as equipo', 'lacp_port.lacp_number', 'list_service_type.require_ip', 'service_port.vlan', 'lacp_port.id as lacp', 'ip.ip', 'ip.prefixes')
            ->groupBy('equipment.acronimo', 'equipment.id', 'lacp_port.lacp_number', 'list_service_type.require_ip', 'service_port.vlan', 'lacp_port.id', 'ip.ip', 'ip.prefixes', 'ip.ip', 'ip.prefixes')->get();
        foreach ($info_group as $key) {
            $info_individual = DB::table("service")
                ->join('list_service_type', 'service.id_type', '=', 'list_service_type.id')
                ->join('service_port', 'service_port.id_service', '=', 'service.id')
                ->Join('lacp_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
                ->join('port', 'port.id_lacp_port', '=', 'lacp_port.id')
                ->join('board', 'port.id_board', '=', 'board.id')
                ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
                ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
                ->where('service.id', '=', $id)
                ->where('lacp_port.id', '=', $key->lacp)
                ->select('board.slot', 'port.n_port', 'list_label.name', 'service_port.id as s_por', 'lacp_port.commentary')->orderBy('n_port', 'asc')->get();
            $port_all ='';
            $all_id = '';
            foreach ($info_individual as $valor) {
                $fsp = ControllerRing::label_por($valor->slot);
                if ($port_all == '') {
                    $port_all = $valor->name.$fsp.$valor->n_port.' ';
                }else{
                    $port_all = $port_all.'- '.$valor->name.$fsp.$valor->n_port.' ';
                }
                if ($all_id == '') {
                    $all_id = $valor->s_por;
                }else{
                    $all_id = $all_id.'.'.$valor->s_por;
                }

            }
            if ($key->vlan == null) {
                $vlan_grou = '';
            }else{
                $vlan_grou = $key->vlan;
            }
            if ($info_individual[0]->commentary == null) {
                $commentary_grou = '';
            }else{
                $commentary_grou = $info_individual[0]->commentary;
            }
            $datos[] = array(
                'slot' => '',
                'acronimo' => $key->acronimo.' - '.$key->ip.'/'.$key->prefixes,
                'n_port' => $port_all,
                'id' => $id,
                'port' => $info_individual[0]->s_por,
                'require_ip' => $key->require_ip,
                'group' => $key->lacp_number,
                'id_group' => $key->lacp,
                'equipo' => $key->equipo,
                'port_id' => 0,
                'vlan' => $vlan_grou,
                'fsp' => 0,
                'commentary' => $commentary_grou,
            );
        }
        if (count($datos) > 0) {
            $pose_order  = array_column($datos, 'fsp');
            $port_order  = array_column($datos, 'n_port');
            array_multisort($pose_order, SORT_ASC, $port_order, SORT_ASC, $datos);
        }
        return array('resul' => 'yes', 'datos' => $datos,);
    }

    public function delete_port_service(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(15);
        if ($authori_status['permi'] >= 5){
            $port = $_POST['port'];
            $id = $_POST['id'];
            $sql = DB::table("service_port")
                ->where('service_port.id_lacp_port', '=', $port)
                ->where('service_port.id_service', '=', $id)
                ->select('service_port.id')->get();
            foreach ($sql as $value) {
                $service = Service_Port::find($value->id);
                $service->delete();
            }
            $validar = DB::table("service_port")
                ->where('service_port.id_lacp_port', '=', $port)
                ->select('service_port.id')->get();
            if (count($validar) == 0) {
                $sql_lacp = Lacp_Port::find($port);
                $port_free = DB::table("port")
                    ->where('port.id_lacp_port', '=', $port)
                    ->select('port.id')->get();
                if ($sql_lacp->group_lacp != 'SI') {
                    $port_old = Port::find($port_free[0]->id);
                    $port_old->id_status = 2;
                    $port_old->type = null;
                    $port_old->id_lacp_port = null;
                    $port_old->commentary = null;
                    $port_old->save();
                    $lacp_port = Lacp_Port::find($port);
                    $lacp_port->delete();
                }
            }
            $Service_info = Service::find($id);
            ControllerUser_history::store("Quito recurso al servicio ".$Service_info->number);
            $resulta = array('resul' => 'yes',);
        }else{
            $resulta = array('resul' => 'autori',);
        }
        return $resulta;
    }

    public function insert_port_service(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $id = $_POST['id'];
        $port = $_POST['port'];
        $board = $_POST['board'];
        $id_port = ControllerService_Port::id_port($port, $board);
        $validar = Port::find($id_port);
        if ($validar->id_lacp_por != null && $validar->id_lacp_por != '') {
            $servi_id= DB::table("service_port")
                ->where('service_port.lacp_number', '=', $validar->lacp_number)
                ->select('service_port.id')->get();
            foreach ($servi_id as $value) {
                $servi_new =Service_Port::find($port);
                $servi_new->id_lacp_port = $id;
                $servi_new->save();
            }
            $group_delete = Lacp_Port::find($validar->id_lacp_por);
            $group_delete->delete();
        }
        $port_new = Port::find($id_port);
        $port_new->id_status = 1;
        $port_new->id_lacp_port = $id;
        $port_new->type = 'SERVICIO';
        $port_new->save();
        return array('resul' => 'yes',);
    }

    public function ip_liberal_sevir($id){
        $existe= DB::table("service_port")
            ->where('service_port.id_service', '=', $id)
            ->select('service_port.id')->get();
        if (count($existe) == 0) {
            $ip_li= DB::table("ip")
                ->where('ip.id_service', '=', $id)
                ->select('ip.id', 'ip.id_equipment', 'ip.id_client', 'ip.id_use_vlan')->get();
            foreach ($ip_li as $ip_id) {
                $IP_old = IP::find($ip_id->id);
                if ($ip_id->id_equipment == null && $ip_id->id_client == null && $ip_id->id_use_vlan == null) {
                    $IP_old->id_status = 1;
                }
                $IP_old->id_service = null;
                $IP_old->save();
            }
        }
    }

    public function port_libre(Request $request){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $id=$_POST['id'];
        $port = DB::table('equipment')
            ->join('board', 'board.id_equipment', '=', 'equipment.id')
            ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
            ->where('equipment.id', '=', $id)
            ->where('board.status', '=', 'ACTIVO')
            ->select('list_label.name as label', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'board.slot', 'list_module_board.name as model', 'board.id')->orderBy('slot', 'asc')->orderBy('port_l_i', 'asc')->get();
        $data_mostrar = [];
        foreach ($port as $val) {
            $fsp_label=ControllerRing::label_por($val->slot);
            for ($z=$val->port_l_i; $z <= $val->port_l_f; $z++) {
                $status = '2';
                $status_name = 'VACANTE';
                $grupos = '';
                $id_port = '';
                $type = '';
                $status_por = DB::table('port')
                    ->join('status_port', 'port.id_status', '=', 'status_port.id')
                    ->leftJoin('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
                    ->leftJoin('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
                    ->where('port.id_board', '=', $val->id)
                    ->where('port.n_port', '=', $z)
                    ->select('port.id_status','status_port.name as status', 'lacp_port.lacp_number', 'port.type', 'port.id', 'port.type')->get();
                if (count($status_por) > 0){
                    $status = $status_por[0]->id_status;
                    $status_name = $status_por[0]->status;
                    $grupos = $status_por[0]->lacp_number;
                    $id_port = $status_por[0]->id;
                    $type = $status_por[0]->type;
                }
                if (($grupos == '' || $grupos == null) && $type != 'ANILLO') {
                    $number = ControllerService::number_service($z, $val->id);
                    $data_mostrar[] = array(
                        'f_s_p' => $fsp_label,
                        'por_selec' => $z,
                        'label' => $val->label,
                        'model' => $val->model,
                        'id' => $z.','.$val->id,
                        'board' => $val->id,
                        'status' => $status_name,
                        'servicios' => $number,
                        'id_port' => $id_port,
                        'id_po_bo' => $z.'~'.$val->id,
                    );
                }
            }

            //obtener todos los lacp del equipo, recibe id del equipo. Seleccionar el lacp que se quiere editar
            $lacps = ControllerPort::get_lacp_groups_of_equipment($id);
            foreach($lacps as $lacp){
                if($lacp['id'] == $request->lacp_id){
                    $lacp_to_be_edited = $lacp;
                }
                else{
                    $lacp_to_be_edited = null;
                }
            }
        }

        //encontrar los puertos pertenecientes al LACP seleccionado
        if($request->has('lacp_id')){
            $ports_in_selected_lacp = ControllerLacp_Port::get_ports_data_of_specific_lacp_port($request->lacp_id);

            foreach($ports_in_selected_lacp as $port)
            {
                $port_slot = str_replace(['/', '|'], ['', '/'], $port->slot);
                $data_mostrar[] = array(
                    'f_s_p'     => $port_slot,
                    'por_selec' => $port->n_port,
                    'label'     => $port->label,
                    'model'     => $port->model,
                    'id'        => $port->n_port.','.$port->id_board,
                    'board'     => $port->id_board,
                    'status'    => 'PUERTO DEL LACP',
                    'servicios' => "",
                    "id_port"   => '',
                    'id_po_bo'  => $port->n_port.'~'.$port->id_board,
                );
            }
        }

        if (count($data_mostrar) > 0) {
            $port_order  = array_column($data_mostrar, 'por_selec');
            $pose_order  = array_column($data_mostrar, 'f_s_p');
            array_multisort($pose_order, SORT_ASC, $port_order, SORT_ASC, $data_mostrar);
        }

        //dd($data_mostrar);
        return array('resul' => 'yes', 'datos' => $data_mostrar,);
    }

    public function index_port_service_group(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $port=$_POST['port'];
        $datos = [];
        $por = DB::table('port')
            ->Join('lacp_port', 'port.id_lacp_port', '=', 'lacp_port.id')
            ->Join('service_port', 'service_port.id_lacp_port', '=', 'lacp_port.id')
            ->Join('board', 'port.id_board', '=', 'board.id')
            ->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->Join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
            ->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->where('port.id_lacp_port', '=', $port)
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

    public function delete_port_service_group(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(15);
        if ($authori_status['permi'] >= 5) {
            $id = $_POST['id'];
            $port = Port::find($id);
            $service_bw = 0;
            $group_bw = 0;
            $bw_service = DB::table('service')
                ->join('service_port', 'service_port.id_service', '=', 'service.id')
                ->where('service_port.id_lacp_port', '=', $port->id_lacp_port)
                ->select(DB::raw("SUM(service.bw_service) as service"))->get();
            if($bw_service[0]->service != null) {
                $service_bw = $bw_service[0]->service;
            }
            $bw_grupo = DB::table('port')
                ->join('board', 'port.id_board', '=', 'board.id')
                ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->where('port.id_lacp_port', '=', $port->id_lacp_port)
                ->where('port.id', '!=', $id)
                ->select(DB::raw("SUM(port_equipment_model.bw_max_port) as grupo"))->get();
            if($bw_grupo[0]->grupo != null) {
                $group_bw = $bw_grupo[0]->grupo;
            }

            if ($group_bw < $service_bw) {
                return array('resul' => 'nop',);
            }else{
                $port_free = Port::find($id);
                $port_free->id_status = 2;
                $port_free->id_lacp_port = null;
                $port_free->type = null;
                $port_free->commentary = null;
                $port_free->save();
                return array('resul' => 'yes',);
            }
        }else{
            return array('resul' => 'autori', );
        }
    }

    public function insert_port_lacp(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(15);
        if ($authori_status['permi'] >= 5) {
            $port=$_POST['port'];
            $board=$_POST['board'];
            $group=$_POST['group'];
            $id_port = ControllerService_Port::id_port($port, $board);
            $port_status = Port::find($id_port);
            $port_status->id_status = 1;
            $port_status->id_lacp_port = $group;
            $port_status->type = "SERVICIO";
            $port_status->save();
            $port_info = DB::table('port')
                ->Join('board', 'port.id_board', '=', 'board.id')
                ->Join('lacp_port', 'port.id_lacp_port', '=', 'lacp_port.id')
                ->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
                ->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
                ->where('port.id', '=', $port_status->id)
                ->select('equipment.acronimo', 'board.slot', 'port.n_port', 'list_label.name', 'lacp_port.lacp_number')->get();
            $fsp_label = ControllerRing::label_por($port_info[0]->slot);
            $msj_info = $port_info[0]->name.$fsp_label.$port_info[0]->n_port;
            ControllerUser_history::store("Agrego el puerto ".$msj_info." al grupo ".$port_info[0]->lacp_number." del equipo ".$port_info[0]->acronimo);
            return array('resul' => 'yes',);
        }else{
            return array('resul' => 'autori', );
        }
    }

    public function index_port_group(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $group=$_POST['id'];
        $datos = [];
        $port_sql = DB::table('port')
            ->Join('lacp_port', 'port.id_lacp_port', '=', 'lacp_port.id')
            ->Join('board', 'port.id_board', '=', 'board.id')
            ->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->Join('list_module_board', 'port_equipment_model.id_module_board', '=', 'list_module_board.id')
            ->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->where('port.id_lacp_port', '=', $group)
            ->select('port.id', 'port.n_port', 'board.slot', 'list_module_board.name as model', 'list_label.name as label', 'board.id as board')->get();
        foreach ($port_sql as $value) {
            $slot=ControllerRing::label_por($value->slot);
            $number = ControllerService::number_service($value->n_port, $value->board);
            $datos[] = array(
                'id' => $value->id,
                'n_port' => $value->n_port,
                'slot' => $value->label.$slot,
                'model' => $value->model,
                'board' => $value->board,
                'service' => $number,
                'f_s_p' => $slot,
            );
        }
        if (count($datos)>0) {
            $port_order  = array_column($datos, 'n_port');
            $pose_order  = array_column($datos, 'f_s_p');
            array_multisort($pose_order, SORT_ASC, $port_order, SORT_ASC, $datos);
        }
        return array('resul' => 'yes', 'datos' => $datos,);
    }

    public function delecte_port_group(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $port=$_POST['id'];
        $servi = 0;
        $group = 0;
        $puerto = 0;
        $port_sql = Port::find($port);
        $bw_sql_servi = DB::table('service_port')
            ->Join('service', 'service_port.id_service', '=', 'service.id')
            ->where('service_port.id_lacp_port', '=', $port_sql->id_lacp_port)
            ->where('service.status', '=', 'ALTA')
            ->select(DB::raw("SUM(service.bw_service) as bw"))->get();
        if ($bw_sql_servi[0]->bw != null && $bw_sql_servi[0]->bw != '') {
            $servi = $bw_sql_servi[0]->bw;
        }
        $bw_sql_group = DB::table('port')
            ->Join('board', 'port.id_board', '=', 'board.id')
            ->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->where('port.id_lacp_port', '=', $port_sql->id_lacp_port)
            ->select(DB::raw("SUM(port_equipment_model.bw_max_port) as bw"))->get();
        if ($bw_sql_group[0]->bw != null && $bw_sql_group[0]->bw != '') {
            $group = $bw_sql_group[0]->bw;
        }
        $bw_sql_port = DB::table('port')
            ->Join('board', 'port.id_board', '=', 'board.id')
            ->Join('equipment', 'board.id_equipment', '=', 'equipment.id')
            ->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->Join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->where('port.id', '=', $port)
            ->select('port_equipment_model.bw_max_port', 'equipment.acronimo', 'board.slot', 'port.n_port', 'list_label.name')->get();
        if (count($bw_sql_port)>0) {
            $puerto = $bw_sql_port[0]->bw_max_port;
            $group_info = Lacp_Port::find($port_sql->id_lacp_port);
            $fsp_label = ControllerRing::label_por($bw_sql_port[0]->slot);
            $msj_info = $bw_sql_port[0]->name.$fsp_label.$bw_sql_port[0]->n_port;
            ControllerUser_history::store("Quito el puerto ".$msj_info." al grupo ".$group_info->lacp_number." del equipo ".$bw_sql_port[0]->acronimo);
        }
        $new_group = $group - $puerto;
        if ($new_group < $servi) {
            $data = array('resul' => 'nop');
        }else{
            $port_free = Port::find($port);
            $port_free->id_status = 2;
            $port_free->type = null;
            $port_free->commentary = null;
            $port_free->id_lacp_port = null;
            $port_free->save();
            $data = array('resul' => 'yes');
        }
        return $data;
    }

	/**
	 * Registrar asignación de servicio internet dedicado (Agg común) a equipo
	 */
	public function register_internet_wan_assignment() {
		try {
            if (Auth::guest()) throw new Error('login');
			// Permisos. 
            
            // Valida que no se omita información
			if (empty($_POST['service_id'])) throw new Error('No se seleccionó ningun servicio');
            else if (empty($_POST['frontier_id'])) throw new Error('No se seleccionó ninguna frontera');
            else if (empty($_POST['vlan'])) throw new Error('No se seleccionó ninguna vlan');
			else if (empty($_POST['ports'])) throw new Error('No se seleccionó ningun puerto');
			else if ($_POST['is_ds'] === 'false' && empty($_POST['ip_id'])) throw new Error('No se seleccionó ninguna IP');
            else if ($_POST['is_ds'] === 'true' && empty($_POST['ds_subnet_id'])) throw new Error('No se seleccionó ninguna subred /30');
            else if ($_POST['is_ds'] === 'true' && empty($_POST['ctag'])) throw new Error('No se seleccionó ningun CTAG');
			else if (empty($_POST['public_subnet_id'])) throw new Error('No se seleccionó ningun rango IP público');

            // Valida que la frontera no haya cambiado durante la operación
            if (!Self::validate_before_assign($_POST['frontier_id'], $_POST['frontier_avail']))
				throw new Error('La frontera fue modifcada por otro usuario');

            // Si es una vlan existente modifica el registro, si es nueva lo crea y se la asigna a la subred
			if (!empty($_POST['use_vlan_id'])) {
				$vlan = Use_Vlan::find($_POST['use_vlan_id']);
				$vlan->status = 'ASIGNADO';
				$vlan->save();
			} else {
				$vlan = new Use_Vlan;
				$vlan->vlan = $_POST['vlan'];
				$vlan->id_list_use_vlan = 3;
				$vlan->id_ring = $_POST['ring_id'];
				$vlan->id_frontera = $_POST['frontier_id'];
				$vlan->status = 'ASIGNADO';
				$vlan->save();
                if ($_POST['is_ds'] === 'false') {
                    $subnet = IP::find($_POST['wan_subnet_id']);
				    $subnet_ips = ControllerIP::ip_by_subnet($subnet->ip, $subnet->prefixes, $subnet->id_branch);
				    $sip_ids = [];
				    foreach ($subnet_ips as $sip) $sip_ids[] = $sip->id;
				    IP::whereIn('id', $sip_ids)->update(['id_use_vlan' => $vlan->id]);
                }
			}

            // Si es DS registra subred /30. Si NO es DS registra IP wan
            if ($_POST['is_ds'] === 'true') {
                $ds_subnet = IP::find($_POST['ds_subnet_id']);
				$ds_subnet_ips = ControllerIP::ip_by_subnet($ds_subnet->ip, $ds_subnet->prefixes, $ds_subnet->id_branch);
				$dsip_ids = [];
				foreach ($ds_subnet_ips as $dsip) $dsip_ids[] = $dsip->id;
				IP::whereIn('id', $dsip_ids)->update(['id_use_vlan' => $vlan->id, 'id_service' => $_POST['service_id'], 'id_status' => 2]);
            } else {
                $ip = IP::find($_POST['ip_id']);
			    $ip->id_status = 2;
			    $ip->id_equipment_wan = $_POST['equip_id'];
			    $ip->save();
            }

            // Se registra rango IP publico
			$public_subnet = IP::find($_POST['public_subnet_id']);
            $public_subnet_ips = ControllerIP::ip_by_subnet($public_subnet->ip, $public_subnet->prefixes, $public_subnet->id_branch);
            $psip_ids = [];
            foreach ($public_subnet_ips as $psip) $psip_ids[] = $psip->id;
            IP::whereIn('id', $psip_ids)->update(['id_service' => $_POST['service_id'], 'id_status' => 2]);

            // Registro de puertos
			foreach ($_POST['ports'] as $pt) {
				$port = Port::find($pt);
				if (empty($port)) {
                    throw new Error('Hay puertos sin registrar en BD');
				} else {
					$port->id_status = 1;
					$port->commentary = $_POST['service_id'];
					if (!empty($port->id_lacp_port)) {
						$service_port = Service_Port::where('id_lacp_port', $port->id_lacp_port)->first();
						if (!empty($service_port)) {
							$service_port->id_service = $_POST['service_id'];
						} else {
							$service_port = new Service_Port;
							$service_port->id_lacp_port = $port->id_lacp_port;
							$service_port->id_service = $_POST['service_id'];
						}
					} else {
						$lacp_port = new Lacp_Port;
						$lacp_port->group_lacp = 'NO';
						$lacp_port->save();
						$port->id_lacp_port = $lacp_port->id;
						$service_port = new Service_Port;
						$service_port->id_lacp_port = $lacp_port->id;
						$service_port->id_service = $_POST['service_id'];
					}
					$port->save();
					$service_port->save();
				}
			}

            // Registro de la asignación de servicio
			$asignment = new Asignacion_Servicio_Vlan;
			$asignment->id_service = $_POST['service_id'];
			$asignment->id_use_vlan = $vlan->id;
            if ($_POST['is_ds'] === 'true') $asignment->ctag = $_POST['ctag'];
            $asignment->usuario = Auth::user()->id;
			$asignment->estado = 'ASIGNADO';
			$asignment->save();

            // Registro de la operación por parte del usuario
			$service = Service::find($_POST['service_id']);
			$equipment = Equipment::find($_POST['equip_id']);
			ControllerUser_history::store("Asignó el servicio $service->number al equipo $equipment->acronimo");
			return $asignment->id;
		} catch (Error $e) {
            return $e->getMessage();
		}
	}

    /**
     * Valida que la frontera no haya cambiado durante la operación
     */
	public static function validate_before_assign($frt_id, $available_bw) {
		$frt = Link::find($frt_id, ['bw_limit']);
		$occupancy = Link::get_occupancy($frt_id);
		$capacity = intval($frt->bw_limit);
		$frt_ok = intval($available_bw) == ($capacity - $occupancy) ? true : false;
		return $frt_ok;
	}

    /**
	 * Registrar asignación de servicio internet dedicado (Agg BVI) a equipo
	 */
	public function register_internet_bv_assignment() {
		try {
            if (Auth::guest()) throw new Error('login');
			// Permisos. 
            
            // Valida que no se omita información
			if (empty($_POST['service_id'])) throw new Error('No se seleccionó ningun servicio');
            else if (empty($_POST['vlan'])) throw new Error('No se seleccionó ninguna vlan');
			else if (empty($_POST['ports'])) throw new Error('No se seleccionó ningun puerto');
			else if ($_POST['is_ds'] === 'false' && empty($_POST['ip_id'])) throw new Error('No se seleccionó ninguna IP');
            else if ($_POST['is_ds'] === 'true' && empty($_POST['ds_subnet_id'])) throw new Error('No se seleccionó ninguna subred /30');
			else if (empty($_POST['public_subnet_id'])) throw new Error('No se seleccionó ningun rango IP público');

            // Valida que la frontera no haya cambiado durante la operación

            // Si es una vlan existente modifica el registro, si es nueva lo crea y se la asigna a la subred
			if (!empty($_POST['use_vlan_id'])) {
				$vlan = Use_Vlan::find($_POST['use_vlan_id']);
				$vlan->status = 'ASIGNADO';
				$vlan->save();
			} else {
				$vlan = new Use_Vlan;
				$vlan->vlan = $_POST['vlan'];
				$vlan->id_list_use_vlan = 6;
				$vlan->id_ring = $_POST['ring_id'];
                $vlan->id_equipment = $_POST['agg_id'];
				$vlan->status = 'ASIGNADO';
				$vlan->save();
                if ($_POST['is_ds'] === 'false') {
                    $subnet = IP::find($_POST['wan_subnet_id']);
				    $subnet_ips = ControllerIP::ip_by_subnet($subnet->ip, $subnet->prefixes, $subnet->id_branch);
				    $sip_ids = [];
				    foreach ($subnet_ips as $sip) $sip_ids[] = $sip->id;
				    IP::whereIn('id', $sip_ids)->update(['id_use_vlan' => $vlan->id]);
                }
			}

            // Si es DS, registra subred /30. Si NO es DS, registra IP wan
            if ($_POST['is_ds'] === 'true') {
                $ds_subnet = IP::find($_POST['ds_subnet_id']);
				$ds_subnet_ips = ControllerIP::ip_by_subnet($ds_subnet->ip, $ds_subnet->prefixes, $ds_subnet->id_branch);
				$dsip_ids = [];
				foreach ($ds_subnet_ips as $dsip) $dsip_ids[] = $dsip->id;
				IP::whereIn('id', $dsip_ids)->update(['id_use_vlan' => $vlan->id, 'id_service' => $_POST['service_id'], 'id_status' => 2]);
            } else {
                $ip = IP::find($_POST['ip_id']);
			    $ip->id_status = 2;
			    $ip->id_equipment_wan = $_POST['equip_id'];
			    $ip->save();
            }

            // Se registra rango IP publico
			$public_subnet = IP::find($_POST['public_subnet_id']);
            $public_subnet_ips = ControllerIP::ip_by_subnet($public_subnet->ip, $public_subnet->prefixes, $public_subnet->id_branch);
            $psip_ids = [];
            foreach ($public_subnet_ips as $psip) $psip_ids[] = $psip->id;
            IP::whereIn('id', $psip_ids)->update(['id_service' => $_POST['service_id'], 'id_status' => 2]);

            // Registro de puertos
			foreach ($_POST['ports'] as $pt) {
				$port = Port::find($pt);
				if (empty($port)) {
					throw new Error('Hay puertos sin registrar en BD');
				} else {
                    $port->id_status = 1;
					$port->commentary = $_POST['service_id'];
					if (!empty($port->id_lacp_port)) {
						$service_port = Service_Port::where('id_lacp_port', $port->id_lacp_port)->first();
						if (!empty($service_port)) {
							$service_port->id_service = $_POST['service_id'];
						} else {
							$service_port = new Service_Port;
							$service_port->id_lacp_port = $port->id_lacp_port;
							$service_port->id_service = $_POST['service_id'];
						}
					} else {
						$lacp_port = new Lacp_Port;
						$lacp_port->group_lacp = 'NO';
						$lacp_port->save();
						$port->id_lacp_port = $lacp_port->id;
						$service_port = new Service_Port;
						$service_port->id_lacp_port = $lacp_port->id;
						$service_port->id_service = $_POST['service_id'];
					}
					$port->save();
					$service_port->save();
				}
			}

            // Registro de la asignación de servicio
			$asignment = new Asignacion_Servicio_Vlan;
			$asignment->id_service = $_POST['service_id'];
			$asignment->id_use_vlan = $vlan->id;
            $asignment->usuario = Auth::user()->id;
			$asignment->estado = 'ASIGNADO';
			$asignment->save();

            // Registro de la operación por parte del usuario
			$service = Service::find($_POST['service_id']);
			$equipment = Equipment::find($_POST['equip_id']);
			ControllerUser_history::store("Asignó el servicio $service->number al equipo $equipment->acronimo");
			return $asignment->id;
		} catch (Error $e) {
            return $e->getMessage();
		}
	}

    /**
     * Registrar servicios varios a equipo
     */
    public function register_service_assignment() {
        try {
            if (Auth::guest()) throw new Error('login');
            // Permisos. 
            
            // Valida que no se omita información
            if (empty($_POST['service_id'])) throw new Error('No se seleccionó ningun servicio');
            else if (empty($_POST['vlan'])) throw new Error('No se seleccionó ninguna vlan');
            else if (empty($_POST['ports'])) throw new Error('No se seleccionó ningun puerto');
            if (intval($_POST['vlan']) < 1 || intval($_POST['vlan']) > 4095) throw new Error('La VLAN debe ser de 0001 a 4095');
            
            // Registro de puertos especificando la vlan
            foreach ($_POST['ports'] as $pt) {
                $port = Port::find($pt);
                if (empty($port)) {
                    throw new Error('Hay puertos sin registrar en BD');
                } else {
                    $port->id_status = 1;
                    $port->commentary = $_POST['service_id'];
                    if (!empty($port->id_lacp_port)) {
                        $service_port = Service_Port::where('id_lacp_port', $port->id_lacp_port)->first();
                        if (!empty($service_port)) {
                            $service_port->id_service = $_POST['service_id'];
                        } else {
                            $service_port = new Service_Port;
                            $service_port->id_lacp_port = $port->id_lacp_port;
                            $service_port->id_service = $_POST['service_id'];
                            $service_port->vlan = $_POST['vlan'];
                        }
                    } else {
                        $lacp_port = new Lacp_Port;
                        $lacp_port->group_lacp = 'NO';
                        $lacp_port->save();
                        $port->id_lacp_port = $lacp_port->id;
                        $service_port = new Service_Port;
                        $service_port->id_lacp_port = $lacp_port->id;
                        $service_port->id_service = $_POST['service_id'];
                        $service_port->vlan = $_POST['vlan'];
                    }
                    $port->save();
                    $service_port->save();
                }
            }

            // Registro de la operación por parte del usuario
            $service = Service::find($_POST['service_id']);
            $equipment = Equipment::find($_POST['equip_id']);
            ControllerUser_history::store("Asignó el servicio $service->number al equipo $equipment->acronimo");
            return $service_port->id;
        } catch (Error $e) {
            return $e->getMessage();
        }
    }

    /**
     * Registrar asignación de servicio RPV a equipo
     *
     */
    public function register_rpv_assignment(Request $request)
    {

        try {
            if (Auth::guest()) throw new Error('login');
            // Permisos. Corroborar qué información consultar para obtener el permiso.

            // Valida que no se omita información
            if (empty($request->service_id))  throw new Error('No se seleccionó ningun servicio');
            if (empty($request->vlan_number)) throw new Error('No se seleccionó ninguna vlan');
            if (empty($request->ports))       throw new Error('No se seleccionó ningun puerto');

            // Si es una vlan existente modifica el registro, si es nueva lo crea y se la asigna a la subred
            if (empty($request->vlan_id)) {

                $vlan       = new Use_Vlan;
                $vlan->vlan = $request->vlan_number;

                if(!$request->is_multihome){
                    $vlan->id_list_use_vlan = Constants::VLAN_TYPE_RPV_Y_TIP;
                }

                if($request->is_multihome){
                    $vlan->id_list_use_vlan = Constants::VLAN_TYPE_RPV_MH;
                }

                $vlan->id_ring      = $request->ring_id;
                $vlan->id_equipment = $request->agg_id;
                $vlan->status       = 'ASIGNADO';
                $vlan->save();

                //asignacion_service_vlan
                $asignacion              = new Asignacion_Servicio_Vlan();
                $asignacion->id_service  = $request->service_id;
                $asignacion->id_use_vlan = $vlan->id;
                $asignacion->ctag        = $request->ctag;
                $asignacion->usuario     = Auth::user()->id;
                $asignacion->estado      = "ASIGNADO";
                $asignacion->save();
            }

            // puertos
            foreach ($request->ports as $index => $port){
                $pt             = Port::find($port);
                $pt->id_status  = Constants::OCCUPIED_PORT;
                $pt->commentary = $request->service_id;
                $pt->save();

                $service_port                   = new Service_Port();
                if(!isset($pt->id_lacp_port)){
                    $lacp_port                  = new Lacp_Port;
                    $lacp_port->group_lacp      = 'NO';
                    $lacp_port->save();

                    $pt->id_lacp_port           = $lacp_port->id;
                    $service_port->id_lacp_port = $lacp_port->id;
                    $service_port->id_service   = $request->service_id;
                }

                if(isset($pt->id_lacp_port)){
                    $service_port->id_lacp_port = $pt->id_lacp_port;
                    $service_port->id_service   = $request->service_id;
                }

                $service_port->save();

            }

            return 'añadido';

        } catch (Error $e) {
            return $e->getMessage();
        }
    }
}
