<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Agg_Association extends Model
{
    protected $table = 'agg_association';
    protected $fillable = ['id_agg', 'prefijo_agg', 'id_home_zone', 'id_home_pe', 'id_home_pei', 'id_multihome_zone', 'id_multihome_pe', 'id_multihome_pei'];
}
