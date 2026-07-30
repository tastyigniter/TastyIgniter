<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Models;

use Igniter\Automation\Models\AutomationRule;
use Igniter\Automation\Models\RuleCondition;
use Mockery;

it('applies action class and loads custom data after fetch', function(): void {
    $ruleCondition = Mockery::mock(RuleCondition::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $ruleCondition->shouldReceive('applyConditionClass')->once();

    callProtectedMethod($ruleCondition, 'afterFetch');
});

it('configures rule condition model correctly', function(): void {
    $ruleCondition = new RuleCondition;

    expect($ruleCondition->getTable())->toEqual('igniter_automation_rule_conditions')
        ->and($ruleCondition->timestamps)->toBeTrue()
        ->and($ruleCondition->getGuarded())->toBe([])
        ->and($ruleCondition->getCasts()['options'])->toBe('array')
        ->and($ruleCondition->relation['belongsTo']['automation_rule'])->toEqual([AutomationRule::class, 'key' => 'automation_rule_id'])
        ->and($ruleCondition->rules)->toEqual(['class_name' => 'required']);
});
