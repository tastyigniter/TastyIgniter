<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reservations', function(Blueprint $table): void {
            $table->string('telephone', 40)->nullable()->change();
        });
    }

    public function down(): void {}
};
