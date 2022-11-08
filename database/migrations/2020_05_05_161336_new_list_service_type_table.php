<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class NewListServiceTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_service_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',40);
            $table->string('require_ip',3);
            $table->string('require_rank',3);
            $table->string('require_bw',3);
            $table->string('require_related',3);
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
        Schema::dropIfExists('list_service_type');
    }
}
