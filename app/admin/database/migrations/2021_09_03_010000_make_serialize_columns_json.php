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
        $this->updatePayments();
        $this->updateExtensionSettings();
        $this->updateThemes();
    }

    public function down()
    {
    }

    private function updateLocations()
    {
        DB::table('locations')
            ->get(['location_id', 'options'])
            ->each(function ($location) {
                DB::table('locations')
                    ->where('location_id', $location->location_id)
                    ->update([
                        'options' => unserialize($location->options) ?: [],
                    ]);
            });

        Schema::table('locations', function (Blueprint $table) {
            $table->json('options')->change();
        });
    }

    private function updateLocationAreas()
    {
        DB::table('location_areas')
            ->get(['area_id', 'boundaries', 'conditions'])
            ->each(function ($area) {
                DB::table('location_areas')
                    ->where('area_id', $area->area_id)
                    ->update([
                        'boundaries' => unserialize($area->boundaries) ?: [],
                        'conditions' => unserialize($area->conditions) ?: [],
                    ]);
            });

        Schema::table('location_areas', function (Blueprint $table) {
            $table->json('boundaries')->change();
            $table->json('conditions')->change();
        });
    }

    private function updatePayments()
    {
        DB::table('payments')
            ->get(['payment_id', 'data'])
            ->each(function ($payment) {
                DB::table('payments')
                    ->where('payment_id', $payment->payment_id)
                    ->update([
                        'data' => unserialize($payment->data) ?: [],
                    ]);
            });

        Schema::table('payments', function (Blueprint $table) {
            $table->json('data')->change();
        });
    }

    protected function updateExtensionSettings()
    {
        DB::table('extension_settings')
            ->get(['id', 'data'])
            ->each(function ($record) {
                DB::table('extension_settings')
                    ->where('id', $record->id)
                    ->update([
                        'data' => unserialize($record->data) ?: [],
                    ]);
            });

        Schema::table('extension_settings', function (Blueprint $table) {
            $table->json('data')->change();
        });
    }

    protected function updateThemes()
    {
        DB::table('themes')
            ->get(['theme_id', 'data'])
            ->each(function ($record) {
                DB::table('themes')
                    ->where('theme_id', $record->theme_id)
                    ->update([
                        'data' => unserialize($record->data) ?: [],
                    ]);
            });

        Schema::table('themes', function (Blueprint $table) {
            $table->json('data')->change();
        });
    }
}
