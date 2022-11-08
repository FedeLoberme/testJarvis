<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewRingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ring', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bw_limit',10)->nullable();
            $table->string('name',50);
            $table->string('status',20);
            $table->string('type',30);
            $table->string('dedicated',10);
            $table->string('commentary',100)->nullable();
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
        Schema::dropIfExists('ring');
    }
}
