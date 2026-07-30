<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Classes;

use Carbon\Carbon;
use Igniter\Automation\Classes\BaseModelAttributesCondition;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Model;
use Mockery;
use stdClass;

it('initialises config data', function(): void {
    $model = Mockery::mock(Model::class)->makePartial();
    $condition = new class($model) extends BaseModelAttributesCondition
    {
        public function getModel(): ?Model
        {
            return $this->model;
        }
    };

    expect($condition->getModel())->operator->toBe('is');
});

it('defines model attributes', function(): void {
    $condition = new BaseModelAttributesCondition;

    expect($condition->defineModelAttributes())->toBeArray();
});

it('returns attribute labels from listModelAttributes', function(): void {
    $condition = new class extends BaseModelAttributesCondition
    {
        public function defineModelAttributes(): array
        {
            return [
                'attribute1' => 'Label 1',
                'attribute2' => ['label' => 'Label 2'],
            ];
        }
    };

    $result = $condition->getAttributeOptions();

    expect($result)->toBe([
        'attribute1' => 'Label 1',
        'attribute2' => 'Label 2',
    ]);

    $result = $condition->getAttributeOptions();

    expect($result)->toBeArray('Test modelAttrbiutes is set');
});

it('returns an empty array when no model attributes are defined', function(): void {
    $condition = new BaseModelAttributesCondition;

    $result = $condition->getAttributeOptions();

    expect($result)->toBe([]);
});

it('returns the correct operator options', function(): void {
    $condition = new BaseModelAttributesCondition;

    $result = $condition->getOperatorOptions();

    expect($result)->toBe([
        'is' => 'is',
        'is_not' => 'is not',
        'contains' => 'contains',
        'does_not_contain' => 'does not contain',
        'equals_or_greater' => 'equals or greater than',
        'equals_or_less' => 'equals or less than',
        'greater' => 'greater than',
        'less' => 'less than',
    ]);
});

it('evalIsTrue returns false when no subconditions', function(): void {
    $modelToEval = new stdClass;
    $baseModelAttributesCondition = new BaseModelAttributesCondition;
    expect($baseModelAttributesCondition->evalIsTrue($modelToEval))->toBeFalse();
});

it('evalIsTrue returns false when matching operator', function(): void {
    $operator = 'invalid';
    $modelToEval = new stdClass;
    $modelToEval->attribute = 'test';
    $baseModelAttributesCondition = new class($operator) extends BaseModelAttributesCondition
    {
        public function __construct($operator)
        {
            $attributes = [
                'options' => [
                    [
                        'attribute' => 'attribute',
                        'operator' => $operator,
                        'value' => null,
                    ],
                ],
            ];

            $this->model = new class($attributes) extends Model {};
        }

        public function defineModelAttributes(): array
        {
            return [
                'attribute' => [
                    'label' => 'Attribute label',
                ],
            ];
        }
    };

    expect($baseModelAttributesCondition->evalIsTrue($modelToEval))->toBeFalse();
});

it('evalIsTrue evaluates string type attribute correctly', function($evalValue, $operator, $value, $eval): void {
    $modelToEval = new stdClass;
    $modelToEval->attribute = $evalValue;

    $baseModelAttributesCondition = new class($operator, $value) extends BaseModelAttributesCondition
    {
        public function __construct($operator, $value)
        {
            $attributes = [
                'options' => [
                    [
                        'attribute' => 'attribute',
                        'operator' => $operator,
                        'value' => $value,
                    ],
                ],
            ];

            $this->model = new class($attributes) extends Model {};
        }

        public function defineModelAttributes(): array
        {
            return [
                'attribute' => [
                    'label' => 'Attribute label',
                ],
            ];
        }
    };

    expect($baseModelAttributesCondition->evalIsTrue($modelToEval))->toBe($eval);
})->with([
    ['test', 'is', 'test', true],
    ['test', 'is', 'wrong', false],
    ['test', 'is_not', 'test', false],
    ['test', 'is_not', 'wrong', true],
    ['test', 'contains', 'es', true],
    ['test', 'contains', 'wrong', false],
    ['test', 'does_not_contain', 'es', false],
    ['test', 'does_not_contain', 'wrong', true],
    ['test', 'contains', ['test'], true],
    ['test', 'contains', ['wrong'], false],
    ['test', 'does_not_contain', ['test'], false],
    ['test', 'does_not_contain', ['wrong'], true],
    [10, 'equals_or_greater', 10, true],
    [10, 'equals_or_greater', 5, true],
    [10, 'equals_or_greater', 15, false],
    [10, 'equals_or_less', 10, true],
    [10, 'equals_or_less', 15, true],
    [10, 'equals_or_less', 5, false],
    [10, 'greater', 5, true],
    [10, 'greater', 15, false],
    [10, 'less', 15, true],
    [10, 'less', 5, false],
]);

