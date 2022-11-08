<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Reserve;
use Jarvis\User_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Jarvis\Http\Controllers\ControllerIP;
use Jarvis\Http\Controllers\ControllerRing;
use Jarvis\Http\Controllers\ControllerPort;
use Jarvis\Http\Controllers\ControllerEquipment;
use Jarvis\Http\Controllers\ControllerEquipment_Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Jarvis\User;
use Jarvis\Link;
use Jarvis\List_Type_Link;
use Jarvis\Client;
use Jarvis\Equipment;
use Jarvis\Chain;
use Jarvis\Port;
use Jarvis\Equipment_Model;
use Jarvis\Service;
use Jarvis\List_Service_Type;
use Jarvis\Node;
use Jarvis\Http\Requests\RequestReserve;
use Exception;

class ControllerReserve extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Auth::guest() == false) { 
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(25);
		if ($authori_status['permi'] >= 3) {
			$type_services = List_Service_Type::pluck('name','id')->toArray();
            $number_reserve = Reserve::max('number_reserve')+1;
            return view('reserve.list', compact("authori_status","type_services", "number_reserve"));
		} else {
			return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
		}
    }

    public function index_list(){
        if (!Auth::guest() == false){ 
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
       }
       $authori_status = User::authorization_status(25);
       if ($authori_status['permi'] >= 3) {
           $data = [];
           $info = Reserve::all();
           foreach ($info as $value) {
            $link = Link::find($value->id_link, ['name', 'id_node',]);
            $bw = ControllerEquipment_Model::format_bw($value->bw_reserve);
            $bw_reserved = ControllerEquipment_Model::format_bw($value->cell_bw_reserved);
            $user = User::find($value->id_user, ['name', 'last_name',]);
            $node = Node::find($link->id_node, ['cell_id', 'node']);
            $service = Service::find($value->id_service,['id','number']);
            $service!=null?$service=$service->number:$service='';
            $type_link = List_Service_Type::find($value->id_service_type, ['name']);

            $different_days = '-';
            if ($value->status == "VIGENTE") {
                $date_start = Carbon::parse($value->created_at);
                $expiration_date = $date_start->addDays($value->quantity_dates);
                $today = Carbon::now();
                $different_days = $expiration_date->diffInDays($today);
            }

            $data[] = array(
                'id' => $value->id,
                'number_reserve' => $value->number_reserve,
                'id_link' => $link->name,
                'bw' => $bw['data'].$bw['signo'], 
                'status' => $value->status,
                'date' => date($value->created_at),
                'node' => $node->cell_id.' - '.$node->node,
                'service' => $service,
                'user' => $user->name.' '.$user->last_name,
                'list_type_link' => $type_link->name,
                'quantity_dates' => $different_days,
                'days' => $value->quantity_dates,
                'cell_bw_reserved' => $bw_reserved['data'].$bw_reserved['signo'],
                'oportunity' => $value->oportunity, 
                'commentary' => $value->commentary,
                //'id_service' => $value->id_service,
                'type' => $value->type
               );
           }
             return datatables()->of($data)->make(true);
       }else{
           return redirect('home')
               ->withErrors([Lang::get('validation.authori_status'),]);
       }
    }
    
    public function list_links_related_node(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(25);
        if ($authori_status['permi'] >= 3) {
            $id = $_POST['id'];
			$data = [];
			$info = DB::table('link')
				->join('list_type_links','link.id_list_type_links','=','list_type_links.id')
				->join('node', 'link.id_node', '=', 'node.id')
				->where('node.id', '=', $id)
                ->where('list_type_links.id', '=', 3)
				->select('link.id','node.cell_id','node.node','list_type_links.name as type','link.name','link.bw_limit','link.commentary', 'node.type','node.status','node.contract_date')->get();
			foreach ($info as $value) {
				$bw = ControllerEquipment_Model::format_bw($value->bw_limit);
				$data[] = array(
					'id' => $value->id,
					'commentary' => $value->commentary,
					'type' => $value->type,
					'name' => $value->name,
					'node' => $value->cell_id.' '.$value->node,
					'bw' => $bw['data'].' '.$bw['signo'],
				);
			}
			return array('resul' => 'yes', 'data' => $data);
		}else{
			return array('resul' => 'autori', );
		}
    }

    public function get_info_bw_link(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(25);
        if ($authori_status['permi'] >= 3) {
            $id = $_POST['id_link'];
			$data = [];
            $link = Link::find($id);
            $bw_service = 0;
            $bw_anillo = 0;
            $id_equipos = [];

            if($link->id_extreme_2 != null){
                $equipo =  DB::table('port')
                ->join('board', 'board.id', '=', 'port.id_board')
		        ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
                ->where('port.id_lacp_port', '=', $link->id_extreme_2)
                ->select('equipment.id')->get();

                $ring_equipment = DB::table('board')
                ->join('port', 'port.id_board','=','board.id')
                ->join('port as por1', 'por1.id_ring','=','port.id_ring')
                ->join('board as boar1', 'boar1.id', '=', 'por1.id_board')
                ->join('equipment','equipment.id','=','boar1.id_equipment')
                ->where('board.id_equipment','=', $equipo[0]->id)
                ->select('equipment.id')->groupBy('equipment.id')->get();
                foreach ($ring_equipment as $value) {
                    $servi = DB::table('equipment')
                    ->join('board', 'board.id_equipment', '=', 'equipment.id')		    
                    ->join('port', 'port.id_board', '=', 'board.id')
                    ->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
                    ->Join('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
                    ->join('service', 'service_port.id_service', '=', 'service.id')
                    ->where('equipment.id', '=', $value->id)
                    ->select('service.id','service.bw_service')->groupBy('service.id', 'service.bw_service')->get();
                    #quizas aca habria que agregar un isset, como esta en info_bw_equipment()
                    foreach($servi as $valor){
                        $bw_anillo += $valor->bw_service;
                    }
                }
            }
			$bw_used = ControllerEquipment_Model::format_bw($bw_service + $bw_anillo);

            # Bandwidth reservado por otros tickets
            $bw_pre_reserve = 0;
            #La reserva puede tener 4 estados and that's it: VIGENTE, VENCIDO, CANCELADO, ASIGNADO
            $reserve = DB::table('reserves')
                            ->where('id_link','=',$id)
                            ->select('reserves.bw_reserve','reserves.status')->get();
            if(count($reserve) > 0){
                foreach ($reserve as $val){
                    if($val->status == 'VIGENTE'){
                        $bw_pre_reserve += $val->bw_reserve;
                    }
                }
            }
            $bw_previous_reserve = ControllerEquipment_Model::format_bw($bw_pre_reserve);
            
			$node = Node::find($link->id_node);
            $status_node= "APTA";
            $diff = "";
            $node_info_plus = "";

            if($node->type != "PROPIO"){
                if($node->contract_date != null){
                    $date = Carbon::parse($node->contract_date);
                    $now = Carbon::now();
                    $diff = $date->diffInDays($now);
                    $node_info_plus = " El contrato vence en ". $diff ." dias (MAYOR A 2 ANOS).";
                    if($diff < 730){
                        $status_node = 'NO APTA';
                        $node_info_plus = " El contrato ya esta vencido, CUIDADO!";

                    }
                }
            }
            $bw_available = ControllerEquipment_Model::format_bw($link->bw_limit - $bw_pre_reserve - ($bw_service + $bw_anillo));
            $status = $link->status;
            $commentary = $link->commentary;
            $bw = ControllerEquipment_Model::format_bw($link->bw_limit);

            $data[] = array(
                'id' => $id,
                'status' => $status,
                'commentary' => $commentary,
                'status_node' => $status_node,
                'commentary_node' => $node->commentary,
                'node_info_plus' => $node->type . $node_info_plus,
                'bw' => $bw['data'],
                'bw_size' => $bw['signo'],
                'bw_used_info' => $bw_used['data'],
                'bw_used_size' => $bw_used['signo'],
                'bw_pre_reserve' => $bw_previous_reserve['data'],
                'bw_pre_reserve_size' => $bw_previous_reserve['signo'],
                'bw_available' => $bw_available['data'],
                'bw_available_size' => $bw_available['signo'],

            );
			return array('resul' => 'yes', 'data' => $data);
		}else{
			return array('resul' => 'autori', );
		}
    }
        
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(RequestReserve $request)
    {
        $info = $_POST;
        $user_id = Auth::id();
        $last_number = Reserve::max('number_reserve')+1;
        if($last_number < 9999){
            $last_number = 10000;
        }
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(25);
		if ($authori_status['permi'] >= 10) {
                $data = [];
                $reserve = new Reserve;
                $reserve->number_reserve = $last_number;
                $reserve->id_link = $info['id_link'];
                $reserve->id_cliente = $info['id_cliente'];
                $reserve->bw_reserve = $info['bw_reserve'];
                $reserve->status = "VIGENTE";
                $reserve->id_user = $user_id;
                $reserve->quantity_dates = 90;
                $reserve->oportunity = $info['oportunity'];
                $reserve->id_service_type = $info['id_service_type'];
                $reserve->commentary = $info['commentary'];
                $reserve->cell_status = $info['cell_status'];
                $reserve->cell_bw_link = $info['cell_bw_link'];
                $reserve->cell_bw_usado = $info['cell_bw_usado'];
                $reserve->cell_bw_reserved = $info['cell_bw_reserved'];
                if (isset($info['id_service'])) $reserve->id_service = $info['id_service'];
                if (isset($info['type'])) $reserve->type = $info['type'];

                ControllerUser_history::store("Creó la reserva numero ".$reserve->number_reserve );
                $reserve->save();
                $link = Link::find($info['id_link'], ['status']);
                $data[] = array(
                    'nro_reserve' => $last_number,
                    'status_node' => $info['cell_status'],
                    'status_link' => $last_number,
                    'bw_reserved' => $info['bw_reserve'],
                    'commentary' => $info['commentary'],
                );
                $resul = 'yes';
			}else{
			    $resul = 'autori';
		    }
		return array('resul' => $resul, 'data' => $data);
	}
    public function index_reserves_equipment(){
        ##### Esta funcion recibe un id de la tabla equipment y muestra las reservas VIGENTES relacionadas a ese equipo mediante el nodo #### 
        if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(25);
		if ($authori_status['permi'] >= 3) {
            $id = $_POST['id_equipment'];
            $data = [];
            $id_equipment = '';
            $equipment = Equipment::find($id);
            if($equipment->client_management == 'Si'){
                $equipment_info = DB::table('board')
                ->join('port', 'port.id_board','=','board.id')
                ->join('port as por1', 'por1.id_ring','=','port.id_ring')
                ->join('board as boar1', 'boar1.id', '=', 'por1.id_board')
                ->join('equipment','equipment.id','=','boar1.id_equipment')
                ->where('board.id_equipment','=', $id)
                ->select('equipment.id', 'equipment.client_management')->groupBy('equipment.id', 'equipment.client_management')->get();
                foreach($equipment_info as $val)
                {
                    if($val->id != $id && $val->client_management == 'No'){
                        $id_equipment = $val->id;
                    }
                }
                $id = $id_equipment;
               } 
            $info = DB::table('equipment')
                ->join('node', 'node.id', '=', 'equipment.id_node')
                ->join('link', 'node.id', '=', 'link.id_node')
                ->join('reserves', 'reserves.id_link','=','link.id')
                ->where('equipment.id', '=', $id)
                ->where('reserves.status', '=', 'VIGENTE')
                ->select('reserves.id','reserves.number_reserve')
                ->groupBy('reserves.id','reserves.number_reserve')->get();
            foreach ($info as $value) {
                $data[] = array(
                    'id' => $value->id,
                    'number_reserve' => $value->number_reserve,
                );
            }
            
			return array('resul' => 'yes', 'data' => $data);
		}else{
			return array('resul' => 'autori', );
		}
    }
    public function cancell(){
        if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(25);
		if ($authori_status['permi'] >= 10) {
			$id = $_POST['id'];
			$reserve = Reserve::find($id);
			$reserve->status = 'CANCELADO';
			$reserve->save();
			ControllerUser_history::store("Modificó el estado de la reserva numero". $reserve->number_reserve ." a 'Cancelado' ");
			return array('resul' => 'yes');
		}else{
			return array('resul' => 'autori', );
		}
    }
    public function details_reserve(){
        if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(25);
		if ($authori_status['permi'] >= 3) {
            $data=[];
			$id = $_POST['id'];
            $reserve = Reserve::find($id);
            $link = Link::find($reserve->id_link);
			$node = Node::find($link->id_node);
            $client = Client::find($reserve->id_cliente);
            $bw_used = floor($reserve->cell_bw_usado);
            $bw_link = floor($link->bw_limit);
            $bw_limit = $bw_link - $bw_used;
            $bw_available = floor($reserve->cell_bw_link) - floor($reserve->cell_bw_usado) - floor($reserve->cell_bw_reserved);
            $bw_available=str_replace('.',',',$bw_available);
            $bw_reserve = ControllerEquipment_Model::format_bw($reserve->bw_reserve);
            $cell_bw_link = ControllerEquipment_Model::format_bw($reserve->cell_bw_link);
            $cell_bw_used = ControllerEquipment_Model::format_bw($reserve->cell_bw_usado);
            $cell_bw_reserved = ControllerEquipment_Model::format_bw($reserve->cell_bw_reserved);
            $bw_available = ControllerEquipment_Model::format_bw($bw_available);
			$data = array(
                'id' => $id,
                'status' => $reserve->cell_status,
                'bw_reserve' => $bw_reserve['data'],
                'bw_reserve_size' => $bw_reserve['signo'], 
                'cell_bw' => $cell_bw_link['data'],
                'cell_bw_size' => $cell_bw_link['signo'], 
                'bw_used' => $cell_bw_used['data'],
                'bw_used_size' => $cell_bw_used['signo'],
                'cell_bw_reserved' => $cell_bw_reserved['data'],
                'cell_bw_reserved_size' => $cell_bw_reserved['signo'],
                'bw_available' => $bw_available['data'],
                'bw_available_size' => $bw_available['signo'],
				'number_reserve' => $reserve->number_reserve,
                'quantity_dates' => $reserve->quantity_dates,
                'oportunity' => $reserve->oportunity,
                'node' => $node->node,
                'link' => $link->name,
                'bw_limit' => $bw_limit,
                'client_id' => $client->id,
                'client' => $client->business_name,
                'id_service_type' => $reserve->id_service_type,
                'date_start' => $reserve->created_at->format('Y-m-d'),
				'commentary' => $reserve->commentary ,
            );
            if (isset($reserve->id_service)) {
                $service = Service::find($reserve->id_service, 'bw_service');
                $bw_service = ControllerEquipment_Model::format_bw($service->bw_service);
                $data['id_service'] = $reserve->id_service;
                $data['bw_service'] = $bw_service['data'];
                $data['bw_service_size'] = $bw_service['signo'];
            }
			return array('resul' => 'yes', 'data' => $data);
		}else{
			return array('resul' => 'autori', );
		}
    }

    public function info_edic(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(25);
		if ($authori_status['permi'] >= 5) {
			$id = $_POST['id'];
			$reserve = Reserve::find($id);
            $link = Link::find($reserve->id_link);
			$node = Node::find($link->id_node);
            $client = Client::find($reserve->id_cliente);
            $bw_used = ControllerReserve::bw_used($link->id_extreme_2, $reserve->id_link);
            $bw_link = $link->bw_limit;
            $bw_limit = $bw_link - $bw_used;
			$bw = ControllerEquipment_Model::format_bw($reserve->bw_reserve);
			$data = array(
				'number_reserve' => $reserve->number_reserve,
                'quantity_dates' => $reserve->quantity_dates,
                'oportunity' => $reserve->oportunity,
                'node' => $node->node,
                'link' => $link->name,
                'bw_limit' => $bw_limit,
                'cell_bw_reserved' => $reserve->cell_bw_reserved,
                'client_id' => $client->id,
                'client' => $client->business_name,
                'id_service_type' => $reserve->id_service_type,
                'date_start' => $reserve->created_at->format('Y-m-d'),
				'bw' => $bw['data'],
				'max' => $bw['logo'],
				'commentary' => $reserve->commentary ,
			);
			return array('resul' => 'yes', 'data' => $data);
		}else{
			return array('resul' => 'autori', );
		}
	}
    public function add_time(){
        #Funcion para agregar 30 dias a la reserva
        if (!Auth::guest() == false){ return array('resul' => 'login', );}
		$authori_status = User::authorization_status(25);
		if ($authori_status['permi'] >= 5) {
			$id = $_POST['id'];
			$reserve = Reserve::find($id);

			$reserve->quantity_dates = ($reserve->quantity_dates + 30);
			$reserve->save();

			ControllerUser_history::store("Modificó el tiempo de la reserva #". $reserve->number_reserve ." a ".$reserve->quantity_dates);
			
			return array('resul' => 'yes');
		}else{
			return array('resul' => 'autori');
		}
    }
    public function edic(){
		if (!Auth::guest() == false){ return array('resul' => 'login', );}
        $info = $_POST;
        $user_id = Auth::id();
		$authori_status = User::authorization_status(25);
        
		if ($authori_status['permi'] >= 5) {
			$reserve = Reserve::find($info['id_reserve']);
				$reserve->id_cliente = $info['id_cliente'];
				$reserve->oportunity = $info['oportunity'];
				$reserve->id_service_type = $info['edic_id_type_service'];
				$reserve->bw_reserve = $info['bw_reserve_edit'];
				$reserve->commentary = $info['commentary'];

			ControllerUser_history::store("Modificó la cadena #".$reserve->number_reserve );
			$reserve->save();
			return array('resul' => 'yes', );
		}else{
			return array('resul' => 'autori', );
		}
	}
    static function bw_used($extreme_link, $id_link)
    {
        $bw = 0;
        $id_equipos = [];
        if($extreme_link != null){
            $equipos =  DB::table('port')
            ->join('board', 'board.id', '=', 'port.id_board')
            ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
            ->where('port.id_lacp_port', '=', $extreme_link)
            ->select('equipment.id')
            ->groupBy('equipment.id')->get()->toArray();
            foreach ($equipos as $value) {
                $id_equipos[] = $value->id;
            }
            $servi = DB::table('equipment')
            ->join('board', 'board.id_equipment', '=', 'equipment.id')		    
            ->join('port', 'port.id_board', '=', 'board.id')
            ->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
            ->Join('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
            ->join('service', 'service_port.id_service', '=', 'service.id')
            ->join('client', 'service.id_client', '=', 'client.id')
            ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->whereIn('equipment.id', $id_equipos)
            ->select('service.id as id_serv', 'service.number', 'service.bw_service', 'service.commentary', 'client.business_name', 'client.acronimo', 'port.n_port', 'board.slot', 'list_label.name as label', 'service_port.vlan', 'lacp_port.id')->groupBy('service.id','service.number', 'service.bw_service', 'service.commentary', 'client.business_name', 'client.acronimo', 'port.n_port', 'board.slot', 'list_label.name', 'service_port.vlan', 'lacp_port.id')->get();
            foreach ($servi as $value){
                $bw += $value->bw_service;
            }
        }
        $reserve = DB::table('reserves')
                            ->where('id_link','=',$id_link)
                            ->select('reserves.bw_reserve','reserves.status')->get();
            if(count($reserve) > 0){
                foreach ($reserve as $val){
                    if($val->status == 'VIGENTE'){
                        $bw += $val->bw_reserve;
                    }
                }
            }
        return $bw;
    }
    public function info_bW_equipment(){
        if (!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(25);
		if ($authori_status['permi'] >= 3) {
			$id = $_POST['id_equipment'];
            $bw_pre_reserve = 0;
            $bw_link_limit = 0;
            $bw_remanent = 0;
            $bw_anillo = 0;

            $ring_equipment = DB::table('board')
            ->join('port', 'port.id_board','=','board.id')
            ->join('port as por1', 'por1.id_ring','=','port.id_ring')
            ->join('board as boar1', 'boar1.id', '=', 'por1.id_board')
            ->join('equipment','equipment.id','=','boar1.id_equipment')
            ->where('board.id_equipment','=', $id)
            ->select('equipment.id')->groupBy('equipment.id')->get();
            foreach ($ring_equipment as $value) {
                $servi = DB::table('equipment')
                ->join('board', 'board.id_equipment', '=', 'equipment.id')		    
                ->join('port', 'port.id_board', '=', 'board.id')
                ->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
                ->Join('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
                ->join('service', 'service_port.id_service', '=', 'service.id')
                ->where('equipment.id', '=', $value->id)
                ->select('service.id','service.bw_service')->groupBy('service.id', 'service.bw_service')->get();
                if(isset($servi[0])){
                    foreach($servi as $valor){
                        $bw_anillo += $valor->bw_service;
                    }
                }
                if($value->id != $id){
                    $equipment = Equipment::find($value->id);
                    if($equipment->client_management == 'No'){
                        $id = $equipment->id;
                    }
                }
            }

            $links =  DB::table('board')
            ->join('port', 'board.id', '=', 'port.id_board')
            ->join('link', 'port.id_lacp_port', '=', 'link.id_extreme_2')
            ->where('board.id_equipment', '=', $id)
            ->select('link.id', 'link.bw_limit','port.id as port')
            ->groupBy('link.id', 'link.bw_limit','port.id')->groupBy('link.id', 'link.bw_limit','port.id')->get()->toArray();

            foreach($links as $value){
                $link = Link::find($value->id);
                $bw_link_limit += $link->bw_limit;
                $reserve = DB::table('reserves')
                        ->where('id_link','=',$link->id)
                        ->select('reserves.bw_reserve','reserves.status')->get();
                if(count($reserve) > 0){
                    foreach ($reserve as $val){
                        if($val->status == 'VIGENTE'){
                            $bw_pre_reserve += $val->bw_reserve;
                        }
                    }
                }
            }
            $bw_remanent = ($bw_link_limit) - ($bw_pre_reserve) - ($bw_anillo);
            $bw_remanent = $bw_remanent/1024;
            return array('resul' => 'yes', 'bw_equipment' => $bw_remanent);
            //}
        } else{
			return array('resul' => 'autori', );
		}
    }

    public function apply_service_reserve($id_reserve) {
        try {
            if (Auth::guest()) return ['resul' => 'login'];
            $authori_status = User::authorization_status(25);
            if ($authori_status['permi'] < 5) return ['resul' => 'autori'];
            $reserve = Reserve::find($id_reserve);
            $service = Service::find($reserve->id_service);
            $service->bw_service = $service->bw_service + $reserve->bw_reserve;
            $reserve->status = 'ASIGNADO';
            $reserve->save();
            ControllerUser_history::store("Modificó el servicio #".$service->number);
            $service->save();
            return ['resul' => 'yes'];
        } catch (Exception $e) {
            return ['resul' => 'nop', 'datos' => $e->getMessage()];
        }
    }

    public function info_service_reserve($id_reserve) {
        try {
            if (Auth::guest()) return ['resul' => 'login'];
            $authori_status = User::authorization_status(25);
            if ($authori_status['permi'] < 3) return ['resul' => 'autori'];
            $data = [];
            $reserve = Reserve::find($id_reserve);
            $service = Service::find($reserve->id_service);
            $current_bw = ControllerEquipment_Model::format_bw($service->bw_service);
            $new_bw = $service->bw_service + $reserve->bw_reserve;
            $new_bw =  ControllerEquipment_Model::format_bw($new_bw);
            $data['current_bw'] = $current_bw['data'];
            $data['current_bw_size'] = $current_bw['signo'];
            $data['new_bw'] = $new_bw['data'];
            $data['new_bw_size'] = $new_bw['signo'];
            return ['resul' => 'yes', 'datos' => $data];
        } catch (Exception $e) {
            return ['resul' => 'nop', 'datos' => $e->getMessage()];
        }
    }
}
