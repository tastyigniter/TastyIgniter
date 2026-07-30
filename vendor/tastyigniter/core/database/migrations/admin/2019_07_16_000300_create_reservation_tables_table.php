<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Create reservation_tables table
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('reservation_tables', function(Blueprint $table) {
            $table->integer('reservation_id')->unsigned()->index('reservation_id_index');
            $table->integer('table_id')->unsigned()->index('table_id_index');
            $table->unique(['reservation_id', 'table_id'], 'reservation_table_unique');
        });

        DB::table('reservations')->get()->each(function($model) {
            DB::table('reservation_tables')->insert([
                'reservation_id' => $model->reservation_id,
                'table_id' => $model->table_id,
            ]);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservation_tables');
    }
};
