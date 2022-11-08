<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;
class Relation_Agg_Acronimo extends Model
{
    protected $table = 'relation_agg_acronimo';
    protected $fillable = [ 'id_equipment','id_agg_acronimo','status'];

    public static function relation_acronimo($equip, $acroni){
    	$resul = DB::table('relation_agg_acronimo')
		    ->where('relation_agg_acronimo.id_equipment', '=', $equip)
		    ->where('relation_agg_acronimo.id_agg_acronimo', '=', $acroni)
		    ->select('relation_agg_acronimo.id')->get();
		return $resul;
    }

    public static function relation_acronimo_exis($acroni){
    	$resul = DB::table('relation_agg_acronimo')
    		->join('agg_acronimo', 'relation_agg_acronimo.id_agg_acronimo','=', 'agg_acronimo.id')
		    ->where('agg_acronimo.name', '=', $acroni)
		    ->select('relation_agg_acronimo.id')->get();
		return $resul;
    }
}
