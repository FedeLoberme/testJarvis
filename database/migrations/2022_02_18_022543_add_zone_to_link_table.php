<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZoneToLinkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Se comenta esta migracion ya que no está corriendo en el servidor de produccion. La BD fue actualizada desde el gestor.
        Schema::table('link', function (Blueprint $table) {
            $table->string('id_zone', 10)->nullable();
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*
        Schema::table('link', function (Blueprint $table) {
            $table->dropColumn('id_zone');
        });
        */
    }
}
