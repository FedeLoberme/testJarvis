<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;
class Equipment extends Model
{
   	protected $table = 'equipment';
    protected $fillable = ['id_model', 'id_function', 'id_client', 'id_node', 'acronimo', 'client_management', 'ip_wan_rpv', 'address', 'service', 'id_ne', 'ir_os_up', 'ir_os_down', 'commentary', 'status', 'location', 'type', 'ne_id', 'id_zone'
	];

	public static function detalle_equipo($functi){
		$equipo =DB::table('equipment_model')
		->join('relation_model_function', 'relation_model_function.id_equipment_model', '=', 'equipment_model.id')
		->join('function_equipment_model', 'relation_model_function.id_function_equipment_model', '=', 'function_equipment_model.id')
		->Join('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
        ->Join('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
		->where('relation_model_function.id_function_equipment_model', '=', $functi)
		->where('relation_model_function.status', '=', 'Activo')
		->where('equipment_model.status', '!=', 'Obsoleto')
        ->select('equipment_model.id', 'list_mark.name as mark', 'list_equipment.name as equipment', 'equipment_model.model', 'equipment_model.status', 'equipment_model.description', 'function_equipment_model.id as function')->orderBy('model', 'asc')->get();
        return $equipo;	
	}
}