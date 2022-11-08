<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Chain extends Model
{
    protected $table = 'chain';
    protected $fillable = ['name','extreme_1','extreme_2','bw','status','commentary'];
}
