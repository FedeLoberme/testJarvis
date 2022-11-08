<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Error;

class Use_Vlan extends Model
{
    protected $table = 'use_vlan';
    protected $fillable = ['vlan', 'id_list_use_vlan', 'id_ring', 'id_node', 'id_frontera', 'status'];

    /**
     * Devuelve array con vlans de tipo Internet BV que ya estén registradas
     */
    public static function get_used_internet_bv($ring_id) {
        $agg = DB::table('equipment')
            ->join('board', 'board.id_equipment', '=', 'equipment.id')
            ->join('port', 'port.id_board', '=', 'board.id')
            ->join('ring', 'ring.id', '=', 'port.id_ring')
            ->where('ring.id', '=', $ring_id)
            ->select('equipment.id')
            ->first();
        $vlans = Self::where('id_list_use_vlan', 6)
            ->where('id_ring', $ring_id)
            ->where('id_equipment', $agg->id)
            ->select('id', 'vlan')
            ->get();
        foreach ($vlans as $v) $v->vlan = str_pad($v->vlan, 4, '0', STR_PAD_LEFT);
        return $vlans;
    }

    /**
     * Devuelve array con numeros de vlan del rango Internet BV. No están registradas
     */
    public static function get_new_internet_bv($ring_id) {
        $agg = DB::table('equipment')
            ->join('board', 'board.id_equipment', '=', 'equipment.id')
            ->join('port', 'port.id_board', '=', 'board.id')
            ->join('ring', 'ring.id', '=', 'port.id_ring')
            ->where('ring.id', '=', $ring_id)
            ->select('equipment.id')
            ->first();
        $range = Range_Vlan::where("id_list_use_vlan", 6)
            ->whereIn("id_equipment", [$agg->id, 0])
            ->select("range_from", "range_until")
            ->get();
        $vlan_numbers = [];
        foreach ($range as $r) {
            for ($i = $r->range_from; $i <= $r->range_until; $i++) {
                $vlan_numbers[] = str_pad($i, 4, '0', STR_PAD_LEFT);
            }
        }
        return $vlan_numbers;
    }
}
