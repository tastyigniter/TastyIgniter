<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Http\Controllers;

use Igniter\Api\Http\Controllers\ShowTokenUser;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Laravel\Sanctum\Sanctum;

beforeEach(function(): void {
    $this->controller = new ShowTokenUser;
});

it('show authenticated user', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['users:*']);

    $this->get(route('igniter.api.token.user'))
        ->assertOk();
});

it('show authenticated customer', function(): void {
    Sanctum::actingAs(Customer::factory()->create(), ['customers:*']);

    $this->get(route('igniter.api.token.user'))
        ->assertOk();
});

it('returns null for unauthenticated user', function(): void {
    $this->get(route('igniter.api.token.user'))
        ->assertUnauthorized();
});
