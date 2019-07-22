<?php namespace System\Database\Migrations;

use DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 *
 */
class addUserTypeColumnToActivitiesTable extends Migration
{
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('user_type')->nullable();
        });

        DB::table('menus_specials')->update([
            'type' => 'F',
            'validity' => 'period',
        ]);
    }

    public function down()
    {
        //
    }
}