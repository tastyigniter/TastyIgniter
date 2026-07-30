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
            $table->dropForeignKeyIfExists('reservations_table_id_foreign');
            $table->dropIndexIfExists('reservations_table_id_foreign');
        });
    }

    public function down(): void {}
};
