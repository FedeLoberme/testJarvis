<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Jarvis\Constants;
use Jarvis\Equipment_Model;
use Jarvis\Equipment;
use Jarvis\Client;
use Jarvis\User;
use Jarvis\placa;
use Jarvis\Nodo;
use Jarvis\Function_Equipment_Model;
use Jarvis\Http\Controllers\ControllerUser_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;
use Session;
class ControllerRelation_Agg_Acronimo extends Controller
{
    public function rela_acro_agg(){
    	if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(Constants::APPLICATION_TYPE_MODELO);
		if ($autori_status['permi'] >= 3){
	  		$id=$_POST['id_relati'];
		  	$acro = DB::table('agg_acronimo')
		    ->join('relation_agg_acronimo', 'relation_agg_acronimo.id_agg_acronimo', '=', 'agg_acronimo.id')
		    ->where('relation_agg_acronimo.id', '=', $id)
		    ->select('agg_acronimo.name', 'relation_agg_acronimo.id', 'relation_agg_acronimo.id_equipment', 'relation_agg_acronimo.id_agg_acronimo')->get();

		    $data = array('resul' => 'yes',
	      					'datos' => $acro,
		      			);
		    return $data;
  		}else{
      		return array('resul' => 'autori', );
      	}

    }
}
