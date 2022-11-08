<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('range', function (Blueprint $table) {
            $table->dropForeign(['id_use_vlan']);
            $table->renameColumn('id_use_vlan', 'id_list_use_vlan');
            $table->foreign('id_list_use_vlan')->references('id')->on('list_use_vlan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('range', function (Blueprint $table) {
            $table->dropForeign(['id_list_use_vlan']);
            $table->renameColumn('id_list_use_vlan', 'id_use_vlan');
            $table->foreign('id_use_vlan')->references('id')->on('use_vlan');
        });
    }
}
