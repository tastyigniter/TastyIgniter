<?php

namespace Tests\Unit\Admin\Requests;

use Admin\Models\Customer;
use Tests\RefreshDatabase;

uses(RefreshDatabase::class);
uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequest(\Admin\Requests\Customer::class, $callback);
})->with([
    'request_should_fail_when_no_first_name_is_provided' => [
        function () {
            return [FALSE, array_except(Customer::factory()->raw(), ['first_name'])];
        },
    ],
]);
