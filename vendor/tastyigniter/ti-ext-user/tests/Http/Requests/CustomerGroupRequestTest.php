<?php

declare(strict_types=1);

namespace Igniter\User\Tests\Http\Requests;

use Igniter\User\Http\Requests\CustomerGroupRequest;

it('returns correct attribute labels for customer group', function(): void {
    $attributes = (new CustomerGroupRequest)->attributes();

    expect($attributes['group_name'])->toBe(lang('igniter::admin.label_name'))
        ->and($attributes['description'])->toBe(lang('igniter::admin.label_description'));
});

it('validates rules correctly for customer group', function(): void {
    $rules = (new CustomerGroupRequest)->rules();

    expect($rules['group_name'])->toContain('required', 'string', 'between:2,32')
        ->and($rules['group_name'][3]->__toString())->toBe('unique:customer_groups,NULL,NULL,customer_group_id')
        ->and($rules['approval'])->toBe(['required', 'boolean'])
        ->and($rules['description'])->toBe(['nullable', 'string', 'between:2,512']);
});
