<?php

namespace Jarvis\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class apiAgg extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'apiAgg:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este script va correrse una vez al dia a las 09:00 (GMT-3) para actualizar la tabla ImportExcels ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::table('import_excels')->truncate(); #reinicio tabla de agg
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
            //dd($puerto->data);
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
                    if($port->sfppid != ''){
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
                        else{
                            $tipoModulo = "Modulo desconocido db";
                            $distModulo = "Modulo desconocido db";
                            $fibraModulo = "Modulo desconocido db";
                            $cortaLargaModulo = "Modulo desconocido db";
                        }
                    }
                }
                
                DB::table('IMPORT_EXCELS')->insert(
                    array('IDAGG' => $idAgg,
                          'DATE' => $last_update,
                          'IP' => $ip,
                          'HOSTNAME' => strtoupper($hostname),
                          'INTERFACE' => $interface,
                          'ANILLO' => $anillo,
                          'ADMINSTATUS' => $adminStatus,
                          'OPERSTATUS' => $poperStatus,
                          'DESCRIPCION' => $descripPuerto,
                          'NOMBREMODULO' => $nombreModulo,
                          'DESCRIPMODULO' => $descripModulo,
                          'TIPOMODULO' => $tipoModulo,
                          'DISTANCIA' => $distModulo,
                          'FIBRA' => $fibraModulo,
                          'CORTALARGA' => $cortaLargaModulo,
                          "created_at" =>  Carbon::now(), 
                          "updated_at" => Carbon::now(),)
                );
                $count++;
                }
            }
            echo("Se realizaron ".$count." registros con exito!");
    }
}
