<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Exceptions;

use Igniter\Api\Exceptions\ResourceException;
use Illuminate\Support\MessageBag;

it('creates ResourceException with default message bag when errors are null', function(): void {
    $exception = new ResourceException('Error message');

    expect($exception->getErrors())->toBeInstanceOf(MessageBag::class)
        ->and($exception->getErrors()->isEmpty())->toBeTrue();
});

it('creates ResourceException with message bag from array', function(): void {
    $errors = ['field' => ['Error message']];
    $exception = new ResourceException('Error message', $errors);

    expect($exception->getErrors())->toBeInstanceOf(MessageBag::class)
        ->and($exception->getErrors()->get('field'))->toBe(['Error message']);
});

it('creates ResourceException with message bag instance', function(): void {
    $errors = new MessageBag(['field' => ['Error message']]);
    $exception = new ResourceException('Error message', $errors);

    expect($exception->getErrors())->toBe($errors);
});

it('returns errors as array', function(): void {
    $errors = ['field' => ['Error message']];
    $exception = new ResourceException('Error message', $errors);

    expect($exception->errors())->toBe($errors);
});

it('determines if message bag has errors', function(): void {
    $errors = ['field' => ['Error message']];
    $exception = new ResourceException('Error message', $errors);

    expect($exception->hasErrors())->toBeTrue();
});

it('determines if message bag is empty', function(): void {
    $exception = new ResourceException('Error message', []);

    expect($exception->hasErrors())->toBeFalse();
});
