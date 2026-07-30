<?php

declare(strict_types=1);

namespace Igniter\Pages\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tableName = DB::getTablePrefix().'pages';
        $primaryKey = 'page_id';
        $driver = DB::getDriverName();

        switch ($driver) {
            case 'mysql':
                $this->ensurePrimaryKeyHasAutoIncrementForMysql($tableName, $primaryKey);
                break;
            case 'pgsql':
                $this->ensurePrimaryKeyHasAutoIncrementForPostgresql($tableName, $primaryKey);
                break;
        }
    }

    public function down(): void {}

    protected function ensurePrimaryKeyHasAutoIncrementForMysql(string $tableName, string $primaryKey): void
    {
        $columnInfo = DB::selectOne('
            SELECT EXTRA 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
              AND TABLE_NAME = ? 
              AND COLUMN_NAME = ?
        ', [$tableName, $primaryKey]);

        if (!isset($columnInfo->EXTRA) || stripos($columnInfo->EXTRA, 'auto_increment') === false) {
            DB::statement(sprintf('ALTER TABLE `%s` MODIFY `%s` INT NOT NULL AUTO_INCREMENT;', $tableName, $primaryKey));
        }
    }

    protected function ensurePrimaryKeyHasAutoIncrementForPostgresql(string $tableName, string $primaryKey): void
    {
        // Check if the column is backed by a sequence
        $sequenceCheck = DB::selectOne('
        SELECT pg_get_serial_sequence(?, ?) AS sequence
    ', [$tableName, $primaryKey]);

        if (isset($sequenceCheck->sequence)) {
            // Check if the default value is set to use the sequence
            $defaultCheck = DB::selectOne('
            SELECT column_default 
            FROM information_schema.columns 
            WHERE table_name = ? 
              AND column_name = ?
        ', [$tableName, $primaryKey]);

            if (!str_contains($defaultCheck->column_default ?? '', 'nextval')) {
                DB::statement(sprintf("ALTER TABLE %s ALTER COLUMN %s SET DEFAULT nextval('%s');", $tableName, $primaryKey, $sequenceCheck->sequence));
            }
        } else {
            // Create a new sequence and link it to the column
            $sequenceName = sprintf('%s_%s_seq', $tableName, $primaryKey);
            DB::statement(sprintf('CREATE SEQUENCE %s;', $sequenceName));
            DB::statement(sprintf("ALTER TABLE %s ALTER COLUMN %s SET DEFAULT nextval('%s');", $tableName, $primaryKey, $sequenceName));
            DB::statement(sprintf('ALTER SEQUENCE %s OWNED BY %s.%s;', $sequenceName, $tableName, $primaryKey));
        }
    }
};
