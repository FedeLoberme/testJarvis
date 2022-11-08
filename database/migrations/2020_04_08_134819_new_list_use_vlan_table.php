<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class NewListUseVlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_use_vlan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('subred',5);
            $table->timestamps();
        });

        DB::table('list_use_vlan')->insert([
            'name' => 'GESTIÓN LS',
            'subred' => 'SI',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_use_vlan')->insert([
            'name' => 'GESTIÓN RADIO',
            'subred' => 'SI',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_use_vlan')->insert([
            'name' => 'INTERNET WAN',
            'subred' => 'SI',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_use_vlan')->insert([
            'name' => 'RPV Y TIP',
            'subred' => 'NO',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_use_vlan')->insert([
            'name' => 'RPV MH',
            'subred' => 'NO',
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
        Schema::dropIfExists('list_use_vlan');
    }
}
