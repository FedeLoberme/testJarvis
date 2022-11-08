<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditUseVlanAuxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edit_use_vlan_aux_2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('excel_id');
            $table->unsignedBigInteger('excel_id_frontera');
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
        Schema::dropIfExists('edit_use_vlan_aux');
    }
}
