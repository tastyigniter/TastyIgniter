<?php

declare(strict_types=1);

namespace Igniter\Automation\Classes;

use Illuminate\Support\Str;
use Override;

class BaseModelAttributesCondition extends BaseCondition
{
    protected array $operators = [
        'is' => 'is',
        'is_not' => 'is not',
        'contains' => 'contains',
        'does_not_contain' => 'does not contain',
        'equals_or_greater' => 'equals or greater than',
        'equals_or_less' => 'equals or less than',
        'greater' => 'greater than',
        'less' => 'less than',
    ];

    protected $modelAttributes;

    #[Override]
    public function initConfigData($model): void
    {
        $model->operator = 'is';
    }

    /**
     * @return array<string, string|array>
     */
    public function defineModelAttributes()
    {
        return [];
    }

    #[Override]
    public function getConditionDescription(): string
    {
        $model = $this->model;
        $attributes = $this->listModelAttributes();
        $subConditions = $model->options ?? [];

        $result = collect($subConditions)->sortBy('priority')->map(function($subCondition) use ($attributes): string {
            $attribute = array_get($subCondition, 'attribute');
            $operator = array_get($subCondition, 'operator');
            $value = array_get($subCondition, 'value');

            $result = $this->getConditionAttributePrefix($attribute, $attributes);
            $result .= ' <b>'.array_get($this->operators, $operator, $operator).'</b> ';

            return $result.$value;
        })->toArray();

        return implode(' <b>AND</b> ', $result);
    }

    protected function getConditionAttributePrefix($attribute, array $attributes)
    {
        $result = [];
        if (isset($attributes[$attribute])) {
            $result = $attributes[$attribute];
        }

        return array_get($result, 'label', 'Unknown attribute');
    }

    public function getAttributeOptions(): array
    {
        return array_map(fn($attribute) => array_get($attribute, 'label'), $this->listModelAttributes());
    }

    public function getOperatorOptions(): array
    {
        return $this->operators;
    }

    /**
     * Checks whether the condition is TRUE for a specified model
     * @return bool
     */
    public function evalIsTrue($modelToEval)
    {
        $attributes = $this->listModelAttributes();
        $subConditions = $this->model->options ?? [];

        $success = false;

        collect($subConditions)->sortBy('priority')->each(function($subCondition) use (&$success, $modelToEval, $attributes) {
            $attribute = array_get($subCondition, 'attribute');
            $attributeType = array_get($attributes, $attribute.'.type');

            if ($attributeType == 'string') {
                $success = $this->evalAttributeStringType($modelToEval, $subCondition);
            }

            return $success;
        });

        return $success;
    }

    protected function listModelAttributes()
    {
        if ($this->modelAttributes) {
            return $this->modelAttributes;
        }

        $attributes = array_map(function(array|string $info): array {
            if (is_string($info)) {
                $info = ['label' => $info];
            }

            if (!isset($info['type'])) {
                $info['type'] = 'string';
            }

            return $info;
        }, $this->defineModelAttributes());

        return $this->modelAttributes = $attributes;
    }

    protected function evalAttributeStringType($model, $subCondition)
    {
        $attribute = array_get($subCondition, 'attribute');
        $operator = array_get($subCondition, 'operator');
        $conditionValue = array_get($subCondition, 'value');
        $conditionValue = is_array($conditionValue) ? $conditionValue : mb_strtolower(trim((string)$conditionValue));

        $modelValue = $this->getModelEvalAttribute($model, $attribute, $subCondition);

        if ($operator === 'is') {
            return $modelValue == $conditionValue;
        }

        if ($operator === 'is_not') {
            return $modelValue != $conditionValue;
        }

        if ($operator === 'contains') {
            return is_array($conditionValue)
                ? in_array($modelValue, $conditionValue)
                : str_contains($modelValue, $conditionValue);
        }

        if ($operator === 'does_not_contain') {
            return is_array($conditionValue)
                ? in_array($modelValue, $conditionValue) === false
                : !str_contains($modelValue, $conditionValue);
        }

        if ($operator === 'equals_or_greater') {
            return $modelValue >= $conditionValue;
        }

        if ($operator === 'equals_or_less') {
            return $modelValue <= $conditionValue;
        }

        if ($operator === 'greater') {
            return $modelValue > $conditionValue;
        }

        if ($operator === 'less') {
            return $modelValue < $conditionValue;
        }

        return false;
    }

    protected function getModelEvalAttribute($model, $attribute, $condition = []): string
    {
        $value = $model->{$attribute};

        if (method_exists($this, 'get'.Str::studly($attribute).'Attribute')) {
            $value = $this->{'get'.Str::studly($attribute).'Attribute'}($value, $model, $condition);
        }

        return mb_strtolower(trim((string)$value));
    }

    protected function applyDateRange($query, $attribute, array $options)
    {
        $from = $this->getDateRangeFrom($options);
        $to = $this->getDateRangeTo($options);
        if ($from && $to) {
            $query->whereBetween($attribute, [$from, $to]);
        }

        return $query;
    }

    protected function getDateRangeFrom(array $options)
    {
        if (array_get($options, 'when') === 'is_current') {
            return now()->startOf(array_get($options, 'current', 'day'))->toDateTimeString();
        }

        if (array_get($options, 'when') === 'is_past') {
            return now()
                ->parse('- '.str_replace('_', ' ', array_get($options, 'range', '1_day')))
                ->startOfDay()
                ->toDateTimeString();
        }

        return null;
    }

    protected function getDateRangeTo(array $options)
    {
        if (array_get($options, 'when') === 'is_current') {
            return now()->endOf(array_get($options, 'current', 'day'))->toDateTimeString();
        }

        if (array_get($options, 'when') === 'is_past') {
            return now()->endOfDay()->toDateTimeString();
        }

        return null;
    }
}
