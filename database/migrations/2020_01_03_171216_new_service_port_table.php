<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewServicePortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_port', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_lacp_port',10);
            $table->integer('id_service',10);
            $table->integer('vlan',10)->nullable();
            $table->timestamps();
            $table->foreign('id_lacp_port')->references('id')->on('lacp_port')->onDelete('cascade');
            $table->foreign('id_service')->references('id')->on('service')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_port');
    }
}
