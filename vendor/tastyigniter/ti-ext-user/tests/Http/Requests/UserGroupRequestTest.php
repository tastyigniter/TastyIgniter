<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Requests;

use Igniter\User\Http\Requests\UserGroupRequest;

it('returns correct attribute labels for user group', function(): void {
    $attributes = (new UserGroupRequest)->attributes();

    expect($attributes['user_group_name'])->toBe(lang('igniter::admin.label_name'))
        ->and($attributes['description'])->toBe(lang('igniter::admin.label_description'))
        ->and($attributes['auto_assign'])->toBe(lang('igniter.user::default.user_groups.label_auto_assign'))
        ->and($attributes['auto_assign_mode'])->toBe(lang('igniter.user::default.user_groups.label_assignment_mode'))
        ->and($attributes['auto_assign_limit'])->toBe(lang('igniter.user::default.user_groups.label_load_balanced_limit'))
        ->and($attributes['auto_assign_availability'])->toBe(lang('igniter.user::default.user_groups.label_assignment_availability'));
});

it('validates rules correctly for user group', function(): void {
    $rules = (new UserGroupRequest)->rules();

    expect($rules['user_group_name'])->toContain('required', 'string', 'between:2,255')
        ->and($rules['user_group_name'][3]->__toString())->toBe('unique:admin_user_groups,NULL,NULL,user_group_id')
        ->and($rules['description'])->toBe(['string'])
        ->and($rules['auto_assign'])->toBe(['required', 'boolean'])
        ->and($rules['auto_assign_mode'])->toBe(['required_if:auto_assign,true', 'integer', 'max:2'])
        ->and($rules['auto_assign_limit'])->toBe(['required_if:auto_assign_mode,2', 'integer', 'max:99'])
        ->and($rules['auto_assign_availability'])->toBe(['required_if:auto_assign,true', 'boolean']);
});
