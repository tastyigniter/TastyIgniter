<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;

/**
 *
 */
class changeSortValueRatingsToConfigOnSettingsTable extends Migration
{
    public function up()
    {
        \DB::table('settings')
           ->where('sort', 'ratings')
           ->update(['sort' => 'config']);
    }

    public function down()
    {
        \DB::table('settings')
           ->where('sort', 'config')
           ->update(['sort' => 'ratings']);
    }
}