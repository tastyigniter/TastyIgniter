<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media_attachments', function(Blueprint $table) {
            $table->index(['attachment_type', 'attachment_id', 'priority'], 'idx_media_attachments_type_id_priority');
        });

        Schema::table('languages', function(Blueprint $table) {
            $table->index(['status', 'is_default'], 'idx_languages_status_default');
        });

        Schema::table('countries', function(Blueprint $table) {
            $table->index(['status', 'is_default'], 'idx_countries_status_default');
        });

        Schema::table('currencies', function(Blueprint $table) {
            $table->index(['currency_status', 'is_default'], 'idx_currencies_status_default');
        });
    }

    public function down(): void
    {
        Schema::table('media_attachments', function(Blueprint $table) {
            $table->dropIndex('idx_media_attachments_type_id_priority');
        });

        Schema::table('languages', function(Blueprint $table) {
            $table->dropIndex('idx_languages_status_default');
        });

        Schema::table('countries', function(Blueprint $table) {
            $table->dropIndex('idx_countries_status_default');
        });

        Schema::table('currencies', function(Blueprint $table) {
            $table->dropIndex('idx_currencies_status_default');
        });
    }
};
