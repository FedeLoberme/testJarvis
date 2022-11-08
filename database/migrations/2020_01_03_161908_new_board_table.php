<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_equipment',10);
            $table->integer('id_port_model',10);
            $table->string('status',30)->default('ACTIVO');
            $table->string('slot',80)->nullable();
            $table->timestamps();
            $table->foreign('id_equipment')->references('id')->on('equipment')->onDelete('cascade');
            $table->foreign('id_port_model')->references('id')->on('port_equipment_model')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('board');
    }
}
