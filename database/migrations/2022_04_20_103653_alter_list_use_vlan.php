<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AlterListUseVlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('list_use_vlan')->insert(
            [
                'name' => 'GESTIÓN ANILLO IPRAN',
                'subred' => 'SI',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'behavior' => 0
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
        DB::table('list_use_vlan')->where('name', 'GESTIÓN ANILLO IPRAN')->delete();
    }
}
