<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AlterRangeVlan2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $id = DB::table('list_use_vlan')->where('name', 'GESTIÓN ANILLO IPRAN')->value('id');

        DB::table('range_vlan')->insert(
            [
                'id_equipment' => 0,
                'id_list_use_vlan' => $id,
                'range_from' => 400,
                'range_until' => 405,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $id = DB::table('list_use_vlan')->where('name', 'GESTIÓN ANILLO IPRAN')->value('id');

        DB::table('range_vlan')
            ->where('id_equipment', 0)
            ->where('id_list_use_vlan', $id)
            ->where('range_from', 400)
            ->where('range_until', 405)
            ->delete();
    }
}
