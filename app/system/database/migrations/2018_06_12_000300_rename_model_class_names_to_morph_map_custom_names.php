<?php namespace System\Database\Migrations;

use Illuminate\Database\Migrations\Migration;

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
            '\System\Models\Activities_model' => ['subject_type', 'causer_type'],
            '\System\Models\Message_meta_model' => ['messageable_type'],
            '\System\Models\Messages_model' => ['sender_type'],
            '\Admin\Models\Reviews_model' => ['sale_type'],
            '\Admin\Models\Status_history_model' => ['object_type'],
        ]);
    }

    public function down()
    {
        //
    }

    protected function updateMorphClassName($definitions)
    {
        collect($definitions)->each(function ($columns, $className) {
            $className::all()->each(function ($model) use ($columns) {

                foreach ($columns as $column) {
                    $columnValue = $model->{$column};

                    if (!$columnValue) continue;

                    if (!array_key_exists($columnValue, $this->morphMap)) continue;

                    $model->{$column} = array_get($this->morphMap, $columnValue);
                }

                $model->timestamps = FALSE;
                $model->save();
            });
        });
    }
}
