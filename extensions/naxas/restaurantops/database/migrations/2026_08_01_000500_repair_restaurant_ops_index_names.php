<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Naxas\RestaurantOps\Support\MySqlSchemaInspector;

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
        $inspector = new MySqlSchemaInspector(DB::connection());
        $inspector->assertMySql();

        foreach ($this->indexes as $tableName => $indexes) {
            if (! $inspector->tableExists($tableName)) {
                throw new RuntimeException('RestaurantOps index repair dependency is missing: table '.$tableName.'. Run the preceding RestaurantOps migrations before 000500.');
            }
            foreach ($indexes as $name => $definition) {
                $expectedUnique = $definition['type'] === 'unique';
                $existing = $inspector->indexMetadata($tableName, $name);
                if ($existing !== null) {
                    if ($existing['columns'] !== $definition['columns'] || $existing['unique'] !== $expectedUnique) {
                        throw new RuntimeException(sprintf(
                            'RestaurantOps schema drift: index %s on %s is %s (%s); expected %s (%s).',
                            $name,
                            $inspector->physicalTable($tableName),
                            $existing['unique'] ? 'unique' : 'non-unique',
                            implode(', ', $existing['columns']),
                            $expectedUnique ? 'unique' : 'non-unique',
                            implode(', ', $definition['columns']),
                        ));
                    }

                    continue;
                }

                $obsoleteName = $this->obsoleteGeneratedIndex($inspector, $tableName, $definition['columns'], $expectedUnique);
                if ($obsoleteName !== null) {
                    Schema::table($tableName, function (Blueprint $table) use ($obsoleteName, $name): void {
                        $table->renameIndex($obsoleteName, $name);
                    });

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
        // These indexes belong to the original create migrations. A repair rollback
        // must not remove valid schema that it may only have verified or renamed.
    }

    /** @param list<string> $columns */
    private function obsoleteGeneratedIndex(MySqlSchemaInspector $inspector, string $table, array $columns, bool $unique): ?string
    {
        $suffix = $unique ? 'unique' : 'index';
        $generatedNames = [
            $table.'_'.implode('_', $columns).'_'.$suffix,
            $inspector->physicalTable($table).'_'.implode('_', $columns).'_'.$suffix,
        ];

        foreach ($inspector->indexes($table) as $candidate => $definition) {
            if (in_array($candidate, $generatedNames, true)
                && $definition['columns'] === $columns
                && $definition['unique'] === $unique) {
                return $candidate;
            }
        }

        return null;
    }
};
