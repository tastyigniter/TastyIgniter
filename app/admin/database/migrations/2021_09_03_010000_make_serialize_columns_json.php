<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MakeSerializeColumnsJson extends Migration
{
    public function up()
    {
        $this->updateLocations();
        $this->updateLocationAreas();
    }

    public function down()
    {
    }

    private function updateLocations()
    {
        DB::table('locations')
            ->select(['location_id', 'options'])
            ->get()
            ->each(function ($location) {

                DB::table('locations')
                    ->where('location_id', $location->location_id)
                    ->update([
                        'options' => unserialize($location->options) ?? [],
                    ]);

            });

        Schema::table('locations', function (Blueprint $table) {
            $table->json('options')->change();
        });

    }

    private function updateLocationAreas()
    {
        DB::table('location_areas')
            ->select(['area_id', 'boundaries', 'conditions'])
            ->get()
            ->each(function ($area) {

                DB::table('location_areas')
                    ->where('location_id', $area->area_id)
                    ->update([
                        'boundaries' => unserialize($area->boundaries) ?? [],
                        'conditions' => unserialize($area->conditions) ?? [],
                    ]);

            });

        Schema::table('location_areas', function (Blueprint $table) {
            $table->json('boundaries')->change();
            $table->json('conditions')->change();
        });

    }
}
