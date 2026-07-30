<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\AutomationRules\Actions;

use Igniter\Automation\AutomationException;
use Igniter\Automation\AutomationRules\Actions\AssignToGroup;
use Igniter\Automation\Models\RuleAction;
use Igniter\Cart\Models\Order;
use Igniter\Reservation\Models\Reservation;
use Igniter\User\Models\UserGroup;
use Illuminate\Support\Facades\Event;

dataset('assignable', [
    fn(): array => ['order' => Order::factory()->create()],
    fn(): array => ['reservation' => Reservation::factory()->create()],
]);

it('assigns to valid group', function($params): void {
    Event::fake();

    $staffGroup = UserGroup::factory()->create();

    $assignToGroup = new AssignToGroup(new RuleAction([
        'staff_group_id' => $staffGroup->getKey(),
    ]));

    $assignToGroup->triggerAction($params);

    expect(current($params)->assignee_group_id)->toEqual($staffGroup->getKey());
    Event::assertDispatched('admin.assignable.beforeAssignTo');
    Event::assertDispatched('admin.assignable.assigned');
})->with('assignable');

it('throws exception when missing group id', function($params): void {
    $action = new RuleAction(['staff_group_id' => null]);
    $assignToGroup = new AssignToGroup($action);

    $assignToGroup->triggerAction($params);
})->with('assignable')->throws(AutomationException::class, 'Missing valid staff group to assign to.');

it('throws exception when invalid group id', function($params): void {
    $action = new RuleAction(['staff_group_id' => 999]);
    $assignToGroup = new AssignToGroup($action);

    $assignToGroup->triggerAction($params);
})->with('assignable')->throws(AutomationException::class, 'Invalid staff group to assign to.');

it('throws exception when missing assignable model', function(): void {
    $staffGroup = UserGroup::factory()->create();
    $action = new RuleAction(['staff_group_id' => $staffGroup->getKey()]);
    $assignToGroup = new AssignToGroup($action);

    $assignToGroup->triggerAction([]);
})->throws(AutomationException::class, 'Missing assignable model.');
