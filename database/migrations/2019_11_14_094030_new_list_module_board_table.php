<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class NewListModuleBoardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_module_board', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50);
            $table->timestamps();
        });

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C1900',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C2800',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C2911',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-2901',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C3800',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C3925',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C3925E',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-ISR4300',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-ISR4351',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-ISR4400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C881',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C1841',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-S5320',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C3400',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'LS5D00E4XY00',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'NIM-ES2-8',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-H3328',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'A9K-MPA-20X1GE',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'A9K-MPA-8X10GE (10G SFP+)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'A9K-MPA-4X10GE (10G XFP)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'EHWIC-4ESG - 4X10/100/1000M ETH SWITCH',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'VWIC3-1MFT-T1/E1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'VWIC3-2MFT-T1/E1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'HWIC-1T',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'HWIC-2T',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'A900-IMA8S1Z (10G SFP+)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'A9K-8T/4-B (10G XFP)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => '7600-ES+4TG3CXL (10G XFP)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'A9K-48X10GE-1G-TR (10G SFP+)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => '76-ES+T-40G',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => '7600-ES+2TG3CXL (10G XFP)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'WS-X6748-SFP',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'WS-X6548-GE-TX',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C2921',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-S3928',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'RSP720-3C-GE',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-C3600',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'RSP720-3CXL-10GE (10G X2)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => '76-ES+T-4TG (10G XFP)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-S5328',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'A9K-2T20GE-B (10G XFP)',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'A9K-40GE-TR',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'GENERICA-4XFE',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-S5320-LI',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('list_module_board')->insert([
            'name' => 'ONBOARD-5320-SI',
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
        Schema::dropIfExists('list_module_board');
    }
}
