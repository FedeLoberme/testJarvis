<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Service_Port extends Model
{
    protected $table = 'service_port';
    protected $fillable = ['id_lacp_port', 'id_service', 'vlan'];

}
