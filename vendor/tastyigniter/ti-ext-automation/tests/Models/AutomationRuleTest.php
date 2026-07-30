<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Models;

use Igniter\Automation\Classes\BaseEvent;
use Igniter\Automation\Models\AutomationLog;
use Igniter\Automation\Models\AutomationRule;
use Igniter\Automation\Models\RuleAction;
use Igniter\Automation\Models\RuleCondition;
use Igniter\Automation\Tests\Fixtures\TestAction;
use Igniter\Automation\Tests\Fixtures\TestCondition;
use Igniter\Automation\Tests\Fixtures\TestEvent;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Builder;
use Igniter\Flame\Database\Traits\Purgeable;
use Igniter\Flame\Database\Traits\Validation;
use Igniter\System\Classes\ExtensionManager;
use Mockery;

it('triggers actions when conditions are met', function(): void {
    $automationRule = AutomationRule::createFromPreset('some_rule', [
        'name' => 'Test Automation Rule',
        'event' => TestEvent::class,
        'actions' => [TestAction::class => []],
    ]);
    $automationRule->status = 1;
    $automationRule->save();
    $order = Mockery::mock(Order::class)->makePartial();

    expect($automationRule->triggerRule($order))->toBeNull();
});

it('logs exception when no actions are found', function(): void {
    $order = Mockery::mock(Order::class)->makePartial();
    $automationRule = AutomationRule::create([
        'code' => 'some_rule',
        'name' => 'Test Automation Rule',
        'event_class' => TestEvent::class,
        'is_custom' => 0,
        'status' => 1,
    ]);

    expect($automationRule->triggerRule($order))->toBeNull();

    $this->assertDatabaseHas('igniter_automation_logs', [
        'automation_rule_id' => $automationRule->getKey(),
        'message' => 'No actions found for this rule',
    ]);
});

it('does not trigger actions when conditions are not met', function(): void {
    $automationRule = AutomationRule::create([
        'code' => 'some_rule',
        'name' => 'Test Automation Rule',
        'event_class' => TestEvent::class,
        'is_custom' => 0,
        'status' => 1,
    ]);
    $automationRule->actions()->create([
        'class_name' => TestAction::class,
    ]);
    $automationRule->conditions()->create([
        'options' => [
            'attribute' => 'order_total',
            'operator' => 'is',
            'value' => 100,
        ],
        'class_name' => TestCondition::class,
    ]);

    $order = Mockery::mock(Order::class)->makePartial();
    $order->shouldReceive('getAttribute')->with('order_total')->andReturn(0);

    expect($automationRule->triggerRule($order))->toBeFalse();
});

it('returns event description when event object is valid', function(): void {
    $eventDescription = 'Sample Event Description';
    $eventObject = Mockery::mock(BaseEvent::class);
    $eventObject->shouldReceive('getEventDescription')->andReturn($eventDescription);

    $automationRule = Mockery::mock(AutomationRule::class)->makePartial();
    $automationRule->shouldReceive('getEventObject')->andReturn($eventObject);

    expect($automationRule->getEventDescriptionAttribute())->toBe($eventDescription);
});

it('applies class filter with object class name', function(): void {
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('where')->with('event_class', TestEvent::class)->andReturnSelf();

    $eventObject = new TestEvent;

    $result = (new AutomationRule)->scopeApplyClass($query, $eventObject);
    expect($result)->toBe($query);
});

it('syncs all rules and creates new ones from presets', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerAutomationRules')->andReturn([
        [
            'presets' => [
                'rule1' => ['name' => 'Rule 1', 'event' => 'Event1', 'actions' => [TestAction::class => []]],
                'rule2' => ['name' => 'Rule 2', 'event' => 'Event2', 'actions' => [TestAction::class => []]],
            ],
        ],
    ])->once();
    app()->instance(ExtensionManager::class, $extensionManager);

    AutomationRule::syncAll();

    $this->assertDatabaseHas('igniter_automation_rules', ['code' => 'rule1']);
    $this->assertDatabaseHas('igniter_automation_rules', ['code' => 'rule2']);
});

it('deletes non-customized rules not in presets', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerAutomationRules')->andReturn([
        [
            'presets' => [
                'rule1' => ['name' => 'Rule 1', 'event' => 'Event1', 'actions' => []],
            ],
        ],
    ])->once();
    app()->instance(ExtensionManager::class, $extensionManager);
    AutomationRule::create(['is_custom' => 0, 'code' => 'rule2']);

    AutomationRule::syncAll();

    $this->assertDatabaseMissing('igniter_automation_rules', ['code' => 'rule2']);
});

it('does not delete customized rules not in presets', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerAutomationRules')->andReturn([
        [
            'presets' => [
                'rule1' => ['name' => 'Rule 1', 'event' => 'Event1', 'actions' => []],
            ],
        ],
    ])->once();
    app()->instance(ExtensionManager::class, $extensionManager);
    AutomationRule::create(['is_custom' => 1, 'code' => 'rule2']);

    AutomationRule::syncAll();

    $this->assertDatabaseHas('igniter_automation_rules', ['code' => 'rule2']);
});

