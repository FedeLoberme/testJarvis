<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class List_Label extends Model
{
    protected $table = 'list_label';
    protected $fillable = ['name',];
}
