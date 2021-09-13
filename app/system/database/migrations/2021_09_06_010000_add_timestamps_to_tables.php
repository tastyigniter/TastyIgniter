<?php

namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToTables extends Migration
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

        Schema::table('mail_layouts', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->timestamp('date_updated')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->renameColumn('date_updated', 'updated_at');
        });

        Schema::table('mail_templates', function (Blueprint $table) {
            $table->timestamp('date_added')->change();
            $table->timestamp('date_updated')->change();
            $table->renameColumn('date_added', 'created_at');
            $table->renameColumn('date_updated', 'updated_at');
        });

        Schema::table('themes', function (Blueprint $table) {
            $table->timestamps();
        });
    }

    public function down()
    {
    }
}
