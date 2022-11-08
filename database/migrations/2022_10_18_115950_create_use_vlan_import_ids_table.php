<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseVlanImportIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('use_vlan_import_ids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_in_use_vlan_table')->nullable();
            $table->integer('vlan',10)->nullable();
            $table->integer('id_list_use_vlan',10)->nullable();
            $table->integer('id_ring',10)->nullable();
            $table->integer('id_node')->nullable();
            $table->integer('id_equipment')->nullable();
            $table->integer('id_frontera')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('use_vlan_import_ids');
    }
}
