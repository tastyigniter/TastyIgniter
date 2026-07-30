@foreach ($optionValues->sortBy('priority') as $optionIndex => $optionValue)
    @php $menuOptionValueId = $optionValue->menu_option_value_id @endphp
    <div
        x-data="{optionQuantity: {{ $this->getOptionQuantityTypeValue($optionValue->menu_option_value_id) }}, optionPrice: {{$optionValue->price}}}"
        @class(['form-quantity d-flex align-items-center', 'py-1' => !$loop->first || !$loop->last])
    >
        <input
            type="hidden"
            name="menu_options[{{ $index }}][option_values][{{ $optionIndex }}][id]"
            value="{{ $optionValue->menu_option_value_id }}"
        />
        <div
            class="form-quantity-input d-flex align-items-center"
            data-option-quantity
        >
            <button
                class="btn btn-outline-secondary btn-sm lh-sm p-0 border-2 rounded-circle"
                x-on:click="(optionQuantity = Math.max(0, optionQuantity-1))"
                type="button"
            ><i class="fa fa-minus fa-fw"></i></button>
            <input
                x-model="optionQuantity"
                x-init="
                    $wire.set('menuOptions.{{ $menuOption->menu_option_id }}.option_values.{{ $menuOptionValueId }}.qty', optionQuantity, false);
                    $watch('optionQuantity', () => calculateTotal() || $wire.set('menuOptions.{{ $menuOption->menu_option_id }}.option_values.{{ $menuOptionValueId }}.qty', optionQuantity, false))
                "
                type="text"
                class="form-control bg-transparent shadow-none border-0 text-center p-0"
                id="menuOptionQuantity{{ $menuOptionValueId }}"
                name="menu_options[{{ $index }}][option_values][{{ $optionIndex }}][qty]"
                data-option-price="{{ $optionValue->price }}"
                data-option-value-id="{{ $menuOptionValueId }}"
                data-free-quantity="{{ (int) ($optionValue->free_quantity ?? 0) }}"
                inputmode="numeric"
                pattern="[0-9]*"
                min="0"
                autocomplete="off"
                readonly
                style="max-width:40px;"
            >
            <button
                class="btn btn-outline-secondary btn-sm lh-sm p-0 border-2 rounded-circle"
                x-on:click="(optionQuantity = Math.max(0, optionQuantity+1))"
                type="button"
            ><i class="fa fa-plus fa-fw"></i></button>
        </div>
        <label class="form-quantity-label ps-3 w-100">
            {{ $optionValue->name }}
            @if ($optionValue->price > 0 || !$hideZeroOptionPrices)
                <span class="float-end fw-light" x-text="priceLabel({{ $menuOptionValueId }}, optionQuantity, optionPrice)"></span>
            @endif
        </label>
    </div>
@endforeach
