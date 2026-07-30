<?php

declare(strict_types=1);

namespace Igniter\Admin\Traits;

use Igniter\Flame\Exception\FlashException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Form Model Widget Trait
 *
 * Special logic for form widgets that use a database stored model.
 */
trait FormModelWidget
{
    use PopulatesModelAttributes;

    public function createFormModel(): Model
    {
        if (!property_exists($this, 'modelClass') || !$this->modelClass) {
            throw new FlashException(sprintf(lang('igniter::admin.alert_missing_field_property'), $this::class));
        }

        $class = $this->modelClass;

        return new $class;
    }

    public function findFormModel(int|string $recordId): Model
    {
        throw_unless(!empty($recordId = strip_tags((string)$recordId)),
            new FlashException(lang('igniter::admin.form.missing_id')),
        );

        $model = $this->createFormModel();

        // Prepare query and find model record
        $query = $model->newQuery();

        /** @var Model $result */
        throw_unless($result = $query->find($recordId),
            new FlashException(sprintf(lang('igniter::admin.form.record_not_found_in_model'), $recordId, $model::class)),
        );

        return $result;
    }

    /**
     * Returns the final model and attribute name of
     * a nested HTML array attribute.
     * Eg: list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);
     */
    public function resolveModelAttribute(?string $attribute = null): array
    {
        return property_exists($this, 'formField')
            ? $this->formField->resolveModelAttribute($this->model, $attribute)
            : [null, null];
    }

    /** Returns the model of a relation type. */
    protected function getRelationModel(): Model
    {
        [$model, $attribute] = $this->resolveModelAttribute(
            property_exists($this, 'valueFrom') ? $this->valueFrom : null,
        );

        if (!$model || !$this->hasModelRelation($model, (string)$attribute)) {
            throw new FlashException(sprintf(lang('igniter::admin.alert_missing_model_definition'),
                $this->model::class, property_exists($this, 'valueFrom') ? $this->valueFrom : null,
            ));
        }

        return $this->makeModelRelation($model, (string)$attribute);
    }

    protected function getRelationObject(): Relation
    {
        [$model, $attribute] = $this->resolveModelAttribute(
            property_exists($this, 'valueFrom') ? $this->valueFrom : null,
        );

        if (!$model || !$this->hasModelRelation($model, (string)$attribute)) {
            throw new FlashException(sprintf(lang('igniter::admin.alert_missing_model_definition'),
                $this->model::class, property_exists($this, 'valueFrom') ? $this->valueFrom : null,
            ));
        }

        return $model->{$attribute}();
    }

    protected function getRelationType(): string
    {
        [$model, $attribute] = $this->resolveModelAttribute(
            property_exists($this, 'valueFrom') ? $this->valueFrom : null,
        );

        return $model ? $this->getModelRelationType($model, (string)$attribute) : '';
    }

    protected function makeModelRelation(Model $model, string $attribute): mixed
    {
        if (method_exists($model, 'makeRelation')) {
            return $model->makeRelation($attribute);
        }

        return $model->{$attribute}()->getModel();
    }
}
