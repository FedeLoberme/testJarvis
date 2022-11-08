<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUseVlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('use_vlan', function (Blueprint $table) {
            $table->integer('id_equipment')->after('id_ring')->nullable();
            $table->integer('id_frontera')->after('id_equipment')->nullable();
            $table->integer('status')->after('id_frontera')->nullable();

            $table->foreign('id_equipment')->references('id')->on('equipment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('use_vlan', function (Blueprint $table) {
            $table->dropColumn('id_equipment');
            $table->dropColumn('id_frontera');
            $table->dropColumn('status');
        });
    }
}
