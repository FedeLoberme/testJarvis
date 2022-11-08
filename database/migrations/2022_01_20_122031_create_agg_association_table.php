<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAggAssociationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agg_association', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_agg');
            $table->integer('n_frontier');
            $table->integer('id_home_zone');
            $table->integer('id_home_pe');
            $table->integer('id_home_pei');
            $table->integer('id_multihome_zone');
            $table->integer('id_multihome_pe');
            $table->integer('id_multihome_pei');
            $table->timestamps();
            
            $table->foreign('id_agg')->references('id')->on('equipment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agg_association');
    }
}
