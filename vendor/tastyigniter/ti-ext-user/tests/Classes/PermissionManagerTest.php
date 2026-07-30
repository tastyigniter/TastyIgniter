<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Classes;

use Igniter\System\Classes\ExtensionManager;
use Igniter\User\Classes\PermissionManager;
use Mockery;

it('returns empty list when no permissions are registered', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerPermissions')->andReturn([]);
    app()->instance(ExtensionManager::class, $extensionManager);
    $permissionManager = new PermissionManager;

    $result = $permissionManager->listPermissions();

    expect($result)->toBeEmpty();
});

it('returns registered permissions', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerPermissions')->andReturn([
        'owner' => 'not an array',
    ]);
    app()->instance(ExtensionManager::class, $extensionManager);
    $permissionManager = new PermissionManager;
    $permissionManager->registerPermissions('testOwner', [
        'test.another-code' => [
            'label' => 'Test Another Permission',
            'group' => 'Test Group',
            'priority' => 99,
        ],
        'test.code' => [
            'label' => 'Test Permission',
            'group' => 'Test Group',
            'priority' => 9,
        ],
    ]);

    $result = $permissionManager->listPermissions();

    expect($result)->toBeGreaterThanOrEqual(1)
        ->and($result[0]->code)->toBe('test.code')
        ->and($result[0]->label)->toBe('Test Permission')
        ->and($result[0]->group)->toBe('Test Group');
});

it('returns registered permissions from extensions', function(): void {
    $permissionManager = new PermissionManager;

    $result = $permissionManager->listPermissions();

    expect($result)->not->toBeEmpty();
});

it('returns grouped permissions', function(): void {
    $permissionManager = new PermissionManager;
    $permissionManager->registerPermissions('testOwner', [
        'test.code' => [
            'label' => 'Test Permission',
            'group' => 'Test Group',
        ],
        'test.another-code' => [
            'label' => 'Test Permission',
        ],
    ]);

    $result = $permissionManager->listGroupedPermissions();

    expect($result)->toHaveKey('test group')
        ->and($result['test group'])->toHaveCount(1)
        ->and($result['test group'][0]->code)->toBe('test.code');
});

it('checks permission with starts with wildcard', function(): void {
    $permissionManager = new PermissionManager;
    $permissions = ['test.*' => 1];

    $result = $permissionManager->checkPermission($permissions, ['test.view'], false);

    expect($result)->toBeTrue();
});

it('checks permission with ends with wildcard', function(): void {
    $permissionManager = new PermissionManager;
    $permissions = ['*.view' => 1];

    $result = $permissionManager->checkPermission($permissions, ['test.view'], false);

    expect($result)->toBeTrue();
});

it('checks permission with exact match', function(): void {
    $permissionManager = new PermissionManager;
    $permissions = ['test.view' => 1];

    $result = $permissionManager->checkPermission($permissions, ['test.view'], false);

    expect($result)->toBeTrue();
});

it('returns false when permission is not matched', function(): void {
    $permissionManager = new PermissionManager;
    $permissions = ['test.view' => 1];

    $result = $permissionManager->checkPermission($permissions, ['test.edit'], true);

    expect($result)->toBeFalse();

    $result = $permissionManager->checkPermission($permissions, ['test.edit'], false);

    expect($result)->toBeFalse();
});

it('executes registered callback functions', function(): void {
    $extensionManager = Mockery::mock(ExtensionManager::class);
    $extensionManager->shouldReceive('getRegistrationMethodValues')->with('registerPermissions')->andReturn([]);
    app()->instance(ExtensionManager::class, $extensionManager);
    $permissionManager = new PermissionManager;
    $callback = function($manager): void {
        $manager->registerPermissions('testOwner', [
            'test.code' => [
                'description' => 'Test Permission',
                'group' => 'Test Group',
            ],
        ]);
    };

    $permissionManager->registerCallback($callback);
    $permissionManager->listPermissions();

    $permissions = $permissionManager->listPermissions();
    expect($permissions)->toHaveCount(1)
        ->and($permissions[0]->code)->toBe('test.code')
        ->and($permissions[0]->label)->toBe('Test Permission')
        ->and($permissions[0]->group)->toBe('Test Group');
});
