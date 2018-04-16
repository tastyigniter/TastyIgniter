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