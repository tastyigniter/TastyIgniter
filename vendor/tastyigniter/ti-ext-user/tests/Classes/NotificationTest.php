<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Classes;

use Igniter\Broadcast\Models\Settings;
use Igniter\User\Classes\Notification;
use Igniter\User\Models\User;
use Mockery;
use stdClass;

it('creates a notification instance with parameters', function(): void {
    $notification = Notification::make()
        ->title('Test Title')
        ->message('Test Message')
        ->subject(new User);

    expect($notification->getTitle())->toBe('Test Title')
        ->and($notification->getMessage())->toBe('Test Message')
        ->and($notification->getRecipients())->toBeArray();
});

it('broadcasts notification to users', function(): void {
    $user = Mockery::mock(User::class);
    $user->shouldReceive('notify')->once();

    $notification = new Notification;
    $notification->broadcast([$user]);
});

it('returns correct channels when broadcast is configured', function(): void {
    Settings::set([
        'provider' => 'pusher',
        'app_id' => 'foo',
        'key' => 'foo',
        'secret' => 'foo',
    ]);

    $notification = new Notification;
    $channels = $notification->via(new stdClass);

    expect($channels)->toContain('database', 'broadcast');
    Settings::clearInternalCache();
});

it('returns correct channels when broadcast is not configured', function(): void {
    $notification = new Notification;
    $channels = $notification->via(new stdClass);

    expect($channels)->toContain('database')
        ->and($channels)->not->toContain('broadcast');
});

it('returns correct database notification data', function(): void {
    $notification = (new Notification)
        ->title('Test Title')
        ->message('Test Message')
        ->url('http://example.com')
        ->icon('icon.png')
        ->iconColor('blue');

    $data = $notification->toDatabase(new stdClass);

    expect($data)->toBe([
        'title' => 'Test Title',
        'icon' => 'icon.png',
        'iconColor' => 'blue',
        'url' => 'http://example.com',
        'message' => 'Test Message',
    ]);
});

it('returns correct broadcast notification data', function(): void {
    $notification = (new Notification)
        ->title('Test Title')
        ->message('Test Message')
        ->url('http://example.com')
        ->icon('icon.png')
        ->iconColor('blue');

    $broadcastMessage = $notification->toBroadcast(new stdClass);

    expect($broadcastMessage->data)->toBe([
        'title' => 'Test Title',
        'icon' => 'icon.png',
        'iconColor' => 'blue',
        'url' => 'http://example.com',
        'message' => 'Test Message',
    ]);
});

it('returns correct alias for database type', function(): void {
    $notification = new Notification;
    $alias = $notification->databaseType(new stdClass);

    expect($alias)->toBe(Notification::class);
});

it('returns correct alias for broadcast type', function(): void {
    $notification = new Notification;
    $alias = $notification->broadcastType();

    expect($alias)->toBe(Notification::class);
});
