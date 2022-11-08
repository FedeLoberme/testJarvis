<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewRelationAggAcronimoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_agg_acronimo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_equipment',10);
            $table->integer('id_agg_acronimo',10);
            $table->string('status',30)->default('Activo');
            $table->timestamps();
            $table->foreign('id_equipment')->references('id')->on('equipment')->onDelete('cascade');
            $table->foreign('id_agg_acronimo')->references('id')->on('agg_acronimo')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relation_agg_acronimo');
    }
}
