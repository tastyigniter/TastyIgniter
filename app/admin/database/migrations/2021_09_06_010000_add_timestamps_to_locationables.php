<?php

namespace Admin\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToLocationables extends Migration
{
    public function up()
    {
        Schema::table('locationables', function (Blueprint $table) {
            $table->timestamps();
        });

        DB::table('locationables')->update(['created_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
    }

    public function down()
    {
    }
}
