<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Requests;

use Igniter\User\Http\Requests\UserRoleRequest;

it('returns correct attribute labels for user role', function(): void {
    $attributes = (new UserRoleRequest)->attributes();

    expect($attributes['code'])->toBe(lang('igniter::admin.label_code'))
        ->and($attributes['name'])->toBe(lang('igniter::admin.label_name'))
        ->and($attributes['permissions'])->toBe(lang('igniter.user::default.user_roles.label_permissions'))
        ->and($attributes['permissions.*'])->toBe(lang('igniter.user::default.user_roles.label_permissions'));
});

it('validates rules correctly for user role', function(): void {
    $rules = (new UserRoleRequest)->rules();

    expect($rules['code'])->toBe(['string', 'between:2,32', 'alpha_dash'])
        ->and($rules['name'])->toContain('required', 'string', 'between:2,255')
        ->and($rules['name'][3]->__toString())->toBe('unique:admin_user_roles,NULL,NULL,user_role_id')
        ->and($rules['permissions'])->toBe(['required', 'array'])
        ->and($rules['permissions.*'])->toBe(['required', 'integer']);
});
