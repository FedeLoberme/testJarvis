<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Function_Equipment_Model extends Model
{
    protected $table = 'function_equipment_model';
    protected $fillable = [
        'name',
    ];
}
