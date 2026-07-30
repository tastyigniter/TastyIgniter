<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create language translations table
 */
return new class extends Migration
{
    public function up()
    {
        Schema::create('language_translations', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('translation_id');
            $table->string('locale', 10);
            $table->string('namespace', 64)->default('*');
            $table->string('group', 64)->index();
            $table->string('item');
            $table->text('text');
            $table->boolean('unstable')->default(false);
            $table->boolean('locked')->default(false);
            $table->timestamps();
            $table->unique(['locale', 'namespace', 'group', 'item'], 'item_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('language_translations');
    }
};
