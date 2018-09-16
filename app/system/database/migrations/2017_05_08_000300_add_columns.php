<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * New column 'label' on mail_templates_data table
 * New columns on activities table
 * New column object_type on status_history table
 * New column 'permalink_slug' on pages, categories, locations tables
 * New column alias on layout_modules table
 * New column 'original_id' on Languages table
 * New column 'priority' on menu options, menu_options_values table
 * New column 'is_default' on menu_options_values table
 * New columns 'original_id, layout, plain_layout' on Mail Template table
 * New column 'plain_body' on Mail Template data table
 */
class AddColumns extends Migration
{
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('log_name')->nullable();
            $table->text('properties')->nullable();
            $table->integer('subject_id')->nullable();
            $table->string('subject_type')->nullable();
            $table->integer('causer_id')->nullable();
            $table->string('causer_type')->nullable();
            $table->dateTime('date_updated');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->integer('priority')->default(999);
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->string('name')->change();
            $table->integer('nest_left')->nullable();
            $table->string('nest_right')->nullable();
            $table->string('permalink_slug')->nullable();
        });

        Schema::table('layout_modules', function (Blueprint $table) {
            $table->string('alias')->nullable();
        });

        Schema::table('languages', function (Blueprint $table) {
            $table->integer('original_id')->nullable();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->string('permalink_slug')->nullable();
        });

        Schema::table('mail_templates_data', function (Blueprint $table) {
            $table->string('label')->nullable();
        });

        Schema::table('menu_options', function (Blueprint $table) {
            $table->integer('priority')->default(0);
        });

        Schema::table('menu_option_values', function (Blueprint $table) {
            $table->integer('priority')->default(0);
            $table->boolean('is_default')->nullable();
        });

        Schema::table('mail_templates', function (Blueprint $table) {
            $table->string('code');
            $table->text('layout')->nullable();
            $table->text('plain_layout')->nullable();
            $table->text('layout_css')->nullable();
        });

        Schema::table('mail_templates_data', function (Blueprint $table) {
            $table->text('is_custom')->nullable();
            $table->text('plain_body')->nullable();
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->string('permalink_slug')->nullable();
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->boolean('is_custom')->default(1);
        });

        Schema::table('status_history', function (Blueprint $table) {
            $table->string('object_type')->after('object_id');
        });
    }
}