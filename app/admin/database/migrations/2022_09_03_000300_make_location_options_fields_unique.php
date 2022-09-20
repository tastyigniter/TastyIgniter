<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MakeLocationOptionsFieldsUnique extends Migration
{
    public function up()
    {
        $idsToKeep = DB::table('location_options')
            ->groupBy('location_id', 'item')
            ->get()
            ->pluck('id')
            ->all();

        DB::table('location_options')->whereNotIn('id', $idsToKeep)->delete();

        Schema::table('location_options', function (Blueprint $table) {
            $table->unique(['location_id', 'item']);
        });
    }

    public function down()
    {
    }
}
