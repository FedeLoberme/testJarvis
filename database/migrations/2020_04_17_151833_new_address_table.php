<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_provinces',10);
            $table->string('location',50)->nullable();
            $table->string('street',200)->nullable();
            $table->string('height',100)->nullable();
            $table->string('floor',100)->nullable();
            $table->string('department',50)->nullable();
            $table->string('postal_code',50)->nullable();
            $table->timestamps();
            $table->foreign('id_provinces')->references('id')->on('list_provinces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('address');
    }
}
