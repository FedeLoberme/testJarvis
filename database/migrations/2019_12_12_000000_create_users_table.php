<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',20);
            $table->string('username',20)->unique();
            $table->string('email',50);
            $table->string('password');
            $table->integer('status',2)->default(1);
            $table->string('url_img',100);
            $table->string('last_name',20);
            $table->string('workgroup',50);
            $table->string('department',50);
            $table->integer('id_profile',10)->default(1);
            $table->dateTime('fin_login')->nullable();
            $table->string('SESSION_ID')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->foreign('id_profile')->references('id')->on('profile')->onDelete('cascade');
        });

        DB::table('users')->insert([
            'name' => 'SUPER',
            'username' => 'ADMIN_JARVIS',
            'email' => 'JARVIS@CLARO.COM.AR',
            'password' => '$2y$10$nSC6hhSndlYPKd2q3DYKKuswlC4LMZl8mJwC3D8d3o45Py5l/A4R2',
            'url_img' => 'https://logodownload.org/wp-content/uploads/2014/02/claro-logo1.png',
            'last_name' => 'JARVIS',
            'remember_token' => 'Oa7WsF0Z1t5X7FZVZZqlDRAmiPlS8ku9v6TB4C68xhmuQ2ey6ySVEDuljAr0',
            'workgroup' => 'ADIMIN',
            'fin_login' => null,
            'department' => 'SUPER USUARIO',
            'id_profile' => '2',
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
        Schema::dropIfExists('users');
    }
}
