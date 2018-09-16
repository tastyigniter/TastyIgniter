<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Update password fields on users and customers tables
 * Add new columns (reset_code, reset_time, activation_code,
 * remember_token, is_activated, date_activated, last_login)  to both tables
 * Add super_user column to users table
 */
class ModifyColumnsOnUsersAndCustomersTables extends Migration
{
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('salt', 9)->nullable()->change();
            $table->string('password')->change();
            $table->string('reset_code')->nullable();
            $table->dateTime('reset_time')->nullable();
            $table->string('activation_code')->nullable();
            $table->string('remember_token')->nullable();
            $table->boolean('is_activated')->nullable();
            $table->dateTime('date_activated')->nullable();
            $table->dateTime('last_login')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('salt', 9)->nullable()->change();
            $table->string('password')->change();
            $table->boolean('super_user')->nullable();
            $table->string('reset_code')->nullable();
            $table->dateTime('reset_time')->nullable();
            $table->string('activation_code')->nullable();
            $table->string('remember_token')->nullable();
            $table->boolean('is_activated')->nullable();
            $table->dateTime('date_activated')->nullable();
            $table->dateTime('last_login')->nullable();
        });
    }

    public function down()
    {
        //
    }
}