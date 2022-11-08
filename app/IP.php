<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class IP extends Model
{
    protected $table = 'ip';
    protected $fillable = ['ip', 'prefixes', 'type', 'id_status', 'id_branch', 'id_equipment', 'id_client', 'id_service', 'id_use_vlan', 'assignment', 'id_equipment_wan', 'id_loopback'];

    /**
     * Toma la ip de la subnet y borra el último octeto
     */
    public static function get_group($subnet_ip) {
        $arr = explode('.', $subnet_ip);
        array_pop($arr);
        $group = implode('.', (array) $arr);
        return $group;
    }
}