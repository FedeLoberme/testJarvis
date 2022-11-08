<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewRelationModelFunctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relation_model_function', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_equipment_model',10);
            $table->integer('id_function_equipment_model',10);
            $table->string('status',25);
            $table->timestamps();
            $table->foreign('id_equipment_model')->references('id')->on('equipment_model')->onDelete('cascade');
            $table->foreign('id_function_equipment_model')->references('id')->on('function_equipment_model')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('relation_model_function');
    }
}
