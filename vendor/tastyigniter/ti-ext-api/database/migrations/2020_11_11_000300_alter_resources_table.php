<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('igniter_api_resources', function(Blueprint $table): void {
            $table->dropColumn('model');
            $table->dropColumn('transformer');
        });
    }

    public function down(): void {}
};
