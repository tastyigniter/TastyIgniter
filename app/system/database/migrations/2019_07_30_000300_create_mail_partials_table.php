<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailPartialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mail_partials', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('partial_id');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->text('html')->nullable();
            $table->text('text')->nullable();
            $table->boolean('is_custom')->default(0);
            $table->timestamps();
        });

        Schema::table('mail_templates', function (Blueprint $table) {
            $table->boolean('is_locked')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mail_partials');
    }
}
