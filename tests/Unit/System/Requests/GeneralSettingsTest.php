<?php

namespace Tests\Unit\System\Requests;

use function Pest\Faker\faker;

uses(\Tests\Unit\System\Requests\ValidateRequest::class);

test('validation results as expected', function ($callback) {
    $this->assertFormRequest(\System\Requests\GeneralSettings::class, $callback);
})->with([
    'request_should_fail_when_no_site_name_is_provided' => [
        function () {
            return [FALSE, array_except(generalSettingsData(), 'site_name')];
        },
    ],
    'request_should_fail_when_no_site_email_is_provided' => [
        function () {
            return [FALSE, array_except(generalSettingsData(), 'site_email')];
        },
    ],
    'request_should_fail_when_no_distance_unit_is_provided' => [
        function () {
            return [FALSE, array_except(generalSettingsData(), 'distance_unit')];
        },
    ],
    'request_should_fail_when_no_default_geocoder_is_provided' => [
        function () {
            return [FALSE, array_except(generalSettingsData(), 'default_geocoder')];
        },
    ],
    'request_should_fail_when_no_timezone_is_provided' => [
        function () {
            return [FALSE, array_except(generalSettingsData(), 'timezone')];
        },
    ],
    'request_should_fail_when_no_default_currency_code_is_provided' => [
        function () {
            return [FALSE, array_except(generalSettingsData(), 'default_currency_code')];
        },
    ],
    'request_should_fail_when_no_default_language_is_provided' => [
        function () {
            return [FALSE, array_except(generalSettingsData(), 'default_language')];
        },
    ],
    'request_should_fail_when_no_country_id_is_provided' => [
        function () {
            return [FALSE, array_except(generalSettingsData(), 'country_id')];
        },
    ],
    'request_should_fail_when_site_name_is_less_than_2' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['site_name' => faker()->lexify('?'),
            ]),
            ];
        },
    ],
    'request_should_fail_when_site_name_is_greater_than_128' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['site_name' => faker()->sentence(128),
            ]),
            ];
        },
    ],
    'request_should_fail_when_site_email_is_not_valid_email' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['site_email' => faker()->word(),
            ]),
            ];
        },
    ],
    'request_should_fail_when_site_email_is_greater_than_96' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['site_email' => faker()->sentence(128),
            ]),
            ];
        },
    ],
    'request_should_fail_when_distance_unit_is_not_valid' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['distance_unit' => faker()->word(),
            ]),
            ];
        },
    ],
    'request_should_fail_when_default_geocoder_is_not_valid' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['default_geocoder' => faker()->word(),
            ]),
            ];
        },
    ],
    'request_should_fail_when_maps_api_key_is_not_alpha_dash' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['maps_api_key' => faker()->text(),
            ]),
            ];
        },
    ],
    'request_should_fail_when_timezone_is_not_valid_timezone' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['timezone' => faker()->word(),
            ]),
            ];
        },
    ],
    'request_should_fail_when_default_currency_code_is_not_string' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['default_currency_code' => faker()->randomDigit(),
            ]),
            ];
        },
    ],
    'request_should_fail_when_default_language_is_not_string' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['default_language' => faker()->randomDigit(),
            ]),
            ];
        },
    ],
    'request_should_fail_when_detect_language_is_not_boolean' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), ['detect_language' => faker()->numberBetween(2, 99),
            ]),
            ];
        },
    ],
    'request_should_fail_when_country_id_is_not_integer' => [
        function () {
            return [FALSE, array_merge(generalSettingsData(), [
                'country_id' => faker()->word(),
            ])];
        },
    ],

    'request_should_pass_when_data_is_provided' => [
        function () {
            return [TRUE, generalSettingsData()];
        },
    ],
]);

function generalSettingsData(): array
{
    return [
        'site_name' => faker()->word(),
        'site_email' => faker()->email(),
        'site_logo' => 'no_phone.png',
        'timezone' => faker()->timezone(),
        'default_currency_code' => faker()->currencyCode(),
        'default_language' => faker()->locale(),
        'detect_language' => faker()->boolean(),
        'distance_unit' => faker()->randomElement(['mi', 'km']),
        'default_geocoder' => faker()->randomElement(['nominatim', 'google', 'chain']),
        'maps_api_key' => faker()->word(60),
        'country_id' => faker()->randomDigit(),
    ];
}
