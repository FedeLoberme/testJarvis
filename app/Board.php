<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    protected $table = 'board';
    protected $fillable=[ 'id_equipment', 'id_port_model', 'slot', 'status'];
}
