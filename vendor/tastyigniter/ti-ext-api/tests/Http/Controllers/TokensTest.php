<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Http\Controllers;

use Igniter\Api\Models\Token;

it('loads tokens page', function(): void {
    actingAsSuperUser()
        ->get(route('igniter.api.tokens'))
        ->assertOk();
});

it('deletes token on tokens page', function(): void {
    $token = Token::factory()->create();

    actingAsSuperUser()
        ->post(route('igniter.api.tokens'), [
            'checked' => [$token->getKey()],
        ], [
            'X-Requested-With' => 'XMLHttpRequest',
            'X-IGNITER-REQUEST-HANDLER' => 'onDelete',
        ])
        ->assertOk();
});
