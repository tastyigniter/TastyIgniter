<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models;

use Igniter\User\Models\Notification;
use Igniter\User\Models\User;
use Illuminate\Database\Eloquent\Prunable;

it('can get title attribute', function(): void {
    $notification = new Notification;
    $notification->data = ['title' => 'Test Title'];

    expect($notification->title)->toEqual('Test Title');
});

it('can get message attribute', function(): void {
    $notification = new Notification;
    $notification->data = ['message' => 'Test Message'];

    expect($notification->message)->toEqual('Test Message');
});

it('can get url attribute', function(): void {
    $notification = new Notification;
    $notification->data = ['url' => 'http://localhost'];

    expect($notification->url)->toEqual('http://localhost');
});

it('can get icon attribute', function(): void {
    $notification = new Notification;
    $notification->data = ['icon' => 'fa fa-bell'];

    expect($notification->icon)->toEqual('fa fa-bell');
});

it('can get icon color attribute', function(): void {
    $notification = new Notification;
    $notification->data = ['iconColor' => '#ff0000'];

    expect($notification->iconColor)->toEqual('#ff0000');
});

it('can scope where notifiable', function(): void {
    $query = Notification::query();
    $notifiable = User::factory()->create();

    $query = $query->whereNotifiable($notifiable);

    expect($query->toSql())->toContain('where ((`notifications`.`notifiable_type` = ? and `notifications`.`notifiable_id` in (?)))');
});

it('can prune notifications', function(): void {
    $query = (new Notification)->prunable();

    expect($query->toSql())->toContain('`read_at` is not null and `read_at` <= ?');
});

it('configures automation logs correctly', function(): void {
    $model = new Notification;

    expect(class_uses_recursive($model))
        ->toHaveKey(Prunable::class);
});
