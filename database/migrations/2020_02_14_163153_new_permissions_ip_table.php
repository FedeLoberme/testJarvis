<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewPermissionsIpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions_ip', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_group_ip',10)->nullable();
            $table->integer('id_user',10)->nullable();
            $table->integer('id_branch',10);
            $table->integer('permissions',5);
            $table->timestamps();
            $table->foreign('id_branch')->references('id')->on('branch')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions_ip');
    }
}
