<?php namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 *
 */
class createStaffsGroupsAndLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('staffs_locations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('staff_id')->unsigned();
            $table->integer('location_id')->unsigned();
            $table->primary(['staff_id', 'location_id'], 'staff_location');
        });

        DB::table('staffs')->get()->each(function ($model) {
            if (!empty($model->staff_location_id)) {
                DB::table('staffs_locations')->insert([
                    'staff_id' => $model->staff_id,
                    'location_id' => $model->staff_location_id,
                ]);
            }
        });
    }

    public function down()
    {
    }
}