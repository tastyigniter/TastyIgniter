<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('mail_layouts', function(Blueprint $table) {
            $table->unique(['code']);
        });

        Schema::table('mail_partials', function(Blueprint $table) {
            $table->unique(['code']);
        });
    }

    public function down() {}
};
