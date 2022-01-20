<?php

namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyConstraintsToTables extends Migration
{
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        foreach ($this->getForeignConstraints() as $tableName => $constraints) {
            foreach ($constraints as $options) {
                $this->addForeignKey($tableName, $options);
            }
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down()
    {
        foreach ($this->getForeignConstraints() as $tableName => $constraints) {
            foreach ($constraints as $options) {
                $this->dropForeignKey($tableName, $options);
            }
        }
    }

    protected function addForeignKey($tableName, $options)
    {
        Schema::table($tableName, function (Blueprint $table) use ($options) {
            $foreignTableName = $options[0];

            $keys = (array)$options[1];
            $foreignKey = $keys[0];
            $parentKey = $keys[1] ?? $keys[0];

            $blueprint = $table->foreignId($foreignKey);

            if (array_get($options, 'nullable', TRUE))
                $blueprint->nullable();

            $blueprint->change();

            $table->foreign($foreignKey)
                ->references($parentKey)
                ->on($foreignTableName)
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    protected function dropForeignKey($tableName, $options)
    {
        try {
            Schema::table($tableName, function (Blueprint $table) use ($options) {
                $keys = (array)$options[1];
                $foreignKey = $keys[0];

                $table->dropForeign([$foreignKey]);
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
                ['countries', 'country_id', 'nullOnDelete' => TRUE],
            ],
            'mail_layouts' => [
                ['languages', 'language_id', 'nullOnDelete' => TRUE],
            ],
            'mail_templates' => [
                ['mail_layouts', 'layout_id', 'nullOnDelete' => TRUE],
            ],
        ];
    }
}
