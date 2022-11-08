<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CreateProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50)->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('profile')->insert([
            'name' => 'BASICO',
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);
        
        DB::table('profile')->insert([
            'name' => 'ADMINISTRADOR',
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);

        DB::table('profile')->insert([
            'name' => 'ING. CLIENTES',
            'created_at' =>Carbon::now(),
            'updated_at' =>Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profile');
    }
}
