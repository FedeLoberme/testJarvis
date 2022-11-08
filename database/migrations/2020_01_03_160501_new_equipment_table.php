<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewEquipmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_model',10);
            $table->integer('id_function',10);
            $table->integer('id_client',10)->nullable();
            $table->integer('id_node',10)->nullable();
            $table->string('acronimo',20);
            $table->string('client_management',5);
            $table->string('ip_wan_rpv',20)->nullable();
            $table->string('location',255)->nullable();
            $table->integer('address',10)->nullable();
            $table->string('id_ne',20)->nullable();
            $table->string('service',100)->nullable();
            $table->string('ir_os_up',30)->nullable();
            $table->string('ir_os_down',30)->nullable();
            $table->string('commentary',300)->nullable();
            $table->string('status',20)->default('ALTA');
            $table->timestamps();
            $table->foreign('id_model')->references('id')->on('equipment_model')->onDelete('cascade');
            $table->foreign('id_function')->references('id')->on('function_equipment_model')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment');
    }
}
