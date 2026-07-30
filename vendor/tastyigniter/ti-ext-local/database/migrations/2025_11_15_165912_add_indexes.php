<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Define the indexes to be added/removed for each table.
     *
     * @return array<string, array<int, array{columns: array<int, string>, name: string}>>
     */
    protected function getIndexes(): array
    {
        return [
            'locationables' => [
                ['columns' => ['locationable_type', 'locationable_id', 'location_id'], 'name' => 'idx_locationables_lookup'],
            ],
            'locations' => [
                ['columns' => ['location_name'], 'name' => 'idx_locations_name'],
            ],
            'igniter_reviews' => [
                ['columns' => ['location_id', 'review_status'], 'name' => 'idx_igniter_reviews_location_status'],
            ],
        ];
    }

    public function up(): void
    {
        foreach ($this->getIndexes() as $tableName => $indexes) {
            Schema::table($tableName, function(Blueprint $table) use ($indexes): void {
                foreach ($indexes as $index) {
                    $table->index($index['columns'], $index['name']);
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->getIndexes() as $tableName => $indexes) {
            Schema::table($tableName, function(Blueprint $table) use ($indexes): void {
                foreach ($indexes as $index) {
                    $table->dropIndex($index['name']);
                }
            });
        }
    }
};
