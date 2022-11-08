<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class List_Connector extends Model
{
    protected $table = 'list_connector';
    protected $fillable = ['name',];
}
