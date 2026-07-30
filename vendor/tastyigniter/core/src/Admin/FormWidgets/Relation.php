<?php

declare(strict_types=1);

namespace Igniter\Admin\FormWidgets;

use Igniter\Admin\Classes\BaseFormWidget;
use Igniter\Admin\Classes\FormField;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\SystemException;
use Igniter\Local\Traits\LocationAwareWidget;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\Relation as RelationBase;
use Illuminate\Support\Facades\DB;
use Override;

/**
 * Form Relationship
 * Renders a field prepopulated with a belongsTo and belongsToHasMany relation.
 *
 * Adapted from october\backend\formwidgets\Relation
 */
class Relation extends BaseFormWidget
{
    use LocationAwareWidget;

    //
    // Configurable properties
    //

    /** Relation name, if this field name does not represents a model relationship. */
    public ?string $relationFrom = null;

    /** Model column to use for the name reference */
    public string $nameFrom = 'name';

    /** Custom SQL column selection to use for the name reference */
    public ?string $sqlSelect = null;

    /** Empty value to use if the relation is singluar (belongsTo) */
    public ?string $emptyOption = null;

    /** Use a custom scope method for the list query. */
    public ?string $scope = null;

    /** Define the order of the list query. */
    public ?string $order = null;

    //
    // Object properties
    //

    protected string $defaultAlias = 'relation';

    public Model $relatedModel;

    #[Override]
    public function initialize(): void
    {
        $this->fillFromConfig([
            'relationFrom',
            'nameFrom',
            'emptyOption',
            'scope',
            'order',
        ]);

        if (isset($this->config['select'])) {
            $this->sqlSelect = $this->config['select'];
        }
    }

    #[Override]
    public function render(): string
    {
        $this->prepareVars();

        return $this->makePartial('relation/relation');
    }

    #[Override]
    public function getSaveValue(mixed $value): mixed
    {
        if ($this->formField->disabled || $this->formField->hidden) {
            return FormField::NO_SAVE_DATA;
        }

        if (is_string($value) && !strlen($value)) {
            return null;
        }

        if (is_array($value) && $value === []) {
            return null;
        }

        return $value;
    }

    public function prepareVars(): void
    {
        $this->vars['field'] = $this->makeFormField();
    }

    /**
     * Returns the final model and attribute name of
     * a nested HTML array attribute.
     * Eg: list($model, $attribute) = $this->resolveModelAttribute($this->valueFrom);
     */
    public function resolveModelAttribute(string $attribute): array
    {
        $attribute = $this->relationFrom ?: $attribute;

        return $this->formField->resolveModelAttribute($this->model, $attribute);
    }

    /**
     * Makes the form object used for rendering a simple field type
     */
    protected function makeFormField(): FormField
    {
        return RelationBase::noConstraints(function(): FormField {
            $field = clone $this->formField;
            $relationObject = $this->getRelationObject();
            $query = $relationObject->newQuery();

            $this->locationApplyScope($query);

            [$model, $attribute] = $this->resolveModelAttribute($this->valueFrom);
            $relationType = $model->getRelationType($attribute);
            $this->relatedModel = $model->makeRelation($attribute);

            $field->type = 'selectlist';
            if (in_array($relationType, ['belongsToMany', 'morphToMany', 'morphedByMany', 'hasMany'])) {
                $field->config['mode'] = 'checkbox';
            } elseif (in_array($relationType, ['belongsTo', 'hasOne'])) {
                $field->config['mode'] = 'radio';
            }

            if ($this->order) {
                $query->orderByRaw($this->order);
            } elseif (method_exists($this->relatedModel, 'scopeSorted')) {
                $query->sorted();
            }

            $field->value = $this->processFieldValue($this->getLoadValue(), $this->relatedModel);
            $field->placeholder = $field->placeholder ?: $this->emptyOption;

            // It is safe to assume that if the model and related model are of
            // the exact same class, then it cannot be related to itself
            if ($model->exists && ($model::class === $this->relatedModel::class)) {
                $query->where($this->relatedModel->getKeyName(), '<>', $model->getKey());
            }

            // Even though "no constraints" is applied, belongsToMany constrains the query
            // by joining its pivot table. Remove all joins from the query.
            $query->getQuery()->getQuery()->joins = [];

            if ($scopeMethod = $this->scope) {
                $query->$scopeMethod($model);
            }

            // The "sqlSelect" config takes precedence over "nameFrom".
            // A virtual column called "selection" will contain the result.
            // Tree models must select all columns to return parent columns, etc.
            if ($this->sqlSelect) {
                $nameFrom = 'selection';
                $selectColumn = $this->relatedModel->getKeyName();
                $result = $query->select($selectColumn, DB::raw($this->sqlSelect.' AS '.$nameFrom));
            } else {
                $nameFrom = $this->nameFrom;
                $result = $query->getQuery()->get();
            }

            $field->options = $result->pluck($nameFrom, $this->relatedModel->getKeyName())->all();

            return $field;
        });
    }

    protected function processFieldValue(mixed $value, Model $model)
    {
        if ($value instanceof Collection) {
            $value = $value->pluck($model->getKeyName())->toArray();
        }

        return $value;
    }

    /**
     * Returns the value as a relation object from the model,
     * supports nesting via HTML array.
     */
    protected function getRelationObject(): RelationBase
    {
        [$model, $attribute] = $this->resolveModelAttribute($this->valueFrom);

        if (!$model || !$model->hasRelation($attribute)) {
            throw new SystemException(sprintf(lang('igniter::admin.alert_missing_model_definition'),
                $this->model::class, $this->valueFrom,
            ));
        }

        return $model->{$attribute}();
    }
}
