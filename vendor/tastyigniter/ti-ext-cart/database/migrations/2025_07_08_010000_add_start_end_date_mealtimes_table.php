<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mealtimes', function(Blueprint $table): void {
            $table->string('validity', 15)->default('daily');
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->json('recurring_every')->nullable();
            $table->time('recurring_from')->nullable();
            $table->time('recurring_to')->nullable();
        });
    }

    public function down(): void {}
};
