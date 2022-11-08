<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Lacp_Port extends Model
{
    protected $table = 'lacp_port';
    protected $fillable = ['lacp_number', 'commentary', 'group_lacp'];

}
