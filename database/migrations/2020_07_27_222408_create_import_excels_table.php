<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportExcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_excels', function (Blueprint $table) {
            $table->increments('id');
            $table->string('idagg', 60);
            $table->dateTime('date');
            $table->string('ip', 50);
            $table->string('hostname', 30);
            $table->string('interface', 50);
            $table->string('anillo')->nullable();
            $table->string('adminstatus', 20);
            $table->string('operstatus', 20);
            $table->string('descripcion', 255)->nullable();
            $table->string('nombremodulo', 255);
            $table->string('descripmodulo', 255);
            $table->string('tipomodulo', 50)->nullable();
            $table->string('distancia', 50)->nullable();
            $table->string('fibra', 50)->nullable();
            $table->string('cortalarga', 50)->nullable();
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
        Schema::dropIfExists('import_excels');
    }
}
