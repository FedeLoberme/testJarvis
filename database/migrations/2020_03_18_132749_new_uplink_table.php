<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewUplinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uplink', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',30);
            $table->integer('id_node',10);
            $table->integer('bw_maximum',10);
            $table->string('sar_equipment',20)->nullable();
            $table->string('sar_ip',20)->nullable();
            $table->string('sar_port',20)->nullable();
            $table->integer('mt',10)->nullable();
            $table->integer('ct',10)->nullable();
            $table->integer('vlan',10)->nullable();
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
        Schema::dropIfExists('uplink');
    }
}
