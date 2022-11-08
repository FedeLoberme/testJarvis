<?php

namespace Jarvis;

use Illuminate\Database\Eloquent\Model;

class Range_Vlan extends Model
{
    protected $table = 'range_vlan';
    protected $fillable = ['id_equipment', 'id_list_use_vlan', 'n_frontier', 'range_from', 'range_until'];
    public $timestamps = true;

    public static function overlap($existing_range_from, $existing_range_until, $new_range_from, $new_range_until) {
        $from_overlaps = false;
        $until_overlaps = false;
        if ($existing_range_from <= $new_range_from && $new_range_from <= $existing_range_until) $from_overlaps = true;
        if ($existing_range_from <= $new_range_until && $new_range_until <= $existing_range_until) $until_overlaps = true;
        if ($from_overlaps || $until_overlaps) return true;
        else return false;
    }
}
