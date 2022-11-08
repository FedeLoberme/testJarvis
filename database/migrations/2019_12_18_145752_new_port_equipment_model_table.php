<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewPortEquipmentModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('port_equipment_model', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('quantity',2);
            $table->integer('port_f_i',2);
            $table->integer('port_f_f',2);
            $table->integer('id_list_port',10);
            $table->integer('id_connector',10);
            $table->integer('bw_max_port',15);
            $table->integer('id_label',10);
            $table->integer('port_l_i',2);
            $table->integer('port_l_f',2);
            $table->integer('id_module_board',10);
            $table->string('type_board',15);
            $table->string('status',25)->default('ALTA');
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
        Schema::dropIfExists('port_equipment_model');
    }
}
