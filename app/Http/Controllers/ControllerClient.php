<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Client;
use Jarvis\Constants;
use Jarvis\Ring;
use Jarvis\User;
use Jarvis\User_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Jarvis\Http\Requests\RequestClient;
use Jarvis\Http\Controllers\ControllerIP;
use DB;
use Carbon\Carbon;
class ControllerClient extends Controller
{
    // -----------------Funcion para listar cliente---------------------------
	public function index(){
		if (!Auth::guest() == false){
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
		if ($authori_status['permi'] >= 3) {
			return view('client.list',compact('authori_status'));
		}else{
			return redirect('home')
        ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}
	public function index_list(){
		if (!Auth::guest() == false){
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
		if ($authori_status['permi'] >= 3) {
			$client= Client::all(['id', 'cuit', 'acronimo', 'business_name'])->sortBy('cuit');
      return datatables()->of($client)->make(true);
    }else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

  // -----------------Funcion para registrar cliente---------------------------
	public function store(RequestClient $request){
		if (!Auth::guest() == false){ return array('resul' => 'login');}
		$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
		if ($authori_status['permi'] >= 10) {
			$Client = new Client();
			    $Client->cuit = $request->input('cuit');
			    $Client->acronimo = strtoupper($request->input('acronimo'));
			    $Client->business_name = strtoupper($request->input('name'));
	    $Client->save();
	    	ControllerUser_history::store('Registro al cliente '.$request->input('name'). ' acronimo '. $request->input('acronimo'));
          $mostrar = array(
            'id' =>$Client->id ,
            'acronimo' => $Client->acronimo,
            'razon' =>$Client->business_name , );

      $Datos = array('resul' => 'yes', 'dato' =>  $mostrar);
      return $Datos;
		}else{
			return array('resul' => 'autori');
		}
	}

	// -----------------Funcion para buscar cliente---------------------------
	public function client(){
      	if (!Auth::guest() == false){ return array('resul' => 'login', ); }
		$id=$_POST['id'];
      	$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
      	if ($authori_status['permi'] >= 5) {
        	$client =Client::find($id);
        	if ($client <> null) {
        		$data = array(
        			'resul'=> 'yes',
			        'name' => $client->business_name,
			        'cuit' => $client->cuit,
			        'acronimo' => $client->acronimo,
			        'id' => $client->id,
        		);
        	}else{
        		$data = array( 'resul'=> 'no',);
        	}
        	return $data;
      	}else{
        	return array('resul' => 'home', );
      	}
  	}

  	// -----------------Funcion para modificar perfiles---------------------------
  	public function update_client(RequestClient $request){
	    if (!Auth::guest() == false){ return array('resul' => 'login',); }
	   	$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
    	if ($authori_status['permi'] >= 5) {
	      	$Client = Client::find($request->id);
            $Client->business_name = $request->name;
            $Client->cuit = $request->cuit;
	        	$Client->acronimo = strtoupper($request->acronimo);
	      	$Client->save();
			 ControllerUser_history::store('Modifico el cliente '.$Client->name. ' acronimo '. $request->acronimo);
      		$data = array('resul' => 'yes',);
            return $data;
	    }else{
	      return redirect('home')
	      	->withErrors([Lang::get('validation.authori_status'),]);
	    }
  	}

  	public function client_name(){
      	if (!Auth::guest() == false){
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
      	$authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
      	$name = $_POST['social'];
      	if ($authori_status['permi'] >= 5) {
        	$client =DB::table('client')->where('client.business_name', '=', $name)
        ->select('client.business_name', 'client.acronimo')
        ->get();
        	if (count($client) > 0) {
        		$Data = array(
        			'resul' => 'sip' ,
        			'acronimo' => $client[0]->acronimo ,
        			'name' => $client[0]->business_name ,
        		);
        	}else{
        		$Data = array(
        			'resul' => 'no' ,
        			'name' => 'Nuevo cliente' ,
        		);
        	}
        	return $Data;
      	}else{
        	return redirect('home')
        		->withErrors([Lang::get('validation.authori_status'),]);
      	}
  	}

    public function client_cuit(){
      if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
        $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
        $cuit = $_POST['cuit'];
        if ($authori_status['permi'] >= 5) {
          $client =DB::table('client')->where('client.cuit', '=', $cuit)
        ->select('client.business_name', 'client.acronimo')
        ->get();
          if (count($client) > 0) {
            $Data = array(
              'resul' => 'sip' ,
              'acronimo' => $client[0]->acronimo ,
              'name' => $client[0]->business_name ,
            );
          }else{
            $Data = array(
              'resul' => 'no' ,
              'name' => 'Nuevo CUIT' ,
            );
          }
          return $Data;
        }else{
          return redirect('home')
            ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function client_acronimo(){
      if (!Auth::guest() == false){
        return redirect('login')->withErrors([Lang::get('validation.login'),]);
      }
        $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
        $acronimo = $_POST['acronimo'];
        if ($authori_status['permi'] >= 5) {
          $client =DB::table('client')->where('client.acronimo', '=', $acronimo)
        ->select('client.business_name', 'client.acronimo')
        ->get();
          if (count($client) > 0) {
            $Data = array(
              'resul' => 'sip' ,
              'acronimo' => $client[0]->acronimo ,
              'name' => $client[0]->business_name ,
            );
          }else{
            $Data = array(
              'resul' => 'no' ,
              'name' => 'Nuevo acronimo' ,
            );
          }
          return $Data;
        }else{
          return redirect('home')
            ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

  	public function acronimo(){
  		$name = $_POST['razon'];
    	$length = 2;
    	$patrón = '/[0-9,.-]/';
    	$razon = strtoupper($name);
    	$razon = preg_replace($patrón,'', $razon);
        $palabra = explode(" ", $razon);
        $razon = str_replace(' ', '', $razon);
        $con = strlen($razon);
        $n_paabra = count($palabra);
        $fin = 0;
        $pala= 0;
        foreach ($palabra as $value) {
            if ($value <> "") {
                $real1[] = $value[0];
                if (strlen($value) > 1) {
                  $real2[] = $value[1];
                }else{
                  $real2[] = $value[0];
                }
            }
        }
        if (count($real1) > 1) {
            if (count($real1) == 2) {
                $resul= $real1[0].''.$real2[0].''.$real1[1].''.$real2[1];
            }elseif (count($real1) == 3) {
                $resul= $real1[0].''.$real2[0].''.$real1[1].''.$real1[2];
            }elseif (count($real1) == 4) {
                $resul= $real1[0].''.$real1[1].''.$real1[2].''.$real1[3];
            }elseif (count($real1) >= 5) {
                $resul= $real1[0].''.$real1[1].''.$real1[3].''.$real1[4];
            }
            $client=DB::table('client')->select('id')->where('acronimo', '=', $resul)->get();
            if (count($client) <> 0) {
                 $pala = 1;
             }
        }else{
            $pala = 1;
        }
        if ($pala <> 0) {
        	$l1 = $razon[0];
        	$l2 = $razon[1];
            if ($con > 4) {
                for ($i=2; $i <= $con ; $i++) {
                    $l3 = $razon[$i];
                    if ($i == $con) {
                      $letra_otra =  $i+1;
                    }else{
                      $letra_otra = $i;
                    }
                    $l4 = $razon[$letra_otra];
                    $resul = $l1.''.$l2.''.$l3.''.$l4;
                    $client=DB::table('client')->select('id')->where('acronimo', '=', $resul)->get();
                    if (count($client) == 0) {
                        $i= $con;
                    }else{
                        if ($i == $con || $i == $con - 1) {
                            $fin =1;
                            $i= $con;
                        }
                    }
                }
            }elseif ($con == 4) {
                $l3 = $razon[2];
                $l4 = $razon[3];
                $resul = $l1.''.$l2.''.$l3.''.$l4;
                $client=DB::table('client')->select('id')->where('acronimo', '=', $resul)->get();
                    if (count($client) <> 0) {
                        $fin = 1;
                    }
            }else{
               $fin = 1;
            }

            if ($fin == 1) {
            	for ($c=0; $c <=1 ; $c++) {
        	    	$azar = substr(str_shuffle($razon), 0, $length);
        	    	$resul = $l1.''.$l2.''.$azar;
        	    	$client=DB::table('client')->select('id')->where('acronimo', '=', $resul)->get();
        	    	if (count($client) <> 0) {
        	    		$c=0;
        	    	}
            	}
            }
        }
       $acronimo = array('acronimo' => $resul, );
		return $acronimo;
	}

  public function data_client(RequestClient $request){
    $cuit = $request->input('cuit');
    $acronimo = strtoupper($request->input('acronimo'));
    $name = strtoupper($request->input('name'));
    $id = $request->input('id');
    if ($id <> 0) {
      $data1 =DB::table('client') ->where('client.cuit', '=', $cuit)
                                  ->where('client.business_name', '=', $name)
                                  ->where('client.id', '!=', $id)
                                  ->select('*')->get();
    }else{
      $data1 =DB::table('client') ->where('client.cuit', '=', $cuit)
                                ->where('client.business_name', '=', $name)
                                ->select('*')->get();
    }
    if (count($data1) > 0) {
          $resul = array(
                          'resul' => 1,
                          'name' => $data1[0]->business_name,
                          'cuit' => $data1[0]->cuit,
                        );
    }else{
      if ($id <> 0) {
        $data2 =DB::table('client') ->where('client.business_name', '=', $name)
                                    ->where('client.id', '!=', $id)
                                    ->select('*')->get();

        $data3 =DB::table('client') ->where('client.cuit', '=', $cuit)
                                    ->where('client.id', '!=', $id)
                                    ->select('*')->get();

        $data4 =DB::table('client') ->where('client.acronimo', '=', $acronimo)
                                    ->where('client.id', '!=', $id)
                                    ->select('*')->get();
      }else{
        $data2 =DB::table('client') ->where('client.business_name', '=', $name)
                                    ->select('*')->get();

        $data3 =DB::table('client') ->where('client.cuit', '=', $cuit)
                                    ->select('*')->get();

        $data4 =DB::table('client') ->where('client.acronimo', '=', $acronimo)
                                    ->select('*')->get();
      }
      if (count($data2) > 0 && count($data3) > 0) {
          $business_name = array(
                          'name' => $data2[0]->business_name,
                          'cuit' => $data2[0]->cuit,
                        );
           $cuit_sql = array(
                          'name' => $data3[0]->business_name,
                          'cuit' => $data3[0]->cuit,
                        );
           $resul = array(
                          'resul' => 7,
                          'razon' => $business_name,
                          'cuit_sql' => $cuit_sql,
                        );
      }else{
        if (count($data2) > 0 && count($data4) > 0) {
          $business_name = array(
                          'name' => $data2[0]->business_name,
                          'cuit' => $data2[0]->cuit,
                        );
           $acronimo_sql = array(
                            'name' => $data4[0]->business_name,
                            'cuit' => $data4[0]->cuit,
                            'acronimo' => $data4[0]->acronimo,
                          );
           $resul = array(
                          'resul' => 5,
                          'razon' => $business_name,
                          'acronimo' => $acronimo_sql,
                        );
        }else{
          if (count($data3) > 0 && count($data4) > 0) {
             $cuit_sql = array(
                          'name' => $data3[0]->business_name,
                          'cuit' => $data3[0]->cuit,
                        );
           $acronimo_sql = array(
                            'name' => $data4[0]->business_name,
                            'cuit' => $data4[0]->cuit,
                            'acronimo' => $data4[0]->acronimo,
                          );
           $resul = array(
                          'resul' => 6,
                          'cuit_sql' => $cuit_sql,
                          'acronimo' => $acronimo_sql,
                        );
          }else{
        if (count($data2) > 0) {
          $resul = array(
                          'resul' => 2,
                          'name' => $data2[0]->business_name,
                          'cuit' => $data2[0]->cuit,
                        );
        }else{
          if (count($data3) > 0) {
            $resul = array(
                            'resul' => 3,
                            'name' => $data3[0]->business_name,
                            'cuit' => $data3[0]->cuit,
                          );
          }else{
            if (count($data4) > 0) {
              $resul = array(
                            'resul' => 0,
                            'name' => $data4[0]->business_name,
                            'cuit' => $data4[0]->cuit,
                          );
            }else{
              $resul = array('resul' => 4,);
            }
          }

        }
      }
    }
      }
    }
    return $resul;
  }

  public function acronimo_equipo(){
    if (!Auth::guest() == false){ return array('resul' => 'login', );}
    $autori_status = User::authorization_status(8);
    if ($autori_status['permi'] >= 5){
      $id = $_POST['id'];
      $data4 =DB::table('client')->where('client.id','=',$id)->select('client.acronimo')->get();
      $acronimo = $data4[0]->acronimo;
      $canti = DB::table('equipment')->where('equipment.id_client', '=', $id)
      ->select(\DB::raw('count(equipment.id_client) as cantidad'))->get();
      if ($canti[0]->cantidad == 0) {
        $numer ='01';
      }else{
        $numer =$canti[0]->cantidad;
      }
      for ($h=0; $h <= 2 ; $h++) {
        $numeros = '01';
         if ($numer >= 99) {
          $numeros = $numeros + 1;
          $numer = 01;
        }
        if (strlen($numer) < 2) {
          $numer = '0'.$numer;
        }
        if (strlen($numeros) < 2) {
          $numeros = '0'.$numeros;
        }
        $acro_equipo = $acronimo.''.$numeros.'RT'. $numer;
        $resulta = DB::table('equipment')->where('equipment.acronimo', '=', $acro_equipo)
        ->select('equipment.id')->get();
        if ($numer == 99) {
          $numeros = $numeros + 1;
          $numer = 01;
        }
        if (count($resulta) > 0) {
          $h = 0;
          $numer = $numer + 1;
        }else{
          $h = 2;
        }

      }
      $data = array('resul' => 'yes','acronimo' => $acro_equipo,);
    }else{
      $data = array('resul' => 'autori', );
    }
    return $data;
  }

  public function acronimo_lanswitch(){
    if (!Auth::guest() == false){ return array('resul' => 'login', ); }
    $id = $_POST['id'];
    $anillo = $_POST['anillo'];
    $client = $_POST['client'];
    $info_client = Client::find($client);
    if ($info_client->acronimo == null || $info_client->acronimo == '') {
      return array( 'resul' => 'nop');
    }
    $info_anillo = Ring::find($anillo);
    $name_anillo = explode('-', $info_anillo->name);
    $name_acro = preg_replace('/[_]/','', $name_anillo[1]);
      for ($i=1; $i <=100 ; $i++) {
        $acronimo = $info_client->acronimo.$i.$name_acro;
        $equi_acro =DB::table('equipment')->where('equipment.acronimo', '=', $acronimo)->where('equipment.id', '!=', $id)->select('equipment.id')->get();
        if (count($equi_acro) == 0) {
          $i = 100;
        }
      }
    return array( 'resul' => 'yes', 'acronimo' => $acronimo,);
  }

  public static function client_selec(){
    if (!Auth::guest() == false){ return array('resul' => 'login', ); }
    $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_CLIENTES);
    if ($authori_status['permi'] >= 3) {
      $id = $_POST['id'];
      $Client = Client::find($id, ['cuit', 'acronimo', 'business_name']);
      if ($Client != null) {
        $datos = $Client->acronimo.' '.$Client->cuit.' '.$Client->business_name;
        $resul = array('resul' => 'yes', 'datos' => $datos,);
      }else{
        $resul = array('resul' => 'nop', );
      }
      return $resul;
    }else{
       return array('resul' => 'autori',);
    }
  }

  public function list_ip_client_all($data){
    if (!Auth::guest() == false){
      return redirect('login')->withErrors([Lang::get('validation.login'),]);
    }
    $all = [];
    $slq_id = DB::table('ip')->where('ip.id_client', '=', $data)->select('id')->get();
    foreach ($slq_id as $valor) {
      $id_full[] = $valor->id;
    }
    if (count($slq_id) > 0) {
      $all = ControllerIP::info_ip_filtro($id_full);
    }
    return datatables()->of($all)->make(true);
  }
}
