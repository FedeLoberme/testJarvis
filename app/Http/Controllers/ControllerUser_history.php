<?php

namespace Jarvis\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Http\Request;
use Jarvis\Constants;
use Jarvis\user;
use Jarvis\User_history;
use Carbon\Carbon;
use DB;
class ControllerUser_history extends Controller
{
    public static function store($description){
    	if (!Auth::guest() == false){
    		return redirect('login')->withErrors([Lang::get('validation.login'),]);
    	}
		$history = new User_history();
			$history->id_user = Auth::user()->id;
			$history->description = $description;
		$history->save();
    }

    public static function index(){
    	if (!Auth::guest() == false){
    		return redirect('login')->withErrors([Lang::get('validation.login'),]);
    	}
        $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_HISTORIAL);
		return view('users.history',compact('authori_status'));
    }

    public function index_list(){
        if (!Auth::guest() == false){
           return redirect('login')->withErrors([Lang::get('validation.login'),]);
        }
        $authori_status = User::authorization_status(Constants::APPLICATION_TYPE_HISTORIAL);
        if ($authori_status['permi'] >= 10) {
            $user_history = DB::table('user_history')
            ->join('users', 'users.id', '=', 'user_history.id_user')
            ->select('user_history.created_at', 'users.name', 'users.last_name', 'user_history.description')->orderBy('user_history.created_at', 'desc');
        return datatables()->of($user_history)->make(true);
        }else{
            return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
        }
    }

    public function azar(){
    	$length = 2;
    	$patrón = '/[0-9,.-]/';
    	$razon = strtoupper("hola . . 12346");
    	$razon = preg_replace($patrón,'', $razon);
        $palabra = explode(" ", $razon);
        $razon = str_replace(' ', '', $razon);
        $con = strlen($razon);
        $fin = 0;
        $pala= 0;
        foreach ($palabra as $value) {
            if ($value <> "") {
                $real1[] = $value[0];
                $real2[] = $value[1];
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
                    $l4 = $razon[$i+1];

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
		return $resul;
	}
}
