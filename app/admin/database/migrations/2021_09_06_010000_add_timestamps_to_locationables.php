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
        Schema::table('categories', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->timestamp('updated_at');
        });

        Schema::table('mealtimes', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('menu_options', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::table('staffs', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->timestamp('updated_at');
        });

        Schema::table('tables', function (Blueprint $table) {
            $table->timestamps();
        });

        DB::table('categories')->update(['created_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
        DB::table('customers')->update(['updated_at' => DB::raw('now()')]);
        DB::table('mealtimes')->update(['created_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
        DB::table('menus')->update(['created_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
        DB::table('menu_options')->update(['created_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
        DB::table('staffs')->update(['updated_at' => DB::raw('now()')]);
        DB::table('tables')->update(['created_at' => DB::raw('now()'), 'updated_at' => DB::raw('now()')]);
    }

    public function down()
    {
    }
}
