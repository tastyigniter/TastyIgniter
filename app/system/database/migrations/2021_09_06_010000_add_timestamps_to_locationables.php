<?php

namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToLocationables extends Migration
{
    public function up()
    {
        Schema::table('countries', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('currencies', function (Blueprint $table) {
            $table->timestamp('date_modified')->change();
            $table->renameColumn('date_modified', 'updated_at');
            $table->timestamp('created_at');
        });

        Schema::table('languages', function (Blueprint $table) {
            $table->timestamps();
        });
        Schema::table('themes', function (Blueprint $table) {
            $table->timestamps();
        });

        DB::table('countries')->update(['created_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
        DB::table('currencies')->update(['created_at' => DB::raw('now()')]);
        DB::table('languages')->update(['created_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
        DB::table('themes')->update(['created_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
    }

    public function down()
    {
    }
}
