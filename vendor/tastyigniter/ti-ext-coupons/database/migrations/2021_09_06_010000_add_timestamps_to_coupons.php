<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $couponsHadUpdatedAt = Schema::hasTable('igniter_coupons')
            && Schema::hasColumn('igniter_coupons', 'updated_at');

        $this->convertLegacyTimestamp('igniter_coupons', 'date_added', 'created_at');
        $this->ensureNullableTimestamp('igniter_coupons', 'updated_at');

        if (!$couponsHadUpdatedAt && Schema::hasTable('igniter_coupons')) {
            $connection = Schema::getConnection();
            $qualifiedTable = $this->quoteIdentifier($connection->getTablePrefix().'igniter_coupons');
            $connection->statement("UPDATE {$qualifiedTable} SET `updated_at` = `created_at`");
        }

        $this->convertLegacyTimestamp('igniter_coupons_history', 'date_used', 'created_at');
        $this->ensureNullableTimestamp('igniter_coupons_history', 'updated_at');
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

        $connection->statement("ALTER TABLE {$qualifiedTable} MODIFY {$quotedLegacyColumn} TIMESTAMP NULL DEFAULT NULL");
        $connection->statement(
            "UPDATE {$qualifiedTable} SET {$quotedLegacyColumn} = NULL "
            ."WHERE CAST({$quotedLegacyColumn} AS CHAR) IN ('', '0000-00-00', '0000-00-00 00:00:00')",
        );
        $connection->statement(
            "ALTER TABLE {$qualifiedTable} CHANGE {$quotedLegacyColumn} {$quotedNewColumn} TIMESTAMP NULL DEFAULT NULL",
        );
    }

    private function quoteIdentifier(string $identifier): string
    {
        return '`'.str_replace('`', '``', $identifier).'`';
    }

    public function down(): void {}
};
