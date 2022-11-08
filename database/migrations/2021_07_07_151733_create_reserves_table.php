<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reserves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('number_reserve',50);
            $table->integer('id_link',10);
            $table->integer('id_cliente',10);
            $table->integer('bw_reserve',15)->default(0);
            $table->string('status',50)->nullable();
            $table->integer('id_user',10);
            $table->integer('quantity_dates')->default(90); // 2.3meses
            $table->string('oportunity',100);
            $table->integer('id_service_type',20);
            $table->string('commentary',300)->nullable();
            $table->string('cell_status',20)->nullable();
            $table->string('cell_bw_link',20)->nullable();
            $table->string('cell_bw_usado',20)->nullable();            
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
        Schema::dropIfExists('reserves');
    }
}
