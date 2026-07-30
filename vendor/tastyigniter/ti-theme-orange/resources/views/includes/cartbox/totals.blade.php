<div
    id="cart-totals"
    @class(['mt-3', 'border-top pt-2' => $previewMode])
>
    <div class="table-responsive">
        <table class="table table-sm table-borderless mb-0">
            <tbody>
            <tr>
                <td>@lang('igniter.cart::default.text_sub_total'):</td>
                <td class="text-end">{{ currency_format($cart->subtotal()) }}</td>
            </tr>

            @foreach ($cart->conditions() as $id => $condition)
                @continue(!$previewMode && $id === 'tip' && $tipConditionValue = $condition->getValue())
                <tr>
                    <td>
                        {{ $condition->getLabel() }}:
                        @if (!$previewMode && $condition->removeable)
                            <button
                                type="button"
                                class="btn btn-sm"
                                wire:click="onRemoveCondition('{{ $id }}')"
                            ><i
                                    class="fa fa-times"
                                    wire:loading.class="fa fa-spinner fa-spin"
                                    wire:loading.class.remove="fa-times"
                                    wire:target="onRemoveCondition"
                                ></i></button>
                        @endif
                    </td>
                    <td class="text-end">
                        {{ is_numeric($result = $condition->getValue()) ? currency_format($result) : $result }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if (!$previewMode && $this->tippingEnabled())
        @php $tipCondition = $cart->getCondition('tip') @endphp
        <div class="border-top border-bottom my-2 pt-2 pb-2">
            <div class="table-responsive">
                <table class="table table-sm table-borderless mb-0">
                    <tbody>
                    <tr>
                        <td>{{ $tipCondition->getLabel() }}:</td>
                        <td class="text-end">{{ currency_format($tipConditionValue ?? 0) }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            @include('igniter-orange::includes.cartbox.tip-form')
        </div>
    @endif
    <div class="table-responsive">
        <table class="table table-sm table-borderless mb-0">
            <tbody>
            <tr class="fw-bold">
                <td>@lang('igniter.cart::default.text_order_total'):</td>
                <td class="text-end">{{ $this->cartTotal }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
