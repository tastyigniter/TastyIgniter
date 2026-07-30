<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Exceptions;

use Exception;
use Igniter\Api\Exceptions\ErrorHandler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mockery;

beforeEach(function(): void {
    $this->handler = Mockery::mock(ExceptionHandler::class);
    $this->request = Mockery::mock(Request::class);
    $this->errorHandler = new ErrorHandler($this->handler, [
        'message' => ':message',
        'errors' => ':errors',
        'code' => ':code',
        'status_code' => ':status_code',
        'debug' => ':debug',
    ], false);
});

it('renders generic response for non-API route', function(): void {
    $this->request->shouldReceive('routeIs')->with('igniter.api.*.*')->andReturn(false);
    $exception = new Exception('Test Exception');

    $response = $this->errorHandler->render($this->request, $exception);

    expect($response)->toBeNull();
});

it('renders 404 response for ModelNotFoundException', function(): void {
    $this->request->shouldReceive('routeIs')->with('igniter.api.*.*')->andReturn(true);
    $exception = new ModelNotFoundException;

    $response = $this->errorHandler->render($this->request, $exception);

    expect($response->getStatusCode())->toBe(404);
});

it('renders 422 response for ValidationException', function(): void {
    $this->request->shouldReceive('routeIs')->with('igniter.api.*.*')->andReturn(true);
    $exception = Mockery::mock(ValidationException::class);
    $exception->shouldReceive('errors')->andReturn(['field' => ['error']]);
    $exception->shouldReceive('status')->andReturn(422);

    $response = $this->errorHandler->render($this->request, $exception);

    expect($response->getStatusCode())->toBe(422)
        ->and($response->getOriginalContent()['errors'])->toBe(['field' => ['error']]);
});

it('returns 500 status code for invalid status code above 599', function(): void {
    $this->request->shouldReceive('routeIs')->with('igniter.api.*.*')->andReturn(true);
    $exception = new Exception('Test Exception', 600);

    $response = $this->errorHandler->render($this->request, $exception);

    expect($response->getStatusCode())->toBe(500);
});

it('renders 500 response for generic exception', function(): void {
    $this->request->shouldReceive('routeIs')->with('igniter.api.*.*')->andReturn(true);
    $exception = new Exception('Test Exception');

    $response = $this->errorHandler->render($this->request, $exception);

    expect($response->getStatusCode())->toBe(500)
        ->and($response->getOriginalContent()['message'])->toBe('Test Exception');
});

it('renders debug information when in debug mode', function(): void {
    $this->request->shouldReceive('routeIs')->with('igniter.api.*.*')->andReturn(true);
    $exception = new Exception('Test Exception');

    $errorHandler = new ErrorHandler($this->handler, [
        'message' => ':message',
        'errors' => ':errors',
        'code' => ':code',
        'status_code' => ':status_code',
        'debug' => ':debug',
    ], true);
    $response = $errorHandler->render($this->request, $exception);

    expect($response->getStatusCode())->toBe(500)
        ->and($response->getOriginalContent()['debug'])->toHaveKeys(['line', 'file', 'class', 'trace']);
});
