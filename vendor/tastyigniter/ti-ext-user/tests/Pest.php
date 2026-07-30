<?php

declare(strict_types=1);

use Igniter\User\Models\User;
use Illuminate\Http\Request;
use SamPoyigi\Testbench\TestCase;

uses(TestCase::class)->in(__DIR__);

function actingAsSuperUser(?User $user = null)
{
    return test()->actingAs($user ?? User::factory()->superUser()->create(), 'igniter-admin');
}

function setObjectProtectedProperty($object, $property, $value): void
{
    $reflection = new ReflectionClass($object);
    $property = $reflection->getProperty($property);
    $property->setValue($object, $value);
}

function getObjectProtectedProperty($object, $property): mixed
{
    $reflection = new ReflectionClass($object);
    $property = $reflection->getProperty($property);

    return $property->getValue($object);
}

function mockRequest(array $data)
{
    $mockRequest = Mockery::mock(Request::class)->makePartial();
    $mockRequest->shouldReceive('post')->andReturn($data);
    $mockRequest->shouldReceive('setUserResolver')->andReturnNull();
    app()->instance('request', $mockRequest);

    return $mockRequest;
}

function withoutAdminUsers(): void
{
    User::all()->each->delete();
}
