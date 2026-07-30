@if($this->paymentGateways->isNotEmpty())
    <div class="px-3">
        <h5 class="fw-normal mb-2">@lang($field->label)</h5>
        <div data-toggle="payments" class="progress-indicator-container">
            <div class="list-group list-group-flush p-3 border rounded">
                @foreach ($this->paymentGateways as $paymentMethod)
                    @php
                        $paymentIsSelected = ($field->value == $paymentMethod->code);
                        $paymentIsNotApplicable = !$paymentMethod->isApplicable($order->order_total, $paymentMethod);
                    @endphp
                    <div
                        @class(['list-group-item px-0', 'selected' => $paymentIsSelected])
                        data-checkout-payment
                        wire:key="{{ $paymentMethod->code }}"
                    >
                        <div class="form-check">
                            <input
                                data-checkout-control="{{$field->fieldName}}"
                                data-payment-code="{{ $paymentMethod->code }}"
                                data-pre-validate-checkout="{{ $paymentMethod->completesPaymentOnClient() ? 'true' : 'false' }}"
                                type="radio"
                                name="{{$field->getName()}}"
                                id="payment-{{ $paymentMethod->code }}"
                                class="form-check-input"
                                value="{{ $paymentMethod->code }}"
                                @checked($paymentIsSelected)
                                @disabled($paymentIsNotApplicable)
                                autocomplete="off"
                            />
                            <label
                                class="form-check-label ms-2 d-block"
                                for="payment-{{ $paymentMethod->code }}"
                                data-checkout-control="payment-label"
                            >
                                <div class="">{{ $paymentMethod->name }}</div>
                                @if(strlen($paymentMethod->description))
                                    <div class="small text-muted fw-normal">
                                        {!! $paymentMethod->description !!}
                                    </div>
                                @endif
                                @if($paymentIsNotApplicable)
                                    <div class="small text-muted fw-normal">
                                        <em>
                                            {!! sprintf(
                                                lang('igniter.payregister::default.alert_min_order_total'),
                                                currency_format($paymentMethod->order_total),
                                                lang('igniter.payregister::default.text_this_payment')
                                            ) !!}
                                        </em>
                                    </div>
                                @endif
                                @if($paymentMethod->hasApplicableFee())
                                    <div class="small text-muted fw-normal">
                                        <em>
                                            {!! sprintf(
                                                lang('igniter.payregister::default.alert_order_fee'),
                                                $paymentMethod->getFormattedApplicableFee(),
                                                lang('igniter.payregister::default.text_this_payment')
                                            ) !!}
                                        </em>
                                    </div>
                                @endif
                            </label>
                            @if($paymentIsSelected && ($viewName = $paymentMethod->getPaymentFormViewName()))
                                @include($viewName)
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <x-igniter-orange::forms.error field="{{$field->getName()}}" id="{{$field->getName()}}-feedback"
            class="text-danger"/>
    </div>
@endif
