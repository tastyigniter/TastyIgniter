<?php

declare(strict_types=1);

namespace Igniter\Local\Tests\Http\Controllers;

use Igniter\Flame\Support\Facades\Igniter;

it('loads reviews settings page', function(): void {
    Igniter::partialMock()->shouldReceive('runningInAdmin')->andReturnTrue();
    actingAsSuperUser()
        ->get(route('igniter.system.extensions', ['slug' => 'edit/igniter/local/reviewsettings']))
        ->assertOk();
});
