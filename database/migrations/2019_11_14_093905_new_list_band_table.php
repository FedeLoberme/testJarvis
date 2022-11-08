<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class NewListBandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_band', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->timestamps();
        });

        DB::table('list_band')->insert([
            'name' => 'BANDA R - 1.70 a 2.60 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA D - 2.20 a 3.30 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA S - 2.60 a 3.95 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA E - 3.30 a 4.90 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA G - 3.95 a 5.85 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        
        DB::table('list_band')->insert([
            'name' => 'BANDA F - 4.90 a 7.05 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA C - 5.85 a 8.20 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA H - 7.05 a 10.10 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA X - 8.2 a 12.4 GHZ7',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA Ku - 12.4 a 18.0 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA K - 15.0 a 26.5 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA Ka - 26.5 a 40.0 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA Q - 33 to 50 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA U - 40 to 60 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA V - 50 to 75 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA W - 75 to 110 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_band')->insert([
            'name' => 'BANDA Y - 325 to 500 GHZ',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_band');
    }
}
