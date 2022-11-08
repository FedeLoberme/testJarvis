<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class List_Provinces extends Model
{
    protected $table = 'list_provinces';
    protected $fillable = ['name', 'id_countries'];
}
