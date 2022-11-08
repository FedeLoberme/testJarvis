<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;
class Port_Equipment_Model extends Model
{
    protected $table = 'port_equipment_model';
    protected $fillable = [
        'quantity', 'port_f_i', 'port_f_f', 'id_list_port', 'id_connector', 'bw_max_port', 'id_label', 'port_l_i', 'port_l_f', 'id_module_board', 'type_board', 'cod_sap'
    ];

    public static function relation($id_port, $id_model){
        $relation =DB::table('port_equipment_model')
            ->Join('relation_port_model', 'port_equipment_model.id', '=', 'relation_port_model.id_port_equipment_model')
            ->Join('equipment_model', 'equipment_model.id', '=', 'relation_port_model.id_equipment_model')
            ->Join('list_equipment', 'list_equipment.id', '=', 'equipment_model.id_equipment')
            ->Join('list_mark', 'list_mark.id', '=', 'equipment_model.id_mark')
            ->where('port_equipment_model.id', '=', $id_port)
            ->where('equipment_model.id', '=', $id_model)
        ->select('relation_port_model.status', 'relation_port_model.id', 'list_equipment.name as t_equipo', 'list_mark.name as marca', 'equipment_model.model', 'relation_port_model.description_label')
            ->get();
            return $relation;
    }

    public static function exists($quantity, $port_f_i, $port_f_f, $id_list_port, $id_connector, $bw_max_port, $id_label, $port_l_i, $port_l_f, $id_module_board, $type_board, $id){
        $relation =DB::table('port_equipment_model')
            ->where('port_equipment_model.quantity', '=', $quantity)
            ->where('port_equipment_model.port_f_i', '=', $port_f_i)
            ->where('port_equipment_model.port_f_f', '=', $port_f_f)
            ->where('port_equipment_model.id_list_port', '=', $id_list_port)
            ->where('port_equipment_model.id_connector', '=', $id_connector)
            ->where('port_equipment_model.bw_max_port', '=', $bw_max_port)
            ->where('port_equipment_model.id_label', '=', $id_label)
            ->where('port_equipment_model.port_l_i', '=', $port_l_i)
            ->where('port_equipment_model.port_l_f', '=', $port_l_f)
            ->where('port_equipment_model.id_module_board', '=', $id_module_board)
            ->where('port_equipment_model.type_board', '=', $type_board)
            ->where('port_equipment_model.id', '!=', $id)
        ->select('port_equipment_model.id')
            ->get();
            return $relation;
    }

     public function relation_port_model(){
        return $this->hasMany('Jarvis\Relation_Port_Model', 'id_port_equipment_model', 'id');
    }

    public static function port(){
        $port =DB::table('port_equipment_model')
            ->Join('list_connector', 'list_connector.id', '=', 'port_equipment_model.id_connector')
            ->Join('list_module_board', 'list_module_board.id', '=', 'port_equipment_model.id_module_board')
            ->Join('list_port', 'list_port.id', '=', 'port_equipment_model.id_list_port')
            ->Join('list_label', 'list_label.id', '=', 'port_equipment_model.id_label')
        ->select( 'list_module_board.name as board', 'list_port.name as port', 'list_connector.name as connector', 'list_label.name as label', 'port_equipment_model.type_board', 'port_equipment_model.quantity', 'port_equipment_model.port_f_i', 'port_equipment_model.port_f_f', 'port_equipment_model.bw_max_port', 'port_equipment_model.port_l_i', 'port_equipment_model.port_l_f', 'port_equipment_model.id' )->get();
            return $port;
    }
}
