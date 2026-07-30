<?php

declare(strict_types=1);

namespace Igniter\Frontend\Tests\Models;

use Igniter\Frontend\Models\CaptchaSettings;
use Igniter\System\Actions\SettingsModel;

it('configures captcha settings model correctly', function(): void {
    $model = new CaptchaSettings;

    expect($model->implement)->toContain(SettingsModel::class)
        ->and($model->settingsCode)->toEqual('igniter_frontend_captchasettings')
        ->and($model->settingsFieldsConfig)->toEqual('captchasettings')
        ->and(CaptchaSettings::getLang())->toBe('en');
});
