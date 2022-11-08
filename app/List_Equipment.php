<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class List_Equipment extends Model
{
    protected $table = 'list_equipment';
    protected $fillable = ['name',];

    public function equipment_model(){
        return $this->hasMany('Jarvis\Equipment_Model', 't_equipo', 'id');
    }
}
