<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function(Blueprint $table): void {
            $table->index(['notifiable_type', 'notifiable_id', 'read_at'], 'idx_notifications_notifiable_read');
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function(Blueprint $table): void {
            $table->dropIndex('idx_notifications_notifiable_read');
        });
    }
};
