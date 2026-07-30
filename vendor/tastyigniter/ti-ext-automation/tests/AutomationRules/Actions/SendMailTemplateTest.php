<?php

declare(strict_types=1);

namespace Igniter\Automation\Tests\AutomationRules\Actions;

use Igniter\Automation\AutomationException;
use Igniter\Automation\AutomationRules\Actions\SendMailTemplate;
use Igniter\Automation\Models\RuleAction;
use Igniter\Local\Models\Location;
use Igniter\System\Mail\AnonymousTemplateMailable;
use Igniter\System\Models\MailTemplate;
use Igniter\User\Models\Customer;
use Igniter\User\Models\CustomerGroup;
use Igniter\User\Models\User;
use Igniter\User\Models\UserGroup;
use Illuminate\Support\Facades\Mail;

beforeEach(function(): void {
    $this->mailTemplate = MailTemplate::create([
        'code' => 'test_template',
        'subject' => 'Test Subject',
        'body' => 'Test Body',
        'is_custom' => 1,
    ]);
});

it('sends mail template to custom email', function(): void {
    Mail::fake();

    $customEmail = 'custom@domain.tld';
    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => $this->mailTemplate->code,
        'send_to' => 'custom',
        'custom' => $customEmail,
    ]));

    $sendMailTemplate->triggerAction([]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $customEmail);
});

it('sends mail template to restaurant', function(): void {
    Mail::fake();

    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => $this->mailTemplate->code,
        'send_to' => 'restaurant',
    ]));

    $sendMailTemplate->triggerAction([]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === setting('site_email', config('mail.from.address')));
});

it('sends mail template to staff group', function(): void {
    Mail::fake();

    $staff = User::factory()->create(['status' => true]);
    $staffGroup = UserGroup::factory()->create();
    $staff->addGroups([$staffGroup->getKey()]);

    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => $this->mailTemplate->code,
        'send_to' => 'staff_group',
        'staff_group' => $staffGroup->getKey(),
    ]));

    $sendMailTemplate->triggerAction([]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $staff->email);
});

it('sends mail template to customer group', function(): void {
    Mail::fake();

    $customerGroup = CustomerGroup::factory()->create();
    $customer = Customer::factory()->create([
        'customer_group_id' => $customerGroup->getKey(),
    ]);
    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => $this->mailTemplate->code,
        'send_to' => 'customer_group',
        'customer_group' => $customerGroup->getKey(),
    ]));

    $sendMailTemplate->triggerAction([]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $customer->email);
});

it('sends mail template to location', function(): void {
    Mail::fake();

    $location = Location::factory()->create();

    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => $this->mailTemplate->code,
        'send_to' => 'location',
    ]));

    $sendMailTemplate->triggerAction(['location' => $location]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $location->location_email);
});

it('sends mail template to system', function(): void {
    Mail::fake();

    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => $this->mailTemplate->code,
        'send_to' => 'system',
    ]));

    $sendMailTemplate->triggerAction([]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === setting('site_email', config('mail.from.address')));
});

it('sends mail template to customer', function(): void {
    Mail::fake();

    $customer = Customer::factory()->create();
    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => $this->mailTemplate->code,
        'send_to' => 'customer',
    ]));

    $sendMailTemplate->triggerAction(['customer' => $customer]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $customer->email);

    $sendMailTemplate->triggerAction([
        'first_name' => $customer->first_name,
        'last_name' => $customer->last_name,
        'email' => $customer->email,
    ]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $customer->email);
});

it('sends mail template to staff', function(): void {
    Mail::fake();

    $staff = User::factory()->create();
    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => $this->mailTemplate->code,
        'send_to' => 'staff',
    ]));

    $sendMailTemplate->triggerAction(['staff' => $staff]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $staff->email);

    $sendMailTemplate->triggerAction([
        'order' => (object)['assignee' => $staff],
    ]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $staff->email);
});

