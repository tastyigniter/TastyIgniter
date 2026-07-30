<?php

declare(strict_types=1);

namespace Igniter\Frontend\Tests\Models;

use Igniter\Frontend\Models\MailchimpSettings;
use Igniter\Frontend\Models\Subscriber;
use Illuminate\Support\Facades\Event;

it('subscribes an email to the database', function(): void {
    Event::fake();

    $email = 'email@example.com';
    $subscriber = Subscriber::subscribe($email);

    expect($subscriber->email)->toBe($email);
    Event::assertDispatched('igniter.frontend.subscribed');
});

it('subscribes to Mailchimp when listId is provided and configured', function(): void {
    Event::fake();
    MailchimpSettings::set([
        'api_key' => 'some-api-key',
        'list_id' => 'some-list-id',
    ]);

    $email = 'email@example.com';
    $listId = 'list-id';
    Subscriber::subscribe($email, $listId);

    Event::assertDispatched('igniter.frontend.subscribed');
});

it('configures subscriber model correctly', function(): void {
    $slider = new Subscriber;

    expect($slider->getTable())->toBe('igniter_frontend_subscribers')
        ->and($slider->getKeyName())->toBe('id')
        ->and($slider->getFillable())->toBe(['email']);
});
