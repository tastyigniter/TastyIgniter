<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('customers', 'last_location_area')) {
            return;
        }

        Schema::table('customers', function(Blueprint $table): void {
            $table->text('last_location_area');
        });
    }

    public function down(): void {}
};
