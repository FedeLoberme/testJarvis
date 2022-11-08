<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class List_Use_Vlan extends Model
{
    protected $table = 'list_use_vlan';
    protected $fillable = ['name','subred','behavior'];
}
