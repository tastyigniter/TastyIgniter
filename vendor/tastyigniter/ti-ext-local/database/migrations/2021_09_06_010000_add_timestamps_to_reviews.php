<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('igniter_reviews', 'date_added')) {
            return;
        }

        Schema::table('igniter_reviews', function(Blueprint $table): void {
            $table->renameColumn('date_added', 'created_at');
        });

        Schema::table('igniter_reviews', function(Blueprint $table): void {
            $table->timestamp('created_at')->change();
            $table->timestamp('updated_at');
        });
    }

    public function down(): void {}
};
