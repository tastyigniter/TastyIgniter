<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Actions;

use Igniter\Admin\Classes\AdminController;
use Igniter\Admin\Widgets\Filter;
use Igniter\Admin\Widgets\Form;
use Igniter\Admin\Widgets\Toolbar;
use Igniter\Cart\Http\Controllers\Menus;
use Igniter\Cart\Models\Order;
use Igniter\Flame\Database\Builder;
use Igniter\User\Http\Actions\AssigneeController;
use Igniter\User\Models\User;
use Illuminate\Support\Facades\Event;
use Mockery;

it('applies scope on list query when user has restricted scope', function(): void {
    $controller = new class extends AdminController
    {
        public array $assigneeConfig = [
            'applyScopeOnListQuery' => true,
            'applyScopeOnFormQuery' => true,
        ];
    };
    $query = Mockery::mock(Builder::class);
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('extendableGet')->with('groups')->andReturn(collect([['user_group_id' => 1], ['user_group_id' => 2]]));
    $user->shouldReceive('hasGlobalAssignableScope')->andReturn(false);
    $user->shouldReceive('hasRestrictedAssignableScope')->andReturn(true);
    $user->shouldReceive('getKey')->andReturn(1);
    $user->shouldReceive('groups->pluck->all')->andReturn([1, 2]);
    $controller->setUser($user);
    $query->shouldReceive('whereInAssignToGroup')->with([1, 2])->once();
    $query->shouldReceive('whereAssignTo')->with(1)->once();

    (new AssigneeController($controller))->assigneeApplyScope($query);
});

it('does not apply scope on list query when user has global scope', function(): void {
    $controller = resolve(Menus::class);
    $user = Mockery::mock(User::class)->makePartial();
    $query = Mockery::mock(Builder::class);
    $user->shouldReceive('hasGlobalAssignableScope')->andReturn(true);
    $controller->setUser($user);
    $query->shouldReceive('whereInAssignToGroup')->never();
    $query->shouldReceive('whereAssignTo')->never();

    $assigneeController = new AssigneeController($controller);

    $assigneeController->assigneeApplyScope($query);
});

it('removes delete button from toolbar when user does not have global scope', function(): void {
    $controller = resolve(Menus::class);
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('hasGlobalAssignableScope')->andReturn(false);
    $controller->setUser($user);
    $toolbar = new Toolbar($controller);
    $toolbar->allButtons = ['delete' => 'deleteWidget'];
    $controller->widgets = ['toolbar' => $toolbar];

    new AssigneeController($controller);

    $controller->fireEvent('controller.beforeRemap');
    $toolbar->fireEvent('toolbar.extendButtons', [$toolbar->allButtons]);

    expect($toolbar->allButtons)->not->toHaveKey('delete');
});

it('does not remove delete button from toolbar when user has global scope', function(): void {
    $controller = resolve(Menus::class);
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('hasGlobalAssignableScope')->andReturn(true);
    $controller->setUser($user);
    $toolbar = new Toolbar($controller);
    $toolbar->allButtons = ['delete' => 'deleteWidget'];
    $controller->widgets = ['toolbar' => $toolbar];

    new AssigneeController($controller);

    $controller->fireEvent('controller.beforeRemap');
    $toolbar->fireEvent('toolbar.extendButtons', [$toolbar->allButtons]);

    expect($toolbar->allButtons)->toHaveKey('delete');
});

it('assigns user to model when conditions are met', function(): void {
    $controller = resolve(Menus::class);
    $assignable = Mockery::mock(Order::class)->makePartial();
    $query = Mockery::mock(Builder::class);
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('getKey')->andReturn(1);
    $user->shouldReceive('hasGlobalAssignableScope')->andReturn(false);
    $user->shouldReceive('hasRestrictedAssignableScope')->andReturn(true);
    $controller->setUser($user);
    $query->shouldReceive('getModel')->andReturn($user);
    $query->shouldReceive('whereInAssignToGroup')->once();
    $query->shouldReceive('whereAssignTo')->with(1)->once();
    $assignable->shouldReceive('hasAssignToGroup')->andReturn(true);
    $assignable->shouldReceive('hasAssignTo')->andReturnFalse()->once();
    $assignable->shouldReceive('extendableGet')->with('assignee_group')->andReturnSelf();
    $assignable->shouldReceive('autoAssignEnabled')->andReturnFalse()->once();
    $assignable->shouldReceive('cannotAssignToStaff')->with($user)->andReturnFalse()->once();
    $assignable->shouldReceive('assignTo')->with($user)->once();

    $widget = new Form($controller, ['model' => $assignable]);

    new AssigneeController($controller);
    $controller->fireEvent('controller.beforeRemap');

    $controller->fireEvent('admin.controller.extendFormQuery', [$query]);
    Event::dispatch('admin.form.extendFields', [$widget]);
});

it('applies scope on list query when extended', function(): void {
    $controller = resolve(Menus::class);
    $assignable = Mockery::mock(Order::class)->makePartial();
    $user = Mockery::mock(User::class)->makePartial();
    $query = Mockery::mock(Builder::class);
    $query->shouldReceive('whereInAssignToGroup')->once();
    $query->shouldReceive('whereAssignTo')->with(1)->once();
    $query->shouldReceive('getModel')->andReturn($user);
    $user->shouldReceive('getKey')->andReturn(1);
    $user->shouldReceive('hasGlobalAssignableScope')->andReturn(false);
    $user->shouldReceive('hasRestrictedAssignableScope')->andReturn(true);
    $controller->setUser($user);

    $widget = new Form($controller, ['model' => $assignable]);
    new AssigneeController($controller);
    $controller->fireEvent('controller.beforeRemap');

    Event::dispatch('admin.list.extendQuery', [$widget, $query]);
});

it('removes assignee scope when user has restricted scope', function(): void {
    $controller = resolve(Menus::class);
    $user = Mockery::mock(User::class)->makePartial();
    $user->shouldReceive('getKey')->andReturn(1);
    $user->shouldReceive('hasGlobalAssignableScope')->andReturn(false);
    $user->shouldReceive('hasRestrictedAssignableScope')->andReturn(true);
    $controller->setUser($user);

    $widget = new Filter($controller);
    $widget->scopes = ['assignee' => 'some_scope'];
    new AssigneeController($controller);
    $controller->fireEvent('controller.beforeRemap');

    Event::dispatch('admin.filter.extendScopesBefore', [$widget]);

    expect($widget->scopes)->not->toHaveKey('assignee');
});
