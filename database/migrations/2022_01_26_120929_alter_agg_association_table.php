<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAggAssociationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agg_association', function (Blueprint $table) {
            $table->renameColumn('n_frontier', 'prefijo_agg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agg_association', function (Blueprint $table) {
            $table->renameColumn('prefijo_agg', 'n_frontier');
        });
    }
}
