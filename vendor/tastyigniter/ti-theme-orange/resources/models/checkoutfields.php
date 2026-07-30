<?php

declare(strict_types=1);

use Igniter\User\Facades\Auth;
use Illuminate\Validation\Rule;

return [
    'fields' => [
        'first_name' => [
            'label' => 'lang:igniter.cart::default.checkout.label_first_name',
            'tab' => 'details',
            'type' => 'text',
        ],
        'last_name' => [
            'label' => 'lang:igniter.cart::default.checkout.label_last_name',
            'tab' => 'details',
            'type' => 'text',
        ],
        'email' => [
            'label' => 'lang:igniter.cart::default.checkout.label_email',
            'tab' => 'details',
            'type' => 'email',
        ],
        'telephone' => [
            'label' => 'lang:igniter.cart::default.checkout.label_telephone',
            'tab' => 'details',
            'type' => 'telephone',
        ],
        'comment' => [
            'label' => 'lang:igniter.cart::default.checkout.label_comment',
            'tab' => 'comments',
            'type' => 'textarea',
            'cssClass' => 'col-sm-12',
        ],
        'delivery_comment' => [
            'label' => 'lang:igniter.cart::default.checkout.label_delivery_comment',
            'tab' => 'comments',
            'type' => 'textarea',
            'cssClass' => 'col-sm-12',
        ],
        'payment' => [
            'label' => 'lang:igniter.cart::default.checkout.label_payment_method',
            'tab' => 'payments',
            'type' => 'payments',
            'cssClass' => 'col-sm-12',
        ],
        'termsAgreed' => [
            'label' => 'lang:igniter.cart::default.checkout.text_checkout_terms',
            'tab' => 'terms',
            'type' => 'checkbox',
            'cssClass' => 'col-sm-12',
            'options' => [],
        ],
    ],
    'rules' => [
        'first_name' => ['required', 'between:1,48'],
        'last_name' => ['required', 'between:1,48'],
        'email' => ['sometimes', 'required', 'email:filter', 'max:96',
            Rule::unique('customers', 'email')->ignore(Auth::customer()?->getKey(), 'customer_id'),
        ],
        'telephone' => ['sometimes', 'required_if:telephoneIsRequired,true', 'regex:/^([0-9\s\-\+\(\)]*)$/i'],
        'comment' => ['max:500'],
        'delivery_comment' => ['max:500'],
        'payment' => ['sometimes', 'nullable', 'alpha_dash'],
        'termsAgreed' => ['sometimes', 'accepted'],
        'payment_fields' => ['sometimes', 'array'],
        'payment_fields.*' => ['sometimes'],
        'payment_fields.pay_from_profile' => ['sometimes', 'integer'],
        'payment_fields.create_payment_profile' => ['sometimes', 'integer'],
    ],
    'messages' => [
        'telephone.required_if' => lang('igniter.orange::default.error_telephone_required'),
        'telephone.regex' => lang('igniter.orange::default.error_telephone_invalid'),
    ],
];
