<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ModifyColumnsOnTablesReservationsTable extends Migration
{
    public function up()
    {
        $this->moveLocationTablesRecordsToLocationablesTable();

        Schema::table('tables', function (Blueprint $table) {
            $table->integer('extra_capacity')->default(0);
            $table->boolean('is_joinable')->default(1);
            $table->integer('priority')->default(0);
        });

        Schema::dropIfExists('location_tables');
    }

    public function down()
    {
    }

    protected function moveLocationTablesRecordsToLocationablesTable()
    {
        DB::table('location_tables')->get()->each(function ($model) {
            DB::table('locationables')->insert([
                'location_id' => $model->location_id,
                'locationable_type' => 'tables',
                'locationable_id' => $model->table_id,
            ]);
        });
    }
}
