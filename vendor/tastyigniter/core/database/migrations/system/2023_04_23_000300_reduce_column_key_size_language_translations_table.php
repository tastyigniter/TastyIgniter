<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('language_translations', function(Blueprint $table) {
            $table->string('locale', 10)->change();
            $table->string('namespace', 64)->default('*')->change();
            $table->string('group', 64)->change();
        });
    }
};
