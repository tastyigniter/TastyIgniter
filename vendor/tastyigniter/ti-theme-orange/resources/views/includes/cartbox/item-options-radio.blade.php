@foreach ($optionValues->sortBy('priority') as $optionValue)
    <div @class(['form-check', 'py-1' => !$loop->first || !$loop->last])>
        <input
            x-on:change="calculateTotal()"
            wire:model.fill="menuOptions.{{ $menuOption->menu_option_id }}.option_values"
            type="radio"
            id="menuOptionRadio{{ $menuOptionValueId = $optionValue->menu_option_value_id }}"
            class="form-check-input"
            name="menuOptions[{{ $menuOption->menu_option_id }}][option_values][]"
            value="{{ $optionValue->menu_option_value_id }}"
            data-option-price="{{ $optionValue->price }}"
            data-option-value-id="{{ $menuOptionValueId }}"
            data-free-quantity="{{ (int) ($optionValue->free_quantity ?? 0) }}"
            @checked(($cartItem && $cartItem->hasOptionValue($menuOptionValueId)) || $optionValue->isDefault())
        >

        <label
            class="form-check-label ps-2 w-100"
            for="menuOptionRadio{{ $menuOptionValueId }}"
        >
            {{ $optionValue->name }}
            @if ($optionValue->price > 0 || !$hideZeroOptionPrices)
                <span class="float-end fw-light">@lang('igniter::main.text_plus'){{ currency_format($optionValue->price) }}</span>
            @endif
        </label>
    </div>
@endforeach
