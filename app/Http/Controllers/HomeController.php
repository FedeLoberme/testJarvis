<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Jarvis\Reserve;
use Jarvis\Port;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Jarvis\Http\Controllers\ControllerPort;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data[0]= DB::table('service')->count();//Servicios
        $data[1]= DB::table('client')->count(); //Clientes
        $data[2]= DB::table('node')->count(); //Nodos
        $data[3]= DB::table('equipment')->where('equipment.id_function', '=',2)->count(); //Router
        $data[4]= DB::table('equipment')->where('equipment.id_function', '=',4)->count(); //Lanswitch
        $data[5]= DB::table('import_st_excels')->count(); //Mercancia

        $data[6]= 0; //Conteo de reservas
        $data[7]= 0; //Cantidad usuarios
        $data[8]= 0; //Cantidad puertos tengiga
        $data[9]= 0; //Cantidad puertos giga

        $data_port = DB::table('list_agg_port')->get();
        $ports_info = array(
            "giga" => [
                "saturado" => 0,
                "critico" => 0,
                "analisis" => 0,
                "ok" => 0,
            ],
            "tengiga" => [
                "saturado" => 0,
                "critico" => 0,
                "analisis" => 0,
                "ok" => 0
            ],
        );
        foreach($data_port as $port_agg){
            if($port_agg->tipo_puerto == 'TENGIGABITETHERNET' || $port_agg->tipo_puerto == 'TENGIGE'){
                $data[8]++;
            } else{
                $data[9]++;
            }

            switch($port_agg->nivel){
                case 'Saturado':
                    if($port_agg->tipo_puerto == 'TENGIGABITETHERNET' || $port_agg->tipo_puerto == 'TENGIGE'){
                        $ports_info['tengiga']['saturado']++;
                    } else{
                        $ports_info['giga']['saturado']++;
                    }
                break;
                case 'Critico':
                    if($port_agg->tipo_puerto == 'TENGIGABITETHERNET' || $port_agg->tipo_puerto == 'TENGIGE'){
                        $ports_info['tengiga']['critico']++;
                    } else{
                        $ports_info['giga']['critico']++;

                    }
                break;
                case 'Analisis':
                    if($port_agg->tipo_puerto == 'TENGIGABITETHERNET' || $port_agg->tipo_puerto == 'TENGIGE'){
                        $ports_info['tengiga']['analisis']++;
                    } else{
                        $ports_info['giga']['analisis']++;
                    }
                break;
                case 'ok':
                    if($port_agg->tipo_puerto == 'TENGIGABITETHERNET' || $port_agg->tipo_puerto == 'TENGIGE'){
                        $ports_info['tengiga']['ok']++;
                    } else{
                        $ports_info['giga']['ok']++;
                    }
                break;
            }
        }
        switch (true) {
            case $data[8] > 10:
                $color_ports[0]=['red-bg'];
            break;
            case ($data[8] >= 5 && $data[8] <= 10):
                $color_ports[0]=['yellow-bg'];
            break;
            case($data[8] < 5):
                $color_ports[0]=['navy-bg'];
            break;
        }
        switch(true){
            case $data[9] > 10:
                $color_ports[1]=['red-bg'];
            break;
            case ($data[9] >= 5 && $data[9] <= 10):
                $color_ports[1]=['yellow-bg'];
            break;
            case($data[9] < 5):
                $color_ports[1]=['navy-bg'];
            break;
        }
        

        $reserves = DB::table('reserves')->where('status','=', 'VIGENTE')->get();
        foreach ($reserves as $value) {
            $now = Carbon::now();
            $expires_day = Carbon::parse($value->created_at)->addDays($value->quantity_dates);
            $diff = $now->diffInDays($expires_day);
            if($diff<30){
                $data[6]++;
            }
            if($expires_day->isPast()){
                $reserve = Reserve::find($value->id);
                    $reserve->status = 'VENCIDO';
                    $reserve->save();
            }
        }
        $data[7] = DB::table('users')->count();
        return view('home')->with('data',$data)->with('color_ports',$color_ports)->with('ports_info', $ports_info);
    }

    public function api_request(){
            DB::table('import_excels')->delete();
            $data = [];
            $client = new Client(["verify" => false]);
            try{
                $response = $client->get('https://matef.claro.amx/mat/api/v2/inventory/resource/aggsinventory',
                array(
                    'headers' => array(
                        'apikey' => 'nKPu2v2R60IrZqtiVxT3b9HPJ9h407pE',
                        )
                    )
                );
                echo '<pre>';
                $data = (json_decode( $response->getBody()->getContents() ));

            } catch (RequestException $e){
                echo '<pre>';
                dd($e->getMessage());
            }

            function interfaceClean($e){
                #Funcion para limpiar la interface y ponerle el 'gigabit' o 'tengiga' al inicio!
                $palabra = "";
                $tercero=substr($e, 2,1);
                $array = explode($tercero, $e, 2); #El 2 es para que solo saque el primer 0 dentro del xplode
                if($array[0] == "Gi"){
                    $palabra = "GigabitEthernet";
                } else {
                    $palabra = "TenGigabitEthernet";
                }
                $puerto = $tercero.$array[1];

                $interface = $palabra.$puerto;
                return $interface;
            }

            function puertoClean($puerto){
                $puertoFormat = "";
                preg_match_all('!\d+!', $puerto, $matches);
                if(count($matches)>0){
                    $puerto = $matches[0];
                    $puertoConver = implode("/",$puerto);
                    echo $puertoConver;
                }
                return $puertoFormat;
            }

            function anillo($e){
                $array = explode(' ',trim($e));
                if ($array[0] == "ANILLO"){
                    /*$cadena = "";
                    for ($i=1; $i < count($array) ; $i++) { 
                for ($i=1; $i < count($array) ; $i++) { 
                    for ($i=1; $i < count($array) ; $i++) { 
                        $cadena = $cadena." ".$array[$i];
                    }*/
                    
                    $patron = '/[Mm][Ee][-_][a-zA-Z0-9]{3,6}[-_][0-9]{4}/i';
                    preg_match_all($patron, $e, $matches, PREG_OFFSET_CAPTURE);
                    //dd($e, $cadena, $coincidencia, $array[$coincidencia]);
                    if(isset($matches[0][0][0])){
                        return $matches[0][0][0];
                    }else{
                        return "N/D";
                    }
                } else{
                    return "N/D";
                }
            }
            function adminOper($e){
                if($e == "SHUTDOWN"){
                    return "DOWN";
                } else{
                    return $e;
                }
            }
            $count = 0;
            foreach ($data as $port)
            {
                //dd($port->data);
                
                $portinfogrid =  $port->data->portInfoGrid;
                $ip = $port->data->managementAddress;
                $hostname = $port->data->hostname->data->hostname;
                $last_update = $port->data->lastUpdate;

                foreach($portinfogrid as $port){
                    $interface = strtoupper($port->portname); #Pasar todo a mayusq
                    $idAgg = strtoupper($hostname.'/'.$interface); #Pasar todo a mayusq
                    $adminStatus = adminOper($port->portadmin);
                    $poperStatus = adminOper($port->portoper);
                    $descripPuerto = $port->portdesc;
                    $anillo = anillo($descripPuerto);
                    $nombreModulo = "N/D";
                    $descripModulo = "N/D";
                    $tipoModulo = "N/D";
                    $distModulo = "N/D";
                    $fibraModulo = "N/D";
                    $cortaLargaModulo = "N/D";

                    if(isset($port->sfppid) && isset($port->sfpsnum)){
                        $nombreModulo = $port->sfppid;
                        $descripModulo = $port->sfpsnum;
                        
                        $moduleExist = DB::table('module')
                                        ->where('module.nombre_modulo', '=', $nombreModulo)
                                        ->exists();
                        if($moduleExist){
                            $module = DB::table('module')
                                    ->where('module.nombre_modulo','=', $nombreModulo)
                                    ->select('module.tipo_modulo', 'module.distancia','module.fibra', 'module.corta_larga')
                                    ->get();
                            
                            $tipoModulo = $module[0]->tipo_modulo;
                            $distModulo = $module[0]->distancia;
                            $fibraModulo = $module[0]->fibra;
                            $cortaLargaModulo = $module[0]->corta_larga;
                        }
                    }
                    echo("IP: " . $ip);
                    echo("<br>");
                    echo("idAgg: " . $idAgg);
                    echo("<br>");
                    echo("Hostname: " . $hostname);
                    echo("<br>");
                    echo("Date: " . $last_update);
                    echo("<br>");
                    echo("interface: " . $interface);
                    echo("<br>");
                    echo("anillo: " . $anillo);
                    echo("<br>");
                    echo("AdminStatus: " . $adminStatus);
                    echo("<br>");
                    echo("PoperStatus: " . $poperStatus);
                    echo("<br>");
                    echo("Descripcion puerto: " . $descripPuerto);
                    echo("<br>");
                    echo("NombreModulo: " . $nombreModulo);
                    echo("<br>");
                    echo("DescripcionModulo: " . $descripModulo);
                    echo("<br>");
                    echo("Tipo modulo: " . $tipoModulo);
                    echo("<br>");
                    echo("Distancia: " . $distModulo);
                    echo("<br>");
                    echo("Fibra: " . $fibraModulo);
                    echo("<br>");
                    echo("Corta Larga: " . $cortaLargaModulo);
                    echo("<br>");
                    echo("<br>");
                    /*
                    DB::table('IMPORT_EXCELS')->insert(
                        array('IDAGG' => $idAgg,
                            'DATE' => $last_update,
                            'IP' => $ip,
                            'HOSTNAME' => $hostname,
                            'INTERFACE' => $interface,
                            'ADMINSTATUS' => $adminStatus,
                            'OPERSTATUS' => $poperStatus,
                            'DESCRIPCION' => $descripPuerto,
                            'NOMBREMODULO' => $nombreModulo,
                            'DESCRIPMODULO' => $descripModulo,
                            'TIPOMODULO' => $descripModulo,
                            'DISTANCIA' => $descripModulo,
                            'FIBRA' => $descripModulo,
                            'CORTALARGA' => $descripModulo,
                            "created_at" =>  Carbon::now(), 
                          "created_at" =>  Carbon::now(), 
                            "created_at" =>  Carbon::now(), 
                            "updated_at" => Carbon::now(),)
                    );
                    */
                    
                    
                    $count++;
                    }
                }
                echo("Se realizaron ".$count." registros con exito");
            }

    public function list_port_agg(){
        $type = $_POST['id']; // 0 tengiga; 1 giga
        if($type == 0){
            $type_port = ['TENGIGABITETHERNET', 'TENGIGE'];
            $size_port = 'TENGIGABITETHERNET';
        } else {
            $type_port = ['GIGABITETHERNET'];
            $size_port = 'GIGABITETHERNET';
        }
        $list_port_agg = DB::table('list_agg_port')->whereIn('list_agg_port.tipo_puerto', $type_port)->get();
        $data=[];
        
        foreach ($list_port_agg as $value) {
            $data[] = array(
                'acronimo' => $value->acronimo,
                'status' => $value->nivel,
                'rings_available' => $value->q_ocupado_anillos,
                'rings' => $value->q_anillos,
                'ports_available' => $value->q_vacante,
                'used_percentage' => $value->porcentaje_ocupado,
            );
        }
		return datatables()->of($data)->make(true);
    }
}