<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewChainTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chain', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->string('extreme_1',100);
            $table->string('extreme_2',100);
            $table->integer('bw');
            $table->string('status',25)->default('ACTIVO');
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
        Schema::dropIfExists('chain');
    }
}
