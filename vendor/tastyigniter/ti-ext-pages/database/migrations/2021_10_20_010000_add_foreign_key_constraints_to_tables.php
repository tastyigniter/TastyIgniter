<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function(Blueprint $table): void {
            $table->unsignedBigInteger('page_id')->change();
        });

        rescue(function(): void {
            Schema::table('pages', function(Blueprint $table): void {
                $table->foreignId('language_id')->change()->constrained('languages', 'language_id');
            });
        });
    }

    public function down(): void
    {
        try {
            Schema::table('pages', function(Blueprint $table): void {
                $table->dropForeignKeyIfExists('language_id');
            });
        } catch (Exception) {
        }
    }
};
