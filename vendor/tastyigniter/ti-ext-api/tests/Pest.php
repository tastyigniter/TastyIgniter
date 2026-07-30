<?php

declare(strict_types=1);

use Igniter\User\Models\User;
use SamPoyigi\Testbench\TestCase;

uses(TestCase::class)->in(__DIR__);

function callProtectedMethod(object $condition, string $methodName, array $args = []): mixed
{
    $reflection = new ReflectionClass($condition);
    $method = $reflection->getMethod($methodName);

    return $method->invokeArgs($condition, $args);
}

function actingAsSuperUser()
{
    return test()->actingAs(User::factory()->superUser()->create(), 'igniter-admin');
}
