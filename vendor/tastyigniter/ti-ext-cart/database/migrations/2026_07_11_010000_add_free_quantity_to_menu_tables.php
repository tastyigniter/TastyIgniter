<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_item_options', function(Blueprint $table): void {
            $table->unsignedInteger('free_quantity')->default(0);
        });

        Schema::table('menu_item_option_values', function(Blueprint $table): void {
            $table->unsignedInteger('free_quantity')->default(0);
        });

        Schema::table('order_menu_options', function(Blueprint $table): void {
            $table->unsignedInteger('free_qty')->default(0);
        });
    }

    public function down(): void {}
};
