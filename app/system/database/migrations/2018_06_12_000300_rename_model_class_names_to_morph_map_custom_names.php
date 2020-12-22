<?php

namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Rename existing model class_names in all tables
 * with morph map custom names.
 */
class RenameModelClassNamesToMorphMapCustomNames extends Migration
{
    protected $morphMap;

    public function up()
    {
        $morphMap = \Illuminate\Database\Eloquent\Relations\Relation::$morphMap;
        $this->morphMap = array_flip($morphMap);

        $this->updateMorphClassName([
            'activities' => ['subject_type', 'causer_type'],
            'status_history' => ['object_type'],
        ]);
    }

    public function down()
    {
        //
    }

    protected function updateMorphClassName($definitions)
    {
        collect($definitions)->each(function ($columns, $tableName) {
            if (!Schema::hasTable($tableName))
                return;

            DB::table($tableName)->get()->each(function ($model) use ($tableName, $columns) {
                $columnsToUpdate = [];
                foreach ($columns as $column) {
                    $columnValue = $model->{$column};

                    if (!$columnValue) continue;

                    if (!array_key_exists($columnValue, $this->morphMap)) continue;

                    $columnsToUpdate[$column] = array_get($this->morphMap, $columnValue);
                }

                $keyName = str_singular($tableName).'_id';
                DB::table($tableName)
                    ->where($keyName, $model->{$keyName})
                    ->update($columnsToUpdate);
            });
        });
    }
}
