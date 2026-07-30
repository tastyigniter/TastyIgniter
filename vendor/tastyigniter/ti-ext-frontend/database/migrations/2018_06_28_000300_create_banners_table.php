<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('banners')) {
            return;
        }

        Schema::create('banners', function(Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->increments('banner_id');
            $table->string('name');
            $table->char('type', 8);
            $table->integer('language_id');
            $table->string('click_url')->nullable();
            $table->string('alt_text')->nullable();
            $table->text('image_code')->nullable();
            $table->text('custom_code')->nullable();
            $table->boolean('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
