<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateXlAnillosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xl_anillos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('anillo', 30);
            $table->string('bw_anillo', 30)->nullable();
            $table->string('acronimo_sw', 30)->nullable();
            $table->string('bwcpe', 15)->nullable();
            $table->string('capacidad', 4)->nullable();
            $table->string('ic_alta', 80)->nullable();
            $table->string('cliente', 150)->nullable();
            $table->string('direccion', 255)->nullable();
            $table->string('sw_viejo', 100)->nullable();
            $table->string('ip_gestion', 50)->nullable();
            $table->string('vlan_gestion', 30)->nullable();
            $table->string('by_pass', 70)->nullable();
            $table->string('modelo', 70)->nullable();
            $table->string('bw_migrado', 70)->nullable();
            $table->string('ic_01', 750)->nullable();
            $table->string('bw_01', 250)->nullable();
            $table->string('ic_02', 300)->nullable(); //cambiar a 70 todo para abajo
            $table->string('bw_02', 250)->nullable();
            $table->string('ic_03', 250)->nullable();
            $table->string('bw_03', 250)->nullable();
            $table->string('ic_04', 500)->nullable();
            $table->string('bw_04', 250)->nullable();
            $table->string('ic_05', 250)->nullable();
            $table->string('bw_05', 250)->nullable();
            $table->string('ic_06', 250)->nullable();
            $table->string('bw_06', 250)->nullable();
            $table->string('ic_07', 250)->nullable();
            $table->string('bw_07', 250)->nullable();
            $table->string('ic_08', 250)->nullable();
            $table->string('bw_08', 250)->nullable();
            $table->string('ic_09', 250)->nullable();
            $table->string('bw_09', 250)->nullable();
            $table->string('ic_10', 700)->nullable();
            $table->string('bw_10', 250)->nullable();
            $table->string('ic_11', 250)->nullable();
            $table->string('bw_11', 250)->nullable();
            $table->string('ic_12', 250)->nullable();
            $table->string('bw_12', 250)->nullable();
            $table->string('ic_13', 250)->nullable();
            $table->string('bw_13', 250)->nullable();
            $table->string('ic_14', 250)->nullable();
            $table->string('bw_14', 250)->nullable();
            $table->string('ic_15', 250)->nullable();
            $table->string('bw_15', 250)->nullable();
            $table->string('ic_16', 250)->nullable();
            $table->string('bw_16', 250)->nullable();
            $table->string('ic_17', 250)->nullable();
            $table->string('bw_17', 250)->nullable();
            $table->string('ic_18', 250)->nullable();
            $table->string('bw_18', 250)->nullable();
            $table->string('ic_19', 250)->nullable();
            $table->string('bw_19', 250)->nullable();
            $table->string('ic_20', 250)->nullable();
            $table->string('bw_20', 250)->nullable();
            $table->string('ic_21', 250)->nullable();
            $table->string('bw_21', 250)->nullable();
            $table->string('ic_22', 250)->nullable();
            $table->string('bw_22', 250)->nullable();
            $table->string('ic_23', 750)->nullable();
            $table->string('bw_23', 250)->nullable();
            $table->string('ic_24', 250)->nullable();
            $table->string('bw_24', 250)->nullable();
            $table->string('ic_25', 450)->nullable();
            $table->string('bw_25', 250)->nullable();
            $table->string('ic_26', 250)->nullable();
            $table->string('bw_26', 250)->nullable();
            $table->string('ic_27', 250)->nullable();
            $table->string('bw_27', 250)->nullable();
            $table->string('ic_28', 250)->nullable();
            $table->string('bw_28', 250)->nullable();
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
        Schema::dropIfExists('xl_anillos');
    }
}
