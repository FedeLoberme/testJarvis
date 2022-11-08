<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('link', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->integer('id_extreme_1',10)->nullable();
            $table->integer('id_extreme_2',10)->nullable();
            $table->integer('bw_all',15)->default(0);
            $table->integer('bw_limit',15)->default(0);
            $table->integer('id_list_type_links',10);
            $table->string('commentary',300)->nullable();
            $table->string('status',50)->nullable();
            $table->string('ir',80)->nullable();
            $table->string('interface_identification_1',100)->nullable();
            $table->string('interface_identification_2',100)->nullable();
            $table->integer('id_node',10)->nullable();
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
        Schema::dropIfExists('link');
    }
}
