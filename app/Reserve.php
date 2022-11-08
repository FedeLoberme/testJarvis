<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    protected $table = 'reserves';
    protected $fillable = ['number_reserve','id_link','bw_reserve','status','id_user','quantity_dates','oportunity', 'commentary','id_service', 'cell_bw_reserved'];
}
