<?php

declare(strict_types=1);

namespace Igniter\Frontend\Tests\Models;

use Igniter\Frontend\Models\MailchimpSettings;
use Igniter\System\Actions\SettingsModel;

it('returns true when api_key and list_id are configured', function(): void {
    MailchimpSettings::set([
        'api_key' => 'some-api-key',
        'list_id' => 'some-list-id',
    ]);

    $result = MailchimpSettings::isConfigured();

    expect($result)->toBeTrue();
});

it('returns false when api_key is not configured', function(): void {
    MailchimpSettings::set([
        'api_key' => '',
        'list_id' => 'some-list-id',
    ]);

    $result = MailchimpSettings::isConfigured();

    expect($result)->toBeFalse();
});

it('configures captcha settings model correctly', function(): void {
    $model = new MailchimpSettings;

    expect($model->implement)->toContain(SettingsModel::class)
        ->and($model->settingsCode)->toEqual('igniter_frontend_mailchimpsettings')
        ->and($model->settingsFieldsConfig)->toEqual('mailchimpsettings');
});
