<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRangeVlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('range_vlan', function (Blueprint $table) {
            $table->dropForeign('RANGE_ID_EQUIPMENT_FK');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('range_vlan', function (Blueprint $table) {
            $table->foreign('id_equipment')->references('id')->on('equipment');
        });
    }
}