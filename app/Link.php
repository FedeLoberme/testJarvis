<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Link extends Model
{
    protected $table = 'link';
    protected $fillable = ['name','id_extreme_1','id_extreme_2','bw_all','bw_limit','id_list_type_links','commentary','status','ir','interface_identification_1','interface_identification_2','id_node','id_zone'];

    public static function get_occupancy($link_id) {
        $bw_occu = 0;
        $services = DB::table('service')
            ->join('asignacion_servicio_vlan', 'service.id', '=', 'asignacion_servicio_vlan.id_service')
            ->join('use_vlan', 'asignacion_servicio_vlan.id_use_vlan', '=', 'use_vlan.id')
            ->join('link', 'use_vlan.id_frontera', '=', 'link.id')
            ->where('link.id', $link_id)
            ->select('service.bw_service')
            ->get();
        if (count($services) > 0) foreach ($services as $serv) $bw_occu += $serv->bw_service;
        return $bw_occu;
    }
}
