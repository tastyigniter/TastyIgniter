<?php

namespace Admin\Database\Migrations;

use Admin\Models\Locations_model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MakeSerializeColumnsJson extends Migration
{
    public function up()
    {
        $this->updateLocationModels();
    }

    public function down()
    {
    }

    private function updateLocationModels()
    {
        $location_options_cache = [];
        Locations_model::select(['location_id', 'options'])
            ->get()
            ->each(function ($location) use (&$location_options_cache) {
                $location_options_cache[$location->location_id] = unserialize($location->getOriginal('options')) ?? [];
            });

        DB::table('locations')->update(['options' => '{}']);

        Schema::table('locations', function (Blueprint $table) {
            $table->json('options')->change();
        });

        foreach ($location_options_cache as $location_id => $location_options) {
            DB::table('locations')
                ->where('location_id', $location_id)
                ->update(['options' => $location_options]);
        }
    }
}
