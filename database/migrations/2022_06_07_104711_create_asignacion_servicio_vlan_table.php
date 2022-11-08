<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsignacionServicioVlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignacion_servicio_vlan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_service',10)->references('id')->on('service')->onDelete('cascade');
            $table->integer('id_use_vlan',10)->references('id')->on('use_vlan')->onDelete('cascade');
            $table->integer('ctag',10)->nullable();
            $table->string('usuario', 100)->nullable();
            $table->string('estado', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asignacion_servicio_vlan');
    }
}
