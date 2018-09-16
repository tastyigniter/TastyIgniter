<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Modify columns on orders and reservations table
 * add processed column
 * rename status column to status_id on reservations
 */
class ModifyColumnsOnOrdersReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('processed')->nullable();
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->boolean('processed')->nullable();
            $table->renameColumn('status', 'status_id');
        });
    }

    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->renameColumn('status_id', 'status');
        });
    }
}