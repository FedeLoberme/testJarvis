<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;
class Agg_Acronimo extends Model
{
    protected $table = 'agg_acronimo';
    protected $fillable = ['name',];


    public static function acronimo($name){
    	$acro = DB::table('agg_acronimo')->where('agg_acronimo.name', '=', $name)
		    ->select('agg_acronimo.id')->get();
		return $acro;
    }
}