it('returns the custom attribute value when custom getter exists', function(): void {
    $modelToEval = new stdClass;
    $modelToEval->test = '  Test Value  ';

    $condition = new class extends BaseModelAttributesCondition
    {
        public function getTestAttribute(): string
        {
            return 'Custom Value';
        }
    };

    $result = callProtectedMethod($condition, 'getModelEvalAttribute', [$modelToEval, 'test']);

    expect($result)->toBe('custom value');
});

it('applies date range when both from and to dates are present', function(): void {
    $this->travelTo(Carbon::parse('2023-01-01 00:00:00'));

    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('whereBetween')->with('created_at', ['2023-01-01 00:00:00', '2023-01-31 23:59:59'])->andReturnSelf();

    $condition = new BaseModelAttributesCondition;
    $options = ['when' => 'is_current', 'current' => 'month'];

    $result = callProtectedMethod($condition, 'applyDateRange', [$query, 'created_at', $options]);

    expect($result)->toBe($query);
});

it('returns null when no date range is specified in getDateRangeFrom', function(): void {
    $condition = new BaseModelAttributesCondition;
    $options = ['when' => 'is_future'];

    $result = callProtectedMethod($condition, 'getDateRangeFrom', [$options]);

    expect($result)->toBeNull();
});

it('returns start of current day for getDateRangeFrom when is_current is specified', function(): void {
    $condition = new BaseModelAttributesCondition;
    $options = ['when' => 'is_current', 'current' => 'day'];

    $result = callProtectedMethod($condition, 'getDateRangeFrom', [$options]);

    expect($result)->toBe(now()->startOfDay()->toDateTimeString());
});

it('returns start of past range for getDateRangeFrom when is_past is specified', function(): void {
    $condition = new BaseModelAttributesCondition;
    $options = ['when' => 'is_past', 'range' => '1_week'];

    $result = callProtectedMethod($condition, 'getDateRangeFrom', [$options]);

    expect($result)->toBe(now()->parse('- 1 week')->startOfDay()->toDateTimeString());
});

it('returns null when no date range is specified in getDateRangeTo', function(): void {
    $condition = new BaseModelAttributesCondition;
    $options = ['when' => 'is_future'];

    $result = callProtectedMethod($condition, 'getDateRangeTo', [$options]);

    expect($result)->toBeNull();
});

it('returns end of current day for getDateRangeTo when is_current is specified', function(): void {
    $condition = new BaseModelAttributesCondition;
    $options = ['when' => 'is_current', 'current' => 'day'];

    $result = callProtectedMethod($condition, 'getDateRangeTo', [$options]);

    expect($result)->toBe(now()->endOfDay()->toDateTimeString());
});

it('returns end of current day for getDateRangeTo when is_past is specified', function(): void {
    $condition = new BaseModelAttributesCondition;
    $options = ['when' => 'is_past'];

    $result = callProtectedMethod($condition, 'getDateRangeTo', [$options]);

    expect($result)->toBe(now()->endOfDay()->toDateTimeString());
});
