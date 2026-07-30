<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        foreach ([
            'addresses',
            'allergens',
            'categories',
            'customer_groups',
            'locations',
            'mealtimes',
            'menus',
            'menu_options',
            'menu_item_options',
            'menu_item_option_values',
            'menus_specials',
            'staff_groups',
            'statuses',
            'tables',
            'admin_users',
        ] as $table) {
            $this->ensureNullableTimestamp($table, 'created_at');
            $this->ensureNullableTimestamp($table, 'updated_at');
        }

        $this->convertLegacyTimestamp('customers', 'date_added', 'created_at');
        $this->ensureNullableTimestamp('customers', 'updated_at');

        $this->convertLegacyTimestamp('orders', 'date_added', 'created_at');
        $this->convertLegacyTimestamp('orders', 'date_modified', 'updated_at');

        $this->convertLegacyTimestamp('payments', 'date_added', 'created_at');
        $this->convertLegacyTimestamp('payments', 'date_updated', 'updated_at');

        $this->convertLegacyTimestamp('payment_logs', 'date_added', 'created_at');
        $this->convertLegacyTimestamp('payment_logs', 'date_updated', 'updated_at');

        $this->convertLegacyTimestamp('reservations', 'date_added', 'created_at');
        $this->convertLegacyTimestamp('reservations', 'date_modified', 'updated_at');

        $this->convertLegacyTimestamp('staffs', 'date_added', 'created_at');
        $this->ensureNullableTimestamp('staffs', 'updated_at');

        $this->convertLegacyTimestamp('status_history', 'date_added', 'created_at');
        $this->ensureNullableTimestamp('status_history', 'updated_at');
    }

    private function ensureNullableTimestamp(string $table, string $column): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $connection = Schema::getConnection();
        $qualifiedTable = $this->quoteIdentifier($connection->getTablePrefix().$table);
        $quotedColumn = $this->quoteIdentifier($column);

        if (!Schema::hasColumn($table, $column)) {
            $connection->statement("ALTER TABLE {$qualifiedTable} ADD {$quotedColumn} TIMESTAMP NULL DEFAULT NULL");

            return;
        }

        $connection->statement("ALTER TABLE {$qualifiedTable} MODIFY {$quotedColumn} TIMESTAMP NULL DEFAULT NULL");
    }

    private function convertLegacyTimestamp(string $table, string $legacyColumn, string $newColumn): void
    {
        if (!Schema::hasTable($table)) {
            return;
        }

        $hasLegacyColumn = Schema::hasColumn($table, $legacyColumn);
        $hasNewColumn = Schema::hasColumn($table, $newColumn);

        if ($hasLegacyColumn && $hasNewColumn) {
            throw new \RuntimeException(sprintf(
                'Ambiguous timestamp migration for table [%s]: both [%s] and [%s] exist.',
                $table,
                $legacyColumn,
                $newColumn,
            ));
        }

        if (!$hasLegacyColumn) {
            $this->ensureNullableTimestamp($table, $newColumn);

            return;
        }

        $connection = Schema::getConnection();
        $qualifiedTable = $this->quoteIdentifier($connection->getTablePrefix().$table);
        $quotedLegacyColumn = $this->quoteIdentifier($legacyColumn);
        $quotedNewColumn = $this->quoteIdentifier($newColumn);

        $connection->statement(
            "ALTER TABLE {$qualifiedTable} MODIFY {$quotedLegacyColumn} TIMESTAMP NULL DEFAULT NULL",
        );
        $connection->statement(
            "UPDATE {$qualifiedTable} SET {$quotedLegacyColumn} = NULL "
            ."WHERE CAST({$quotedLegacyColumn} AS CHAR) IN ('', '0000-00-00 00:00:00')",
        );
        $connection->statement(
            "ALTER TABLE {$qualifiedTable} CHANGE {$quotedLegacyColumn} {$quotedNewColumn} "
            .'TIMESTAMP NULL DEFAULT NULL',
        );
    }

    private function quoteIdentifier(string $identifier): string
    {
        return '`'.str_replace('`', '``', $identifier).'`';
    }

    public function down() {}
};
