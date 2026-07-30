<?php

declare(strict_types=1);

return [
    'fields' => [
        'test_field' => [
            'label' => 'Test Field',
            'type' => 'text',
        ],
    ],
    'rules' => [
        ['test_field', 'lang:igniter.payregister::default.stripe.label_test_field', 'required|string'],
    ],
    'validationAttributes' => [
        'test_field' => 'lang:igniter.payregister::default.stripe.label_test_field',
    ],
    'validationMessages' => [
        'test_field.required' => 'lang:igniter.payregister::default.stripe.label_test_field',
        'test_field.string' => 'lang:igniter.payregister::default.stripe.label_test_field',
    ],
];
