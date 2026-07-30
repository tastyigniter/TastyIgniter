<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Requests;

use Igniter\User\Http\Requests\UserRequest;
use Illuminate\Validation\Rules\Password;

it('has correct attribute labels', function(): void {
    $attributes = (new UserRequest)->attributes();

    expect($attributes['name'])->toBe(lang('igniter::admin.label_name'))
        ->and($attributes['email'])->toBe(lang('igniter::admin.label_email'))
        ->and($attributes['username'])->toBe(lang('igniter.user::default.staff.label_username'))
        ->and($attributes['password'])->toBe(lang('igniter.user::default.staff.label_password'))
        ->and($attributes['password_confirm'])->toBe(lang('igniter.user::default.staff.label_confirm_password'))
        ->and($attributes['status'])->toBe(lang('igniter::admin.label_status'))
        ->and($attributes['language_id'])->toBe(lang('igniter.user::default.staff.label_language_id'))
        ->and($attributes['user_role_id'])->toBe(lang('igniter.user::default.staff.label_role'))
        ->and($attributes['groups'])->toBe(lang('igniter.user::default.staff.label_group'))
        ->and($attributes['locations'])->toBe(lang('igniter.user::default.staff.label_location'))
        ->and($attributes['groups.*'])->toBe(lang('igniter.user::default.staff.label_group'))
        ->and($attributes['locations.*'])->toBe(lang('igniter.user::default.staff.label_location'));
});

it('has correct validation rules', function(): void {
    $userRequest = new UserRequest;
    $userRequest->setMethod('post');
    $userRequest->merge([
        'send_invite' => false,
        'password' => 'Pa$$w0rd!',
        'password_confirm' => 'Pa$$w0rd!',
    ]);
    $rules = $userRequest->rules();

    expect($rules['name'])->toBe(['required', 'string', 'between:2,255'])
        ->and($rules['email'])->toContain('required', 'email:filter', 'max:96')
        ->and($rules['email'][3]->__toString())->toBe('unique:admin_users,NULL,NULL,user_id')
        ->and($rules['telephone'])->toContain('nullable', 'string')
        ->and($rules['username'])->toContain('required', 'alpha_dash', 'between:2,32')
        ->and($rules['username'][3]->__toString())->toBe('unique:admin_users,NULL,NULL,user_id')
        ->and($rules['send_invite'])->toBe(['present', 'boolean'])
        ->and($rules['password'])->toContain('nullable', 'required_if_declined:send_invite', 'string', 'same:password_confirm')
        ->and($rules['password'][3])->toBeInstanceOf(Password::class)
        ->and($rules['status'])->toBe(['boolean'])
        ->and($rules['super_user'])->toBe(['boolean'])
        ->and($rules['language_id'])->toBe(['nullable', 'integer'])
        ->and($rules['user_role_id'])->toBe(['sometimes', 'required', 'integer'])
        ->and($rules['groups'])->toBe(['sometimes', 'required', 'array'])
        ->and($rules['locations'])->toBe(['nullable', 'array'])
        ->and($rules['groups.*'])->toBe(['integer'])
        ->and($rules['locations.*'])->toBe(['integer']);
});

it('has correct validation rules when request method is patch', function(): void {
    $userRequest = new UserRequest;
    $userRequest->setMethod('patch');
    $rules = $userRequest->rules();

    expect($rules)
        ->not->toHaveKey('send_invite')
        ->and($rules['password'])->toContain('nullable', 'exclude_without:password_confirm', 'string', 'same:password_confirm')
        ->and($rules['password'][3])->toBeInstanceOf(Password::class);
});
