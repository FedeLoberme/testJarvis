<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('node', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cell_id',50);
            $table->string('node',50);
            $table->string('type',50);
            $table->string('status',30);
            $table->integer('address',10)->nullable();
            $table->date('contract_date')->nullable();
            $table->string('owner',100)->nullable();
            $table->string('commentary',50)->nullable();
            $table->integer('id_uplink',10)->nullable();
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
        Schema::dropIfExists('node');
    }
}
