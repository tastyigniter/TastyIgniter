<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2018. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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