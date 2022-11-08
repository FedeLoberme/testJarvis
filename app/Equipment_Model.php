<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;
class Equipment_Model extends Model
{
	protected $table = 'equipment_model';
    protected $fillable = ['id_equipment', 'id_mark', 'model', 'cod_sap', 'status', 'description', 'bw_max_hw', 'bw_bas_lic', 'id_electrical_power', 'dual_stack', 'id_band', 'id_radio', 'multivrf', 'module_slots', 'bw_encriptado', 'full_table', 'img_url'
    ];

    public static function List()
    {
    	$status 		= array(
					  	'Activo' => 'Activo',
					  	'Descontinuado' => 'Descontinuado',
					  	'Obsoleto' => 'Obsoleto',
					  	);

        $status_funtion = array(
                        'Activo' => 'Activo',
                        'Inhabilitado' => 'Inhabilitado',
                        );       

        $elemento        = array(
                        '0' => 'Ninguno',
                        '1' => '1 Elemento',
                        '2' => '2 Elementos',
                        '3' => '3 Elementos',
                        '4' => '4 Elementos',
                        );
        
        $letra        = array(
                        'F' => 'F',
                        'S' => 'S',
                        'R' => 'R',
                        'P' => 'P',
                        );

    	$confir 		= array(
					  	'Si' => 'Si',
					  	'No' => 'No',
					  	);

    	$type_placa		= array(
					  	'ONBOARD' => 'ONBOARD',
					  	'PLACA' => 'PLACA',
					  	);

    	$bw 			= array(
                        '1'         => 'Kbps',
					  	'1024'      => 'Mbps',
					  	'1048576'   => 'Gbps',
					  	);
        $separador      = array(
                        '-' => '"-"',
                        '/' => '"/"',
                        '.' => '"."',
                        '*' => '"*"',
                        '+' => '"+"',
                        '|' => '"|"',
                        );

    	$all= array( 
    		'status' => $status,
    		'confir' => $confir,
    		'bw' => $bw,
            'letra' =>$letra,
            'elemento' => $elemento,
            'separador' => $separador,
    		'type_placa' => $type_placa,
            'status_funtion' => $status_funtion,
    	);
    	return $all;
    }

    public function relation_port_model(){
        return $this->hasMany('Jarvis\Relation_Port_Model', 'id_equipment_model', 'id');
    }

    public static function exists_inventory($t_equipo, $marca, $model, $id, $alimenta){
        if ($id <> '0') {
            $relation =DB::table('equipment_model')
            ->where('equipment_model.id_equipment', '=', $t_equipo)
            ->where('equipment_model.id_mark', '=', $marca)
            ->where('equipment_model.model', '=', $model)
            ->where('equipment_model.id_electrical_power', '=', $alimenta)
            ->where('equipment_model.id', '!=', $id)
            ->select('equipment_model.id')->get();
        }else{
            $relation =DB::table('equipment_model')
            ->where('equipment_model.id_equipment', '=', $t_equipo)
            ->where('equipment_model.id_mark', '=', $marca)
            ->where('equipment_model.id_electrical_power', '=', $alimenta)
            ->where('equipment_model.model', '=', $model)
            ->select('equipment_model.id')->get();
        }    
        return $relation;
    }

    public static function data_equipment($id){
        $relation =DB::table('equipment_model')
            ->Join('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
            ->Join('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
            ->where('equipment_model.id', '=', $id)
            ->select('equipment_model.model', 'list_mark.name as mark', 'list_equipment.name as equipment')->get();
        return $relation;
    }

    public function list_equip(){
        return $this->belongsTo('Jarvis\List_Equipment', 'id_equipment', 'id');
    }
    
}
