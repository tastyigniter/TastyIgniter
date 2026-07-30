<?php

declare(strict_types=1);

namespace Igniter\Frontend\Tests\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Igniter\Frontend\Classes\ReCaptcha;
use Mockery;

beforeEach(function(): void {
    $this->secretKey = 'test-secret-key';
    $this->reCaptcha = new ReCaptcha($this->secretKey);
    $this->httpClient = Mockery::mock(Client::class);
    $this->reCaptcha->setHttpClient($this->httpClient);
});

it('returns false for empty response', function(): void {
    $result = $this->reCaptcha->verifyResponse('');

    expect($result)->toBeFalse();
});

it('returns true for valid response', function(): void {
    $this->httpClient
        ->shouldReceive('post')
        ->andReturn(new Response(200, [], json_encode(['success' => true])));

    $result = $this->reCaptcha->verifyResponse('valid-response', '127.0.0.1');

    expect($result)->toBeTrue();
});

it('returns false for invalid response', function(): void {
    $this->httpClient
        ->shouldReceive('post')
        ->andReturn(new Response(200, [], json_encode(['success' => false])));

    $result = $this->reCaptcha->verifyResponse('invalid-response', '127.0.0.1');

    expect($result)->toBeFalse();
});

it('uses client IP if not provided', function(): void {
    $this->httpClient
        ->shouldReceive('post')
        ->with(ReCaptcha::API_VERIFY_URL, [
            'form_params' => [
                'secret' => $this->secretKey,
                'response' => 'valid-response',
                'remoteip' => '127.0.0.1',
            ],
        ])
        ->andReturn(new Response(200, [], json_encode(['success' => true])));

    $result = $this->reCaptcha->verifyResponse('valid-response');

    expect($result)->toBeTrue();
});
