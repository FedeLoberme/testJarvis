<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;
class Relation_Model_Function extends Model
{
    protected $table = 'relation_model_function';
    protected $fillable = [
        'id_equipment_model',
        'id_function_equipment_model',
        'status',
    ];

    public static function function_relation($id){
      $function = DB::table('function_equipment_model')
      ->join('relation_model_function', 'relation_model_function.id_function_equipment_model', '=', 'function_equipment_model.id')
      ->where('relation_model_function.id_equipment_model', '=', $id)
      ->where('relation_model_function.status', '=', 'Activo')
      ->select('function_equipment_model.name', 'function_equipment_model.id')->get();
      return $function;
    }

    public static function relation($id_funtion, $id_equip){
      $relation = DB::table('relation_model_function')
      ->where('relation_model_function.id_equipment_model', '=', $id_equip)
      ->where('relation_model_function.id_function_equipment_model', '=', $id_funtion)
      ->select('relation_model_function.status', 'relation_model_function.id')->get();
      return $relation;
    }
}
