<?php

declare(strict_types=1);

namespace Naxas\RestaurantOps\Support;

use Illuminate\Database\ConnectionInterface;
use RuntimeException;

final class MySqlSchemaInspector
{
    public function __construct(private readonly ConnectionInterface $connection) {}

    public function assertMySql(): void
    {
        if ($this->connection->getDriverName() !== 'mysql') {
            throw new RuntimeException('RestaurantOps index repair requires MySQL; active driver is '.$this->connection->getDriverName().'.');
        }
    }

    public function tableExists(string $table): bool
    {
        return (bool) $this->connection->selectOne(
            'SELECT EXISTS (SELECT 1 FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?) AS found',
            [$this->physicalTable($table)],
        )->found;
    }

    /** @return array{columns:list<string>, unique:bool}|null */
    public function indexMetadata(string $table, string $name): ?array
    {
        $rows = $this->connection->select(
            'SELECT COLUMN_NAME, NON_UNIQUE FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND INDEX_NAME = ? ORDER BY SEQ_IN_INDEX',
            [$this->physicalTable($table), $name],
        );
        if ($rows === []) {
            return null;
        }

        return [
            'columns' => array_map(fn (object $row): string => $row->COLUMN_NAME, $rows),
            'unique' => (int) $rows[0]->NON_UNIQUE === 0,
        ];
    }

    /** @return array<string, array{columns:list<string>, unique:bool}> */
    public function indexes(string $table): array
    {
        $rows = $this->connection->select(
            'SELECT INDEX_NAME, COLUMN_NAME, NON_UNIQUE FROM information_schema.STATISTICS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? ORDER BY INDEX_NAME, SEQ_IN_INDEX',
            [$this->physicalTable($table)],
        );
        $indexes = [];
        foreach ($rows as $row) {
            $indexes[$row->INDEX_NAME] ??= ['columns' => [], 'unique' => (int) $row->NON_UNIQUE === 0];
            $indexes[$row->INDEX_NAME]['columns'][] = $row->COLUMN_NAME;
        }

        return $indexes;
    }

    /** @return array{columns:list<string>, referenced_table:string, referenced_columns:list<string>}|null */
    public function foreignKey(string $table, string $name): ?array
    {
        $rows = $this->connection->select(
            "SELECT k.COLUMN_NAME, k.REFERENCED_TABLE_NAME, k.REFERENCED_COLUMN_NAME
             FROM information_schema.TABLE_CONSTRAINTS c
             JOIN information_schema.KEY_COLUMN_USAGE k
               ON k.CONSTRAINT_SCHEMA = c.CONSTRAINT_SCHEMA AND k.TABLE_NAME = c.TABLE_NAME AND k.CONSTRAINT_NAME = c.CONSTRAINT_NAME
             WHERE c.CONSTRAINT_SCHEMA = DATABASE() AND c.TABLE_NAME = ? AND c.CONSTRAINT_NAME = ? AND c.CONSTRAINT_TYPE = 'FOREIGN KEY'
             ORDER BY k.ORDINAL_POSITION",
            [$this->physicalTable($table), $name],
        );
        if ($rows === []) {
            return null;
        }

        return [
            'columns' => array_map(fn (object $row): string => $row->COLUMN_NAME, $rows),
            'referenced_table' => $rows[0]->REFERENCED_TABLE_NAME,
            'referenced_columns' => array_map(fn (object $row): string => $row->REFERENCED_COLUMN_NAME, $rows),
        ];
    }

    public function physicalTable(string $table): string
    {
        return $this->connection->getTablePrefix().$table;
    }
}
