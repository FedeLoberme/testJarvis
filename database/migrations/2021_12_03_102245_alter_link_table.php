<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('link', function (Blueprint $table) {
            $table->string('sufijo_vcid', 100)->after('id_node')->nullable();
            $table->integer('tecnologia')->after('sufijo_vcid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('link', function (Blueprint $table) {
            $table->dropColumn('sufijo_vcid');
            $table->dropColumn('tecnologia');
        });
    }
}
