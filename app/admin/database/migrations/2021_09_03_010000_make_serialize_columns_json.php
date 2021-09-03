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
        $this->updateLocationModels();
    }

    public function down()
    {
    }

    private function updateLocationModels()
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
}
