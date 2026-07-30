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
            $table->timestamp('date_added')->change();
            $table->timestamp('date_updated')->change();
        });

        Schema::table('pages', function(Blueprint $table): void {
            $table->renameColumn('date_added', 'created_at');
            $table->renameColumn('date_updated', 'updated_at');
        });
    }

    public function down(): void {}
};
