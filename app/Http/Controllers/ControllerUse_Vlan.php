<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Asignacion_Servicio_Vlan;
use Jarvis\Constants;
use Jarvis\Use_Vlan;
use Jarvis\User_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Jarvis\List_Use_Vlan;
use Jarvis\Ring;
use Jarvis\Node;
use Jarvis\IP;
use Jarvis\Lacp_Port;
use Jarvis\Port;
use Jarvis\Board;
use Illuminate\Support\Facades\DB;
use Jarvis\List_Service_Type;
use Jarvis\Link;
use Carbon\Carbon;
use Exception;
use Jarvis\User;
use Jarvis\Equipment;
use Jarvis\Range_Vlan;
use Jarvis\Service;
use Error;

class ControllerUse_Vlan extends Controller
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
        $authori_status = User::authorization_status(28);
        if ($authori_status['permi'] >= 3) {
            $vlan_type = List_Use_Vlan::all(['id', 'name','behavior'])->sortBy('name');
            return view('admin_vlan.list', compact("authori_status", "vlan_type"));
        } else {
            return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_list(){ // Modificar esta funcion para que la consulta a BD consuma menos recursos
        if (!Auth::guest() == false){
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(28);
        if ($authori_status['permi'] >= 3) {
            $data = [];
            $info = Use_Vlan::all();
            foreach ($info as $value) {
                $node_info = '';
                $ring_info = '';
                $equipment_info = '';
                $ip_info = '';
                $type_vlan = List_Use_Vlan::find($value->id_list_use_vlan, ['name']);
                if ($value->id_node != '' && $value->id_node != null) {
                    $node = Node::find($value->id_node, ['cell_id', 'node']);
                    $node_info = $node->cell_id.' - '.$node->node;
                } else {
                    $equipment =  Equipment::find($value->id_equipment, ['acronimo']);
                    $ring = Ring::find($value->id_ring, ['name']);
                    if (isset($equipment->acronimo)) $equipment_info = $equipment->acronimo;
                    if (isset($ring->name)) $ring_info = $ring->name;
                }
                $ip = DB::table('ip')->where('id_use_vlan','=', $value->id)->select('ip')->get();
                if(isset($ip[0]->ip)){
                    $ip_info = $ip[0]->ip;
                };
                $data[] = array(
                    'nro_vlan' => $value->vlan,
                    'type_vlan' => $type_vlan['name'],
                    'acronimo' => $equipment_info,
                    'ring' => $ring_info,
                    'cell' => $node_info,
                    'n_frontier' => $value->id_frontera,
                    'ip' => $ip_info,
                    'status' => $value->status,
                );
            }
            return datatables()->of($data)->make(true);
        }else{
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_range(){
        #this function gets one id from 'equipment' and returns list of existing ranges vlan from 'range_vlan' table.
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(28);
        if ($authori_status['permi'] >= 3) {
            $id = $_POST['id_equipment'];
            $data = [];
            $ranges = DB::table('range_vlan')
                ->join('list_use_vlan', 'list_use_vlan.id' ,'=','range_vlan.id_list_use_vlan')
                ->whereIn('id_equipment', [$id, '0'])
                ->select('range_vlan.n_frontier', 'range_vlan.range_from','range_vlan.range_until','list_use_vlan.behavior','list_use_vlan.name', 'range_vlan.id_equipment')
                ->selectRaw('ROWIDTOCHAR(range_vlan.rowid) as "rowid"')->get();
            foreach($ranges as $range){
                $data[] = array(
                    'id' => $range->rowid,
                    'behavior' => $range->behavior,
                    'name' => $range->name,
                    'n_frontier' => $range->n_frontier,
                    'range_from' => $range->range_from,
                    'range_until' => $range->range_until,
                    'id_equipment' => $range->id_equipment,
                );
            }
            return array('resul' => 'yes', 'data' => $data);
        }else{
            return array('resul' => 'autori', );
        }
    }

    public function add_range(){
        if (!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(28);
        $info = $_POST;
        if($info['range_max'] > 4096 || $info['range_min'] > 4096 || $info['range_max'] <= 0 || $info['range_min'] <=0){
            return array('resul' => 'exceds',);
        }
        if($info['type_vlan_id'] == '' || $info['type_vlan_id'] == ' '){
            return array('resul' => 'vlan_unknown');
        }
        $current_type = List_Use_Vlan::where('id','=', $info['type_vlan_id'])->first();
        if($info['agg_id'] == 0){
            $id_equipments[] = $info['agg_id'];
        } else{
            $range_gestion = DB::table('range_vlan')->whereIn('id_list_use_vlan', [1,2])->select('id_equipment')->groupBy('id_equipment')->get();
            foreach($range_gestion as $val){
                if($val->id_equipment != 0){
                    $id_equipments[] = $val->id_equipment;
                }
            }
            if($current_type['behavior'] == 0){
                $id_equipments[] = '0';
            }
            if($current_type['behavior'] == 1){
                #si es behavior 1, es decir; comportamiento de frontera, entonces no se limitan entre si;
            }
        }
        $ranges = DB::table('range_vlan')->whereIn('id_equipment', $id_equipments)->select('range_vlan.range_from','range_vlan.range_until')->get()->toArray();
        $min_range = DB::table('range_vlan')->whereIn('id_equipment', $id_equipments)->min('range_from');
        $max_range =  DB::table('range_vlan')->whereIn('id_equipment', $id_equipments)->max('range_until');

        if ($info['agg_id'] != 0){
            $info_agg = Equipment::find($info['agg_id'], ['acronimo',]);
            $name_agg = $info_agg['acronimo'];
        } else{
            $name_agg = 'Tipo frontera';
        }
        if ($authori_status['permi'] >= 10) {
            foreach ($ranges as $range){
                $used = Range_Vlan::overlap($range->range_from, $range->range_until, $info['range_min'], $info['range_max']);
                if ($used) return array('resul' => 'used');
            }
            DB::table('range_vlan')->insert(
                ['id_equipment' => $info['agg_id'], 'id_list_use_vlan' => $info['type_vlan_id'], 'range_from' => $info['range_min'], 'range_until' => $info['range_max']]
            );
            ControllerUser_history::store("Agregó un rango de vlan al agregador ". $name_agg);
        } else{
            return array('resul' => 'autori', );
        }
        return array('resul' => 'yes');
    }

    public function edit_range(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(28);
        if ($authori_status['permi'] >= 5) {
            $name_agg = '';
            $info = $_POST;
            $id_equipments = [];

            if($info['max'] > 4096 || $info['min'] > 4096 || $info['max'] <= 0 || $info['min'] <=0){
                return array('resul' => 'exceds',);
            }
            $current_range = Range_Vlan::where('rowid', $info['id_range'])->get();
            $current_type = List_Use_Vlan::where('id','=', $current_range[0]["id_list_use_vlan"])->get();
            $current_from = $current_range[0]['range_from'];
            $current_till = $current_range[0]['range_until'];
            if($info['agg_id'] != 0){
                $id_equipments[] = $info['agg_id'];
                $id_equipments[] = 0;
            } else{
                $range_gestion = DB::table('range_vlan')->whereIn('id_list_use_vlan', [1,2])->select('id_equipment')->groupBy('id_equipment')->get();
                foreach($range_gestion as $val){
                    if($val->id_equipment != 0){
                        $id_equipments[] = $val->id_equipment;
                    }
                }
                if($current_type[0]['behavior'] == 0){
                    $id_equipments[] = '0';
                }
                if($current_type[0]['behavior'] == 1){
                    #si es behavior 1, es decir; comportamiento de frontera, entonces no se limitan entre si;
                }
            }
            $ranges = DB::table('range_vlan')->whereIn('id_equipment', $id_equipments)->select('range_vlan.range_from','range_vlan.range_until')->get()->toArray();
            $vlans = Use_Vlan::where('id_equipment', $info['agg_id'])->get();

            foreach ($ranges as $range){
                if(($current_from != $range->range_from) && ($current_till != $range->range_until) ){
                    if(($range->range_from <= $info['min']) && ($info['min'] <= $range->range_until)){
                        return array('resul' => 'used',);
                    }
                    if(($range->range_from <= $info['max']) && ($info['max'] <= $range->range_until)){
                        return array('resul' => 'used',);
                    }
                }
            }
            if ($info['agg_id'] != 0){
                $info_agg = Equipment::find($info['agg_id'], ['acronimo',]);
                $name_agg = $info_agg['acronimo'];
            } else{
                $name_agg = 'Tipo frontera';
            }

            if(count($vlans) > 0){
                foreach ($vlans as $vlan){
                    if($vlan->vlan <= $info['min'] || $info['max'] >= $vlan->vlan){
                        return array('resul' => 'exists');
                    } else{
                        #la vlan no esta dentro del rango
                    }
                }
            }

            Range_Vlan::where('rowid', $info['id_range'])->update(['range_from' => $info['min']]);
            Range_Vlan::where('rowid', $info['id_range'])->update(['range_until' => $info['max']]);

            ControllerUser_history::store("Modificó un rango de vlan del agregador ". $name_agg);
            return array('resul' => 'yes');
        }else{
            return array('resul' => 'autori', );
        }
    }
    public function delete_range(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(28);
        if ($authori_status['permi'] >= 5) {
            $info = $_POST;
            $name_agg = "GENERAL";
            $agg_info = Equipment::find($info['agg_id'], ['acronimo']);
            if(isset($agg_info['acronimo'])){
                $name_agg = $agg_info['acronimo'];
            }
            $vlans = Use_Vlan::where('id_equipment', $info['agg_id'])->get();
            $range_vlan = Range_Vlan::where('rowid', $info['id_range'])->get();
            if(count($vlans) > 0){
                foreach ($vlans as $vlan){
                    if(($range_vlan[0]['range_from'] <= $vlan->vlan) && ($vlan->vlan <= $range_vlan[0]['range_until']) ){
                        return array('resul' => 'exists');
                    } else{
                        #la vlan no esta dentro del rango
                    }
                }
            }
            Range_Vlan::where('rowid', $info['id_range'])->delete();
            ControllerUser_history::store("Eliminó un rango de vlan del agregador ". $name_agg);

            return array('resul' => 'yes');
        }else{
            return array('resul' => 'autori', );
        }
    }

    public function edit_undo(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(28);
        if ($authori_status['permi'] >= 5) {
            $info = $_POST;
            $range = Range_Vlan::where('rowid', $info['id_range'])->get();
            $data[] = array(
                'range_from' => $range[0]->range_from,
                'range_till' => $range[0]->range_until,
            );
            return array('resul' => 'yes', 'data' => $data);

        }else{
            return array('resul' => 'autori', );
        }
    }

    //ASIGNACION DE SERVICIOS

    public function services_index()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        //copio y pego el sistema de autorizaciones que ya se viene usando en JARVIS
        $authori_status = User::authorization_status(29);

        if ($authori_status['permi'] >= 3) {
            return view('admin_vlan.asignacion_servicio_list', compact('authori_status'));
        }
        else{
            return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
    }


    //listar las asignaciones de servicios
    public function list_services()
    {
        //traigo todos los servicios que tienen referencia en asignacion_servicio_vlan
        $services = DB::table('service')
            ->join('asignacion_servicio_vlan', 'asignacion_servicio_vlan.id_service', '=', 'service.id')
            ->where('asignacion_servicio_vlan.estado', Constants::SERVICE_TYPE_ASSIGNED)
            ->get();
        $data = [];

        //traigo los demas datos que necesito a partir de $services
        foreach ($services as $item){
            $use_vlan         = Use_Vlan::where('id', $item->id_use_vlan)->first();
            $pe_pei           = null;
            $aggi             = null;
            $mtag             = null;
            $pe_pei_acronimo  = null;
            $name             = null;
            $id_list_use_vlan = null;

            if(isset($use_vlan)){
                $frontier         = Link::where('id', $use_vlan->id_frontera)->first();
                $mtag             = $use_vlan->vlan;
                $id_list_use_vlan = List_Use_Vlan::find($use_vlan->id_list_use_vlan);

                if(!isset($frontier)){
                    $aggi   = Equipment::where('id', $use_vlan->equipment)->first();
                }

                if(isset($frontier)){
                    $pe_pei          = self::get_frontier_equipment($frontier->id_extreme_1);
                    $pe_pei_acronimo = $pe_pei->acronimo;
                    $name            = $frontier->name;
                }
            }

            $service_type = List_Service_Type::where('id', $item->id_type)->pluck('name')->first();
            $bw           = ControllerEquipment_Model::format_bw($item->bw_service);

            //chequear si el id_list_use_vlan->ctag figura como SI

            $has_list_use_vlan = 'no';

            if(isset($id_list_use_vlan) && $id_list_use_vlan->ctag == Constants::VLAN_USE_CTAG){
                $has_list_use_vlan = 'si';
            }

                $data[] = array(
                'id'                => $item->id,
                'service'           => $item->number,
                'service_type'      => $service_type,
                'bw'                => $bw['data'].' '.$bw['signo'],
                'mtag'              => $mtag,
                'pe_pei'            => $pe_pei_acronimo,
                'frontier'          => $name,
                'ctag'              => $item->ctag,
                'aggi'              => $aggi,
                'has_list_use_vlan' => $has_list_use_vlan
            );
        }

        return datatables()->of($data)->make(true);
    }


    //"eliminar" servicios
    public function delete_services(Request $request)
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }

        $authori_status    = User::authorization_status(29);

        if ($authori_status['permi'] >= 3) {
            $assignment    = Asignacion_Servicio_Vlan::find($request->id);
            $use_vlan      = Use_Vlan::find($assignment->id_use_vlan);

            //si la vlan es de tipo internet bv ds o l2l mp, marcar la vlan como desasignada
            if($use_vlan->id_list_use_vlan == Constants::VLAN_TYPE_INTERNET_BV_DS || $use_vlan->id_list_use_vlan == Constants::VLAN_TYPE_L2L_MP ){
                $use_vlan->status = Constants::USE_VLAN_STATUS_UNASSIGNED;
                $use_vlan->save();
            }

            $assignment->estado = Constants::SERVICE_TYPE_UNASSIGNED;
            $assignment->save();

        } else {
            return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }


    }

    //get ctag de una asignación
    public function get_service_ctag(Request $request)
    {
        $asignacion = Asignacion_Servicio_Vlan::find($request->id);
        $data       = [
            'ctag'          => $asignacion->ctag,
            'asignacion_id' => $asignacion->id
        ];


        return response()->json($data);
    }

    //guardar ctag
    public function save_service_ctag(Request $request)
    {
        $asignacion = Asignacion_Servicio_Vlan::find($request->service_id);
        $asignacion->ctag = $request->ctag;
        $asignacion->save();
    }

    public function index_frontier(){
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status    = User::authorization_status(29);
        if ($authori_status['permi'] >= 3) {
            $type_services = List_Service_Type::pluck('name','id')->toArray();
            $n_frontier    = Link::where('id_list_type_links','=',1)->max('name');
            $data_zones    = DB::table('list_key_value')->where('table_name', '=', 'list_zones')->get();
            $zones         = [];
            foreach($data_zones as $zone){
                $only_zone = str_replace("Zona: ", "",$zone->description);
                $zones[]   = array(
                    'value'       => $zone->value,
                    'description' => $only_zone,
                );
            }
            return view('admin_vlan.frontier_list', compact("authori_status","type_services","n_frontier", "zones"));
        } else {
            return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
    }


    //obtener el equipo, pasar el extreme de la frontera
    private function get_frontier_equipment($extreme)
    {
        $lacp = Lacp_Port::where('id', $extreme)->first();
        $port = Port::where('id_lacp_port', $lacp->id)->first();
        $board = Board::where('id', $port->id_board)->first();

        return Equipment::where('id', $board->id_equipment)->first();
    }

    public function get_frontier($id){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(29);
        if($authori_status['permi'] >= 3) {
            // no tengo idea que es 29 y que es 3

            $frontera = Link::where('id', $id)->first();
            $lacp_a = Lacp_Port::where('id', $frontera->id_extreme_1)->first();
            $lacp_b = Lacp_Port::where('id', $frontera->id_extreme_2)->first();
            if(isset($lacp_a->id)){
                $port = Port::where('id_lacp_port', $lacp_a->id)->first();
            }

            //dd($port);
            $board = Board::where('id', $port->id_board)->get();
            //dd($lacp_a->commentary, $lacp_b->commentary);

            $zone = DB::table('list_key_value')
                ->where('table_name', 'list_zones')
                ->where('value', $frontera->id_zone)
                ->select(['description', 'value'])
                ->first();

            $equipment_a = self::get_frontier_equipment($frontera->id_extreme_1);
            $equipment_b = self::get_frontier_equipment($frontera->id_extreme_2);

            $equipos = [
                'equipo_a' => $equipment_a,
                'modelo_a' => DB::table('function_equipment_model')
                    ->where('id', $equipment_a->id_function)->pluck('name')->first(),
                'equipo_b' => $equipment_b,
                'modelo_b' => DB::table('function_equipment_model')
                    ->where('id', $equipment_b->id_function)->pluck('name')->first()
            ];

            //$interface_a = $frontera->interface_identification_1;
            //$interface_b = $frontera->interface_identification_2;

            $acronimo = $frontera->commentary;

            $object = [
                //numero de frontera
                'frontera'   => $frontera->name,
                'zona'       => $zone,
                'interfaz_a' => $lacp_a->commentary,
                'interfaz_b' => $lacp_b->commentary,
                'acronimo'   => $acronimo,
                'equipos'    => $equipos,

            ];

            return response()->json($object);
        }
    }

    //editar acronimo
    public function edit_acronimo(Request $request)
    {
        $request->validate([
            'acronimo' => 'required'
        ]);

        $frontier = Link::where('id', $request->frontier_id)->first();
        $frontier->commentary = $request->acronimo;
        $frontier->save();

    }

    public function list_frontier(){
        if(!Auth::guest() == false){ return array('resul' => 'login', );}
        $authori_status = User::authorization_status(29);
        if ($authori_status['permi'] >= 3) {
            $data = [];
            $info = DB::table('link')
                //meter aca el resto de joins
                ->where('link.id_list_type_links', '=' , 1)
                ->select('link.id', 'link.id_extreme_2', 'link.status', 'link.id_extreme_1', 'link.interface_identification_1', 'link.interface_identification_2', 'link.name','link.bw_limit','link.commentary', 'link.id_zone')->get();
            //meter un if para que entre al foreach ?
            foreach ($info as $value) {
                $equipment_0 = empty($value->interface_identification_1)? '' : $value->interface_identification_1;
                $equipment_1 = empty($value->interface_identification_2)? '' : $value->interface_identification_2;
                $bundle_0 = '';
                $bundle_1 = '';
                if(!empty($value->id_extreme_1)){
                    $lacp_a = Lacp_Port::find($value->id_extreme_1, ['commentary']);
                    $lacp_b = Lacp_Port::find($value->id_extreme_2, ['commentary']);
                    if(!empty($lacp_a) && !empty($lacp_b))
                    {
                        $bundle_0 = $lacp_a->commentary;
                        $bundle_1 = $lacp_b->commentary;
                    } else{
                        $bundle_0 = 'Vacío';
                        $bundle_1 = 'Vacío';
                    }
                }
                if(empty($value->id_zone)){
                    $zone = '';
                } else {
                    $zone_info = DB::table('list_key_value')->where('table_name', '=','list_zones')->where('value','=',$value->id_zone)->select('description')->first();
                    $zone = empty($zone_info) ? '' : str_replace("Zona: ", "",$zone_info->description);
                }
                $bw = ControllerEquipment_Model::format_bw($value->bw_limit);
                $data[] = array(
                    'id' => $value->id,
                    'number_frontier' => $value->name,
                    'equipment_0' => $equipment_0,
                    'bundle_0' => $bundle_0,
                    'equipment_1' => $equipment_1,
                    'bundle_1' => $bundle_1,
                    'zone' => $zone,
                    'status' => $value->status,
                    'bw' => $bw['data'].' '.$bw['signo'],
                    'commentary' => $value->commentary,
                );
            }
            return datatables()->of($data)->make(true);
        }else{
            return array('resul' => 'autori', );
        }
    }
    public function list_equipment_type(){
        if (!Auth::guest() == false){
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(29);
        if ($authori_status['permi'] >= 3) {
            $type = $_POST['id'];
            $zone = $_POST['id_zone'];
            $data = [];
            $info = Equipment::where([
                'id_function' => $type,
                'id_zone' => $zone,
            ])->get();
            if(count($info) != 0){
                foreach($info as $equipment){
                    $node = Node::find($equipment->id_node, ['cell_id', 'node']);
                    $data[] = array(
                        'id' => $equipment->id,
                        'acronimo' => $equipment->acronimo,
                        'status' => $equipment->status,
                        'node' => $node->cell_id,
                    );
                }
                return array('resul' => 'yes', 'datos' => $data);
            } else{
                return array('resul' => 'no', );
            }
        }else{
            return array('resul' => 'autori', );
        }
    }

    public function list_lacp_group(){
        if (!Auth::guest() == false){
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(29);
        if ($authori_status['permi'] >= 3) {
            $data = [];
            $info = Equipment::where('id_lacp_port','=', $_POST['id'])->get();
            
            if(count($info) != 0){
                foreach($info as $equipment){
                    $node = Node::find($equipment->id_node, ['cell_id', 'node']);
                    $data[] = array(
                        'id' => $equipment->id,
                        'acronimo' => $equipment->acronimo,
                        'status' => $equipment->status,
                        'node' => $node->cell_id,
                    );
                }
                return array('resul' => 'yes', 'datos' => $data);
            } else{
                return array('resul' => 'no', );
            }
        }else{
            return array('resul' => 'autori', );
        }
    }
    public function add_frontier(){
        if (!Auth::guest() == false){
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(29);
        if ($authori_status['permi'] >= 10) {
            $info = $_POST;
            if($info['acronimo_frontier'] == '' || $info['bw_lacp_A'] == '' || $info['bw_lacp_B'] == ''){
                return array('resul' => 'incomplete');
            }
            if($info['bw_lacp_A'] != $info ['bw_lacp_B']){
                return array('resul' => 'different');
            }
            $frontiers = Link::where('id_list_type_links','=',1)->get();
            foreach ($frontiers as $front) {
                if($info['frontier_number'] == $front->name){
                    return array('resul' => 'n_frontier');
                }
            }
            $frontier = new Link;
            $frontier->name = $info['frontier_number'];
            $frontier->id_zone = $info['id_zone'];
            $frontier->id_extreme_1 = $info['lacp_id_A'];
            $frontier->id_extreme_2 = $info['lacp_id_B'];
            $frontier->bw_limit = $info['bw_lacp_A'];
            $frontier->commentary = $info['acronimo_frontier'];
            $frontier->status = 'ALTA';
            $frontier->interface_identification_1 = $info['equip_A'];
            $frontier->interface_identification_2 = $info['equip_B'];
            $frontier->id_list_type_links = 1;
            $frontier->save();
            Lacp_Port::where('id',$info['lacp_id_A'])->update(['commentary'=>$info['interfaz_a']]);
            Lacp_Port::where('id',$info['lacp_id_B'])->update(['commentary'=>$info['interfaz_b']]);
            ControllerUser_history::store("Creó la frontera numero ".$info['frontier_number']." con acronimo ".$info['acronimo_frontier']);

            return array('resul'=>'yes');

        }else{
            return array('resul' => 'autori', );
        }
    }
    public function last_frontier(){
        if (!Auth::guest() == false){
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(29);
        if ($authori_status['permi'] >= 3) {
            $data = Link::where('id_list_type_links','=',1)->max('name');
            if (isset($data)){
                $data += 1;
            } else{
                $data = 0;
            }
            return array('resul'=>'yes', 'datos' => $data);

        }else{
            return array('resul' => 'autori', );
        }
    }

    public function change_status_frontier(){
        if (!Auth::guest() == false) return redirect('login')->withErrors([Lang::get('validation.login')]);
        $authori_status = User::authorization_status(29);
        if ($authori_status['permi'] < 5) return redirect('home')->withErrors([Lang::get('validation.authori_status')]);

        $frontier = Link::find($_POST['id']);
        if ($frontier->status == 'ALTA') {
            $frontier->status = 'DESHABILITADA';
            ControllerUser_history::store("Deshabilitó la frontera $frontier->name con acronimo $frontier->commentary");
            $frontier->save();
            return ['resul' => 'yes'];
        } else if ($frontier->status == 'DESHABILITADA') {
            $frontier->status = 'ALTA';
            ControllerUser_history::store("Habilitó la frontera $frontier->name con acronimo $frontier->commentary");
            $frontier->save();
            return ['resul' => 'yes'];
        } else {
            return ['resul' => 'nop'];
        }
    }

    /**
     * Retorna array con todas las vlan ctag disponibles o que no están siendo utilizadas en ninguna asignación.
     *
     * @param  $vlan_id - numerico, id de vlan
     * @return $free - array de strings
     */
    public function get_free_ctags($vlan_id) {
        try {
            if (Auth::guest()) throw new Error('Login');
            $all = [];
            $used = [];
            for ($i=2; $i <= 1000; $i++) $all[] = str_pad($i, 4, '0', STR_PAD_LEFT);
            if (!empty($vlan_id)) {
                $used = Asignacion_Servicio_Vlan::where('id_use_vlan', $vlan_id)->pluck('ctag')->toArray();
                foreach ($used as &$u) {
                    $u = str_pad($u, 4, '0', STR_PAD_LEFT);
                    unset($u);
                }
            }
            $free = array_values(array_diff($all, $used));
            return $free;
        } catch (Error $e) {
            return $e->getMessage();
        }
    }

    /**
     * Retorna array con todas las vlan tipo Internet BV registradas según anillo.
     * Si no encuentra registradas retorna array con numeros de vlan que correspondan al rango Internet BV
     *
     * @param  $ring_id - numerico, id del anillo
     * @return $vlans - array
     */
    public function get_used_or_new_internet_bv($ring_id) {
        try {
            if (Auth::guest()) throw new Error('login');
            $vlans = Use_Vlan::get_used_internet_bv($ring_id);
            if (count($vlans) <= 0) $vlans = Use_Vlan::get_new_internet_bv($ring_id);
            return $vlans;
        } catch (Error $e) {
            return $e->getMessage();
        }
    }





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Jarvis\Use_Vlan  $use_vlan
     * @return \Illuminate\Http\Response
     */
    public function show(Use_Vlan $use_vlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Jarvis\Use_Vlan  $use_vlan
     * @return \Illuminate\Http\Response
     */
    public function edit(Use_Vlan $use_vlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Jarvis\Use_Vlan  $use_vlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Use_Vlan $use_vlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Jarvis\Use_Vlan  $use_vlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Use_Vlan $use_vlan)
    {
        //
    }
}
