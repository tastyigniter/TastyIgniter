<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Classes;

use Closure;
use Igniter\User\Classes\BladeExtension;
use Igniter\User\Facades\AdminAuth;
use Igniter\User\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Mockery;

it('registers custom directive', function(): void {
    Blade::shouldReceive('directive')->with('mainauth', Mockery::type(Closure::class))->once();
    Blade::shouldReceive('directive')->with('endmainauth', Mockery::type(Closure::class))->once();
    Blade::shouldReceive('directive')->with('adminauth', Mockery::type(Closure::class))->once();
    Blade::shouldReceive('directive')->with('endadminauth', Mockery::type(Closure::class))->once();

    $extension = new BladeExtension;
    $extension->register();
});

it('compiles mainauth directive', function(): void {
    $extension = new BladeExtension;
    $result = $extension->compilesMainAuth(null);

    expect($result)->toBe('<?php if('.Auth::class.'::check()): ?>');
});

it('compiles adminauth directive', function(): void {
    $extension = new BladeExtension;
    $result = $extension->compilesAdminAuth(null);

    expect($result)->toBe('<?php if('.AdminAuth::class.'::check()): ?>');
});

it('compiles endmainauth directive', function(): void {
    $extension = new BladeExtension;
    $result = $extension->compilesEndMainAuth();

    expect($result)->toBe('<?php endif ?>');
});

it('compiles endadminauth directive', function(): void {
    $extension = new BladeExtension;
    $result = $extension->compilesEndAdminAuth();

    expect($result)->toBe('<?php endif ?>');
});
