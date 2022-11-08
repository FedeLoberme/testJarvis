<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AlterListKeyValue2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        /* Se comenta esta migracion ya que no está corriendo en el servidor de produccion. La BD fue actualizada desde el gestor.
        DB::table('list_key_value')->where('table_name', 'list_zones')->delete();

        DB::table('list_key_value')->insert([
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '1', 'description' => 'Zona: Olleros', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '2', 'description' => 'Zona: Garay', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '3', 'description' => 'Zona: Cordoba', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '4', 'description' => 'Zona: Mendoza', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '5', 'description' => 'Zona: Rosario', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['table_name' => 'list_zones', 'key_name' => 'id_zone', 'value' => '6', 'description' => 'Zona: Asuncion', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        DB::table('list_key_value')->where('table_name', 'list_zones')->delete();

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
        */
    }
}
