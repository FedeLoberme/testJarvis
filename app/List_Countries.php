<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class List_Countries extends Model
{
    protected $table = 'list_countries';
    protected $fillable = ['name',];
}
