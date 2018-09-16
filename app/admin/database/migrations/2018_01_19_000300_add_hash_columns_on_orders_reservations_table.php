<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Add hash column on orders and reservations table
 */
class AddHashColumnsOnOrdersReservationsTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('hash', 40)->nullable()->index();
        });

        Schema::table('reservations', function (Blueprint $table) {
            $table->string('hash', 40)->nullable()->index();
            $table->integer('duration')->nullable();
        });
    }

    public function down()
    {
        //
    }
}