it('does not create rules if actions are missing or invalid', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerAutomationRules')->andReturn([
        [
            'presets' => [
                'rule1' => ['name' => 'Rule 1', 'event' => 'Event1'],
            ],
        ],
    ])->once();
    app()->instance(ExtensionManager::class, $extensionManager);

    AutomationRule::syncAll();

    $this->assertDatabaseMissing('igniter_automation_rules', ['code' => 'rule1']);
});

it('returns true when there are no conditions', function(): void {
    $rule = Mockery::mock(AutomationRule::class)->makePartial();
    $rule->shouldReceive('getAttribute')->with('conditions')->andReturn(collect());

    expect(callProtectedMethod($rule, 'checkConditions', [[]]))->toBeTrue();
});

it('returns true when all conditions are met with match type all', function(): void {
    $condition = Mockery::mock(RuleCondition::class)->makePartial();
    $condition->shouldReceive('getConditionObject->isTrue')->andReturnTrue();
    $conditions = collect([$condition, $condition]);

    $rule = Mockery::mock(AutomationRule::class)->makePartial();
    $rule->shouldReceive('getAttribute')->with('conditions')->andReturn($conditions);
    $rule->config_data = ['condition_match_type' => 'all'];

    expect(callProtectedMethod($rule, 'checkConditions', [[]]))->toBeTrue();
});

it('returns false when not all conditions are met with match type all', function(): void {
    $conditionTrue = Mockery::mock(RuleCondition::class)->makePartial();
    $conditionTrue->shouldReceive('getConditionObject->isTrue')->andReturnTrue();
    $conditionFalse = Mockery::mock(RuleCondition::class)->makePartial();
    $conditionFalse->shouldReceive('getConditionObject->isTrue')->andReturnFalse();
    $conditions = collect([$conditionTrue, $conditionFalse]);

    $rule = Mockery::mock(AutomationRule::class)->makePartial();
    $rule->shouldReceive('getAttribute')->with('conditions')->andReturn($conditions);
    $rule->config_data = ['condition_match_type' => 'all'];

    expect(callProtectedMethod($rule, 'checkConditions', [[]]))->toBeFalse();
});

it('returns true when at least one condition is met with match type any', function(): void {
    $conditionTrue = Mockery::mock(RuleCondition::class)->makePartial();
    $conditionTrue->shouldReceive('getConditionObject->isTrue')->andReturnTrue();
    $conditionFalse = Mockery::mock(RuleCondition::class)->makePartial();
    $conditionFalse->shouldReceive('getConditionObject->isTrue')->andReturnFalse();
    $conditions = collect([$conditionFalse, $conditionTrue]);

    $rule = Mockery::mock(AutomationRule::class)->makePartial();
    $rule->shouldReceive('getAttribute')->with('conditions')->andReturn($conditions);
    $rule->config_data = ['condition_match_type' => 'any'];

    expect(callProtectedMethod($rule, 'checkConditions', [[]]))->toBeTrue();
});

it('returns false when no conditions are met with match type any', function(): void {
    $conditionFalse = Mockery::mock(RuleCondition::class)->makePartial();
    $conditionFalse->shouldReceive('getConditionObject->isTrue')->andReturnFalse();
    $conditions = collect([$conditionFalse, $conditionFalse]);

    $rule = Mockery::mock(AutomationRule::class)->makePartial();
    $rule->shouldReceive('getAttribute')->with('conditions')->andReturn($conditions);
    $rule->config_data = ['condition_match_type' => 'any'];

    expect(callProtectedMethod($rule, 'checkConditions', [[]]))->toBeFalse();
});

it('deletes relationships when deleting automation rule', function(): void {
    $automationRule = AutomationRule::create(['event_class' => TestEvent::class]);
    $automationRule->conditions()->save(RuleCondition::create(['class_name' => TestCondition::class]));
    $automationRule->actions()->save(RuleAction::create(['class_name' => TestAction::class]));
    $automationRule->logs()->save(AutomationLog::create());

    $automationRule->delete();

    $this->assertDatabaseCount('igniter_automation_rules', 0);
    $this->assertDatabaseCount('igniter_automation_rule_conditions', 0);
    $this->assertDatabaseCount('igniter_automation_rule_actions', 0);
    $this->assertDatabaseCount('igniter_automation_logs', 0);
});

it('configures automation rule model correctly', function(): void {
    $automationRule = new AutomationRule;

    expect(class_uses_recursive($automationRule))
        ->toHaveKey(Purgeable::class)
        ->toHaveKey(Validation::class)
        ->and($automationRule->getTable())->toBe('igniter_automation_rules')
        ->and($automationRule->timestamps)->toBeTrue()
        ->and($automationRule->relation['hasMany']['conditions'])->toBe([RuleCondition::class, 'delete' => true])
        ->and($automationRule->relation['hasMany']['actions'])->toBe([RuleAction::class, 'delete' => true])
        ->and($automationRule->relation['hasMany']['logs'])->toBe([AutomationLog::class, 'delete' => true])
        ->and($automationRule->getCasts()['config_data'])->toBe('array')
        ->and($automationRule->getPurgeableAttributes())->toEqual(['actions', 'conditions'])
        ->and($automationRule->rules['name'])->toContain('sometimes', 'required', 'string')
        ->and($automationRule->rules['code'])->toContain('sometimes', 'required', 'alpha_dash', 'unique:igniter_automation_rules,code')
        ->and($automationRule->rules['event_class'])->toContain('required');
});
