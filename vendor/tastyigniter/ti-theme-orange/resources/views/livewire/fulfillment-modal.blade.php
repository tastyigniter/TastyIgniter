<div x-data='OrangeFulfillment(@json($timeslotTimes))'>
    <div
        wire:ignore.self
        @class(['modal fade', 'show' => $showAddressPicker])
        id="fulfillmentModal"
        data-map-key="{{ $mapKey }}"
        tabindex="-1"
        aria-labelledby="fulfillmentModalLabel"
        aria-hidden="true"
        style="display: {{ $showAddressPicker ? 'block' : 'none' }};"
    >
        <div class="modal-dialog modal-dialog-centered">
            <x-igniter-orange::forms.form class="w-100" wire:submit="onConfirm">
                <div class="modal-content">
                    <div class="modal-header px-4 border-bottom-0">
                        <h5 class="modal-title"
                            id="fulfillmentModalLabel">@lang('igniter.orange::default.text_control_title')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 py-2">
                        <div class="border rounded px-2 mb-3">
                            @foreach($orderTypes as $orderType)
                                <div @class(['form-check py-2', 'border-bottom' => !$loop->last])>
                                    <input
                                        wire:model.live="orderType"
                                        type="radio"
                                        name="orderType"
                                        id="orderType{{ $orderType->getCode() }}"
                                        class="form-check-input"
                                        value="{{ $orderType->getCode() }}"
                                        @checked($orderType->isActive())
                                        @disabled($previewMode)
                                    />
                                    <label
                                        class="form-check-label text-wrap ms-2 d-block"
                                        for="orderType{{ $orderType->getCode() }}"
                                    >{{ $orderType->getLabel() }}</label>
                                </div>
                            @endforeach
                        </div>
                        <div id="local-timeslot" class="pb-3">
                            <h6 class="mt-3">@lang('igniter.orange::default.text_pick_time')</h6>
                            <div class="border rounded px-2">
                                @include('igniter-orange::includes.local.timeslot')
                            </div>
                        </div>
                        @unless($hideDeliveryAddress)
                            <div x-cloak x-show="!hideDeliveryAddress" class="pb-3 position-relative">
                                <h6 class="my-3">
                                    <i class="fa fa-map-pin"></i>&nbsp;&nbsp;
                                    @lang('igniter.orange::default.text_delivering_to')
                                    @unless($previewMode)
                                        <a
                                            wire:click="onChangeDeliveryAddress"
                                            role="button"
                                            class="small text-primary"
                                        >@lang('igniter.local::default.search.text_change')</a>
                                    @endunless
                                </h6>
                                @if(!$previewMode && $showAddressPicker)
                                    <div class="input-group bg-white rounded border p-1 mb-3 mb-lg-0">
                                        <input
                                            @if($searchAutocompleteEnabled)
                                                wire:model.live.debounce.500ms="searchQuery"
                                            @else
                                                wire:model="searchQuery"
                                            @endif
                                            type="text"
                                            id="search-query"
                                            class="bg-white form-control shadow-none border-none"
                                            placeholder="@lang('igniter.local::default.label_search_query')"
                                        />
                                        <button
                                            type="button"
                                            data-control="user-position"
                                            class="btn shadow-none"
                                        ><i class="fa fa-location-arrow fs-5 align-bottom"></i></button>
                                    </div>
                                    @if($isSearching && $searchAutocompleteEnabled)
                                        @include('igniter-orange::includes.local.autocomplete-suggestions')
                                    @endif
                                    <x-igniter-orange::forms.error
                                        field="searchQuery"
                                        id="searchQueryFeedback"
                                        class="text-danger"
                                    />
                                    @if($searchPoint && $this->searchAutocompleteEnabled)
                                        <div wire:ignore class="mt-3">
                                            <h6>@lang('igniter.orange::default.text_mark_your_location')</h6>
                                            <div id="map" class="map-container rounded pt-2"></div>
                                        </div>
                                    @else
                                        @include('igniter-orange::includes.local.saved-address-picker')
                                    @endif
                                @else
                                    <div class="p-2 border rounded bg-white w-100">
                                        <div
                                            class="pe-2 fw-bold text-truncate"
                                        >{{ $searchQuery ?? $deliveryAddress ?? lang('igniter.local::default.alert_no_search_query') }}</div>
                                    </div>
                                @endif
                            </div>
                        @endunless
                    </div>
                    <div class="modal-footer border-0">
                        <button
                            type="submit"
                            class="btn btn-primary btn-lg text-nowrap text-white w-100"
                            wire:loading.class="disabled"
                        >@lang('igniter.orange::default.button_confirm')</button>
                    </div>
                </div>
            </x-igniter-orange::forms.form>
        </div>
    </div>
</div>
