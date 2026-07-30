<?php

declare(strict_types=1);

use Igniter\User\Models\User;
use SamPoyigi\Testbench\TestCase;
use Stripe\HttpClient\CurlClient;
use Stripe\Util\CaseInsensitiveArray;

uses(TestCase::class)->in(__DIR__);

function actingAsSuperUser()
{
    return test()->actingAs(User::factory()->superUser()->create(), 'igniter-admin');
}

function setupStripeRequest(CurlClient $httpClient, string $uri, array $response, string $method = 'get', int $statusCode = 200): void
{
    $httpClient->shouldReceive('request')
        ->with($method, 'https://api.stripe.com/v1/'.$uri, Mockery::any(), Mockery::any(), false)
        ->andReturn([
            json_encode($response),
            200,
            new CaseInsensitiveArray(['Request-Id' => 'req_123']),
        ]);
}
