<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Requests;

use Igniter\User\Http\Requests\UserSettingsRequest;

it('returns correct attribute labels for user settings', function(): void {
    $attributes = (new UserSettingsRequest)->attributes();

    expect($attributes['allow_registration'])->toBe(lang('igniter::system.settings.label_allow_registration'))
        ->and($attributes['registration_email.*'])->toBe(lang('igniter::system.settings.label_registration_email'));
});

it('validates rules correctly for user settings', function(): void {
    $rules = (new UserSettingsRequest)->rules();

    expect($rules['allow_registration'])->toBe(['required', 'integer'])
        ->and($rules['registration_email'])->toBe(['required', 'array'])
        ->and($rules['registration_email.*'])->toBe(['required', 'alpha']);
});
