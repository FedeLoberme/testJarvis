<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewUseVlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_vlan', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vlan',10)->nullable();
            $table->integer('id_list_use_vlan',10);
            $table->integer('id_ring',10)->nullable();
            $table->timestamps();
            $table->foreign('id_list_use_vlan')->references('id')->on('list_use_vlan')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('use_vlan');
    }
}
