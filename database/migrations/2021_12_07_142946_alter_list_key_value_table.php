<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AlterListKeyValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('list_key_value')->insert([
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '1', 'description' => 'Zona: Olleros', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '2', 'description' => 'Zona: Garay', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '3', 'description' => 'Zona: Tucuman', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '4', 'description' => 'Zona: Suipacha', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '5', 'description' => 'Zona: Boulogne', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '6', 'description' => 'Zona: Olleros 3', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '7', 'description' => 'Zona: Cordoba', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '8', 'description' => 'Zona: Mendoza', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '9', 'description' => 'Zona: Rosario', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '10', 'description' => 'Zona: Neuquen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('list_key_value')->where('table_name', 'list_zones')->delete();
    }
}
