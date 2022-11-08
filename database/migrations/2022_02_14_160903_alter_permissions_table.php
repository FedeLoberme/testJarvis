<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AlterPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert(
            [
                [
                    'id_profile' => 2,
                    'id_application' => 27,
                    'permission' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'id_profile' => 21,
                    'id_application' => 27,
                    'permission' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
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
        DB::table('permissions')
            ->where('id_application', 27)
            ->where('id_profile', 2)
            ->where('permission', 0)
            ->delete();
        DB::table('permissions')
            ->where('id_application', 27)
            ->where('id_profile', 21)
            ->where('permission', 0)
            ->delete();
    }
}
