<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        $idsToKeep = DB::table('location_options')
            ->groupBy('id', 'location_id', 'item')
            ->pluck('id')
            ->all();

        DB::table('location_options')->whereNotIn('id', $idsToKeep)->delete();

        Schema::table('location_options', function(Blueprint $table) {
            $table->unique(['location_id', 'item']);
        });
    }

    public function down() {}
};
