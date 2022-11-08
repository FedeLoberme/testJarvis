<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InsertReservasUplinkipran extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('application')->insert([
            'name' => 'Reservas',
            'id' => 25,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);

        DB::table('application')->insert([
            'name' => 'Uplink Ipran',
            'id' => 26,
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application', function (Blueprint $table) {
            //
        });
    }
}
