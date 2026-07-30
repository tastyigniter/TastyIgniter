<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('igniter_reviews', function(Blueprint $table): void {
            $table->unsignedBigInteger('review_id', true)->change();
            $table->unsignedBigInteger('customer_id')->nullable()->change();
            $table->unsignedBigInteger('sale_id')->nullable()->change();
            $table->unsignedBigInteger('location_id')->nullable()->change();
        });
    }

    public function down(): void {}
};
