<?php

namespace Tests\Unit\System\Requests;

use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequest(\System\Requests\AdvancedSettings::class, $callback);
})->with([
    'request_should_fail_when_no_enable_request_log_is_provided' => [
        function () {
            return [FALSE, array_except(advancedSettingsData(), 'enable_request_log')];
        },
    ],
    'request_should_fail_when_no_maintenance_mode_is_provided' => [
        function () {
            return [FALSE, array_except(advancedSettingsData(), 'maintenance_mode')];
        },
    ],
    'request_should_fail_when_no_maintenance_message_is_provided' => [
        function () {
            return [FALSE, array_merge(advancedSettingsData(), [
                'maintenance_mode' => TRUE,
                'maintenance_message' => null,
            ])];
        },
    ],
    'request_should_fail_when_no_activity_log_timeout_is_provided' => [
        function () {
            return [FALSE, array_except(advancedSettingsData(), 'activity_log_timeout')];
        },
    ],
    'request_should_fail_when_enable_request_log_is_not_boolean' => [
        function () {
            return [FALSE, array_merge(advancedSettingsData(), ['maintenance_mode' => faker()->word()])];
        },
    ],
    'request_should_fail_when_maintenance_mode_is_not_boolean' => [
        function () {
            return [FALSE, array_merge(advancedSettingsData(), ['maintenance_mode' => faker()->word()])];
        },
    ],
    'request_should_fail_when_maintenance_message_is_not_string' => [
        function () {
            return [FALSE, array_merge(advancedSettingsData(), ['maintenance_message' => []])];
        },
    ],
    'request_should_fail_when_activity_log_timeout_is_greater_than_999' => [
        function () {
            return [FALSE, array_merge(advancedSettingsData(), ['activity_log_timeout' => faker()->numberBetween(1000, 99999)])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, advancedSettingsData()];
        },
    ],
]);

function advancedSettingsData(): array
{
    return [
        'enable_request_log' => faker()->boolean(),
        'maintenance_mode' => faker()->boolean(),
        'maintenance_message' => faker()->sentence(),
        'activity_log_timeout' => faker()->numberBetween(0, 999),
    ];
}
