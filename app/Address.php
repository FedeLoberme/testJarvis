<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    protected $fillable = ['id_provinces', 'location', 'street', 'height', 'floor', 'department', 'postal_code',];
}
