<?php

declare(strict_types=1);

use SamPoyigi\Testbench\TestCase;

uses(TestCase::class)->in(__DIR__);

function callProtectedMethod(object $condition, string $methodName, array $args = []): mixed
{
    $reflection = new ReflectionClass($condition);
    $method = $reflection->getMethod($methodName);

    return $method->invokeArgs($condition, $args);
}

