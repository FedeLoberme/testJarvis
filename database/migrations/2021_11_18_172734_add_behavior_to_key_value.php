<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddBehaviorToKeyValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('list_key_value')->insert([
            [
                'table_name' => 'list_use_vlan',
                'key_name' => 'behavior', 
                'value' => '0', 
                'description' => 'Vlan no tiene comportamiento de frontera',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
                
            ],
            [
                'table_name' => 'list_use_vlan',
                'key_name' => 'behavior', 
                'value' => '1', 
                'description' => 'Vlan tiene comportamiento de frontera',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('list_key_value')
            ->where([
                ['key_name', '=', 'behavior'],
                ['value', '=', '0'],
            ])
            ->orWhere([
                ['key_name', '=', 'behavior'],
                ['value', '=', '1'],
            ])
            ->delete();
    }
}
