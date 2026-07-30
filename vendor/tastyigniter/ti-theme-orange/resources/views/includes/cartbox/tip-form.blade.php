<div x-data="{isCustom: '{{$isCustomTip}}', tipAmount: {{$tipAmount}}}" id="cart-tip" class="mb-2">
    @if ($tips = $this->tippingAmounts())
        <div class="d-flex flex-wrap justify-content-center pt-2 w-100 text-center tip-amounts">
            <button
                wire:click="onApplyTip(0)"
                wire:loading.class="disabled"
                wire:target="onApplyTip"
                @class(['btn btn-light rounded mb-2 me-2 fw-normal text-nowrap'])
                type="button"
            >@lang('igniter.cart::default.text_no_tip')</button>
            @foreach ($tips as $tip)
                <button
                    wire:click="onApplyTip({{ $tip->value }})"
                    wire:loading.class="disabled"
                    wire:target="onApplyTip"
                    @class(['btn btn-light rounded mb-2 me-2 fw-normal text-nowrap', 'active border-secondary' => $tipAmount == $tip->value])
                    type="button"
                >{{ $tip->valueType != 'F' ? round($tip->value).'%' : currency_format($tip->value) }}</button>
            @endforeach
            <button
                x-on:click="isCustom = !isCustom"
                wire:loading.class="disabled"
                wire:target="onApplyTip"
                @class(['btn btn-light rounded mb-2 fw-normal text-nowrap', 'active border-secondary' => $isCustomTip])
                type="button"
            >@lang('igniter.cart::default.text_edit_tip')</button>
        </div>
    @endif
    <div
        x-cloak
        x-show="isCustom"
        id="tip-form"
    >
        <div class="input-group{{ $tips ? ' mt-2' : '' }}">
            <input
                wire:model.change="tipAmount"
                type="number"
                class="form-control rounded"
                placeholder="@lang('igniter.cart::default.text_apply_tip')"
                step="{{ 1 / (10 ** currency()->getDefault()->decimal_position) }}"
            />
        </div>
    </div>
</div>
