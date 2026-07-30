@foreach ($optionValues->sortBy('priority') as $optionValue)
    <div @class(['form-check', 'py-1' => !$loop->first || !$loop->last])>
        <input
            x-data="{
                key: '{{ $menuOption->menu_option_id }}',
                id: {{ $optionValue->menu_option_value_id }},
                init() {
                    $wire.menuOptions[this.key] ??= { option_values: [] };

                    const values = $wire.menuOptions[this.key].option_values;
                    if ($el.checked && !values.includes(this.id)) {
                        values.push(this.id);
                    }
                    $wire.set(`menuOptions.${this.key}.option_values`, values, false);
                },
                toggle() {
                    const values = $wire.menuOptions[this.key]?.option_values ?? [];
                    const updated = $el.checked
                        ? [...new Set([...values, this.id])]
                        : values.filter(v => v !== this.id);

                    $wire.set(`menuOptions.${this.key}.option_values`, updated, false);
                    calculateTotal();
                }
            }"
            x-init="init"
            x-on:change="toggle"
            type="checkbox"
            class="form-check-input"
            id="menuOptionCheck{{ $menuOptionValueId = $optionValue->menu_option_value_id }}"
            name="menuOptions[{{ $menuOption->menu_option_id }}][option_values][{{$optionValue->menu_option_value_id}}]"
            data-option-price="{{ $optionValue->price }}"
            data-option-value-id="{{ $menuOptionValueId }}"
            data-free-quantity="{{ (int) ($optionValue->free_quantity ?? 0) }}"
            @checked(($cartItem && $cartItem->hasOptionValue($menuOptionValueId)) || $optionValue->isDefault())
        >

        <label
            class="form-check-label ps-2 w-100"
            for="menuOptionCheck{{ $menuOptionValueId }}"
        >
            {!! $optionValue->name !!}
            @if ($optionValue->price > 0 || !$hideZeroOptionPrices)
                <span class="float-end fw-light" x-text="priceLabel({{ $menuOptionValueId }}, 1, {{ $optionValue->price }})"></span>
            @endif
        </label>
    </div>
@endforeach
