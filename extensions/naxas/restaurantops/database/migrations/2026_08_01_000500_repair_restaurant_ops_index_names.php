<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** @var array<string, array<string, array{columns: array<int, string>, type: string}>> */
    private array $indexes = [
        'naxas_restaurant_ops_staff_preferences' => [
            'rops_staff_pref_staff_uq' => ['columns' => ['staff_id'], 'type' => 'unique'],
            'rops_staff_pref_loc_idx' => ['columns' => ['default_location_id'], 'type' => 'index'],
        ],
        'naxas_restaurant_ops_menu_item_metadata' => [
            'rops_menu_meta_kitchen_idx' => ['columns' => ['menu_id', 'kitchen_station_id'], 'type' => 'index'],
        ],
        'naxas_restaurant_ops_item_variants' => [
            'rops_variant_menu_active_idx' => ['columns' => ['menu_id', 'is_active', 'display_order'], 'type' => 'index'],
        ],
        'naxas_restaurant_ops_modifier_groups' => [
            'rops_mod_group_code_uq' => ['columns' => ['code'], 'type' => 'unique'],
            'rops_mod_group_active_idx' => ['columns' => ['is_active', 'display_order'], 'type' => 'index'],
        ],
        'naxas_restaurant_ops_modifier_metadata' => [
            'rops_modifier_stock_idx' => ['columns' => ['is_active', 'is_sold_out'], 'type' => 'index'],
        ],
        'naxas_restaurant_ops_order_item_snapshots' => [
            'rops_snapshot_order_idx' => ['columns' => ['order_id', 'order_menu_id'], 'type' => 'index'],
            'rops_snapshot_location_idx' => ['columns' => ['location_id', 'created_at'], 'type' => 'index'],
        ],
    ];

    public function up(): void
    {
        foreach ($this->indexes as $tableName => $indexes) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }
            foreach ($indexes as $name => $definition) {
                if (Schema::hasIndex($tableName, $definition['columns'], $definition['type'])) {
                    continue;
                }
                Schema::table($tableName, function (Blueprint $table) use ($definition, $name): void {
                    $table->{$definition['type']}($definition['columns'], $name);
                });
            }
        }
    }

    public function down(): void
    {
        foreach (array_reverse($this->indexes, true) as $tableName => $indexes) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }
            foreach (array_reverse($indexes, true) as $name => $definition) {
                if (! Schema::hasIndex($tableName, $name)) {
                    continue;
                }
                Schema::table($tableName, function (Blueprint $table) use ($definition, $name): void {
                    $definition['type'] === 'unique' ? $table->dropUnique($name) : $table->dropIndex($name);
                });
            }
        }
    }
};
