<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Uplink extends Model
{
    protected $table = 'uplink';
    protected $fillable=[ 'name', 'id_node', 'bw_maximum', 'sar_equipment', 'sar_ip', 'sar_port', 'mt', 'ct', 'vlan'];
}