it('sends mail template to all staff', function(): void {
    Mail::fake();

    $staff1 = User::factory()->create(['status' => true]);
    $staff2 = User::factory()->create(['status' => true]);

    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => $this->mailTemplate->code,
        'send_to' => 'all_staff',
    ]));

    $sendMailTemplate->triggerAction([]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $staff1->email);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $staff2->email);
});

it('sends mail template to all customers', function(): void {
    Mail::fake();

    $customer1 = Customer::factory()->create(['status' => 1]);
    $customer2 = Customer::factory()->create(['status' => 1]);

    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => $this->mailTemplate->code,
        'send_to' => 'all_customer',
    ]));

    $sendMailTemplate->triggerAction([]);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $customer1->email);

    Mail::assertSent(AnonymousTemplateMailable::class, fn($mailable): bool => $mailable->getTemplateCode() === $this->mailTemplate->code
        && array_get($mailable->to, '0.address') === $customer2->email);
});

it('throws exception when missing mail template', function(): void {
    $sendMailTemplate = new SendMailTemplate(new RuleAction(['template' => null]));

    expect(fn() => $sendMailTemplate->triggerAction([]))
        ->toThrow(AutomationException::class, 'SendMailTemplate: Missing a valid mail template');
});

it('throws exception when missing recipient', function(): void {
    $sendMailTemplate = new SendMailTemplate(new RuleAction(['template' => 'test_template']));

    expect(fn() => $sendMailTemplate->triggerAction([]))
        ->toThrow(AutomationException::class, 'SendMailTemplate: Missing a valid recipient from the event payload');
});

it('throws exception when missing staff group', function(): void {
    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => 'test_template',
        'send_to' => 'staff_group',
        'staff_group' => 123,
    ]));

    expect(fn() => $sendMailTemplate->triggerAction([]))
        ->toThrow(AutomationException::class, 'SendMailTemplate: Unable to find staff group with ID: 123');
});

it('throws exception when missing customer group', function(): void {
    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => 'test_template',
        'send_to' => 'customer_group',
        'customer_group' => 123,
    ]));

    expect(fn() => $sendMailTemplate->triggerAction([]))
        ->toThrow(AutomationException::class, 'SendMailTemplate: Unable to find customer group with ID: 123');
});

it('throws exception when missing customer', function(): void {
    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => 'test_template',
        'send_to' => 'customer',
    ]));

    expect(fn() => $sendMailTemplate->triggerAction([]))
        ->toThrow(AutomationException::class, 'SendMailTemplate: Missing a valid customer email address');
});

it('throws exception when missing staff', function(): void {
    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => 'test_template',
        'send_to' => 'staff',
    ]));

    expect(fn() => $sendMailTemplate->triggerAction([]))
        ->toThrow(AutomationException::class, 'SendMailTemplate: Missing a valid staff email address');
});

it('sends nothing when missing custom email', function(): void {
    Mail::fake();

    $sendMailTemplate = new SendMailTemplate(new RuleAction([
        'template' => 'test_template',
        'send_to' => 'custom',
        'custom' => null,
    ]));

    $sendMailTemplate->triggerAction([]);

    Mail::assertNothingSent();
});

it('returns template options as dropdown', function(): void {
    $action = new SendMailTemplate;
    $result = $action->getTemplateOptions();

    expect($result)->toBeCollection();
});

it('returns send to options', function(): void {
    $expectedOptions = [
        'custom' => 'lang:igniter.user::default.text_send_to_custom',
        'restaurant' => 'lang:igniter.user::default.text_send_to_restaurant',
        'location' => 'lang:igniter.user::default.text_send_to_location',
        'staff' => 'lang:igniter.user::default.text_send_to_staff_email',
        'customer' => 'lang:igniter.user::default.text_send_to_customer_email',
        'customer_group' => 'lang:igniter.user::default.text_send_to_customer_group',
        'staff_group' => 'lang:igniter.user::default.text_send_to_staff_group',
        'all_staff' => 'lang:igniter.user::default.text_send_to_all_staff',
        'all_customer' => 'lang:igniter.user::default.text_send_to_all_customer',
    ];

    $action = new SendMailTemplate;
    $result = $action->getSendToOptions();

    expect($result)->toBe($expectedOptions);
});
