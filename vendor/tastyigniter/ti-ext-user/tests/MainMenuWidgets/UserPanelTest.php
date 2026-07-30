<?php

declare(strict_types=1);

namespace Igniter\User\Tests\MainMenuWidgets;

use Igniter\Admin\Classes\MainMenuItem;
use Igniter\Cart\Http\Controllers\Menus;
use Igniter\Flame\Database\Model;
use Igniter\Flame\Exception\FlashException;
use Igniter\User\Classes\UserState;
use Igniter\User\MainMenuWidgets\UserPanel;
use Igniter\User\Models\User;
use Mockery;

beforeEach(function(): void {
    $this->user = Mockery::mock(User::class)->makePartial();
    $this->user->email = 'user@example.com';
    $this->mainMenuItem = new MainMenuItem('testField', 'Label');
    $controller = resolve(Menus::class);
    $controller->setUser($this->user);

    $this->userPanel = new UserPanel($controller, $this->mainMenuItem, [
        'model' => Mockery::mock(Model::class)->makePartial(),
    ]);
});

it('renders user panel with correct variables', function(): void {
    $this->userPanel->links = [
        'test' => [
            'label' => 'Test',
            'url' => 'test',
        ],
    ];
    $result = $this->userPanel->render();

    expect($result)->toBeString()
        ->and($this->userPanel->vars['avatarUrl'])->toBe('//www.gravatar.com/avatar/b58996c504c5638798eb6b511e6f49af.png?d=mm')
        ->and($this->userPanel->vars['userName'])->toBeNull()
        ->and($this->userPanel->vars['roleName'])->toBeNull()
        ->and($this->userPanel->vars['userIsOnline'])->toBeTrue()
        ->and($this->userPanel->vars['userIsIdle'])->toBeFalse()
        ->and($this->userPanel->vars['userIsAway'])->toBeFalse()
        ->and($this->userPanel->vars['userStatusName'])->toBe('igniter.user::default.staff_status.text_online')
        ->and($this->userPanel->vars['links'])->toBeCollection();
});

it('loads status form with correct variables', function(): void {
    $result = $this->userPanel->onLoadStatusForm();

    expect($result)->toBeString()
        ->and($this->userPanel->vars['statuses'])->toBe([
            UserState::ONLINE_STATUS => 'igniter.user::default.staff_status.text_online',
            UserState::BACK_SOON_STATUS => 'igniter.user::default.staff_status.text_back_soon',
            UserState::AWAY_STATUS => 'igniter.user::default.staff_status.text_away',
            UserState::CUSTOM_STATUS => 'igniter.user::default.staff_status.text_custom_status',
        ])
        ->and($this->userPanel->vars['clearAfterOptions'])->toHaveKeys([1440, 240, 30, 0])
        ->and($this->userPanel->vars['message'])->toBeNull()
        ->and($this->userPanel->vars['userStatus'])->toBe(1)
        ->and($this->userPanel->vars['clearAfterMinutes'])->toBe(0)
        ->and($this->userPanel->vars['statusUpdatedAt'])->toBeNull();
});

it('sets status successfully with valid data', function(): void {
    request()->request->add([
        'status' => 1,
        'message' => 'Available',
        'clear_after' => 30,
    ]);

    $this->user->shouldReceive('extendableGet')->with('user_id')->andReturn(1);
    $result = $this->userPanel->onSetStatus();

    expect($result)->toBe(['~#'.$this->userPanel->getId() => $this->userPanel->render()]);
});

it('throws exception when setting invalid status', function(): void {
    request()->request->add([
        'status' => 0,
        'message' => '',
        'clear_after' => 30,
    ]);

    $this->expectException(FlashException::class);

    $this->userPanel->onSetStatus();
});
