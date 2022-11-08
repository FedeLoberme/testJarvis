<?php

namespace Jarvis\Http\Controllers;

use Illuminate\Http\Request;
use Jarvis\Http\Controllers\ControllerUser_history;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Jarvis\Http\Controllers\ControllerLedzite;
use Carbon\Carbon;
use Jarvis\User;
use Session;
use DB;
use Jarvis\Ledzite;

class ControllerLedzite extends Controller
{
    public function index(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(31);
		if ($authori_status['permi'] >= 3) {
			return view('nodeledzite.list',compact('authori_status'));
		}else{
			return redirect('home')
        ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}

	public function index_list(){
		if (!Auth::guest() == false){ 
      	   return redirect('login')->withErrors([Lang::get('validation.login'),]);
		}
		$authori_status = User::authorization_status(31);
		if ($authori_status['permi'] >= 3) {
			$data = [];
			$count = 0;
			$info = Ledzite::all();
			foreach ($info as $value) {
					$bw = ControllerEquipment_Model::format_bw($value->bw);
					$data[] = array(
						'cell_id' => $value->cell_id, 
						'node' => $value->node, 
						'type' => $value->type, 
						'status' => $value->status, 
						//'address' => $value->address, 
						'contract_date' => $value->contract_date, 
						'owner' => $value->owner,
						'commentary' => $value->commentary, 
						//'id_uplink' => $value->id_uplink,
						'sit_codigo' => $value->sit_codigo,
						'clu_codigo' => $value->clu_codigo,
						'geo_id' => $value->geo_id,
						'alm_codigo' => $value->alm_codigo,
						'sit_nombre' => $value->sit_nombre,
						'sit_latitud' => $value->sit_latitud,
						'sit_longitud' => $value->sit_longitud,
						'sit_calle' => $value->sit_calle,
						'sit_numero' => $value->sit_numero,
						'sit_address' => $value->sit_address,
						'sit_hsnm' => $value->sit_hsnm,
						'sit_prefijo_telco' => $value->sit_prefijo_telco,
						'sit_prefijo_cti' => $value->sit_prefijo_cti,
						'sit_area_explotacion' => $value->sit_area_explotacion,
						'sit_common_bcch' => $value->sit_common_bcch,
						'sit_observaciones' => $value->sit_observaciones,
						'sit_coubicacion' => $value->sit_coubicacion,
						'tsi_codigo' => $value->tsi_codigo,
						'sit_gsm' => $value->sit_gsm,
						'sit_umts' => $value->sit_umts,
						'sit_id_fija' => $value->sit_id_fija,
						'lcc_id' => $value->lcc_id,
						'pro_id' => $value->pro_id,
						'sit_ns_activo' => $value->sit_ns_activo,
						'sit_ns_integrado' => $value->sit_ns_integrado,
						'sit_ns_tipo_celda' => $value->sit_ns_tipo_celda,
						'sit_ns_ci' => $value->sit_ns_ci,
						'ccn_id' => $value->ccn_id,
						'sit_ns_clasificacion' => $value->sit_ns_clasificacion,
						'sit_ns_creacion' => $value->sit_ns_creacion,
						'sit_ns_actualizacion' => $value->sit_ns_actualizacion,
						'locl_codigo' => $value->locl_codigo,
						'sit_estado' => $value->sit_estado,
						'sit_fecha_carga' => $value->sit_fecha_carga,
						'sit_owner' => $value->sit_owner,
						'sit_fecha_vencimiento' => $value->sit_fecha_vencimiento,
						'sit_tipo_estructura' => $value->sit_tipo_estructura,
						'sit_lte' => $value->sit_lte,
						'sit_factor_fo' => $value->sit_factor_fo,
						'opr_id' => $value->opr_id,
						'te_id' => $value->te_id,
						'sit_te_altura' => $value->sit_te_altura,
						'sit_te_camuflaje' => $value->sit_te_camuflaje,
						'sit_te_compartible' => $value->sit_te_compartible,
						'sit_fecha_baja' => $value->sit_fecha_baja,
						'tipos_soluciones' => $value->tipos_soluciones,
						'sit_fecha_alta' => $value->sit_fecha_alta,
						'sit_granja' => $value->sit_granja,
						'sit_estado_aux' => $value->sit_estado_aux,
						'sit_distribucion_sm_3g' => $value->sit_distribucion_sm_3g,
						'sit_vip' => $value->sit_vip,
						'loc_area_codigo' => $value->loc_area_codigo,
						'sit_distribucion_sm_4g' => $value->sit_distribucion_sm_4g,
						'sit_distribucion_sm_2g' => $value->sit_distribucion_sm_2g,
						'altura_estructura' => $value->altura_estructura,
						'datos_enlace_tx_id' => $value->datos_enlace_tx_id,
						'sit_ubicacion_tec_movil' => $value->sit_ubicacion_tec_movil,
						'sit_ubicacion_tec_fija' => $value->sit_ubicacion_tec_fija,
						'sit_ubicacion_tec_inmueble' => $value->sit_ubicacion_tec_inmueble,
						'sit_coubicacion_otros_claro' => $value->sit_coubicacion_otros_claro,
						'sit_paga_tasa_recurrente' => $value->sit_paga_tasa_recurrente,
						'sit_fecha_alta_municipio' => $value->sit_fecha_alta_municipio,
						'sit_alquilado' => $value->sit_alquilado,
						'ord_judicializada_hab' => $value->ord_judicializada_hab,
						'ord_judicializada_tasas' => $value->ord_judicializada_tasas,
						// 'aud_fecha_ins' => $value->aud_fecha_ins,
						// 'aud_fecha_upd' => $value->aud_fecha_upd,
						// 'aud_usr_ins' => $value->aud_usr_ins,
						// 'aud_usr_upd' => $value->aud_usr_upd,
						'sit_ran_sharing' => $value->sit_ran_sharing,
						'sit_ran_sharing_proveedor' => $value->sit_ran_sharing_proveedor,
						'sit_roaming' => $value->sit_roaming,
						'sit_roaming_proveedor' => $value->sit_roaming_proveedor,
						'sit_propietario' => $value->sit_propietario,
						'sit_codigo_anterior' => $value->sit_codigo_anterior,
						'sit_fronterizo' => $value->sit_fronterizo,
	
					);
			}
      		return datatables()->of($data)->make(true);
    	}else{
			return redirect('home')
                ->withErrors([Lang::get('validation.authori_status'),]);
		}
	}
}
