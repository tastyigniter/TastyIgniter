<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Add color column on location_areas table
 */
class AddColumnsOnLocationAreasTable extends Migration
{
    public function up()
    {
        Schema::table('location_areas', function (Blueprint $table) {
            $table->string('color', 40)->nullable();
            $table->boolean('is_default')->default(0);
        });
    }

    public function down()
    {
        Schema::table('location_areas', function (Blueprint $table) {
            $table->dropColumn('color');
            $table->dropColumn('is_default');
        });
    }
}