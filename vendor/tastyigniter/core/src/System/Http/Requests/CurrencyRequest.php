<?php

declare(strict_types=1);

namespace Igniter\System\Http\Requests;

use Igniter\System\Classes\FormRequest;
use Override;

class CurrencyRequest extends FormRequest
{
    #[Override]
    public function attributes(): array
    {
        return [
            'currency_name' => lang('igniter::system.currencies.label_title'),
            'currency_code' => lang('igniter::system.currencies.label_code'),
            'currency_symbol' => lang('igniter::system.currencies.label_symbol'),
            'country_id' => lang('igniter::system.currencies.label_country'),
            'symbol_position' => lang('igniter::system.currencies.label_symbol_position'),
            'currency_rate' => lang('igniter::system.currencies.label_rate'),
            'thousand_sign' => lang('igniter::system.currencies.label_thousand_sign'),
            'decimal_sign' => lang('igniter::system.currencies.label_decimal_sign'),
            'decimal_position' => lang('igniter::system.currencies.label_decimal_position'),
            'currency_status' => lang('igniter::admin.label_status'),
        ];
    }

    public function rules(): array
    {
        return [
            'currency_name' => ['required', 'string', 'between:2,32'],
            'currency_code' => ['required', 'string', 'size:3'],
            'currency_symbol' => ['required', 'string'],
            'country_id' => ['required', 'integer'],
            'symbol_position' => ['string', 'size:1'],
            'currency_rate' => ['numeric'],
            'thousand_sign' => ['string', 'size:1'],
            'decimal_sign' => ['string', 'size:1'],
            'decimal_position' => ['integer', 'max:10'],
            'currency_status' => ['required', 'boolean'],
        ];
    }
}
