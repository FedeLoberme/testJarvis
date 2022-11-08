<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewLacpPortTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lacp_port', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lacp_number',30)->nullable();
            $table->string('commentary',255)->nullable();
            $table->string('group_lacp',10);
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
        Schema::dropIfExists('Lacp_Port');
    }
}
