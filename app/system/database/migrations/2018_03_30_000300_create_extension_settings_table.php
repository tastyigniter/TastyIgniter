<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Create extension_settings table
 */
class CreateExtensionSettingsTable extends Migration
{
    public function up()
    {
        Schema::table('extensions', function (Blueprint $table) {
            $table->string('version', 32)->nullable()->change();
        });

        Schema::create('extension_settings', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('item')->unique();
            $table->text('data')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('extension_settings');
    }
}