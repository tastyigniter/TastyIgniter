<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Models;

use Exception;
use Igniter\Automation\Models\AutomationLog;
use Igniter\Automation\Models\AutomationRule;
use Igniter\Automation\Models\RuleAction;
use Igniter\Automation\Tests\Fixtures\TestAction;
use Illuminate\Database\Eloquent\Prunable;
use Mockery;

it('creates a log entry with a rule action', function(): void {
    $ruleAction = Mockery::mock(RuleAction::class)->makePartial();
    $ruleAction->shouldReceive('getKey')->andReturn(1);
    $ruleAction->automation_rule_id = 2;

    $log = AutomationLog::createLog($ruleAction, 'Test message', true, ['param1' => 'value1']);

    expect($log->automation_rule_id)->toBe(2)
        ->and($log->rule_action_id)->toBe(1)
        ->and($log->is_success)->toBeTrue()
        ->and($log->message)->toBe('Test message')
        ->and($log->params)->toBe(['param1' => 'value1'])
        ->and($log->exception)->toBeNull();
});

it('creates a log entry without a rule action', function(): void {
    $rule = Mockery::mock(AutomationRule::class);
    $rule->shouldReceive('getKey')->andReturn(1);

    $log = AutomationLog::createLog($rule, 'Test message', false, ['param1' => 'value1']);

    expect($log->automation_rule_id)->toBe(1)
        ->and($log->rule_action_id)->toBeNull()
        ->and($log->is_success)->toBeFalse()
        ->and($log->message)->toBe('Test message')
        ->and($log->params)->toBe(['param1' => 'value1'])
        ->and($log->exception)->toBeNull();
});

it('creates a log entry with an exception', function(): void {
    $rule = Mockery::mock(AutomationRule::class);
    $rule->shouldReceive('getKey')->andReturn(1);
    $exception = new Exception('Test exception', 123);

    $log = AutomationLog::createLog($rule, 'Test message', false, ['param1' => 'value1'], $exception);

    expect($log->exception)->toBe([
        'message' => 'Test exception',
        'code' => 123,
        'file' => $exception->getFile(),
        'line' => $exception->getLine(),
        'trace' => $exception->getTraceAsString(),
    ]);
});

it('returns the correct status name for success', function(): void {
    $log = new AutomationLog;
    $log->is_success = true;

    expect($log->status_name)->toBe(lang('igniter.automation::default.text_success'));
});

it('returns the correct status name for failure', function(): void {
    $log = new AutomationLog;
    $log->is_success = false;

    expect($log->status_name)->toBe(lang('igniter.automation::default.text_failed'));
});

it('returns the correct action name', function(): void {
    $action = Mockery::mock(RuleAction::class)->makePartial();
    $action->class_name = TestAction::class;
    $log = new AutomationLog;
    $log->setRelation('action', $action);

    expect($log->action_name)->toBe('Test Action');
});

it('returns default action name when action is null', function(): void {
    $log = new AutomationLog;

    expect($log->action_name)->toBe('--');
});

it('returns created since attribute correctly', function(): void {
    $log = new AutomationLog;
    $log->created_at = now()->subMinutes(5);

    expect($log->created_since)->toBe(time_elapsed($log->created_at));
});

it('returns null for created since attribute when created_at is null', function(): void {
    $log = new AutomationLog;

    expect($log->created_since)->toBeNull();
});

it('can prune automation logs', function(): void {
    $query = (new AutomationLog)->prunable();

    expect($query->toSql())->toContain('`created_at` is not null and `created_at` <= ?');
});

it('configures automation logs correctly', function(): void {
    $model = new AutomationLog;

    expect(class_uses_recursive($model))
        ->toHaveKey(Prunable::class)
        ->and($model->getTable())->toBe('igniter_automation_logs')
        ->and($model->timestamps)->toBeTrue()
        ->and($model->relation['belongsTo']['rule'])->toBe([AutomationRule::class, 'key' => 'automation_rule_id'])
        ->and($model->relation['belongsTo']['action'])->toBe([RuleAction::class, 'foreignKey' => 'rule_action_id'])
        ->and($model->getCasts()['automation_rule_id'])->toBe('integer')
        ->and($model->getCasts()['rule_action_id'])->toBe('integer')
        ->and($model->getCasts()['is_success'])->toBe('boolean')
        ->and($model->getCasts()['params'])->toBe('array')
        ->and($model->getCasts()['exception'])->toBe('array')
        ->and($model->getAppends())->toBe(['action_name', 'status_name', 'created_since'])
        ->and($model->rules)->toBe([
            'automation_rule_id' => 'integer',
            'rule_action_id' => 'nullable|integer',
            'is_success' => 'boolean',
            'message' => 'string',
            'params' => 'array',
            'exception' => ['nullable', 'array'],
        ]);

});
