<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Models;

use Igniter\Automation\AutomationException;
use Igniter\Automation\Classes\BaseAction;
use Igniter\Automation\Models\AutomationRule;
use Igniter\Automation\Models\RuleAction;
use Igniter\Flame\Database\Traits\Validation;
use Mockery;

it('returns action name from action object', function(): void {
    $actionObject = Mockery::mock(BaseAction::class);
    $actionObject->shouldReceive('getActionName')->andReturn('Sample Action Name');

    $ruleAction = Mockery::mock(RuleAction::class)->makePartial();
    $ruleAction->shouldReceive('getActionObject')->andReturn($actionObject);

    expect($ruleAction->getNameAttribute())->toBe('Sample Action Name');
});

it('returns action description from action object', function(): void {
    $actionObject = Mockery::mock(BaseAction::class);
    $actionObject->shouldReceive('getActionDescription')->andReturn('Sample Action Description');

    $ruleAction = Mockery::mock(RuleAction::class)->makePartial();
    $ruleAction->shouldReceive('getActionObject')->andReturn($actionObject);

    expect($ruleAction->getDescriptionAttribute())->toBe('Sample Action Description');
});

it('applies action class and loads custom data after fetch', function(): void {
    $ruleAction = Mockery::mock(RuleAction::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $ruleAction->shouldReceive('applyActionClass')->once();
    $ruleAction->shouldReceive('loadCustomData')->once();

    callProtectedMethod($ruleAction, 'afterFetch');
});

it('sets custom data before save', function(): void {
    $ruleAction = Mockery::mock(RuleAction::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $ruleAction->shouldReceive('setCustomData')->once();

    callProtectedMethod($ruleAction, 'beforeSave');
});

it('applies and loads custom data', function(): void {
    $actionObject = Mockery::mock(BaseAction::class);
    $ruleAction = Mockery::mock(RuleAction::class)->makePartial();
    $ruleAction->shouldReceive('getActionObject')->andReturn($actionObject);
    $actionObject->shouldReceive('getFieldConfig')->andReturn([
        'fields' => [
            'custom_field' => [
                'label' => 'Custom Field',
                'type' => 'text',
            ],
        ],
    ]);
    $ruleAction->custom_field = 'value';
    $ruleAction->another_field = 'another_value';

    $ruleAction->applyCustomData();

    expect($ruleAction->another_field)->toBe('another_value')
        ->and($ruleAction->options['custom_field'])->toBe('value');
});

it('applies action class when class name is provided', function(): void {
    $ruleAction = Mockery::mock(RuleAction::class)->makePartial();
    $ruleAction->shouldReceive('isClassExtendedWith')->andReturn(false);
    $ruleAction->shouldReceive('extendClassWith')->with('SomeActionClass');

    expect($ruleAction->applyActionClass('SomeActionClass'))->toBeTrue()
        ->and($ruleAction->class_name)->toBe('SomeActionClass');
});

it('throws exception when action object is not found', function(): void {
    $ruleAction = Mockery::mock(RuleAction::class)->makePartial();
    $ruleAction->options = ['custom_field' => 'custom_value'];
    $ruleAction->shouldReceive('getActionObject')->andReturn(null);

    expect(fn() => $ruleAction->applyCustomData())->toThrow(AutomationException::class);
});

it('configures rule action model correctly', function(): void {
    $ruleAction = new RuleAction;

    expect(class_uses_recursive($ruleAction))
        ->toHaveKey(Validation::class)
        ->and($ruleAction->getTable())->toBe('igniter_automation_rule_actions')
        ->and($ruleAction->timestamps)->toBeTrue()
        ->and($ruleAction->getGuarded())->toBe([])
        ->and($ruleAction->relation['belongsTo']['automation_rule'])->toBe([AutomationRule::class, 'key' => 'automation_rule_id'])
        ->and($ruleAction->getCasts()['options'])->toBe('array')
        ->and($ruleAction->rules['class_name'])->toBe('required');
});
