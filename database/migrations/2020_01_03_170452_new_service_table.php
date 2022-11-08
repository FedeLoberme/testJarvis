<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number',30);
            $table->integer('id_type',10);
            $table->integer('bw_service',20)->nullable();
            $table->string('commentary',100)->nullable();
            $table->string('order_down',50)->nullable();
            $table->string('order_high',50)->nullable();
            $table->integer('id_client',10)->nullable();
            $table->integer('id_address_a',10)->nullable();
            $table->integer('id_address_b',10)->nullable();
            $table->integer('list_down',10)->nullable();
            $table->string('status',20);
            $table->integer('relation',20)->nullable();
            $table->integer('id_service',10)->nullable();
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
        Schema::dropIfExists('service');
    }
}
