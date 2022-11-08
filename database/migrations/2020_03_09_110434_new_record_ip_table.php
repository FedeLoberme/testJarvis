<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewRecordIpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_ip', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_ip',10);
            $table->string('prefixes',5)->nullable();
            $table->string('attribute',100)->nullable();
            $table->integer('id_user',10)->nullable();           
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
        Schema::dropIfExists('attribute');
    }
}
