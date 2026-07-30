<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Models\Concerns;

use Igniter\System\Mail\AnonymousTemplateMailable;
use Igniter\User\Models\Concerns\SendsInvite;
use Igniter\User\Models\User;
use Illuminate\Support\Facades\Mail;
use LogicException;
use Mockery;

it('adds send_invite to purgeable attributes on boot', function(): void {
    expect((new User)->getPurgeableAttributes())->toContain('send_invite');
});

it('restores purged values and sends invite on save when send_invite is true', function(): void {
    Mail::fake();

    $user = User::factory()->create();
    $user->name = 'Test User';
    $user->send_invite = true;
    $user->save();

    Mail::assertQueued(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === 'igniter.user::mail.invite');
});

it('does not send invite on save when send_invite is false', function(): void {
    Mail::fake();

    $user = User::factory()->create();
    $user->name = 'Test User';
    $user->send_invite = false;
    $user->save();

    Mail::assertNotQueued(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === 'igniter.user::mail.invite');
});

it('throws exception when mailSendsInvite is called without implementing sendsInviteGetTemplateCode', function(): void {
    $model = Mockery::mock(SendsInvite::class)->makePartial();

    $this->expectException(LogicException::class);
    $this->expectExceptionMessage('The model ['.$model::class.'] must implement a sendsInviteGetTemplateCode() method.');

    $model->mailSendInvite();
});

it('updates reset_code, reset_time, and invited_at when SendsInvite is called', function(): void {
    Mail::fake();

    $user = User::factory()->create();
    $user->name = 'Test User';
    $user->send_invite = true;
    $user->save();

    $user = $user->fresh();

    expect($user->reset_code)->not->toBeNull()
        ->and($user->reset_time)->not->toBeNull()
        ->and($user->invited_at)->not->toBeNull();
});
