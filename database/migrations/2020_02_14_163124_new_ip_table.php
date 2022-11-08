<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewIpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ip',30);
            $table->string('prefixes',5)->nullable();
            $table->string('type',30)->nullable();
            $table->integer('id_status',10);
            $table->integer('id_branch',10);
            $table->string('assignment',50)->nullable();
            $table->integer('id_equipment',10)->nullable();
            $table->integer('id_client',10)->nullable();
            $table->integer('id_service',10)->nullable();
            $table->integer('id_use_vlan',10)->nullable();
            $table->integer('id_equipment_wan',10)->nullable();
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
        Schema::dropIfExists('ip');
    }
}
