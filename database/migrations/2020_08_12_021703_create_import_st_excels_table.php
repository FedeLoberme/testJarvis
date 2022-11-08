<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportStExcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_st_excels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tecn',100)->nullable();
            $table->string('marca',400)->nullable();
            $table->integer('codsap')->nullable();
            $table->integer('codsap_anterior')->nullable();			
            $table->string('descripcion',255)->nullable();
            $table->smallInteger('stock_benavidez')->nullable();
            $table->smallInteger('stock_cordoba')->nullable();
            $table->smallInteger('stock_mantenimiento')->nullable();
            $table->smallInteger('stock_proyectos')->nullable();
            $table->smallInteger('traslado_origen')->nullable();
            $table->smallInteger('oc_generada')->nullable();
            $table->smallInteger('stock_mimnimo')->nullable();
            $table->string('futuro_uso1')->nullable();
            $table->string('futuro_uso2')->nullable();
            $table->smallInteger('costo_uss')->nullable();
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
        Schema::dropIfExists('import_st_excels');
    }
}
