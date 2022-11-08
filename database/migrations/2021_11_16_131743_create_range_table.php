<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('range', function (Blueprint $table) {
            $table->integer('id_equipment')->nullable();
            $table->integer('id_use_vlan')->nullable();
            $table->integer('n_frontier')->nullable();
            $table->integer('range_from')->nullable();
            $table->integer('range_until')->nullable();
            $table->timestamps();

            $table->foreign('id_equipment')->references('id')->on('equipment');
            $table->foreign('id_use_vlan')->references('id')->on('use_vlan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('range');
    }
}
