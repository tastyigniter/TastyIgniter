<?php

namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class DropForeignKeyConstraintsOnAllTables extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        foreach ($this->getForeignConstraints() as $tableName => $constraints) {
            foreach ($constraints as $options) {
                $this->dropForeignKey($tableName, $options);
            }
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
    }

    protected function dropForeignKey($tableName, $options)
    {
        try {
            Schema::table($tableName, function (Blueprint $table) use ($options, $tableName) {
                $keys = (array)$options[1];
                $foreignKey = $keys[0];

                $table->dropForeign([$foreignKey]);
                $table->dropIndex(sprintf('%s%s_%s_foreign', DB::getTablePrefix(), $tableName, $foreignKey));
            });
        }
        catch (\Exception $ex) {
            Log::error($ex);
        }
    }

    protected function getForeignConstraints(): array
    {
        return [
            'currencies' => [
                ['countries', 'country_id', 'nullOnDelete' => true],
            ],
            'mail_layouts' => [
                ['languages', 'language_id', 'nullOnDelete' => true],
            ],
            'mail_templates' => [
                ['mail_layouts', 'layout_id', 'nullOnDelete' => true],
            ],
        ];
    }
}
