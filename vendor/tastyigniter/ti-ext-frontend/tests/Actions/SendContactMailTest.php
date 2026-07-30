<?php

declare(strict_types=1);

namespace Igniter\Frontend\Tests\Actions;

use Igniter\Frontend\Actions\SendContactMail;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Illuminate\Support\Facades\Mail;

beforeEach(function(): void {
    $this->data = ['name' => 'John Doe', 'email' => 'john@example.com', 'message' => 'Hello'];
});

it('queues contact mail with correct data', function(): void {
    Mail::fake();

    (new SendContactMail)($this->data);

    Mail::assertQueued(AnonymousTemplateMailable::class, fn($mail): bool => $mail->getTemplateCode() === 'igniter.frontend::mail.contact');
});
