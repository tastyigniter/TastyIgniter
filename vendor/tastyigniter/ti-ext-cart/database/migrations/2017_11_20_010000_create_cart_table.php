<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Create cart table
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sampoyigi_cart_cart')) {
            Schema::rename('sampoyigi_cart_cart', 'igniter_cart_cart');
        }

        if (Schema::hasTable('igniter_cart_cart')) {
            return;
        }

        Schema::create('igniter_cart_cart', function(Blueprint $table): void {
            $table->engine = 'InnoDB';
            $table->string('identifier');
            $table->string('instance');
            $table->longText('content');
            $table->nullableTimestamps();
            $table->primary(['identifier', 'instance']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('igniter_cart_cart');
    }
};
