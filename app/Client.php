<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';
    protected $fillable = ['cuit', 'acronimo','business_name',];
}
