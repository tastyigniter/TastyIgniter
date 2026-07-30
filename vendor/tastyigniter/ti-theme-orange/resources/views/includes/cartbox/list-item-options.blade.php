<ul class="list-unstyled small">
    @foreach ($itemOptions as $itemOption)
        <li class="text-muted">{{ $itemOption->name }}</li>
        @foreach ($itemOption->values as $optionValue)
            <li>
                @if ($optionValue->qty > 1)
                    {{ $optionValue->qty }} @lang('igniter.cart::default.text_times')
                @endif
                {{ $optionValue->name }}&nbsp;
                @if ($optionValue->price > 0)
                    ({{ currency_format($optionValue->subtotal()) }})
                @endif
            </li>
        @endforeach
    @endforeach
</ul>
