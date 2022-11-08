<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AddBehaviorToListUseVlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('list_use_vlan')
            ->whereIn('id', [1, 2])
            ->update([
                'behavior' => 0,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        DB::table('list_use_vlan')
            ->whereIn('id', [3, 4, 5])
            ->update([
                'behavior' => 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('list_use_vlan')
            ->whereIn('id', [1, 2, 3, 4, 5])
            ->update([
                'behavior' => null,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
    }
}
