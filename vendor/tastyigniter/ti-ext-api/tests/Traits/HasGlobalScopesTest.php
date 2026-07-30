<?php

declare(strict_types=1);

namespace Igniter\Api\Tests\Traits;

use Igniter\Api\Traits\HasGlobalScopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use InvalidArgumentException;
use Mockery;

it('adds a global scope using a string and closure', function(): void {
    $traitObject = new class
    {
        use HasGlobalScopes;
    };
    $closure = function(): void {};
    $result = $traitObject->addGlobalScope('testScope', $closure);

    expect($result)->toBe($closure);
});

it('adds a global scope using a closure', function(): void {
    $traitObject = new class
    {
        use HasGlobalScopes;
    };
    $closure = function(): void {};
    $result = $traitObject->addGlobalScope($closure);

    expect($result)->toBe($closure);
});

it('adds a global scope using a Scope instance', function(): void {
    $traitObject = new class
    {
        use HasGlobalScopes;
    };
    $scope = Mockery::mock(Scope::class);
    $result = $traitObject->addGlobalScope($scope);

    expect($result)->toBe($scope);
});

it('throws an exception when adding an invalid global scope', function(): void {
    $traitObject = new class
    {
        use HasGlobalScopes;
    };

    expect(function() use ($traitObject): void {
        $traitObject->addGlobalScope('invalidScope');
    })->toThrow(InvalidArgumentException::class, 'Global scope must be an instance of Closure or Scope.');
});

it('applies all registered global scopes to the query', function(): void {
    $traitObject = new class
    {
        use HasGlobalScopes;

        public function testApplyScopes($query): void
        {
            $this->applyScopes($query);
        }
    };
    $query = Mockery::mock(Builder::class);
    $scope = Mockery::mock(Scope::class);
    $traitObject->addGlobalScope($scope);

    $query->shouldReceive('withGlobalScope')->with(Mockery::any(), [$scope::class => $scope])->once();
    $traitObject->testApplyScopes($query);
});
