<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class List_Service_Type extends Model
{
    protected $table = 'list_service_type';
    protected $fillable = ['name','require_ip','require_rank', 'require_bw', 'require_related',];
}
