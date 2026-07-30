<?php

declare(strict_types=1);

namespace Igniter\User\Tests\MainMenuWidgets;

use Igniter\Admin\Classes\MainMenuItem;
use Igniter\Cart\Http\Controllers\Menus;
use Igniter\Flame\Database\Model;
use Igniter\User\MainMenuWidgets\NotificationList;
use Igniter\User\Models\Notification;
use Igniter\User\Models\User;
use Mockery;

beforeEach(function(): void {
    $this->user = Mockery::mock(User::class)->makePartial();
    $this->mainMenuItem = new MainMenuItem('testField', 'Label');
    $controller = resolve(Menus::class);
    $controller->setUser($this->user);

    $this->notificationList = new NotificationList($controller, $this->mainMenuItem, [
        'model' => Mockery::mock(Model::class)->makePartial(),
    ]);
});

it('renders notification list with unread count', function(): void {
    $this->user->shouldReceive('unreadNotifications')->andReturnSelf();
    $this->user->shouldReceive('count')->andReturn(5);

    expect($this->notificationList->render())->toBeString()
        ->and($this->notificationList->vars['unreadCount'])->toBe(5);
});

it('returns dropdown options with notifications', function(): void {
    $this->user->shouldReceive('notifications')->andReturnSelf();
    $this->user->shouldReceive('get')->andReturn(collect([new Notification]));

    $result = $this->notificationList->onDropdownOptions();

    expect($result)->toHaveKey('#'.$this->notificationList->getId('options'))
        ->and($result['#'.$this->notificationList->getId('options')])->not->toBeEmpty()
        ->and($this->notificationList->vars['notifications'])->toBeCollection()
        ->and($this->notificationList->vars['notifications'])->toHaveCount(1)
        ->and($this->notificationList->vars['notifications']->first())->toBeInstanceOf(Notification::class);
});

it('marks notifications as read and returns updated list', function(): void {
    $this->user->shouldReceive('unreadNotifications')->andReturnSelf();
    $this->user->shouldReceive('update')->with(['read_at' => now()])->andReturn(1);

    $result = $this->notificationList->onMarkAsRead();

    expect($result)->toHaveKey('~#'.$this->notificationList->getId())
        ->and($result['~#'.$this->notificationList->getId()])->not->toBeEmpty();
});
