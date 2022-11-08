<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use DB;
class Ring extends Model
{
    protected $table = 'ring';
    protected $fillable = ['name', 'status', 'type', 'dedicated', 'commentary', 'bw_limit', 'type_ring'];
}
