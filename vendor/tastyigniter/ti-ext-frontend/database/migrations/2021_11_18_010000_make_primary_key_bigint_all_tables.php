<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('igniter_frontend_banners', function(Blueprint $table): void {
            $table->unsignedBigInteger('banner_id', true)->change();
        });

        Schema::table('igniter_frontend_sliders', function(Blueprint $table): void {
            $table->unsignedBigInteger('id', true)->change();
        });

        Schema::table('igniter_frontend_subscribers', function(Blueprint $table): void {
            $table->unsignedBigInteger('id', true)->change();
        });
    }

    public function down(): void {}
};
