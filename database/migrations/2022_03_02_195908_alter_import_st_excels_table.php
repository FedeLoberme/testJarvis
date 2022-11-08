<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterImportStExcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Se comenta esta migracion ya que no está corriendo en el servidor de produccion. La BD fue actualizada desde el gestor.
        DB::statement('ALTER TABLE import_st_excels MODIFY costo_uss VARCHAR2(20 BYTE)');
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
        DB::statement('ALTER TABLE import_st_excels MODIFY costo_uss NUMBER(5)');
        */
    }
}
