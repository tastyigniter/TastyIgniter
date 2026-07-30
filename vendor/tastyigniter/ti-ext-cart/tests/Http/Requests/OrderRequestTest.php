<?php

declare(strict_types=1);

namespace Igniter\Cart\Tests\Http\Requests;

use Igniter\Cart\Http\Requests\OrderRequest;

it('returns empty array when no rules are defined', function(): void {
    $request = new OrderRequest;

    $rules = $request->rules();

    expect($rules)->toBeArray()
        ->and($rules)->toBeEmpty();
});
