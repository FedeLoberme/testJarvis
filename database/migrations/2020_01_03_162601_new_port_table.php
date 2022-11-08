<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewPortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_board',10);
            $table->integer('n_port',5);
            $table->integer('id_status',10);
            $table->string('commentary',200)->nullable();
            $table->integer('connected_to',10)->nullable();
            $table->string('type',10)->nullable();
            $table->integer('id_ring',10)->nullable();
            $table->integer('id_uplink',10)->nullable();
            $table->integer('id_lacp_port',10)->nullable();
            $table->timestamps();
            $table->foreign('id_board')->references('id')->on('board')->onDelete('cascade');
            $table->foreign('id_status')->references('id')->on('status_port')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('port');
    }
}
