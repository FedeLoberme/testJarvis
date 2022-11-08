<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewEquipmentModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipment_model', function (Blueprint $table) {
            $table->increments('id'); //autoincrementador
            $table->integer('id_equipment',10);
            $table->integer('id_mark',10);
            $table->string('model',30);
            $table->string('cod_sap',30);
            $table->string('status',30);
            $table->string('description',100)->nullable();
            $table->integer('bw_max_hw',10);
            $table->integer('bw_bas_lic',10)->nullable();
            $table->integer('id_electrical_power',10);//alimentacion
            $table->string('dual_stack',2)->nullable();
            $table->integer('id_band',10)->nullable();
            $table->integer('id_radio',10)->nullable();
            $table->string('multivrf',2)->nullable();
            $table->integer('module_slots',2)->nullable();
            $table->integer('bw_encriptado',10)->nullable();
            $table->string('full_table',2)->nullable();
            $table->string('img_url',50)->nullable();
            $table->timestamps();
            $table->foreign('id_equipment')->references('id')->on('list_equipment')->onDelete('cascade');
            $table->foreign('id_mark')->references('id')->on('list_mark')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_model');
    }
}
