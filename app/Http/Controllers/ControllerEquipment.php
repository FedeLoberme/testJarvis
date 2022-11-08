<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Constants;
use Jarvis\Equipment_Model;
use Jarvis\Equipment;
use Jarvis\Client;
use Jarvis\Ring;
use Jarvis\User;
use Jarvis\Port;
use Jarvis\Record_ip;
use Jarvis\IP;
use Jarvis\Lacp_Port;
use Jarvis\Link;
use Jarvis\Board;
use Jarvis\Service;
use Jarvis\Equipment_Location;
use Jarvis\Service_Port;
use Jarvis\Node;
use Jarvis\Function_Equipment_Model;
use Jarvis\List_Service_Type;
use Jarvis\List_Use_Vlan;
use Jarvis\List_Status_IP;
use Jarvis\Agg_Acronimo;
use Jarvis\List_Countries;
use Jarvis\Relation_Agg_Acronimo;
use Jarvis\Range_Vlan;
use Jarvis\Http\Controllers\ControllerUser_history;
use Jarvis\Http\Controllers\ControllerRing;
use Jarvis\Http\Controllers\ControllerAddress;
use Jarvis\Http\Controllers\ControllerEquipment_Model;
use Jarvis\Http\Requests\RequestRegister_SAR;
use Jarvis\Http\Requests\RequestRegister_DM;
use Jarvis\Http\Requests\RequestRegister_PEI;
use Jarvis\Http\Requests\RequestRegister_PE;
use Jarvis\Http\Requests\RequestRegister_AGG;
use Jarvis\Http\Requests\RequestMigrationModel;
use Jarvis\Http\Requests\RequestRegister_CPE;
use Jarvis\Http\Requests\RequestRegister_LS;
use Jarvis\Http\Requests\RequestEdictRadio;
use Jarvis\Http\Requests\RequestEdictRadioNode;
use Jarvis\Http\Requests\RequestLanswitchIpran;
use Jarvis\Http\Requests\RequestRadio;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
use Exception;
use Illuminate\Support\Facades\DB;

