<?php
namespace Jarvis\Http\Controllers;
use Illuminate\Http\Request;
use Jarvis\User;
use Jarvis\Agg_Acronimo;
use Jarvis\Relation_Agg_Acronimo;
use Jarvis\User_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use DB;
use Carbon\Carbon;
class ControllerAgg_Acronimo extends Controller
{
  	public function search_acronimo($id = null){
  		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(7);
		if ($autori_status['permi'] >= 3){
			if ($id == null) {
		  		$id=$_POST['id'];
			}
		  	$acro = DB::table('agg_acronimo')
		    ->join('relation_agg_acronimo', 'relation_agg_acronimo.id_agg_acronimo', '=', 'agg_acronimo.id')
		    ->where('relation_agg_acronimo.id_equipment', '=', $id)
		    ->select('agg_acronimo.name', 'relation_agg_acronimo.id')->get();
		    if (count($acro) > 0) {
		    	$data = array('resul' => 'yes',
	      					'datos' => $acro,
		      			);
		    }else{
		    	$data = array('resul' => 'nop',
		      			);
		    }
		    return $data;
  		}else{
      		return array('resul' => 'autori', );
      	}
  	} 

  	public function inser_update_acronimo(){
  		if (!Auth::guest() == false){ return array('resul' => 'login', );}
    	$autori_status = User::authorization_status(7);
		if ($autori_status['permi'] >= 5){
		  	$id_agg_acro=$_POST['id_agg_acro'];
		  	$acroni_new=$_POST['acroni_new'];
		  	$id_agg_edic=$_POST['id_agg_edic'];
		  	$id_rela=$_POST['id_rela'];
		$resul = Agg_Acronimo::acronimo($acroni_new);
		if (count($resul) == 0) {
			$info_dupli = Relation_Agg_Acronimo::relation_acronimo_exis($acroni_new);
		  	if ($id_agg_edic <> 0 && count($info_dupli) < 2) {
	        	$datos = Agg_Acronimo::find($id_agg_edic);
		    }else{
		        $datos = new Agg_Acronimo();
		    }
	        $datos->name = $acroni_new;
	      	$datos->save();
	      	$id = $datos->id;
	      	$resulta = 'sip';
		}else{
			$resulta = 'nop';
			$id = $resul[0]->id;
		}
		$info = Relation_Agg_Acronimo::relation_acronimo($id_agg_acro, $id);
			if (count($info) == 0) {
				if ($id_agg_edic == 0 && $id_rela == 0) {
		      	$rela = new Relation_Agg_Acronimo();
					$rela->id_equipment = $id_agg_acro;
			    }else{
			        $rela = Relation_Agg_Acronimo::find($id_rela);
			    }
					$rela->id_agg_acronimo = $id;
			    $rela->save();
			    return array('resul' => 'yes', );
			}else{
				if ($resulta =='sip') {
					return array('resul' => 'yes', );
				}else{
			    	return array('resul' => 'exis', );
				}
			}

  		}else{
      		return array('resul' => 'autori', );
      	}
  	} 
}
