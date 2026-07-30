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
            $table->renameColumn('sale_id', 'reviewable_id');
            $table->renameColumn('sale_type', 'reviewable_type');
        });
    }

    public function down(): void {}
};
