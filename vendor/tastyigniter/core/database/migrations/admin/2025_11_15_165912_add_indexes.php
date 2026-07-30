<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('status_history', function(Blueprint $table) {
            $table->index(['object_type', 'object_id', 'created_at'], 'idx_status_history_object_created');
            $table->index(['object_type', 'object_id', 'status_history_id'], 'idx_status_history_object_status');
        });
    }

    public function down(): void
    {
        Schema::table('status_history', function(Blueprint $table) {
            $table->dropIndex('idx_status_history_object_created');
            $table->dropIndex('idx_status_history_object_status');
        });
    }
};