class ControllerEquipment extends Controller
{
// -----------------Funcion para listar equipo---------------------------
    public function index()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(8);
        if ($authori_status['permi'] >= 3) {
            $Equipment = Equipment::all();
            return view('inventario.list');
        } else {
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_radio()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(8);
        if ($authori_status['permi'] >= 3) {
            $status = List_Status_IP::all(['id', 'name'])->where('id', '!=', 4);
            $pais = List_Countries::all(['id', 'name'])->sortBy('name');
            $list_service = List_Service_Type::all(['id', 'name'])->sortBy('name');
            $equipment = Equipment_Model::List();
            $bw = $equipment['bw'];
            $status_port = DB::table("status_port")->select('id', 'name')->where('id', '>', 2)->orderBy('name', 'asc')->get();
            $functi = Function_Equipment_Model::all(['id', 'name'])->sortBy('name');
            return view('admin_radio.list', compact('authori_status', 'status', 'pais', 'list_service', 'bw', 'status_port', 'functi'));
        } else {
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_radio_enlace()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(8);
        if ($authori_status['permi'] >= 3) {
            $status = List_Status_IP::all(['id', 'name'])->where('id', '!=', 4);
            $pais = List_Countries::all(['id', 'name'])->sortBy('name');
            $list_service = List_Service_Type::all(['id', 'name'])->sortBy('name');
            $equipment = Equipment_Model::List();
            $bw = $equipment['bw'];
            $status_port = DB::table("status_port")->select('id', 'name')->where('id', '>', 2)->orderBy('name', 'asc')->get();
            return view('admin_radio.listRadioEnlace', compact('authori_status', 'status', 'pais', 'list_service', 'bw', 'status_port'));
        } else {
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_cpe()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(8);
        if ($authori_status['permi'] >= 3) {
            $status = List_Status_IP::all(['id', 'name'])->where('id', '!=', 4);
            $pais = List_Countries::all(['id', 'name'])->sortBy('name');
            $list_service = List_Service_Type::all(['id', 'name'])->sortBy('name');
            $equipment = Equipment_Model::List();
            $bw = $equipment['bw'];
            $status_port = DB::table("status_port")->select('id', 'name')->where('id', '>', 2)->orderBy('name', 'asc')->get();
            $functi = Function_Equipment_Model::all(['id', 'name'])->sortBy('name');
            return view('admin_cpe.list', compact('authori_status', 'status', 'pais', 'list_service', 'bw', 'status_port', 'functi'));
        } else {
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_lanswitch()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(13);
        if ($authori_status['permi'] >= 3) {
            $Ring = DB::table("equipment")
                ->join('board', 'board.id_equipment', '=', 'equipment.id')
                ->join('port', 'port.id_board', '=', 'board.id')
                ->join('ring', 'port.id_ring', '=', 'ring.id')
                ->where('equipment.id_function', '=', 1)
                ->select('ring.id', 'equipment.acronimo', 'ring.name', 'ring.type')->groupBy('ring.id', 'equipment.acronimo', 'ring.name', 'ring.type')->get();
            $status = List_Status_IP::all(['id', 'name'])->where('id', '!=', 4);
            $pais = List_Countries::all(['id', 'name'])->sortBy('name');
            $equipment = Equipment_Model::List();
            $bw = $equipment['bw'];
            $confi = $equipment['confir'];
            $list_service = List_Service_Type::all(['id', 'name'])->sortBy('name');
            $list_vlan = List_Use_Vlan::all();
            $status_port = DB::table("status_port")->select('id', 'name')->where('id', '>', 2)->orderBy('name', 'asc')->get();
            $functi = Function_Equipment_Model::all(['id', 'name'])->sortBy('name');
            return view('admin_lanswitch.list', compact('authori_status', 'Ring', 'status', 'pais', 'bw', 'confi', 'list_service', 'list_vlan', 'status_port', 'functi'));
        } else {
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_agg()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(7);
        if ($authori_status['permi'] >= 3) {
            $Equipment = Equipment::detalle_equipo(1);
            $status = List_Status_IP::all(['id', 'name'])->where('id', '!=', 4);
            $status_port = DB::table("status_port")->select('id', 'name')->where('id', '>', 2)->orderBy('name', 'asc')->get();
            $pais = List_Countries::all(['id', 'name'])->sortBy('name');
            $list_service = List_Service_Type::all(['id', 'name'])->sortBy('name');
            $equipment = Equipment_Model::List();
            $bw = $equipment['bw'];
            $functi = Function_Equipment_Model::all(['id', 'name'])->sortBy('name');
            $vlan_type = List_Use_Vlan::all(['id', 'name', 'behavior'])->sortBy('name');
            return view('admin_agg.list', compact('authori_status', 'status', 'pais', 'list_service', 'bw', 'status_port', 'functi', 'vlan_type'));
        } else {
            return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_pe()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(9);
        if ($authori_status['permi'] >= 3) {
            $status = List_Status_IP::all(['id', 'name'])->where('id', '!=', 4);
            $pais = List_Countries::all(['id', 'name'])->sortBy('name');
            $status_port = DB::table("status_port")->select('id', 'name')->where('id', '>', 2)->orderBy('name', 'asc')->get();
            $functi = Function_Equipment_Model::all(['id', 'name'])->sortBy('name');
            $zones = DB::table('list_key_value')->select('value', 'description')->where('key_name', 'id_zone')->get();
            foreach ($zones as $z) $z->description = str_replace('Zona: ', '', $z->description);
            return view('admin_pe.list', compact('authori_status', 'pais', 'status', 'status_port', 'functi', 'zones'));
        } else {
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_dm()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(19);
        if ($authori_status['permi'] >= 3) {
            $status = List_Status_IP::all(['id', 'name'])->where('id', '!=', 4);
            $pais = List_Countries::all(['id', 'name'])->sortBy('name');
            $status_port = DB::table("status_port")->select('id', 'name')->where('id', '>', 2)->orderBy('name', 'asc')->get();
            $functi = Function_Equipment_Model::all(['id', 'name'])->sortBy('name');
            $zones = DB::table('list_key_value')->select('value', 'description')->where('key_name', 'id_zone')->get();
            foreach ($zones as $z) $z->description = str_replace('Zona: ', '', $z->description);
            return view('admin_dm.list', compact('authori_status', 'pais', 'status', 'status_port', 'functi', 'zones'));
        } else {
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function index_pei()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(20);
        if ($authori_status['permi'] >= 3) {
            $status = List_Status_IP::all(['id', 'name'])->where('id', '!=', 4);
            $pais = List_Countries::all(['id', 'name'])->sortBy('name');
            $status_port = DB::table("status_port")->select('id', 'name')->where('id', '>', 2)->orderBy('name', 'asc')->get();
            $functi = Function_Equipment_Model::all(['id', 'name'])->sortBy('name');
            $zones = DB::table('list_key_value')->select('value', 'description')->where('key_name', 'id_zone')->get();
            foreach ($zones as $z) $z->description = str_replace('Zona: ', '', $z->description);
            return view('admin_pei.list', compact('authori_status', 'pais', 'status', 'status_port', 'functi', 'zones'));
        } else {
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }


    //funcion que valida si el acrónimo ya existe al editarlo o crearlo

    public function validation_acronimo($id, $name)
    {
        $acro = DB::table("equipment")->select('equipment.id')
            ->where('equipment.id', '!=', $id)
            ->where('equipment.status', '=', 'ALTA')
            ->where('equipment.acronimo', '=', $name)->get();
        if (count($acro) > 0) {
            $resultado = 'Si';
        } else {
            $resultado = 'No';
        }
        return $resultado;
    }

    public function validation_ip($ip, $id)
    {
        $acro = DB::table("ip")->select('ip.id_status', 'ip.id_equipment')
            ->where('ip.id', '=', $ip)->get();
        if (count($acro) > 0) {
            if ($acro[0]->id_status == 1 || $acro[0]->id_equipment == $id || $acro[0]->id_status == 7) {
                $resultado = 'Si';
            } else {
                $resultado = 'No';
            }
        } else {
            $resultado = 'No';
        }
        return $resultado;
    }

    public function store_update_agg(RequestRegister_AGG $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(7);
        if ($autori_status['permi'] >= 5) {
            $ip = $request->ip_admin;
            $name = strtoupper($request->name);
            $acronimo = strtoupper($request->acronimo);
            $equi_alta = $request->equi_alta;
            $nodo_al = $request->nodo_al;
            $commen = $request->commen;
            $alta = $request->alta;
            $id = $request->id;
            $local = $request->local;
            $port = $request->port;
            $info_acro_agg = Agg_Acronimo::acronimo($acronimo);
            $acro = ControllerEquipment::validation_acronimo($id, $name);
            if ($acro == 'Si') {
                return array('resul' => 'acronimo_exi',);
            }
            $ip_valida = ControllerEquipment::validation_ip($ip, $id);
            if ($ip_valida != 'Si') {
                return array('resul' => 'ip_exi',);
            }
            if ($id != 0) {
                $msj_equip = 'Modifico el agregador: ';
                $alta_equi = Equipment::find($id);
            } else {
                if ($autori_status['permi'] >= 10) {
                    $msj_equip = 'Registro el agregador: ';
                    $alta_equi = new Equipment();
                } else {
                    return array('resul' => 'autori',);
                }
                $alta_equi->id_model = $equi_alta;
                $alta_equi->id_function = 1;
                $alta_equi->client_management = 'No';
            }
            $alta_equi->acronimo = $name;
            $alta_equi->location = $local;
            $alta_equi->id_node = $nodo_al;
            $alta_equi->ir_os_up = $alta;
            $alta_equi->commentary = $commen;
            $alta_equi->save();
            $id_equip = $alta_equi->id;

            ControllerUser_history::store($msj_equip . $name);
            ControllerEquipment::store_update_ip_port_equipment($id, $id_equip, $port, $ip, $name);
            if ($id == 0) {
                if (count($info_acro_agg) == 0) {
                    $acron = new Agg_Acronimo();
                    $acron->name = $acronimo;
                    $acron->save();
                    $id_acroni = $acron->id;
                } else {
                    $id_acroni = $info_acro_agg[0]->id;
                }
                $acron_rela = new Relation_Agg_Acronimo();
                $acron_rela->id_equipment = $id_equip;
                $acron_rela->id_agg_acronimo = $id_acroni;
                $acron_rela->save();
            }
            return array('resul' => 'yes', 'datos' => $alta_equi,);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public function ip_status($ip_new, $ip_old, $equipment, $name)
    {
        if ($ip_old != 0) {
            $ip_b = IP::find($ip_old);
            $ip_b->id_status = 1;
            $ip_b->id_equipment = null;
            $ip_b->save();

            $recor_ip = new Record_ip();
            $recor_ip->id_ip = $ip_old;
            $recor_ip->prefixes = $ip_b->prefixes;
            $recor_ip->attribute = 'El Equipo: ' . $name . ' libero la ip';
            $recor_ip->id_user = Auth::user()->id;
            $recor_ip->save();
        }

        if ($ip_new != 0) {
            $ip = IP::find($ip_new);
            $ip->id_status = 2;
            $ip->id_equipment = $equipment;
            $ip->save();

            $recor = new Record_ip();
            $recor->id_ip = $ip_new;
            $recor->prefixes = $ip->prefixes;
            $recor->attribute = 'El Equipo: ' . $name . ' seleccino la ip';
            $recor->id_user = Auth::user()->id;
            $recor->save();
        }
    }


    //guardar o editar router

    public function store_update_cpe(RequestRegister_CPE $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(8);
        if ($autori_status['permi'] >= 5) {
            $id = $request->id_cpe;
            $client = $request->client;
            $rpv = $request->rpv;
            $sitio = $request->sitio;
            $ip_wan = $request->ip_wan;
            $ip_admin = $request->ip_admin;
            $direc = $request->direc;
            $equi_alta = $request->equi_alta;
            $nodo_al = $request->nodo_al;
            $name = $request->name;
            $commen = $request->commen;
            $alta = $request->alta;
            $client_management = $request->management;
            $local = $request->local;
            $enlace = $request->enlace;
            $port = $request->port;
            $acro = ControllerEquipment::validation_acronimo($id, $name);
            if ($acro == 'Si') {
                return array('resul' => 'acronimo_exi',);
            }
            if ($rpv == 'No') {
                $ip_valida = ControllerEquipment::validation_ip($ip_admin, $id);
                if ($ip_valida != 'Si') {
                    return array('resul' => 'ip_exi',);
                }
            }
            if ($id <> 0) {
                $msj_equip = 'Modifico el router: ';
                $alta_equi = Equipment::find($id);
                $alta_equi->acronimo = $name;
            } else {
                if ($autori_status['permi'] >= 10) {
                    $msj_equip = 'Registro el router: ';
                    $alta_equi = new Equipment();
                } else {
                    return array('resul' => 'autori',);
                }
                $alta_equi->id_model = $equi_alta;
                $alta_equi->id_function = 2;
                $alta_equi->acronimo = $name;
            }
            if ($sitio == 'Si') {
                $alta_equi->address = $direc;
                $alta_equi->id_node = null;
            } else {
                $alta_equi->address = null;
                $alta_equi->id_node = $nodo_al;
            }
            if ($rpv == 'Si') {
                $alta_equi->ip_wan_rpv = $ip_wan;
            } else {
                $alta_equi->ip_wan_rpv = null;
            }
            $alta_equi->location = $local;
            $alta_equi->client_management = $client_management;
            $alta_equi->id_client = $client;
            $alta_equi->ir_os_up = $alta;
            $alta_equi->commentary = $commen;
            $alta_equi->service = $enlace;
            $alta_equi->save();
            ControllerUser_history::store($msj_equip . $name);
            ControllerEquipment::store_update_ip_port_equipment($id, $alta_equi->id, $port, $ip_admin, $name);
            $data = array('resul' => 'yes', 'datos' => $alta_equi,);
        } else {
            $data = array('resul' => 'autori',);
        }
        return $data;
    }

    public function store_update_lanswitch(RequestRegister_LS $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(13);
        if ($autori_status['permi'] >= 5) {
            $id = $request->id;
            $equi_alta = $request->equi_alta;
            $name = $request->name;
            $id_function = $request->id_function;
            $client = $request->client;
            $direc = $request->direc;
            $orden = $request->orden;
            $anilo = $request->anilo;
            $ip_admin = $request->ip_admin;
            $enlace = $request->enlace;
            $local = $request->local;
            $nodo_al = $request->nodo_al;
            $sitio = $request->sitio;
            $commen = $request->commen;
            $valor = $request->valor;
            $port = $request->port;
            $acro = ControllerEquipment::validation_acronimo($id, $name);
            if ($acro == 'Si') {
                return array('resul' => 'acronimo_exi',);
            }
            $ip_valida = ControllerEquipment::validation_ip($ip_admin, $id);
            if ($ip_valida != 'Si') {
                return array('resul' => 'ip_exi',);
            }
            if ($id != 0) {
                $msj_equip = 'Modifico el lanswitch: ';
                $alta_equi = Equipment::find($id);
            } else {
                if ($autori_status['permi'] >= 10) {
                    $msj_equip = 'Registro el lanswitch: ';
                    $alta_equi = new Equipment();
                    $alta_equi->type = 'Metroethernet';
                } else {
                    return array('resul' => 'autori',);
                }
                $alta_equi->id_model = $equi_alta;
                $alta_equi->id_function = 4;
                $alta_equi->client_management = 'No';
            }
            $alta_equi->id_client = $client;
            $alta_equi->location = $local;
            $alta_equi->ir_os_up = $orden;
            $alta_equi->acronimo = $name;
            if ($sitio == 'No') {
                $alta_equi->address = null;
                $alta_equi->id_node = $nodo_al;
            } else {
                $alta_equi->address = $direc;
                $alta_equi->id_node = null;
            }
            $alta_equi->service = $enlace;
            $alta_equi->commentary = $commen;
            $alta_equi->save();
            $id_equip = $alta_equi->id;
            ControllerUser_history::store($msj_equip . $name);
            ControllerEquipment::store_update_ip_port_equipment($id, $id_equip, $valor, $ip_admin, $name);
            if ($id == 0) {
                foreach ($port as $port) {
                    // $dividir = explode('@', $port);
                    $divi = explode('|', $port);
                    $info = DB::table('board')->where('board.id_equipment', '=', $id_equip)
                        ->where('board.id_port_model', '=', $divi[1])
                        ->select('board.id')->get();
                    $port_new = new Port();
                    $port_new->id_board = $info[0]->id;
                    $port_new->n_port = $divi[0];
                    $port_new->id_status = 1;
                    $port_new->connected_to = null;
                    $port_new->type = 'ANILLO';
                    $port_new->id_ring = $anilo;
                    $port_new->save();
                    // $port_old = Port::find($dividir[1]);
                    // 	$port_old->connected_to = $port_new->id;
                    // 	$port_old->id_status = 1;
                    // $port_old->save();
                }
            }
            return array('resul' => 'yes', 'datos' => $alta_equi,);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public function ip_admin_buscar($id_equip)
    {
        $info = DB::table('ip')
            ->where('ip.id_equipment', '=', $id_equip)
            ->select('ip.ip', 'ip.id')->get();
        return $info;
    }

    public function index_list($function)
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        switch ($function) {
            case 'AGG':
                $id_function_equipment = 1;
                $valida = 7;
                break;
            case 'CPE':
                $id_function_equipment = 2;
                $valida = 8;
                break;
            case 'PE':
                $id_function_equipment = 3;
                $valida = 9;
                break;
            case 'LANSWITCH':
                $id_function_equipment = 4;
                $valida = 13;
                break;
            case 'DM':
                $id_function_equipment = 5;
                $valida = 19;
                break;
            case 'PEI':
                $id_function_equipment = 6;
                $valida = 20;
                break;
            case 'RADIO':
                $id_function_equipment = 7;
                $valida = 23;
                break;
            case 'SAR':
                $id_function_equipment = 8;
                $valida = 27;
                break;
        }
        $authori_status = User::authorization_status($valida);
        if ($authori_status['permi'] >= 3) {
            $Equipment_Model = DB::table('equipment')
                ->join('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
                ->leftJoin('address', 'equipment.address', '=', 'address.id')
                ->leftJoin('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
                ->leftJoin('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
                ->join('function_equipment_model', 'equipment.id_function', '=', 'function_equipment_model.id')
                ->Join('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
                ->Join('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
                ->leftJoin('client', 'client.id', '=', 'equipment.id_client')
                ->leftJoin('node', 'node.id', '=', 'equipment.id_node')
                ->leftJoin('ip', 'equipment.id', '=', 'ip.id_equipment')
                ->leftJoin('address as add_node', 'node.address', '=', 'add_node.id')
                ->leftJoin('list_provinces as provi_node', 'add_node.id_provinces', '=', 'provi_node.id')
                ->leftJoin('list_countries as coun_node', 'provi_node.id_countries', '=', 'coun_node.id')
                ->leftJoin('list_key_value', function ($join) {
                    $join->on('equipment.id_zone', '=', 'list_key_value.value')->where('list_key_value.key_name', '=', 'id_zone');
                })
                ->where('function_equipment_model.id', '=', $id_function_equipment)
                ->select('equipment.id', 'list_mark.name as mark', 'list_equipment.name as equipment', 'equipment_model.model', 'equipment.status', 'equipment.commentary', 'function_equipment_model.name as function', 'equipment.address', 'node.node', 'node.cell_id', 'client.business_name as client', 'equipment.acronimo', 'ip.ip as admin', 'ip.prefixes', 'equipment.ip_wan_rpv as ip_equipment', 'equipment_model.bw_max_hw', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code', 'list_countries.name as countries', 'list_provinces.name as provinces', 'equipment_model.id as img', 'equipment.service', 'address.id as id_direc', 'add_node.id as id_direcct', 'add_node.location as locati', 'add_node.street as stre', 'add_node.height as heigh', 'add_node.floor as flo', 'add_node.department as depar', 'add_node.postal_code as postal', 'coun_node.name as countrie', 'provi_node.name as province', 'equipment.type', 'equipment.client_management', 'list_key_value.description as zone')
                ->groupBy('equipment.id', 'list_mark.name', 'list_equipment.name', 'equipment_model.model', 'equipment.status', 'equipment.commentary', 'function_equipment_model.name', 'equipment.address', 'node.node', 'node.cell_id', 'client.business_name', 'equipment.acronimo', 'ip.ip', 'ip.prefixes', 'equipment.ip_wan_rpv', 'equipment_model.bw_max_hw', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code', 'list_countries.name', 'list_provinces.name', 'equipment_model.id', 'equipment.service', 'address.id', 'add_node.id', 'add_node.location', 'add_node.street', 'add_node.height', 'add_node.floor', 'add_node.department', 'add_node.postal_code', 'coun_node.name', 'provi_node.name', 'equipment.type', 'equipment.client_management', 'list_key_value.description')
                ->orderBy('model', 'asc')->get();
            $all = [];
            //
            foreach ($Equipment_Model as $value) {
                $ip_equipment = '';
                $ip = '';
                $dire = '';
                if ($value->id_direc != null && $value->id_direc != '') {
                    $dire = $value->street . ' ' . $value->height;
                    if ($value->department != null) {
                        $dire = $dire . ' Depto' . $value->department;
                    }
                    if ($value->floor != null) {
                        $dire = $dire . ' Piso' . $value->floor;
                    }
                    $dire = $dire . ' ' . $value->location . ' ' . $value->provinces . ' ' . $value->countries;
                }
                if ($value->id_direcct != null && $value->id_direcct != '') {
                    $dire = '(' . $value->cell_id . ') ' . $value->stre . ' ' . $value->heigh;
                    if ($value->department != null) {
                        $dire = $dire . ' Depto' . $value->depar;
                    }
                    if ($value->floor != null) {
                        $dire = $dire . ' Piso' . $value->flo;
                    }
                    $dire = $dire . ' ' . $value->locati . ' ' . $value->province . ' ' . $value->countrie;
                }
                if ($value->ip_equipment != null) {
                    $ip_equipment = $value->ip_equipment;
                }
                if ($value->admin != null) {
                    $ip = $value->admin . '/' . $value->prefixes;
                }
                $type = $value->type;
                if ($id_function_equipment === 4 && $value->type === "Ipran") {
                    if ($value->client_management === "Si") {
                        $type = $value->type . ' Cliente';
                    } else {
                        $type = $value->type . ' Celda';
                    }
                }
                if ($value->zone != null && $value->zone != '') {
                    $value->zone = str_replace('Zona: ', '', $value->zone);
                }
                $all[] = array(
                    'id' => $value->id,
                    'mark' => $value->mark,
                    'equipment' => $value->equipment,
                    'service' => $value->service,
                    'model' => $value->model,
                    'status' => $value->status,
                    'commentary' => $value->commentary,
                    'function' => $value->function,
                    'address' => $dire,
                    'node' => $value->node,
                    'cell_id' => $value->cell_id,
                    'client' => $value->client,
                    'acronimo' => $value->acronimo,
                    'admin' => $ip,
                    'ip_equipment' => $ip_equipment,
                    'bw_max_hw' => $value->bw_max_hw,
                    'img' => $value->img,
                    'type' => $type,
                    'zone' => $value->zone
                );
            }
            return datatables()->of($all)->make(true);
        } else {
            return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function search_equip(Request $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $id = $request->id;
        $equipment = DB::table('equipment')
            ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
            ->leftJoin('node', 'equipment.id_node', '=', 'node.id')
            ->leftJoin('client', 'equipment.id_client', '=', 'client.id')
            ->leftJoin('address', 'equipment.address', '=', 'address.id')
            ->leftJoin('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
            ->leftJoin('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
            ->leftJoin('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
            ->leftJoin('list_mark', 'equipment_model.id_mark', '=', 'list_mark.id')
            ->leftJoin('list_equipment', 'equipment_model.id_equipment', '=', 'list_equipment.id')
            ->leftJoin('board', 'board.id_equipment', '=', 'equipment.id')
            ->leftJoin('port', 'port.id_board', '=', 'board.id')
            ->leftJoin('link', 'link.id_extreme_2', '=', 'port.id_lacp_port')
            ->leftJoin('ip loopback', 'loopback.id_loopback', '=', 'equipment.id')
            ->leftJoin('list_key_value', function ($join) {
                $join->on('equipment.id_zone', '=', 'list_key_value.value')->where('list_key_value.key_name', '=', 'id_zone');
            })
            ->where('equipment.id', '=', $id)
            ->select('equipment.ne_id', 'equipment.id_model', 'equipment.id_function', 'equipment.id_client', 'equipment.id_node', 'equipment.acronimo', 'equipment.client_management', 'equipment.ip_wan_rpv', 'equipment.address', 'equipment.service', 'equipment.id_ne', 'equipment.ir_os_up', 'equipment.ir_os_down', 'equipment.commentary', 'equipment.status', 'equipment.location', 'equipment.type', 'equipment.id_zone', 'ip.id as id_ip', 'ip.ip', 'ip.prefixes', 'node.cell_id', 'node.node', 'client.acronimo as client', 'client.business_name', 'client.cuit', 'address.location as local', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code', 'list_provinces.name as provinces', 'list_countries.name as countries', 'equipment_model.model', 'list_mark.name as mark', 'list_equipment.name as equip', 'link.name as link', 'link.id as id_link', 'link.interface_identification_1', 'loopback.ip as ip_loopback', 'loopback.prefixes as prefixes_loopback', 'loopback.id as id_loopback', 'list_mark.id as id_mark', 'list_key_value.description as zone')
            ->groupBy('equipment.ne_id', 'equipment.id_model', 'equipment.id_function', 'equipment.id_client', 'equipment.id_node', 'equipment.acronimo', 'equipment.client_management', 'equipment.ip_wan_rpv', 'equipment.address', 'equipment.service', 'equipment.id_ne', 'equipment.ir_os_up', 'equipment.ir_os_down', 'equipment.commentary', 'equipment.status', 'equipment.location', 'equipment.type', 'equipment.id_zone', 'ip.id', 'ip.ip', 'ip.prefixes', 'node.cell_id', 'node.node', 'client.acronimo', 'client.business_name', 'client.cuit', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code', 'list_provinces.name', 'list_countries.name', 'equipment_model.model', 'list_mark.name', 'list_equipment.name', 'link.name', 'link.id', 'link.interface_identification_1', 'loopback.ip', 'loopback.prefixes', 'loopback.id', 'list_mark.id', 'list_key_value.description')->get();
        if (count($equipment) > 0) {
            switch ($equipment[0]->id_function) {
                case '1':
                    $valida = 7;
                    break;
                case '2':
                    $valida = 8;
                    break;
                case '3':
                    $valida = 9;
                    break;
                case '4':
                    $valida = 13;
                    break;
                case '5':
                    $valida = 19;
                    break;
                case '6':
                    $valida = 20;
                    break;
                case '7':
                    $valida = 23;
                    break;
                case '8':
                    $valida = 27;
                    break;
            }
            $autori_status = User::authorization_status($valida);
            if ($autori_status['permi'] >= 5) {
                $ring = '';
                $direcc = '';
                $ip_all = '';
                $link = '';
                $port_sar = '';
                $Equi_sap = '';
                $agg_info = '';
                $ip_loopback = '';
                if ($equipment[0]->link != null) {
                    $link = $equipment[0]->link;
                    if ($equipment[0]->interface_identification_1 != null) {
                        $di = explode('|', $equipment[0]->interface_identification_1);
                        $Equi_sap = $di[0];
                        if(isset($di[1])){
                            $port_sar = $di[1];
                        }
                    }
                }
                $anillo = DB::table('board')
                    ->join('port', 'port.id_board', '=', 'board.id')
                    ->join('ring', 'port.id_ring', '=', 'ring.id')
                    ->where('board.id_equipment', '=', $id)
                    ->select('ring.id', 'ring.name', 'ring.type')
                    ->groupBy('ring.id', 'ring.name', 'ring.type')->get();
                if (count($anillo) > 0) {
                    $agg_info = DB::table('port')
                        ->join('board', 'port.id_board', '=', 'board.id')
                        ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
                        ->where('port.id_ring', '=', $anillo[0]->id)
                        ->where('equipment.id_function', '=', 1)
                        ->select('equipment.acronimo')->groupBy('equipment.acronimo')->get();
                    if (count($agg_info) > 0) {
                        $agg_info = 'Agregador: ' . $agg_info[0]->acronimo;
                    }
                    $ring = array('id' => $anillo[0]->id,
                        'name' => $anillo[0]->name . ' ' . $anillo[0]->type . ',',
                        'acronimo' => $agg_info,
                    );
                }
                if ($equipment[0]->address != null) {
                    $direcc = $equipment[0]->countries . ' ' . $equipment[0]->provinces . ' ' . $equipment[0]->local . ' ' . $equipment[0]->street . ' ' . $equipment[0]->height . ' ' . $equipment[0]->floor . ' ' . $equipment[0]->department;
                    $resul = array('resul' => 'yes', 'datos' => $direcc,);
                }
                if ($equipment[0]->ip != null) {
                    $ip_all = $equipment[0]->ip . '/' . $equipment[0]->prefixes;
                }
                if ($equipment[0]->ip_loopback != null) {
                    $ip_loopback = $equipment[0]->ip_loopback . '/' . $equipment[0]->prefixes_loopback;
                }
                if ($equipment[0]->zone != null) $equipment[0]->zone = str_replace('Zona: ', '', $equipment[0]->zone);

                $all = array(
                    'id_model' => $equipment[0]->id_model,
                    'id_function' => $equipment[0]->id_function,
                    'id_client' => $equipment[0]->id_client,
                    'id_node' => $equipment[0]->id_node,
                    'id_ip' => $equipment[0]->id_ip,
                    'acronimo' => $equipment[0]->acronimo,
                    'client_management' => ucwords(strtolower($equipment[0]->client_management)),
                    'ip_wan_rpv' => $equipment[0]->ip_wan_rpv,
                    'address' => $equipment[0]->address,
                    'service' => $equipment[0]->service,
                    'id_ne' => $equipment[0]->id_ne,
                    'ir_os_up' => $equipment[0]->ir_os_up,
                    'ir_os_down' => $equipment[0]->ir_os_down,
                    'commentary' => $equipment[0]->commentary,
                    'status' => $equipment[0]->status,
                    'location' => $equipment[0]->location,
                    'id_ip' => $equipment[0]->id_ip,
                    'id_mark' => $equipment[0]->id_mark,
                    'ip' => $ip_all,
                    'cell_id' => $equipment[0]->cell_id,
                    'node' => $equipment[0]->node,
                    'client' => $equipment[0]->client,
                    'business_name' => $equipment[0]->business_name,
                    'cuit' => $equipment[0]->cuit,
                    'model' => $equipment[0]->model . ' ' . $equipment[0]->mark . ' ' . $equipment[0]->equip,
                    'direcc' => $direcc,
                    'id_link' => $equipment[0]->id_link,
                    'ne_id' => $equipment[0]->ne_id,
                    'link' => $link,
                    'Equi_sap' => $Equi_sap,
                    'port_sar' => $port_sar,
                    'ip_loopback' => $ip_loopback,
                    'id_loopback' => $equipment[0]->id_loopback,
                    'id_zone' => $equipment[0]->id_zone,
                    'zone' => $equipment[0]->zone
                );
                $data = array('resul' => 'yes',
                    'datos' => $all,
                    'anillo' => $ring,
                );
            } else {
                $data = array('resul' => 'autori',);
            }
        } else {
            $data = array('resul' => 'nop',);
        }
        return $data;
    }

    public function consultar_acronimo()
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $acro_equipo = strtoupper($_POST['acro']);
        $resul = DB::table('equipment')->where('equipment.acronimo', '=', $acro_equipo)
            ->select('equipment.id')->get();
        if (count($resul) > 0) {
            $respu = 'yes';
        } else {
            $respu = 'nop';
        }
        $data = array('resul' => $respu,);
        return $data;
    }

    public function equipment_lanswitch()
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $equi_resul = DB::table("board")
            ->join('port', 'port.id_board', '=', 'board.id')
            ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
            ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->select('port.id', 'equipment.acronimo', 'board.slot', 'port.n_port', 'list_label.name')
            ->whereIn('port.connected_to', function ($query) {
                $anillo = $_POST['anillo'];
                $equipo = $_POST['equip'];
                $query->select('port.id')->from('board')
                    ->join('port', 'port.id_board', '=', 'board.id')
                    ->where('port.id_ring', '=', $anillo)
                    ->where('board.id_equipment', '=', $equipo);
            })->get();
        if (count($equi_resul) > 0) {
            foreach ($equi_resul as $value) {
                $slot = ControllerRing::label_por($value->slot);
                $name = $value->acronimo . ' ' . $value->name . ' ' . $slot . $value->n_port;
                $equi_new[] = array('id' => $value->id, 'name' => $name,);
            }
        } else {
            $equi_new[] = array('id' => 0, 'name' => '',);
        }
        return array('resul' => 'yes', 'datos' => $equi_new,);
    }

    public function index_list_select($function)
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        switch ($function) {
            case 'AGG':
                $id = 1;
                $valida = 7;
                break;
            case 'CPE':
                $id = 2;
                $valida = 8;
                break;
            case 'PE':
                $id = 3;
                $valida = 9;
                break;
            case 'LANSWITCH':
                $id = 4;
                $valida = 13;
                break;
            case 'DM':
                $id = 5;
                $valida = 19;
                break;
            case 'PEI':
                $id = 6;
                $valida = 20;
                break;
            case 'RADIO':
                $id = 7;
                $valida = 23;
                break;
            case 'SAR':
                $id = 8;
                $valida = 27;
                break;
        }
        $authori_status = User::authorization_status($valida);
        if ($authori_status['permi'] >= 3) {
            $datos = [];
            $equipo = DB::table('equipment_model')
                ->join('relation_model_function', 'relation_model_function.id_equipment_model', '=', 'equipment_model.id')
                ->join('function_equipment_model', 'relation_model_function.id_function_equipment_model', '=', 'function_equipment_model.id')
                ->Join('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
                ->Join('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
                ->leftJoin('import_st_excels', 'import_st_excels.codsap', '=', 'equipment_model.cod_sap')
                ->where('relation_model_function.id_function_equipment_model', '=', $id)
                ->where('relation_model_function.status', '=', 'Activo')
                ->where('equipment_model.status', '!=', 'Obsoleto')
                ->select('equipment_model.id', 'list_mark.name as mark', 'list_equipment.name as equipment', 'equipment_model.model', 'equipment_model.status', 'equipment_model.description', 'function_equipment_model.id as function', 'equipment_model.bw_max_hw', 'import_st_excels.stock_benavidez')
                ->groupBy('equipment_model.id', 'list_mark.name', 'list_equipment.name', 'equipment_model.model', 'equipment_model.status', 'equipment_model.description', 'function_equipment_model.id', 'equipment_model.bw_max_hw', 'import_st_excels.stock_benavidez')
                ->orderBy('model', 'asc')->get();
            foreach ($equipo as $value) {
                $bw = ControllerEquipment_Model::format_bw($value->bw_max_hw);
                $datos[] = array(
                    'id' => $value->id,
                    'mark' => $value->mark,
                    'equipment' => $value->equipment,
                    'model' => $value->model,
                    'status' => $value->status,
                    'description' => $value->description,
                    'function' => $value->function,
                    'bw_max_hw' => $bw['data'] . $bw['signo'],
                    'stock_benavidez' => $value->stock_benavidez,
                );
            }
            return datatables()->of($datos)->make(true);
        } else {
            return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function down_equipmen()
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $id = $_POST['id'];
        $equip = Equipment::find($id, ['id_function']);
        switch ($equip->id_function) {
            case '1':
                $valida = 7;
                break;
            case '2':
                $valida = 8;
                break;
            case '3':
                $valida = 9;
                break;
            case '4':
                $valida = 13;
                break;
            case '5':
                $valida = 19;
                break;
            case '6':
                $valida = 20;
                break;
            case '7':
                $valida = 23;
                break;
            case '8':
                $valida = 27;
                break;
        }
        $autori_status = User::authorization_status($valida);
        if ($autori_status['permi'] >= 10) {
            $down = $_POST['down'];
            $validar = DB::table('equipment')
                ->join('board', 'board.id_equipment', '=', 'equipment.id')
                ->join('port', 'port.id_board', '=', 'board.id')
                ->join('lacp_port', 'port.id_lacp_port', '=', 'lacp_port.id')
                ->join('service_port', 'service_port.id_lacp_port', '=', 'lacp_port.id')
                ->join('service', 'service_port.id_service', '=', 'service.id')
                ->where('equipment.id', '=', $id)
                ->select('equipment.id', 'equipment.acronimo')->get();
            if (count($validar) == 0) {
                $port_all = DB::table('equipment')
                    ->join('board', 'board.id_equipment', '=', 'equipment.id')
                    ->join('port', 'port.id_board', '=', 'board.id')
                    ->leftJoin('link', 'port.id_lacp_port', '=', 'link.id_extreme_2')
                    ->where('equipment.id', '=', $id)
                    ->select('port.id', 'port.connected_to', 'link.id as link')->get();
                foreach ($port_all as $key) {
                    $port_update = Port::find($key->id);
                    $port_update->connected_to = null;
                    $port_update->type = null;
                    $port_update->id_status = 2;
                    $port_update->id_lacp_port = null;
                    $port_update->id_chain = null;
                    $port_update->commentary = null;
                    $port_update->id_uplink = null;
                    $port_update->id_ring = null;
                    $port_update->save();
                    if ($key->link != null) {
                        $link = Link::find($key->link);
                        $link->id_extreme_2 = null;
                        $link->save();
                    }
                }
                $alta_equi = Equipment::find($id);
                $alta_equi->ir_os_down = $down;
                $alta_equi->status = 'BAJA';
                $alta_equi->save();
                ControllerUser_history::store('Le dio de baja al equipo: ' . $alta_equi->acronimo);
                $buscar_ip = DB::table("ip")->where('id_equipment', '=', $id)->orWhere('id_equipment_wan', '=', $id)
                    ->select('ip.id', 'ip.id_service', 'ip.id_client', 'ip.id_use_vlan')->get();
                foreach ($buscar_ip as $var) {
                    $ip_old = IP::find($var->id);
                    $ip_old->id_status = 1;
                    $ip_old->id_equipment = null;
                    $ip_old->id_equipment_wan = null;
                    $ip_old->save();
                }
                $resul = 'yes';
            } else {
                $resul = 'nop';
            }
            return array('resul' => $resul,);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public static function service_equipmen()
    {
        if (!Auth::guest() == false) return array('resul' => 'login');
        $equip = Equipment::find($_POST['id'], ['id_function']);
        switch ($equip->id_function) {
            case '1':
                $valida = 7;
                break;
            case '2':
                $valida = 8;
                break;
            case '3':
                $valida = 9;
                break;
            case '4':
                $valida = 13;
                break;
            case '5':
                $valida = 19;
                break;
            case '6':
                $valida = 20;
                break;
            case '7':
                $valida = 23;
                break;
        }
        $autori_status = User::authorization_status($valida);
        if ($autori_status['permi'] < 3) return array('resul' => 'autori');

        $servicios = [];
        $servi = DB::table('equipment')
            ->join('board', 'board.id_equipment', '=', 'equipment.id')
            ->join('port', 'port.id_board', '=', 'board.id')
            ->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
            ->Join('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
            ->join('service', 'service_port.id_service', '=', 'service.id')
            ->join('client', 'service.id_client', '=', 'client.id')
            ->join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->where('equipment.id', '=', $_POST['id'])
            ->select('service.id as id_serv', 'service.number', 'service.bw_service', 'service.commentary', 'client.business_name', 'client.acronimo', 'port.n_port', 'board.slot', 'list_label.name as label', 'service_port.vlan', 'lacp_port.id')
            ->groupBy('service.id', 'service.number', 'service.bw_service', 'service.commentary', 'client.business_name', 'client.acronimo', 'port.n_port', 'board.slot', 'list_label.name', 'service_port.vlan', 'lacp_port.id')->get();
        foreach ($servi as $value) {
            $slot = ControllerRing::label_por($value->slot);
            $bw = ControllerEquipment_Model::format_bw($value->bw_service);
            $vlan = '';
            if ($value->vlan != null) $vlan = $value->vlan;
            $servicios[] = array(
                'id' => $value->id,
                'number' => $value->number,
                'bw_service' => $bw['data'] . ' ' . $bw['signo'],
                'commentary' => $value->commentary,
                'business_name' => $value->business_name,
                'acronimo' => $value->acronimo,
                'n_port' => $value->n_port,
                'slot' => $slot,
                'label' => $value->label,
                'vlan' => $vlan,
                'service' => $value->id_serv,
            );
        }
        if (count($servicios) > 0) {
            $slot_order = array_column($servicios, 'slot');
            $n_port_order = array_column($servicios, 'n_port');
            array_multisort($slot_order, SORT_ASC, $n_port_order, SORT_ASC, $servicios);
        }
        return array('resul' => 'yes', 'datos' => $servicios,);
    }

    public function equipment()
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $id = $_POST['id'];
        $equipment = Equipment::find($id, ['id_function', 'acronimo', 'type',]);
        $type = $equipment->type;
        switch ($equipment->id_function) {
            case '1':
                $status_valida = 7;
                break;
            case '2':
                $status_valida = 8;
                break;
            case '3':
                $status_valida = 9;
                break;
            case '4':
                $status_valida = 13;
                break;
            case '5':
                $status_valida = 19;
                break;
            case '6':
                $status_valida = 20;
                break;
            case '7':
                $status_valida = 23;
                break;
            //BORRAR ESTE DEFAULT PARA PREVENIR ERRORES; este default es porque los nuevos equipos no tienen un tipo de permiso
            default:
                $status_valida = 23;
                break;
        }
        $autori_status = User::authorization_status($status_valida);
        if ($autori_status['permi'] >= 3) {
            $ip_id = '';
            $ip_ip = '';
            $ip = DB::table('ip')->where('id_equipment_wan', '=', $id)->select('id', 'ip', 'prefixes')->get();
            if (count($ip) > 0) {
                $ip_id = $ip[0]->id;
                $ip_ip = $ip[0]->ip . '/' . $ip[0]->prefixes;
            }
            return array('resul' => 'yes', 'datos' => $equipment->acronimo, 'ip' => $ip_ip, 'id' => $ip_id, 'type' => $type);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public function equipment_rign()
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(11);
        if ($autori_status['permi'] >= 3) {
            $id = $_POST['id'];
            $equi = DB::table('port')
                ->leftJoin('board', 'port.id_board', '=', 'board.id')
                ->leftJoin('equipment', 'board.id_equipment', '=', 'equipment.id')
                ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
                ->leftJoin('address', 'equipment.address', '=', 'address.id')
                ->leftJoin('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
                ->leftJoin('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
                ->leftJoin('function_equipment_model', 'equipment.id_function', '=', 'function_equipment_model.id')
                ->leftJoin('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
                ->leftJoin('list_mark', 'equipment_model.id_mark', '=', 'list_mark.id')
                ->leftJoin('function_equipment_model', 'equipment.id_function', '=', 'function_equipment_model.id')
                ->leftJoin('client', 'client.id', '=', 'equipment.id_client')
                ->leftJoin('node', 'node.id', '=', 'equipment.id_node')
                ->leftJoin('address as add_node', 'node.address', '=', 'add_node.id')
                ->leftJoin('list_provinces as provi_node', 'add_node.id_provinces', '=', 'provi_node.id')
                ->leftJoin('list_countries as coun_node', 'provi_node.id_countries', '=', 'coun_node.id')
                ->where('port.id_ring', '=', $id)
                ->where('equipment.id_function', '!=', 1)
                ->select('equipment.id', 'equipment.acronimo', 'function_equipment_model.name as funsion', 'list_mark.name as mark', 'equipment_model.model', 'equipment_model.description', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'list_countries.name as countries', 'list_provinces.name as provinces', 'ip.ip', 'ip.prefixes', 'add_node.id as id_direcct', 'add_node.location as locati', 'add_node.street as stre', 'add_node.height as heigh', 'add_node.floor as flo', 'add_node.department as depar', 'add_node.postal_code as postal', 'node.cell_id', 'coun_node.name as countrie', 'provi_node.name as province',)->groupBy('equipment.id', 'equipment.acronimo', 'function_equipment_model.name', 'list_mark.name', 'equipment_model.model', 'equipment_model.description', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'list_countries.name', 'list_provinces.name', 'ip.ip', 'ip.prefixes', 'add_node.id', 'add_node.location', 'add_node.street', 'add_node.height', 'add_node.floor', 'add_node.department', 'add_node.postal_code', 'node.cell_id', 'coun_node.name', 'provi_node.name',)->get();
            $datos = [];
            foreach ($equi as $value) {
                $direc = $value->countries . ' ' . $value->provinces . ' ' . $value->location . ' ' . $value->street . ' ' . $value->height;
                if ($value->floor != null) {
                    $direc = $direc . ' Piso' . $value->floor;
                }
                if ($value->department != null) {
                    $direc = $direc . ' Depto' . $value->department;
                }
                if (isset($value->stre)) {
                    $direc = '(' . $value->cell_id . ') ' . $value->stre . ' ' . $value->heigh;
                    if ($value->department != null) {
                        $direc = $direc . ' Depto' . $value->depar;
                    }
                    if ($value->flo != null) {
                        $direc = $direc . ' Piso' . $value->flo;
                    }
                    $direc = $direc . ' ' . $value->locati . ' ' . $value->province . ' ' . $value->countrie;
                }
                $datos[] = array(
                    'id' => $value->id,
                    'acronimo' => $value->acronimo,
                    'funsion' => $value->funsion,
                    'mark' => $value->mark,
                    'model' => $value->model,
                    'description' => $value->description,
                    'direc' => $direc,
                    'ip' => $value->ip . '/' . $value->prefixes,
                );
            }
            $acronimo = Ring::find($id);
            return array('resul' => 'yes', 'datos' => $datos, 'acronimo' => $acronimo->name,);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public function location()
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $location = Equipment_Location::all();
        return array('resul' => 'yes', 'datos' => $location,);
    }

    public function equipment_selec()
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $id = $_POST['id'];
        $Equipment = DB::table('equipment')
            ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
            ->where('equipment.id', '=', $id)
            ->select('equipment.acronimo', 'ip.ip', 'ip.prefixes')->get();
        if (count($Equipment) > 0) {
            $resul = array('resul' => 'yes',
                'datos' => $Equipment[0]->acronimo,
                'ip' => $Equipment[0]->ip . '/' . $Equipment[0]->prefixes,
            );
        } else {
            $resul = array('resul' => 'nop',);
        }
        return $resul;
    }

    public function acronimo_equimenp_all()
    {
        $info = DB::table('equipment')->where('acronimo', 'like', '% %')->select('id', 'acronimo')->get();
        foreach ($info as $value) {
            $name = strtoupper(str_replace(' ', '', $value->acronimo));
            if ($name != "") {
                $sql = Equipment::find($value->id);
                $sql->acronimo = $name;
                $sql->save();
            }
        }
    }

    public function list_ip_equipment_all($data)
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $all = [];
        $slq_id = DB::table('ip')->where('ip.id_equipment', '=', $data)->orwhere('ip.id_equipment', '=', $data)->select('id')->get();
        foreach ($slq_id as $valor) {
            $id_full[] = $valor->id;
        }
        if (count($slq_id) > 0) {
            $all = ControllerIP::info_ip_filtro($id_full);
        }
        return datatables()->of($all)->make(true);
    }

    public function store_update_pe(RequestRegister_PE $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(9);
        if ($autori_status['permi'] >= 5) {
            $id = $request->id;
            $name = strtoupper($request->name);
            $valor = $request->port;
            $ip = $request->ip_admin;
            if ($id != 0 && $id != '') {
                $msj_equip = 'Modifico el PE: ';
                $alta_equi = Equipment::find($id);
            } else {
                if ($autori_status['permi'] >= 10) {
                    $msj_equip = 'Registro el PE: ';
                    $alta_equi = new Equipment();
                    $alta_equi->id_function = 3;
                    $alta_equi->id_model = $request->equipo;
                    $alta_equi->client_management = 'No';
                } else {
                    return array('resul' => 'autori',);
                }
            }
            $alta_equi->acronimo = $name;
            $alta_equi->location = $request->local;
            $alta_equi->id_node = $request->nodo;
            $alta_equi->ir_os_up = $request->alta;
            $alta_equi->commentary = $request->commen;
            $alta_equi->id_zone = $request->id_zone;
            $alta_equi->save();
            ControllerUser_history::store($msj_equip . $name);
            ControllerEquipment::store_update_ip_port_equipment($id, $alta_equi->id, $valor, $ip, $name);
            return array('resul' => 'yes',);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public function store_update_dm(RequestRegister_DM $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(19);
        if ($autori_status['permi'] >= 5) {
            $id = $request->id;
            $name = strtoupper($request->name);
            $valor = $request->port;
            $ip = $request->ip_admin;
            $acro = ControllerEquipment::validation_acronimo($id, $name);
            if ($acro == 'Si') {
                return array('resul' => 'acronimo_exi',);
            }
            $ip_valida = ControllerEquipment::validation_ip($ip, $id);
            if ($ip_valida != 'Si') {
                return array('resul' => 'ip_exi',);
            }
            if ($id != 0 && $id != '') {
                $msj_equip = 'Modifico el DM: ';
                $alta_equi = Equipment::find($id);
            } else {
                if ($autori_status['permi'] >= 10) {
                    $msj_equip = 'Registro el DM: ';
                    $alta_equi = new Equipment();
                    $alta_equi->id_function = 5;
                    $alta_equi->id_model = $request->equipo;
                    $alta_equi->client_management = 'No';
                } else {
                    return array('resul' => 'autori',);
                }
            }
            $alta_equi->acronimo = $name;
            $alta_equi->location = $request->local;
            $alta_equi->id_node = $request->nodo;
            $alta_equi->ir_os_up = $request->alta;
            $alta_equi->commentary = $request->commen;
            $alta_equi->id_zone = $request->id_zone;
            $alta_equi->save();
            ControllerUser_history::store($msj_equip . $name);
            ControllerEquipment::store_update_ip_port_equipment($id, $alta_equi->id, $valor, $ip, $name);
            return array('resul' => 'yes',);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public function store_update_pei(RequestRegister_PEI $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login');
        }
        $autori_status = User::authorization_status(20);
        if ($autori_status['permi'] >= 5) {
            $id = $request->id;
            $name = strtoupper($request->name);
            $valor = $request->port;
            $ip = $request->ip_admin;
            if ($id != 0 && $id != '') {
                $msj_equip = 'Modifico el PEI: ';
                $alta_equi = Equipment::find($id);
            } else {
                if ($autori_status['permi'] >= 10) {
                    $msj_equip = 'Registro el PEI: ';
                    $alta_equi = new Equipment();
                    $alta_equi->id_function = 6;
                    $alta_equi->id_model = $request->equipo;
                    $alta_equi->client_management = 'No';
                } else {
                    return array('resul' => 'autori',);
                }
            }
            $alta_equi->acronimo = $name;
            $alta_equi->location = $request->local;
            $alta_equi->id_node = $request->nodo;
            $alta_equi->ir_os_up = $request->alta;
            $alta_equi->commentary = $request->commen;
            $alta_equi->id_zone = $request->id_zone;
            $alta_equi->save();
            ControllerUser_history::store($msj_equip . $name);
            ControllerEquipment::store_update_ip_port_equipment($id, $alta_equi->id, $valor, $ip, $name);
            return array('resul' => 'yes');
        } else {
            return array('resul' => 'autori');
        }
    }


    public function store_update_ip_port_equipment($id, $id_equip, $valor, $ip, $name)
    {
        $info = ControllerEquipment::ip_admin_buscar($id_equip);
        if (count($info) > 0) {
            $ip_old = $info[0]->id;
        } else {
            $ip_old = '0';
        }
        if ($ip != $ip_old) {
            ControllerEquipment::ip_status($ip, $ip_old, $id_equip, $name);
        }
        if ($id == 0) {
            foreach ($valor as $value) {
                $separar = explode(',', $value);
                if ($separar[1] == '@|@' || $separar[1] == '@') {
                    $lab = null;
                } else {
                    $lab = $separar[1];
                }
                $placas[] = array(
                    'id' => $separar[0],
                    'data' => $lab,
                );
            }
            foreach ($placas as $valu) {
                $pla = new Board();
                $pla->id_equipment = $id_equip;
                $pla->id_port_model = $valu['id'];
                $pla->slot = $valu['data'];
                $pla->status = 'ACTIVO';
                $pla->save();
            }
        }
    }

    public function port_equipment_lsw_ring()
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(13);
        if ($autori_status['permi'] >= 5) {
            $datos_all = [];
            $datos_port = [];
            $id = $_POST['id'];
            $port_equipment = DB::table('equipment')
                ->Join('board', 'equipment.id', '=', 'board.id_equipment')
                ->Join('port', 'board.id', '=', 'port.id_board')
                ->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
                ->where('equipment.id', '=', $id)
                ->whereNotNull('port.id_ring')
                ->select('equipment.acronimo', 'port.id', 'port.n_port', 'board.slot', 'list_label.name')->get();
            foreach ($port_equipment as $value) {
                $slot = ControllerRing::label_por($value->slot);
                $datos_port[] = array(
                    'id' => $value->id,
                    'port' => $value->acronimo . ' ' . $value->name . $slot . $value->n_port,
                    'data' => $value->name . $slot . $value->n_port,
                );
            }
            $port_all = DB::table('board')
                ->Join('port_equipment_model', 'board.id_port_model', '=', 'port_equipment_model.id')
                ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
                ->where('board.id_equipment', '=', $id)
                ->select('board.id', 'board.slot', 'list_label.name', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f')->get();
            foreach ($port_all as $valor) {
                $slot_all = ControllerRing::label_por($valor->slot);
                for ($i = $valor->port_l_i; $i < $valor->port_l_f + 1; $i++) {
                    $selec = 0;
                    $port_real = $valor->name . $slot_all . $i;
                    $info_port = array_search($port_real, array_column($datos_port, 'data'));
                    if ($info_port !== false) {
                        $selec = 1;
                    }
                    $datos_all[] = array(
                        'port' => $valor->id . '|' . $i,
                        'all' => $port_real,
                        'selec' => $selec,
                    );
                }
            }
            return array('resul' => 'yes',
                'datos_port' => $datos_port, 'datos' => $datos_all,);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public function update_port_lsw_ring()
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(13);
        if ($autori_status['permi'] >= 5) {
            $datos = $_POST['port'];
            $data = [];
            foreach ($datos as $value) {
                $id_port = 0;
                $divi = explode('|', $value);
                $vali = $divi[1] . '|' . $divi[2];
                if (count($data) > 0) {
                    $info_port = array_search($vali, array_column($data, 'board_port'));
                    if ($info_port !== false) {
                        return array('resul' => 'duplica',);
                    }
                }
                $port_validar = DB::table('port')->where('id_board', '=', $divi[1])
                    ->where('n_port', '=', $divi[2])->where('id', '!=', $divi[0])->select('id', 'id_status')->get();
                if (count($port_validar) > 0) {
                    if ($port_validar[0]->id_status != 2) {
                        return array('resul' => 'ocupado',);
                    }
                    $id_port = $port_validar[0]->id;
                }
                $data[] = array(
                    'id_old' => $divi[0],
                    'board' => $divi[1],
                    'port' => $divi[2],
                    'board_port' => $vali,
                    'id_port' => $id_port,
                );
            }
            foreach ($data as $val) {
                $port_old = Port::find($val['id_old']);
                if ($val['id_port'] != 0) {
                    $port_new = Port::find($val['id_port']);
                } else {
                    $port_new = new Port();
                    $port_new->id_board = $val['board'];
                    $port_new->n_port = $val['port'];
                }
                $port_new->id_status = 1;
                $port_new->connected_to = $port_old->connected_to;
                $port_new->type = 'ANILLO';
                $port_new->id_ring = $port_old->id_ring;
                $port_new->save();
                $port_free = Port::find($val['id_old']);
                $port_free->id_status = 2;
                $port_free->connected_to = null;
                $port_free->type = null;
                $port_free->id_ring = null;
                $port_free->save();
            }
            return array('resul' => 'yes',);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public function store_update_lsw(RequestLanswitchIpran $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(13);
        if ($autori_status['permi'] >= 5) {
            $id = $request->id;
            $name = $request->name;
            $ip_admin = $request->ip_admin;
            $sitio = $request->sitio;
            $board = $request->board;
            $port = $request->port;
            $link = $request->link;
            $acro = ControllerEquipment::validation_acronimo($id, $name);
            if ($acro == 'Si') {
                return array('resul' => 'acronimo_exi',);
            }
            $ip_valida = ControllerEquipment::validation_ip($ip_admin, $id);
            if ($ip_valida != 'Si') {
                return array('resul' => 'ip_exi',);
            }
            if ($id != 0) {
                $msj_equip = 'Modifico el lanswitch: ';
                $alta_equi = Equipment::find($id);
            } else {
                if ($autori_status['permi'] >= 10) {
                    $msj_equip = 'Registro el lanswitch: ';
                    $alta_equi = new Equipment();
                } else {
                    return array('resul' => 'autori',);
                }
                $alta_equi->id_model = $request->equi_alta;
                $alta_equi->id_function = 4;
                $alta_equi->client_management = $sitio;
            }
            $alta_equi->location = $request->local;
            $alta_equi->ir_os_up = $request->orden;
            $alta_equi->acronimo = $name;
            if ($sitio == 'No') {
                $alta_equi->id_client = 291;
                $alta_equi->address = null;
                $alta_equi->id_node = $request->nodo_al;
            } else {
                $alta_equi->address = $request->direc;
                $alta_equi->id_node = null;
                $alta_equi->id_client = $request->client;
            }
            $alta_equi->service = $request->enlace;
            $alta_equi->commentary = $request->commen;
            $alta_equi->type = 'Ipran';
            $alta_equi->save();
            $id_equip = $alta_equi->id;
            ControllerUser_history::store($msj_equip . $name);
            if ($id == 0) {
                ControllerEquipment::store_update_ip_port_equipment($id, $id_equip, $board, $ip_admin, $name);
            }
            if ($id == 0 && $sitio == 'No') {
                $divi = explode(',', $port[0]);
                $port_sar = $request->equi_sar . '|' . $request->port_sar;
                ControllerEquipment::port_new_link_lsw($id_equip, $divi[0], $divi[1], $link, $port_sar);
            }
            if ($sitio == 'Si' && $id == 0) {
                foreach ($port as $value) {
                    $divi = explode(',', $value);
                    $info = DB::table('board')->where('id_equipment', '=', $id_equip)
                        ->where('id_port_model', '=', $divi[0])->select('id')->get();
                    if (count($info) > 0) {
                        $new = new Port();
                        $new->id_board = $info[0]->id;
                        $new->n_port = $divi[1];
                        $new->id_status = 1;
                        $new->type = 'ANILLO';
                        $new->id_ring = $request->ring;
                        $new->save();
                    }
                }
            }
            return array('resul' => 'yes', 'datos' => $alta_equi);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public function port_new_link_lsw($equip, $board, $port, $link, $port_sar)
    {
        $info = DB::table('board')->where('id_equipment', '=', $equip)
            ->where('id_port_model', '=', $board)->select('id')->get();
        if (count($info) > 0) {
            $lacp = new Lacp_Port();
            $lacp->group_lacp = 'NO';
            $lacp->save();
            $id = $lacp->id;
            $new = new Port();
            $new->id_board = $info[0]->id;
            $new->n_port = $port;
            $new->id_status = 1;
            $new->type = 'LINK';
            $new->id_lacp_port = $id;
            $new->save();
            $new_link = Link::find($link);
            $new_link->id_extreme_2 = $id;
            $new_link->interface_identification_1 = $port_sar;
            $new_link->save();
        }
    }

    public function store_radio(RequestRadio $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(13);
        if ($autori_status['permi'] >= 10) {
            $acro = ControllerEquipment::validation_acronimo(0, $request->radio_acro);
            if ($acro == 'Si') {
                return array('resul' => 'acronimo_exi_2',);
            }
            if ($request->loopback_ip != '' && $request->loopback_ip != null) {
                $valida_loop = ControllerEquipment::validation_ip($request->loopback_ip, 0);
                if ($valida_loop != 'Si') {
                    return array('resul' => 'loopback_exi_2',);
                }
            }
            $info_service = Service::find($request->servicio, ['number']);
            if ($request->radio == '') {
                $acro1 = ControllerEquipment::validation_acronimo(0, $request->acro_radio);
                if ($acro1 == 'Si') {
                    return array('resul' => 'acronimo_exi_1',);
                }
                $ip_valida = ControllerEquipment::validation_ip($request->ip_admin, 0);
                if ($ip_valida != 'Si') {
                    return array('resul' => 'ip_exi',);
                }
                if ($request->ip_loopback != '' && $request->ip_loopback != null) {
                    $loop_vali = ControllerEquipment::validation_ip($request->ip_loopback, 0);
                    if ($loop_vali != 'Si') {
                        return array('resul' => 'loopback_exi_1',);
                    }
                }
                $alta_equi = new Equipment();
                $alta_equi->id_model = $request->modelo;
                $alta_equi->id_function = 7;
                $alta_equi->client_management = 'No';
                $alta_equi->acronimo = $request->acro_radio;
                $alta_equi->location = null;
                $alta_equi->id_node = $request->nodo;
                $alta_equi->ir_os_up = $request->orden;
                $alta_equi->service = $info_service->number;
                $alta_equi->type = 'Celda';
                $alta_equi->commentary = null;
                $alta_equi->ne_id = $request->neid;
                $alta_equi->save();
                $radio = $alta_equi->id;
                ControllerEquipment::BoardNewRadio($radio, $request->modelo);
                $ip = IP::find($request->ip_admin);
                $ip->id_status = 2;
                $ip->id_equipment = $radio;
                $ip->save();
                if ($request->ip_loopback != '' && $request->ip_loopback != null) {
                    $ip_loopback = IP::find($request->ip_loopback);
                    $ip_loopback->id_status = 2;
                    $ip_loopback->id_loopback = $radio;
                    $ip_loopback->save();
                }
                ControllerUser_history::store('Registro el radio: ' . $request->acro_radio);
            } else {
                $radio = $request->radio;
                ControllerUser_history::store('Modifico el radio: ' . $request->acro_radio);
            }
            $alta = new Equipment();
            $alta->id_model = $request->modelo2;
            $alta->id_function = 7;
            $alta->client_management = 'No';
            $alta->acronimo = $request->radio_acro;
            $alta->location = null;
            $alta->id_client = $request->client;
            $alta->address = $request->address;
            $alta->ir_os_up = $request->orden;
            $alta->service = $info_service->number;
            $alta->commentary = null;
            $alta->type = 'Cliente';
            $alta->ne_id = $request->ne_id_radio;
            $alta->save();
            $id_new_equi = $alta->id;
            ControllerUser_history::store('Registro el radio: ' . $request->radio_acro);
            ControllerEquipment::BoardNewRadio($id_new_equi, $request->modelo2);
            if ($request->loopback_ip != '' && $request->loopback_ip != null) {
                $loopback_ip = IP::find($request->loopback_ip);
                $loopback_ip->id_status = 2;
                $loopback_ip->id_loopback = $id_new_equi;
                $loopback_ip->save();
            }
            $divi_port = explode(',', $request->port_radio);
            $port_id = ControllerEquipment::port_id_all($divi_port[0], $radio, $divi_port[1]);

            $lsw_por = Port::find($port_id);
            $lsw_por->id_status = 1;
            $lsw_por->connected_to = $request->port_datos;
            $lsw_por->type = 'UPLINK';
            $lsw_por->save();

            if ($request->port_gestion != '' && $request->port_gestion != null) {
                $gestion = Port::find($request->port_gestion);
                $gestion->id_status = 1;
                $gestion->type = 'UPLINK';
                $gestion->commentary = 'GESTION DEL RADIO: ' . $request->acro_radio;
                $gestion->save();
            }

            $port_divi = explode(',', $request->new_port);
            $id_port = ControllerEquipment::port_id_all($port_divi[0], $id_new_equi, $port_divi[1]);

            $lacp_new = new Lacp_Port();
            $lacp_new->group_lacp = 'NO';
            $lacp_new->save();
            $lacp_new_id = $lacp_new->id;

            $datos = Port::find($request->port_datos);
            $datos->id_status = 1;
            $datos->id_lacp_port = $lacp_new_id;
            $datos->connected_to = $lsw_por->id;
            $datos->type = 'UPLINK';
            $datos->save();

            $port_new = Port::find($id_port);
            $port_new->id_lacp_port = $lacp_new_id;
            $port_new->id_status = 1;
            $port_new->save();

            $servi_new = new Service_Port();
            $servi_new->id_lacp_port = $lacp_new_id;
            $servi_new->id_service = $request->servicio;
            $servi_new->vlan = null;
            $servi_new->save();
            $frecu = explode(',', $request->frecuencia);
            $id_frecu = ControllerEquipment::frecuencia_antena($frecu[0], $frecu[1], $radio, $request->acro_radio);
            $ante = explode(',', $request->antena);
            $id_ante = ControllerEquipment::frecuencia_antena($ante[0], $ante[1], $radio, $request->acro_radio);
            $frecuencia = explode(',', $request->id_frecuencia);
            $id_frecuencia = ControllerEquipment::frecuencia_antena($frecuencia[0], $frecuencia[1], $id_new_equi, $request->radio_acro);
            $antena = explode(',', $request->id_antena);
            $id_antena = ControllerEquipment::frecuencia_antena($antena[0], $antena[1], $id_new_equi, $request->radio_acro);

            $if_port = explode(',', $request->port_radio_if);
            $id_port_if_1 = ControllerEquipment::port_id_all($if_port[0], $radio, $if_port[1]);

            $id_group_1 = ControllerEquipment::NewGroupLACP();

            ControllerEquipment::NewPortLACP($id_port_if_1, $id_group_1, 'Celda', $id_frecu, $id_ante);

            $port_if = explode(',', $request->port_radio2_if);
            $id_port_if_2 = ControllerEquipment::port_id_all($port_if[0], $id_new_equi, $port_if[1]);

            $id_group_2 = ControllerEquipment::NewGroupLACP();

            ControllerEquipment::NewPortLACP($id_port_if_2, $id_group_2, 'Cliente', $id_frecuencia, $id_antena);

            $name_likn = 'RF-' . $request->acro_radio . '_' . $request->radio_acro;
            $sql_info_bw = Equipment_Model::find($request->modelo2);
            $new_link = new Link();
            $new_link->name = $name_likn;
            $new_link->id_extreme_1 = $id_group_2;
            $new_link->id_extreme_2 = $id_group_1;
            $new_link->bw_all = $sql_info_bw->bw_max_hw;
            $new_link->bw_limit = $sql_info_bw->bw_max_hw;
            $new_link->id_list_type_links = 2;
            $new_link->id_node = $request->nodo;
            $new_link->status = 'ALTA';
            $new_link->save();
            return array('resul' => 'yes',);
        } else {
            return array('resul' => 'autori',);
        }
    }

    public function NewPortLACP($id, $lacp_new_id, $type, $ante, $odu)
    {
        $port_new = Port::find($id);
        $port_new->id_lacp_port = $lacp_new_id;
        $port_new->id_status = 1;
        $port_new->type = $type;
        $port_new->id_antena = $ante;
        $port_new->id_odu = $odu;
        $port_new->save();
    }

    public function NewGroupLACP()
    {
        $lacp_new = new Lacp_Port();
        $lacp_new->group_lacp = 'NO';
        $lacp_new->save();
        $lacp_new_id = $lacp_new->id;
        return $lacp_new_id;
    }

    public function port_id_all($model, $equipment, $port)
    {
        $board = DB::table('board')->where('board.id_port_model', '=', $model)
            ->where('board.id_equipment', '=', $equipment)->select('id')->get();
        $sql_port = DB::table('port')->where('port.id_board', '=', $board[0]->id)
            ->where('port.n_port', '=', $port)->select('id')->get();
        if (count($sql_port) > 0) {
            $id_port = $sql_port[0]->id;
        } else {
            $port_alta = new Port();
            $port_alta->id_board = $board[0]->id;
            $port_alta->n_port = $port;
            $port_alta->id_status = 1;
            $port_alta->save();
            $id_port = $port_alta->id;
        }
        return $id_port;
    }

    public function frecuencia_antena($model, $port, $equip, $acro)
    {
        $pla_new = new Board();
        $pla_new->id_equipment = $equip;
        $pla_new->id_port_model = $model;
        $pla_new->status = 'ACTIVO';
        $pla_new->slot = null;
        $pla_new->save();
        $port_alta = new Port();
        $port_alta->id_board = $pla_new->id;
        $port_alta->n_port = $port;
        $port_alta->id_status = 1;
        $port_alta->commentary = 'GESTION DEL RADIO: ' . $acro;
        $port_alta->save();
        return $port_alta->id;
    }

    public function BoardNewRadio($id, $model)
    {
        $Board = DB::table('port_equipment_model')
            ->join('relation_port_model', 'relation_port_model.id_port_equipment_model', '=', 'port_equipment_model.id')
            ->where('relation_port_model.id_equipment_model', '=', $model)
            ->where('port_equipment_model.type_board', '=', 'ONBOARD')
            ->select('port_equipment_model.id', 'relation_port_model.description_label')->get();
        foreach ($Board as $value) {
            $fsp = null;
            if ($value->description_label != null) {
                $divi = explode('#', $value->description_label);
                $sepa = substr($value->description_label, -1);
                foreach ($divi as $val) {
                    $separar = explode('%', $val);
                    $fsp = $fsp . $separar[1] . '|';
                }
                $fsp = $fsp . $sepa;
            }
            $pla = new Board();
            $pla->id_equipment = $id;
            $pla->id_port_model = $value->id;
            $pla->slot = $fsp;
            $pla->status = 'ACTIVO';
            $pla->save();
        }
    }

    public function list_radio_node($id)
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(23);
        if ($authori_status['permi'] >= 3) {
            $Equipment_Model = DB::table('equipment')
                ->join('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
                ->leftJoin('address', 'equipment.address', '=', 'address.id')
                ->leftJoin('list_provinces', 'address.id_provinces', '=', 'list_provinces.id')
                ->leftJoin('list_countries', 'list_provinces.id_countries', '=', 'list_countries.id')
                ->join('function_equipment_model', 'equipment.id_function', '=', 'function_equipment_model.id')
                ->Join('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
                ->Join('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
                ->leftJoin('client', 'client.id', '=', 'equipment.id_client')
                ->join('node', 'node.id', '=', 'equipment.id_node')
                ->leftJoin('ip', 'equipment.id', '=', 'ip.id_equipment')
                ->leftJoin('address as add_node', 'node.address', '=', 'add_node.id')
                ->leftJoin('list_provinces as provi_node', 'add_node.id_provinces', '=', 'provi_node.id')
                ->leftJoin('list_countries as coun_node', 'provi_node.id_countries', '=', 'coun_node.id')
                ->where('equipment.id_function', '=', 7)
                ->where('node.id', '=', $id)
                ->select('equipment.id', 'list_mark.name as mark', 'list_equipment.name as equipment', 'equipment_model.model', 'equipment.status', 'equipment.commentary', 'function_equipment_model.name as function', 'equipment.address', 'node.node', 'node.cell_id', 'client.business_name as client', 'equipment.acronimo', 'ip.ip as admin', 'equipment.ip_wan_rpv as ip_equipment', 'equipment_model.bw_max_hw', 'address.location', 'address.street', 'address.height', 'address.floor', 'address.department', 'address.postal_code', 'list_countries.name as countries', 'list_provinces.name as provinces', 'equipment_model.id as img', 'equipment.service', 'address.id as id_direc', 'add_node.id as id_direcct', 'add_node.location as locati', 'add_node.street as stre', 'add_node.height as heigh', 'add_node.floor as flo', 'add_node.department as depar', 'add_node.postal_code as postal', 'coun_node.name as countrie', 'provi_node.name as province', 'equipment.type')
                ->orderBy('model', 'asc')->get();
            $all = [];
            foreach ($Equipment_Model as $value) {
                $ip_equipment = '';
                $ip = '';
                $dire = '';
                if ($value->id_direc != null && $value->id_direc != '') {
                    $dire = $value->street . ' ' . $value->height;
                    if ($value->department != null) {
                        $dire = $dire . ' Depto' . $value->department;
                    }
                    if ($value->floor != null) {
                        $dire = $dire . ' Piso' . $value->floor;
                    }
                    $dire = $dire . ' ' . $value->location . ' ' . $value->provinces . ' ' . $value->countries;
                }
                if ($value->id_direcct != null && $value->id_direcct != '') {
                    $dire = '(' . $value->cell_id . ') ' . $value->stre . ' ' . $value->heigh;
                    if ($value->department != null) {
                        $dire = $dire . ' Depto' . $value->depar;
                    }
                    if ($value->floor != null) {
                        $dire = $dire . ' Piso' . $value->flo;
                    }
                    $dire = $dire . ' ' . $value->locati . ' ' . $value->province . ' ' . $value->countrie;
                }
                if ($value->ip_equipment != null) {
                    $ip_equipment = $value->ip_equipment;
                }
                if ($value->admin != null) {
                    $ip = $value->admin;
                }
                $all[] = array(
                    'id' => $value->id,
                    'mark' => $value->mark,
                    'equipment' => $value->equipment,
                    'service' => $value->service,
                    'model' => $value->model,
                    'status' => $value->status,
                    'commentary' => $value->commentary,
                    'function' => $value->function,
                    'address' => $dire,
                    'node' => $value->node,
                    'cell_id' => $value->cell_id,
                    'client' => $value->client,
                    'acronimo' => $value->acronimo,
                    'admin' => $ip,
                    'ip_equipment' => $ip_equipment,
                    'bw_max_hw' => $value->bw_max_hw,
                    'img' => $value->img,
                    'type' => $value->type
                );
            }
            return datatables()->of($all)->make(true);
        } else {
            return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function equipment_selec_radio()
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $id = $_POST['id'];
        $Equipment = DB::table('equipment')
            ->Join('equipment_model', 'equipment.id_model', '=', 'equipment_model.id')
            ->Join('list_mark', 'equipment_model.id_mark', '=', 'list_mark.id')
            ->Join('list_equipment', 'equipment_model.id_equipment', '=', 'list_equipment.id')
            ->leftJoin('ip', 'ip.id_equipment', '=', 'equipment.id')
            ->where('equipment.id', '=', $id)
            ->select('equipment.acronimo', 'ip.id as id_ip', 'ip.ip', 'ip.prefixes', 'list_mark.name as mark', 'equipment_model.model', 'list_equipment.name as equipment', 'equipment_model.id as id_model', 'equipment.ne_id')->get();
        if (count($Equipment) > 0) {
            $resul = array('resul' => 'yes',
                'datos' => $Equipment[0]->acronimo,
                'id_model' => $Equipment[0]->id_model,
                'ne_id' => $Equipment[0]->ne_id,
                'id_ip' => $Equipment[0]->id_ip,
                'model' => $Equipment[0]->model . ' ' . $Equipment[0]->mark . ' ' . $Equipment[0]->equipment,
                'ip' => $Equipment[0]->ip . '/' . $Equipment[0]->prefixes,
            );
        } else {
            $resul = array('resul' => 'nop',);
        }
        return $resul;
    }

    public function acronimo_radio_nodo()
    {
        $id = $_POST['id'];
        $equi = $_POST['equi'];
        $info = Node::find($id, ['cell_id']);
        $model = Equipment_Model::find($equi, ['id_mark']);
        switch ($model->id_mark) {
            /** Mati Jr 20/9/2022: Pongo las Constants de los modelos de equipos QUE ESTABLECEN LOS ACRONIMOS*/
            case Constants::EQUIPMENT_MODEL_NOKIA:
                $mark = 'RA';
                break;
            case Constants::EQUIPMENT_MODEL_AVIAT:
                $mark = 'RV';
                break;
            default:
                $mark = 'RH';
                break;
        }
        for ($i = 1; $i < 100; $i++) {
            $n = $i;
            if ($i < 10) {
                $n = '0' . $i;
            }

            $name = $info->cell_id . $mark . $n;
            $acro = count(DB::table('equipment')->where('acronimo', '=', $name)->select('id')->get());
            if ($acro == 0) {
                $i = 101;
            }
        }
        return array('resul' => 'yes', 'datos' => $name, 'modelo' => $model->id_mark);
    }

    public function acronimo_radio_cliente()
    {
        $id = $_POST['id'];
        $equi = $_POST['equi'];
        $info = Client::find($id, ['acronimo']);
        $model = Equipment_Model::find($equi, ['id_mark']);
        switch ($model->id_mark) {

            /** Mati Jr 20/9/2022: Pongo las Constants de los modelos de equipos QUE ESTABLECEN LOS ACRONIMOS*/
            case Constants::EQUIPMENT_MODEL_NOKIA:
                $mark = 'RA';
                break;
            case Constants::EQUIPMENT_MODEL_AVIAT:
                $mark = 'RV';
                break;
            default:
                $mark = 'RH';
                break;
        }
        for ($i = 1; $i < 100; $i++) {
            $n = $i;
            if ($i < 10) {
                $n = '0' . $i;
            }
            for ($h = 1; $h < 100; $h++) {
                $nu = $h;
                if ($h < 10) {
                    $nu = '0' . $h;
                }
                $name = $info->acronimo . $n . $mark . $nu;
                $acro = count(DB::table('equipment')->where('acronimo', '=', $name)->select('id')->get());
                if ($acro == 0) {
                    $i = 101;
                    $h = 101;
                }

            }
        }
        return array('resul' => 'yes', 'datos' => $name);
    }

    public function update_radio(RequestEdictRadio $request)
    {
        $loopback = $request->loopback;
        $id = $request->id;
        $acro = ControllerEquipment::validation_acronimo($id, $request->acro_radio);
        if ($acro == 'Si') {
            return array('resul' => 'acronimo_exi',);
        }
        if ($loopback != "null") {
            $ip_loopback = ControllerEquipment::ValidationIPLoopback($loopback, $id);
            if ($ip_loopback != 'Si') {
                return array('resul' => 'ip_exi_loopback',);
            }
            ControllerEquipment::IPLoopback($loopback, $id, $request->acro_radio);
        }
        $alta_equi = Equipment::find($id);
        $alta_equi->acronimo = $request->acro_radio;
        $alta_equi->id_client = $request->client;
        $alta_equi->address = $request->address;
        $alta_equi->ne_id = $request->ne_id;
        $alta_equi->commentary = $request->commen;
        $alta_equi->save();
        return array('resul' => 'yes',);
    }

    public function update_radio_nodo(RequestEdictRadioNode $request)
    {
        $id = $request->id;
        $ip = $request->gestion;
        $loopback = $request->loopback;
        $acro = ControllerEquipment::validation_acronimo($id, $request->acro_radio);
        if ($acro == 'Si') {
            return array('resul' => 'acronimo_exi',);
        }
        $ip_valida = ControllerEquipment::validation_ip($ip, $id);
        if ($ip_valida != 'Si') {
            return array('resul' => 'ip_exi',);
        }
        if ($loopback != "null") {
            $ip_loopback = ControllerEquipment::ValidationIPLoopback($loopback, $id);
            if ($ip_loopback != 'Si') {
                return array('resul' => 'ip_exi_loopback',);
            }
            ControllerEquipment::IPLoopback($loopback, $id, $request->acro_radio);
        }
        $alta_equi = Equipment::find($id);
        $alta_equi->acronimo = $request->acro_radio;
        $alta_equi->id_node = $request->node;
        $alta_equi->ne_id = $request->ne_id;
        $alta_equi->commentary = $request->commen;
        $alta_equi->save();
        $info = ControllerEquipment::ip_admin_buscar($id);
        if (count($info) > 0) {
            $ip_old = $info[0]->id;
        } else {
            $ip_old = '0';
        }
        if ($ip != $ip_old) {
            ControllerEquipment::ip_status($ip, $ip_old, $id, $name);
        }
        return array('resul' => 'yes',);
    }

    public function IPLoopback($ip, $equimp, $name)
    {
        $info = DB::table('ip')
            ->where('ip.id_loopback', '=', $equimp)
            ->select('ip.ip', 'ip.id')->get();
        if (count($info) > 0) {
            if ($info[0]->id != $ip) {
                $ip_b = IP::find($info[0]->id);
                $ip_b->id_status = 1;
                $ip_b->id_loopback = null;
                $ip_b->save();
                $recor_ip = new Record_ip();
                $recor_ip->id_ip = $info[0]->id;
                $recor_ip->prefixes = $ip_b->prefixes;
                $recor_ip->attribute = 'El Radio: ' . $name . ' libero la ip';
                $recor_ip->id_user = Auth::user()->id;
                $recor_ip->save();
                $IPNew = IP::find($ip);
                $IPNew->id_status = 2;
                $IPNew->id_loopback = $equimp;
                $IPNew->save();
                $recor = new Record_ip();
                $recor->id_ip = $ip;
                $recor->prefixes = $IPNew->prefixes;
                $recor->attribute = 'El Radio: ' . $name . ' seleccino la ip';
                $recor->id_user = Auth::user()->id;
                $recor->save();
            }
        } else {
            $IPNew = IP::find($ip);
            $IPNew->id_status = 2;
            $IPNew->id_loopback = $equimp;
            $IPNew->save();
            $recor = new Record_ip();
            $recor->id_ip = $ip;
            $recor->prefixes = $IPNew->prefixes;
            $recor->attribute = 'El Radio: ' . $name . ' seleccino la ip';
            $recor->id_user = Auth::user()->id;
            $recor->save();
        }
    }

    public function ValidationIPLoopback($ip, $id)
    {
        $info = DB::table("ip")->select('ip.id_status', 'ip.id_loopback')
            ->where('ip.id', '=', $ip)->get();
        if (count($info) > 0) {
            if ($info[0]->id_status == 1 || $info[0]->id_loopback == $id || $info[0]->id_status == 7) {
                $resultado = 'Si';
            } else {
                $resultado = 'No';
            }
        } else {
            $resultado = 'No';
        }
        return $resultado;
    }

    public function list_index_radio_enlace()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(8);
        if ($authori_status['permi'] < 3) {
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
        $data = [];
        $info = DB::table('link')
            ->leftJoin('port ext1', 'link.id_extreme_1', '=', 'ext1.id_lacp_port')
            ->leftJoin('port ext2', 'link.id_extreme_2', '=', 'ext2.id_lacp_port')
            ->leftJoin('board ext_board1', 'ext1.id_board', '=', 'ext_board1.id')
            ->leftJoin('board ext_board2', 'ext2.id_board', '=', 'ext_board2.id')
            ->leftJoin('equipment ext_equi1', 'ext_board1.id_equipment', '=', 'ext_equi1.id')
            ->Join('equipment ext_equi2', 'ext_board2.id_equipment', '=', 'ext_equi2.id')
            ->leftJoin('port_equipment_model model1', 'ext_board1.id_port_model', '=', 'model1.id')
            ->leftJoin('port_equipment_model model2', 'ext_board2.id_port_model', '=', 'model2.id')
            ->leftJoin('list_label label1', 'model1.id_label', '=', 'label1.id')
            ->leftJoin('list_label label2', 'model2.id_label', '=', 'label2.id')
            ->where('link.id_list_type_links', '=', 2)
            ->select('ext_equi1.acronimo as extre1', 'ext_equi2.acronimo as extre2', 'link.bw_all', 'link.name', 'ext1.n_port as port1', 'ext2.n_port as port2', 'ext_board1.slot as slot1', 'ext_board2.slot as slot2', 'label1.name as labe1', 'label2.name as labe2', 'ext_equi2.id')->get();
        foreach ($info as $key => $value) {
            $slot1 = ControllerRing::label_por($value->slot1);
            $slot2 = ControllerRing::label_por($value->slot2);
            $bw = ControllerEquipment_Model::format_bw($value->bw_all);
            $extre1_por1 = '';
            $por1 = '';
            $extre1_por2 = '';
            $por2 = '';
            if ($value->port1 != null) {
                $extre1_por1 = $value->extre1 . ' Puerto: ' . $value->labe1 . $slot1 . $value->port1;
                $por1 = $value->labe1 . $slot1 . $value->port1;
            }
            if ($value->port2 != null) {
                $extre2_por2 = $value->extre2 . ' Puerto: ' . $value->labe2 . $slot2 . $value->port2;
                $por2 = $value->labe2 . $slot2 . $value->port2;
            }
            $data[] = array(
                'name' => $value->name,
                'extreme_1' => $value->extre1,
                'extreme_2' => $value->extre2,
                'id_extreme_2' => $value->id,
                'extreme_1_port1' => $extre1_por1,
                'extreme_2_port2' => $extre2_por2,
                'port1' => $por1,
                'port2' => $por2,
                'bw' => $bw['data'] . $bw['signo'],
            );
        }

        return datatables()->of($data)->make(true);
    }

    public function ChangeModel($id)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $equip = DB::table('equipment')->Join('equipment_model', 'equipment_model.id', '=', 'equipment.id_model')
            ->where('equipment.id', '=', $id)->select('id_function', 'acronimo', 'equipment_model.model')->first();
        switch ($equip->id_function) {
            case '1':
                $valida = 7;
                break;
            case '2':
                $valida = 8;
                break;
            case '3':
                $valida = 9;
                break;
            case '4':
                $valida = 13;
                break;
            case '5':
                $valida = 19;
                break;
            case '6':
                $valida = 20;
                break;
            case '7':
                $valida = 23;
                break;
            case '8':
                $valida = 27;
                break;
        }
        $autori_status = User::authorization_status($valida);
        if ($autori_status['permi'] < 5) {
            return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
        $datos = [];
        $port_all_inf = [];
        $equipo = DB::table('equipment_model')
            ->join('relation_model_function', 'relation_model_function.id_equipment_model', '=', 'equipment_model.id')
            ->join('function_equipment_model', 'relation_model_function.id_function_equipment_model', '=', 'function_equipment_model.id')
            ->Join('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
            ->Join('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
            ->leftJoin('import_st_excels', 'import_st_excels.codsap', '=', 'equipment_model.cod_sap')
            ->where('relation_model_function.id_function_equipment_model', '=', $equip->id_function)
            ->where('relation_model_function.status', '=', 'Activo')
            ->where('equipment_model.status', '!=', 'Obsoleto')
            ->select('equipment_model.id', 'list_mark.name as mark', 'list_equipment.name as equipment', 'equipment_model.model', 'equipment_model.status', 'equipment_model.description', 'function_equipment_model.id as function', 'equipment_model.bw_max_hw', 'import_st_excels.stock_benavidez')
            ->groupBy('equipment_model.id', 'list_mark.name', 'list_equipment.name', 'equipment_model.model', 'equipment_model.status', 'equipment_model.description', 'function_equipment_model.id', 'equipment_model.bw_max_hw', 'import_st_excels.stock_benavidez')
            ->orderBy('model', 'asc')->get();
        foreach ($equipo as $value) {
            $bw = ControllerEquipment_Model::format_bw($value->bw_max_hw);

            $datos[] = array(
                'id' => $value->id,
                'mark' => $value->mark,
                'equipment' => $value->equipment,
                'model' => $value->model,
                'status' => $value->status,
                'description' => $value->description,
                'function' => $value->function,
                'bw_max_hw' => $bw['data'] . $bw['signo'],
                'stock_benavidez' => $value->stock_benavidez,
                'option' => $value->mark . ' ' . $value->model . ', BW: ' . $bw['data'] . $bw['signo'] . ', ' . $value->description,
            );
        }

        $port = DB::table('port_equipment_model')
            ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
            ->join('board', 'board.id_port_model', '=', 'port_equipment_model.id')
            ->join('equipment', 'board.id_equipment', '=', 'equipment.id')
            ->join('list_port', 'port_equipment_model.id_list_port', '=', 'list_port.id')
            ->join('port', 'port.id_board', '=', 'board.id')
            ->leftJoin('status_port', 'status_port.id', '=', 'port.id_status')
            ->leftJoin('ring', 'ring.id', '=', 'port.id_ring')
            ->leftJoin('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
            ->leftJoin('link ex1', 'lacp_port.id', '=', 'ex1.id_extreme_1')
            ->leftJoin('link', 'lacp_port.id', '=', 'link.id_extreme_2')
            ->leftJoin('list_type_links', 'list_type_links.id', '=', 'link.id_list_type_links')
            ->leftJoin('list_type_links type_l', 'type_l.id', '=', 'ex1.id_list_type_links')
            ->leftJoin('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
            ->leftJoin('service', 'service.id', '=', 'service_port.id_service')
            ->leftJoin('client', 'client.id', '=', 'service.id_client')
            ->leftJoin('chain', 'port.id_chain', '=', 'chain.id')
            ->where('board.id_equipment', '=', $id)
            ->where('board.status', '=', 'ACTIVO')
            ->where('list_port.name', '!=', 'ANTENA')
            ->where('list_port.name', '!=', 'ODU')
            ->where('port.id_status', '!=', 2)
            ->select('list_label.name as label', 'board.slot', 'port.n_port', 'port.id', 'port.commentary', 'port.type', 'status_port.name as status', 'ring.name as ring', 'service.number', 'client.business_name', 'port.connected_to', 'lacp_port.commentary as con_sevi', 'status_port.id as id_status', 'lacp_port.lacp_number', 'link.name as link', 'list_type_links.name as type_links', 'type_l.name as links_type', 'ex1.name as link1', 'chain.name as chain1')->get();

        foreach ($port as $value) {
            $number = '';
            $equipo = '';
            $commentary = '';
            $lacp = '';
            $link = '';
            $link = '';
            $cadena = '';
            $anillo = '';
            $service_sql = DB::table('port')
                ->Join('lacp_port', 'lacp_port.id', '=', 'port.id_lacp_port')
                ->Join('service_port', 'lacp_port.id', '=', 'service_port.id_lacp_port')
                ->Join('service', 'service.id', '=', 'service_port.id_service')
                ->where('port.id', '=', $value->id)
                ->select('service.number')->groupBy('service.number')->get();
            foreach ($service_sql as $valor) {
                $number = $number . $valor->number . ' | ';
            }
            if (count($service_sql) > 0) {
                $number = 'Servicio: ' . $number;
                $number = substr($number, 0, -2);
                $service = 'SI';
            }
            if ($value->connected_to != null) {
                $port_connected_to = DB::table('port')
                    ->leftJoin('board', 'board.id', '=', 'port.id_board')
                    ->leftJoin('port_equipment_model', 'port_equipment_model.id', '=', 'board.id_port_model')
                    ->join('list_label', 'port_equipment_model.id_label', '=', 'list_label.id')
                    ->leftJoin('equipment', 'equipment.id', '=', 'board.id_equipment')
                    ->where('port.id', '=', $value->connected_to)
                    ->select('equipment.acronimo', 'list_label.name', 'board.slot', 'port.n_port')
                    ->get();
                if (count($port_connected_to) > 0) {
                    $fsp = ControllerRing::label_por($port_connected_to[0]->slot);
                    $all_port_info = $port_connected_to[0]->name . $fsp . $port_connected_to[0]->n_port;
                    $equipo = 'Equipo: ' . $port_connected_to[0]->acronimo . ' ' . $all_port_info . ' ';
                }
            }

            if ($value->commentary != null) {
                $commentary = $value->commentary;
            } else {
                $commentary = $value->con_sevi;
            }
            if ($value->lacp_number != null) {
                $lacp = $value->lacp_number . '. ';
            }
            if ($value->link != null) {
                $link = $value->type_links . ': ' . $value->link . ' ';
            }
            if ($value->link1 != null) {
                $link = $value->links_type . ': ' . $value->link1 . ' ';
            }
            if ($value->chain1 != null) {
                $cadena = 'Cadena: ' . $value->chain1 . ' ';
            }
            if ($value->ring != null) {
                $anillo = 'Anillo: ' . $value->ring . ' ';
            }

            $fsp_label = ControllerRing::label_por($value->slot);
            $port_all_inf[] = array(
                'id' => $value->id,
                'atributo' => $anillo . $cadena . $equipo . $number . $link,
                'port' => $value->label . $fsp_label . $value->n_port,
                'status' => $value->status,
                'slot' => $fsp_label,
                'n_port' => $value->n_port,
            );
            if (count($port_all_inf) > 1) {
                $pose_order = array_column($port_all_inf, 'slot');
                $port_order = array_column($port_all_inf, 'n_port');
                array_multisort($pose_order, SORT_ASC, $port_order, SORT_ASC, $port_all_inf);
            }
        }
        return view('admin_agg.modelo_nuevo', compact('datos', 'equip', 'port_all_inf', 'id'));
    }

    public function MigrationModelNewAndPort(RequestMigrationModel $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $equip = Equipment::find($request->id, ['id_function']);
        switch ($equip->id_function) {
            case '1':
                $valida = 7;
                $url = "ver/AGG";
                break;
            case '2':
                $valida = 8;
                $url = "ver/CPE";
                break;
            case '3':
                $valida = 9;
                $url = "ver/PE";
                break;
            case '4':
                $valida = 13;
                $url = "ver/lanswitch";
                break;
            case '5':
                $valida = 19;
                $url = "ver/DM";
                break;
            case '6':
                $valida = 20;
                $url = "ver/PEI";
                break;
            case '7':
                $valida = 23;
                $url = "ver/RADIO";
                break;
            case '8':
                $valida = 27;
                $url = "ver/SAR";
                break;
        }
        $autori_status = User::authorization_status($valida);
        if ($autori_status['permi'] < 10) {
            return redirect('home')->withErrors([Lang::get('validation.authori_status'),]);
        }
        $data_port = [];

        if (isset($request->port_new)) {
            $unique = array_unique($request->port_new);
        }

        if (isset($request->port_new) != isset($unique)) {
            return array('resul' => 'unique',);
        }
        if (isset($request->port_new) && count($request->port_new) == count($request->id_port)) {
            foreach ($request->id_port as $key => $port) {
                $data_port[] = array(
                    'old' => $port,
                    'new' => $request->port_new[$key],
                );
                $divi = explode(',', $request->port_new[$key]);
                $board_port[] = $divi[0];
            }
            $board_old = DB::table('board')->where('id_equipment', '=', $request->id)->select('id')->get();
            foreach ($request->placa_alta as $value) {
                $separar = explode(',', $value);
                $lab = null;
                if ($separar[1] != '@|@' && $separar[1] != '@') {
                    $lab = $separar[1];
                }
                $placas[] = array(
                    'id' => $separar[0],
                    'data' => $lab,
                );
                $board_new[] = $separar[0];
            }
            foreach ($board_port as $BoardPort) {
                $BoardInfo = array_search($BoardPort, $board_new);
                if ($BoardInfo === false) {
                    return array('resul' => 'board',);
                }
            }
            $new = Equipment::find($request->id);
            $new->id_model = $request->equi_alta;
            $new->save();
            foreach ($board_old as $val) {
                $old = Board::find($val->id);
                $old->status = 'DESACTIVADO';
                $old->save();
            }
            foreach ($placas as $valu) {
                $pla = new Board();
                $pla->id_equipment = $request->id;
                $pla->id_port_model = $valu['id'];
                $pla->slot = $valu['data'];
                $pla->status = 'ACTIVO';
                $pla->save();
            }
            foreach ($data_port as $valor) {
                $slot_new = null;
                $divi = explode(',', $valor['new']);
                if ($divi[2] != '@') {
                    $slot_new = $divi[2];
                }
                $port_old = Port::find($valor['old']);
                $board_new = DB::table('board')->where('id_equipment', '=', $request->id)->where('slot', '=', $slot_new)
                    ->select('id')->where('id_port_model', '=', $divi[0])->where('status', '=', 'ACTIVO')->get();
                $PortNew = new Port();
                $PortNew->id_board = $board_new[0]->id;
                $PortNew->n_port = $divi[1];
                $PortNew->id_status = $port_old->id_status;
                $PortNew->commentary = $port_old->commentary;
                $PortNew->connected_to = $port_old->connected_to;
                $PortNew->type = $port_old->type;
                $PortNew->id_uplink = $port_old->id_uplink;
                $PortNew->id_ring = $port_old->id_ring;
                $PortNew->id_lacp_port = $port_old->id_lacp_port;
                $PortNew->id_chain = $port_old->id_chain;
                $PortNew->id_odu = $port_old->id_odu;
                $PortNew->id_antena = $port_old->id_antena;
                $PortNew->save();
                if ($port_old->connected_to != null && $port_old->connected_to != '') {
                    $soci = Port::find($port_old->connected_to);
                    $soci->connected_to = $PortNew->id;
                    $soci->save();
                }
                $port_free = Port::find($valor['old']);
                $port_free->id_status = 2;
                $port_free->commentary = null;
                $port_free->connected_to = null;
                $port_free->type = null;
                $port_free->id_uplink = null;
                $port_free->id_ring = null;
                $port_free->id_lacp_port = null;
                $port_free->id_chain = null;
                $port_free->id_odu = null;
                $port_free->id_antena = null;
                $port_free->save();
            }
            return array('resul' => 'yes', 'datos' => $url);
        }
        if (!isset($request->port_new)) {
            return array('resul' => 'yes', 'datos' => $url);
        }
        return array('resul' => 'nop',);
    }

    public function relate_ls_uplink()
    {
        if (!Auth::guest() == false) return array('resul' => 'login',);
        try {
            $data = DB::table('board')
                ->Join('equipment', 'equipment.id', '=', 'board.id_equipment')
                ->where('board.id', '=', $_POST['board_id'])
                ->select('equipment.id_function', 'equipment.acronimo')->first();
            switch ($data->id_function) {
                case '1':
                    $status_valida = 7;
                    break;
                case '2':
                    $status_valida = 8;
                    break;
                case '3':
                    $status_valida = 9;
                    break;
                case '4':
                    $status_valida = 13;
                    break;
                case '5':
                    $status_valida = 19;
                    break;
                case '6':
                    $status_valida = 20;
                    break;
                case '7':
                    $status_valida = 23;
                    break;
            }
            $authori_status = User::authorization_status($status_valida);
            if ($authori_status['permi'] < 3) return ['resul' => 'autori'];

            $ls_port_id = Port::get_id($_POST['board_id'], $_POST['port_n']);
            $ls_port = Port::find($ls_port_id);
            $ls_port->id_status = 1;
            $ls_port->type = 'UPLINK';
            $ls_port->save();

            $lacp_port = ControllerService_Port::id_lacp($ls_port_id);
            $uplink = Link::where('id', $_POST['uplink_id'])->first();
            $uplink->id_extreme_2 = $lacp_port;
            $uplink->save();

            ControllerUser_history::store("Relaciono equipo ls $data->acronimo con uplink $uplink->name");
            return ['resul' => 'yes', 'datos' => $uplink->id];
        } catch (Exception $e) {
            return ['resul' => 'nop', 'datos' => $e->getMessage()];
        }
    }

    public function index_zone()
    {
        if (!Auth::guest() == false) return ['resul' => 'login'];
        $authori_status = User::authorization_status(7);
        if ($authori_status['permi'] < 3) return ['resul' => 'autori'];
        try {
            $zones = DB::table('list_key_value')
                ->select('value', 'description')
                ->where('key_name', 'id_zone')
                ->get();
            return ['resul' => 'yes', 'datos' => $zones];
        } catch (Exception $e) {
            return ['resul' => 'nop', 'datos' => $e->getMessage()];
        }
    }

    public function pe_by_zone($zone_id, $eq_type)
    {
        if (!Auth::guest() == false) return redirect('login')->withErrors([Lang::get('validation.login')]);
        $authori_status = User::authorization_status(7);
        if ($authori_status['permi'] < 3) return redirect('home')->withErrors([Lang::get('validation.authori_status')]);
        try {
            $equipment = DB::table('equipment')
                //->leftJoin('node', 'node.id', '=', 'equipment.id_node')
                ->leftJoin('ip', 'equipment.id', '=', 'ip.id_equipment')
                ->where('equipment.id_function', '=', $eq_type)
                ->where('equipment.id_zone', '=', $zone_id)
                ->select('equipment.id', 'equipment.acronimo', 'ip.ip', 'equipment.status', 'equipment.commentary')
                ->get();
            return datatables()->of($equipment)->make(true);
        } catch (Exception $e) {
            redirect('home')->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function index_sar()
    {
        if (!Auth::guest() == false) {
            return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(27); // Corroborar si es el mismo id de aplicacion en todas las bases
        if ($authori_status['permi'] >= 3) {
            $status = List_Status_IP::all(['id', 'name'])->where('id', '!=', 4);
            $pais = List_Countries::all(['id', 'name'])->sortBy('name');
            $status_port = DB::table("status_port")->select('id', 'name')->where('id', '>', 2)->orderBy('name', 'asc')->get();
            $functi = Function_Equipment_Model::all(['id', 'name'])->sortBy('name');
            $zones = DB::table('list_key_value')->select('value', 'description')->where('key_name', 'id_zone')->get();
            foreach ($zones as $z) $z->description = str_replace('Zona: ', '', $z->description);
            return view('admin_sar.list', compact('authori_status', 'pais', 'status', 'status_port', 'functi', 'zones'));
        } else {
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function store_update_sar(RequestRegister_SAR $request)
    {
        if (!Auth::guest() == false) {
            return array('resul' => 'login',);
        }
        $autori_status = User::authorization_status(27);
        if ($autori_status['permi'] >= 5) {
            //dd($request);
            $id = $request->id;
            $name = strtoupper($request->name);
            $valor = $request->port;
            $ip = $request->ip_admin;
            $acro = ControllerEquipment::validation_acronimo($id, $name);
            if ($acro == 'Si') {
                return array('resul' => 'acronimo_exi',);
            }
            $ip_valida = ControllerEquipment::validation_ip($ip, $id);
            if ($ip_valida != 'Si') {
                return array('resul' => 'ip_exi',);
            }
            if ($id != 0 && $id != '') {
                $msj_equip = 'Modifico el SAR: ';
                $alta_equi = Equipment::find($id);
            } else {
                if ($autori_status['permi'] >= 10) {
                    $msj_equip = 'Registro el SAR: ';
                    $alta_equi = new Equipment();
                    $alta_equi->id_function = 8;
                    $alta_equi->id_model = $request->equipo;
                    $alta_equi->client_management = 'No';
                } else {
                    return array('resul' => 'autori',);
                }
            }
            $alta_equi->acronimo = $name;
            $alta_equi->location = $request->local;
            $alta_equi->id_node = $request->nodo;
            $alta_equi->ir_os_up = $request->alta;
            $alta_equi->commentary = $request->commen;
            $alta_equi->id_zone = $request->id_zone;
            $alta_equi->save();
            ControllerUser_history::store($msj_equip . $name);
            ControllerEquipment::store_update_ip_port_equipment($id, $alta_equi->id, $valor, $ip, $name);
            return array('resul' => 'yes',);
        } else {
            return array('resul' => 'autori',);
        }
    }
}
