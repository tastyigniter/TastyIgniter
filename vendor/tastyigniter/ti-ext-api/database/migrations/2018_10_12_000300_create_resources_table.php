<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('igniter_api_resources', function(Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('endpoint');
            $table->string('model');
            $table->string('controller');
            $table->string('transformer');
            $table->string('description')->nullable();
            $table->text('meta')->nullable();
            $table->boolean('is_custom')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('igniter_api_resources');
    }
};
