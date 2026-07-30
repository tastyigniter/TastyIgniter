<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class StrictMysqlTimestampPatchTest extends TestCase
{
    private string $patch;

    protected function setUp(): void
    {
        $this->patch = file_get_contents(dirname(__DIR__, 2).'/patches/tastyigniter-core-strict-mysql-timestamps.patch');
    }

    public static function partialStates(): iterable
    {
        yield 'fresh schema' => [false, false, 'add'];
        yield 'old legacy column only' => [true, false, 'rename'];
        yield 'new renamed column only' => [false, true, 'normalize'];
        yield 'both columns' => [true, true, 'throw'];
    }

    #[DataProvider('partialStates')]
    public function test_legacy_conversion_state_machine(bool $old, bool $new, string $expected): void
    {
        $actual = match (true) {
            $old && $new => 'throw',
            $old => 'rename',
            $new => 'normalize',
            default => 'add',
        };

        $this->assertSame($expected, $actual);
    }

    public function test_patch_guards_tables_and_columns_for_partial_reruns(): void
    {
        $this->assertStringContainsString('Schema::hasTable($table)', $this->patch);
        $this->assertStringContainsString('Schema::hasColumn($table, $column)', $this->patch);
        $this->assertStringContainsString('Schema::hasColumn($table, $oldColumn)', $this->patch);
        $this->assertStringContainsString('Schema::hasColumn($table, $newColumn)', $this->patch);
        $this->assertStringContainsString('both [%s] and [%s] exist', $this->patch);
    }

    public function test_all_resulting_definitions_are_nullable_without_zero_dates(): void
    {
        $this->assertStringContainsString('TIMESTAMP NULL DEFAULT NULL', $this->patch);
        $this->assertStringContainsString('->nullable()->default(null)', $this->patch);
        $this->assertStringNotContainsString("DEFAULT '0000-00-00 00:00:00'", $this->patch);
    }

    public function test_all_original_tables_are_handled(): void
    {
        foreach (['countries', 'currencies', 'languages', 'mail_layouts', 'mail_templates', 'themes'] as $table) {
            $this->assertStringContainsString("'$table'", $this->patch);
        }
    }
}
