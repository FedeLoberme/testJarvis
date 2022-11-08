<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewRelationPortModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_port_model', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_equipment_model',10);
            $table->integer('id_port_equipment_model',10);
            $table->string('status',25)->default('Activo');
            $table->string('description_label',80)->nullable();
            $table->timestamps();
            $table->foreign('id_equipment_model')->references('id')->on('equipment_model')->onDelete('cascade');
            $table->foreign('id_port_equipment_model')->references('id')->on('port_equipment_model')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relation_port_model');
    }
}
