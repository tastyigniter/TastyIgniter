<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MergeStaffsLocationsIntoLocationablesTable extends Migration
{
    public function up()
    {
        DB::table('staffs_locations')->get()->each(function ($model) {
            DB::table('locationables')->insert([
                'location_id' => $model->location_id,
                'locationable_type' => 'staffs',
                'locationable_id' => $model->staff_id,
            ]);
        });

        Schema::dropIfExists('staffs_locations');
    }

    public function down()
    {
    }
}
