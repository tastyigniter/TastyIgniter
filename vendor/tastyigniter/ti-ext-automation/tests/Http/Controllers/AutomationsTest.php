<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\Http\Controllers;

use Igniter\Automation\AutomationRules\Actions\AssignToGroup;
use Igniter\Automation\Classes\BaseCondition;
use Igniter\Automation\Models\AutomationRule;
use Igniter\User\Models\User;

it('loads automations page', function(): void {
    $this->actingAs(User::factory()->superUser()->create(), 'igniter-admin')
        ->get(route('igniter.automation.automations'))
        ->assertOk();
});

it('loads edit automation page', function(): void {
    AutomationRule::syncAll();

    $this->actingAs(User::factory()->superUser()->create(), 'igniter-admin')
        ->get(route('igniter.automation.automations', ['slug' => 'edit/'.AutomationRule::first()->getKey()]))
        ->assertOk();
});

it('loads create automation page', function(): void {
    $this->actingAs(User::factory()->superUser()->create(), 'igniter-admin')
        ->get(route('igniter.automation.automations', ['slug' => 'create']))
        ->assertOk();
});

it('updates automation', function(): void {
    AutomationRule::syncAll();

    $automation = AutomationRule::first();
    $url = route('igniter.automation.automations', ['slug' => 'edit/'.$automation->getKey()]);
    $this->actingAs(User::factory()->superUser()->create(), 'igniter-admin')
        ->post($url, [
            'AutomationRule' => [
                'name' => 'Some automation rule',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ]);

    expect(AutomationRule::find($automation->getKey()))->name->toBe('Some automation rule');
});

it('deletes automation', function(): void {
    AutomationRule::syncAll();

    $automation = AutomationRule::first();
    $url = route('igniter.automation.automations', ['slug' => 'edit/'.$automation->getKey()]);
    $this->actingAs(User::factory()->superUser()->create(), 'igniter-admin')
        ->post($url, [], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ]);

    expect(AutomationRule::find($automation->getKey()))->toBeNull();
});

it('loads connector form field for', function($field, $className, $handler): void {
    AutomationRule::syncAll();

    $url = route('igniter.automation.automations', ['slug' => 'edit/'.AutomationRule::first()->getKey()]);
    $response = $this->actingAs(User::factory()->superUser()->create(), 'igniter-admin')
        ->post($url, [
            'AutomationRule' => [
                $field => $className,
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => $handler,
        ]);

    expect($response->json())->toBeArray()->toHaveKey('#notification');
})->with([
    ['_action', AssignToGroup::class, 'onLoadCreateActionForm'],
    ['_condition', BaseCondition::class, 'onLoadCreateConditionForm'],
]);

it('sets is_custom and status on form before create', function(): void {
    AutomationRule::syncAll();

    $url = route('igniter.automation.automations', ['slug' => 'create']);
    $this->actingAs(User::factory()->superUser()->create(), 'igniter-admin')
        ->post($url, [
            'AutomationRule' => [
                'event_class' => 'SomeClass',
            ],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onSave',
        ])
        ->assertOk();

    $automation = AutomationRule::firstWhere('event_class', 'SomeClass');

    expect((bool)$automation->is_custom)->toBeTrue()
        ->and((bool)$automation->status)->toBeTrue();
});
