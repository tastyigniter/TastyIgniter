<?php namespace Admin\Database\Migrations;

use Admin\Models\Reservations_model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Create reservation_tables table
 */
class createReservationTablesTable extends Migration
{
    public function up()
    {
        Schema::create('reservation_tables', function (Blueprint $table) {
            $table->integer('reservation_id')->unsigned()->index();
            $table->integer('table_id')->unsigned()->index();
            $table->unique(['reservation_id', 'table_id']);
        });

        Reservations_model::get()->each(function ($model) {
            \DB::table('reservation_tables')->insert([
                'reservation_id' => $model->reservation_id,
                'table_id' => $model->table_id,
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation_tables');
    }
}