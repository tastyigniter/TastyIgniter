<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\ApiResources;

use Igniter\System\Models\Currency;
use Igniter\User\Models\User;
use Laravel\Sanctum\Sanctum;

it('returns all currencies', function(): void {
    Sanctum::actingAs(User::factory()->create(), ['currencies:*']);
    $currency = Currency::listFrontEnd()->first();

    $this->get(route('igniter.api.currencies.index'))
        ->assertOk()
        ->assertJsonPath('data.0.id', (string)$currency->getKey())
        ->assertJsonPath('data.0.attributes.currency_name', $currency->currency_name);
});
