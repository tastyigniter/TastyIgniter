<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Controllers;

use Igniter\User\Http\Controllers\Notifications;
use Igniter\User\Models\User;
use Illuminate\Http\RedirectResponse;

it('loads notification page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.user.notifications'))
        ->assertOk();
});

it('marks notification as read', function(): void {
    $user = User::factory()->superUser()->create();

    $controller = new Notifications;
    $controller->setUser($user);

    $response = $controller->onMarkAsRead();

    expect($response)->toBeInstanceOf(RedirectResponse::class);
});
