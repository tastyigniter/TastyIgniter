<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Models;

use Igniter\Api\Models\Token;
use Igniter\Flame\Database\Model;
use Igniter\User\Models\Customer;
use Igniter\User\Models\User;
use Laravel\Sanctum\NewAccessToken;
use Mockery;

it('creates a new personal access token for the user', function(): void {
    $tokenable = Mockery::mock(Model::class)->makePartial();
    $tokenable->shouldReceive('tokens->create')->andReturn(new Token(['id' => 1, 'token' => 'hashedToken']));
    $name = 'testToken';
    $abilities = ['*'];

    $result = Token::createToken($tokenable, $name, $abilities);

    expect($result)->toBeInstanceOf(NewAccessToken::class);
});

it('determines if the token belongs to an admin', function(): void {
    $token = new Token;
    $token->tokenable_type = User::make()->getMorphClass();

    $result = $token->isForAdmin();

    expect($result)->toBeTrue();
});

it('determines if the token belongs to a customer', function(): void {
    $token = new Token;
    $token->tokenable_type = Customer::make()->getMorphClass();

    $result = $token->isForCustomer();

    expect($result)->toBeTrue();
});

it('configures token model correctly', function(): void {
    $token = new Token;

    expect($token->getTable())->toBe('igniter_api_access_tokens');
});
