<?php

declare(strict_types=1);

namespace Igniter\Admin\Traits;

use Igniter\Admin\Classes\FormField;
use Illuminate\Database\Eloquent\Model;
use LogicException;

trait PopulatesModelAttributes
{
    protected array $modelsToSave = [];

    protected function prepareModelsToSave(?Model $model, mixed $saveData): array
    {
        $this->modelsToSave = [];
        $this->setModelAttributes($model, $saveData);

        return $this->modelsToSave;
    }

    /** Sets a data collection to a model attributes, relations will also be set. */
    protected function setModelAttributes(?Model $model, mixed $saveData)
    {
        $saveData = is_array($saveData) ? $saveData : [];

        $this->modelsToSave[] = $model;

        $singularTypes = ['belongsTo', 'hasOne', 'morphTo', 'morphOne'];
        foreach ($saveData as $attribute => $value) {
            $isNested = ($attribute == 'pivot' || (
                $this->hasModelRelation($model, $attribute) &&
                in_array($this->getModelRelationType($model, $attribute), $singularTypes)
            ));

            if ($isNested && is_array($value) && isset($model->{$attribute})) {
                $this->setModelAttributes($model->{$attribute}, $value);
            } elseif ($value !== FormField::NO_SAVE_DATA) {
                if (!starts_with($attribute, '_')) {
                    $model->{$attribute} = $value;
                }
            }
        }
    }

    protected function getModelRelationType(Model $model, int|string $attribute)
    {
        if (method_exists($model, 'getRelationType')) {
            return $model->getRelationType($attribute);
        }

        throw new LogicException('Model does not implement getRelationType method');
    }

    protected function hasModelRelation(Model $model, string $attribute): bool
    {
        if (method_exists($model, 'hasRelation')) {
            return $model->hasRelation($attribute);
        }

        return method_exists($model, $attribute);
    }
}
