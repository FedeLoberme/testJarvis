<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;
class Relation_Port_Model extends Model
{
    protected $table = 'relation_port_model';
    protected $fillable = [
        'id_equipment_model',
        'id_port_equipment_model',
        'description_label',
        'status',
    ];

    public static function relation_exi($id_model, $id_port){
    	$relation =DB::table('relation_port_model')
            ->where('relation_port_model.id_equipment_model', '=', $id_model)
            ->where('relation_port_model.id_port_equipment_model','=', $id_port)
            ->select('relation_port_model.id')
            ->get()->toArray();
        return $relation;
    }

    public function equipment_model(){
        return $this->belongsTo('Jarvis\Equipment_Model', 'id_equipment_model', 'id');
    }

    public function port_equipment_model(){
        return $this->belongsTo('Jarvis\Port_Equipment_Model', 'id_port_equipment_model', 'id');
    }
}
