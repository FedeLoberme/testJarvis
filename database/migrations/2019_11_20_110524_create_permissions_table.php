<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_profile',10);
            $table->integer('id_application',10);
            $table->integer('permission',3);
            $table->timestamps();
            $table->foreign('id_profile')->references('id')->on('profile')->onDelete('cascade');
            $table->foreign('id_application')->references('id')->on('application')->onDelete('cascade');
        });
        
        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '1',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '1',
            'permission' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '2',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '2',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '3',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '3',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '4',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '4',
            'permission' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '5',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '5',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '6',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '6',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '7',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '7',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '8',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '8',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '9',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '9',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '10',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '10',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '11',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '11',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '12',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '12',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '13',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '13',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '14',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '14',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '15',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '15',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '16',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '16',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '17',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '17',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '1',
            'id_application' => '18',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '2',
            'id_application' => '18',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '1',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '2',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '3',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '4',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '5',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '6',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '7',
            'permission' => '5',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '8',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '9',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '10',
            'permission' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '11',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '12',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '13',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '14',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '15',
            'permission' => '10',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '16',
            'permission' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '17',
            'permission' => '3',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('permissions')->insert([
            'id_profile' => '3',
            'id_application' => '18',
            'permission' => '0',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
