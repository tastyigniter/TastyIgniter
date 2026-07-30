<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dining_areas', function(Blueprint $table): void {
            $table->index(['id', 'location_id'], 'idx_dining_areas_location_id');
        });

        Schema::table('dining_tables', function(Blueprint $table): void {
            $table->index([
                'parent_id',
                'is_enabled',
                'min_capacity',
                'max_capacity',
                'dining_area_id',
                'dining_section_id',
            ], 'idx_dining_tables_booked_filter');
            $table->index(['min_capacity', 'max_capacity'], 'idx_dining_tables_capacity');
            $table->index(['id', 'priority'], 'idx_dining_tables_priority');
        });

        Schema::table('dining_sections', function(Blueprint $table): void {
            $table->index(['id', 'is_enabled'], 'idx_dining_sections_enabled');
        });

        // Add computed column for MySQL / PostgreSQL
        if (DB::getDriverName() === 'mysql') {
            DB::statement('
                ALTER TABLE '.DB::getTablePrefix().'reservations
                ADD COLUMN reserve_datetime DATETIME
                GENERATED ALWAYS AS (ADDTIME(reserve_date, reserve_time)) STORED
            ');
        }

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('
                ALTER TABLE '.DB::getTablePrefix().'reservations
                ADD COLUMN reserve_datetime TIMESTAMP
                GENERATED ALWAYS AS (reserve_date::timestamp + reserve_time::interval) STORED
            ');
        }

        Schema::table('reservations', function(Blueprint $table): void {
            $table->index(['reserve_datetime'], 'idx_reservations_datetime');
            $table->index(['location_id', 'status_id', 'reserve_date', 'reserve_time'], 'idx_reservations_time_filter');
        });

        Schema::table('reservation_tables', function(Blueprint $table): void {
            $table->index(['reservation_id', 'dining_table_id'], 'idx_reservation_tables_res_table');
        });
    }

    public function down(): void
    {
        Schema::table('dining_areas', function(Blueprint $table): void {
            $table->dropIndex('idx_dining_areas_location_id');
        });

        Schema::table('dining_tables', function(Blueprint $table): void {
            $table->dropIndex('idx_dining_tables_booked_filter');
            $table->dropIndex('idx_dining_tables_capacity');
        });

        Schema::table('dining_sections', function(Blueprint $table): void {
            $table->dropIndex('idx_dining_sections_enabled');
        });

        Schema::table('reservations', function(Blueprint $table): void {
            $table->dropIndex('idx_reserve_datetime');
            $table->dropIndex('idx_reservations_time_filter');
        });

        Schema::table('reservation_tables', function(Blueprint $table): void {
            $table->dropIndex('idx_reservation_tables_res_table');
        });
    }
};
