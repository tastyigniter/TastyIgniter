<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Schema;

/**
 * Create language translations table
 */
class CreateLanguageTranslationsTable extends Migration
{
    public function up()
    {
        Schema::create('language_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('translation_id');
            $table->string('locale', 10);
            $table->string('namespace')->default('*');
            $table->string('group')->index();
            $table->string('item');
            $table->text('text');
            $table->boolean('unstable')->default(FALSE);
            $table->boolean('locked')->default(FALSE);
            $table->timestamps();
            $table->unique(['locale', 'namespace', 'group', 'item']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('language_translations');
    }
}