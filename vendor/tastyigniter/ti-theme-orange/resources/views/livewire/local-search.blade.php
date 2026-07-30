<div>
    @if ($hideSearch)
        <a
            class="btn w-100 btn-primary"
            href="{{ restaurant_url('local/menus') }}"
        >@lang('igniter.local::default.text_find')</a>
    @else
        <div class="text-center">
            <h2 class="mb-3">@lang('igniter.local::default.text_order_summary')</h2>
            <span class="search-label sr-only">@lang('igniter.local::default.label_search_query')</span>
        </div>
        <div id="local-search-container">
            <div id="local-search-form">
                <x-igniter-orange::forms.form id="location-search" wire:submit="onSearchNearby">
                    <div class="input-group input-group-lg bg-white rounded border p-1 mb-3 mb-lg-0">
                        <button
                            type="button"
                            data-control="user-position"
                            class="btn rounded border-0 shadow-none"
                            wire:loading.class="disabled"
                        ><i class="fa fa-location-arrow fs-4 align-bottom"></i> </button>
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
                            type="submit"
                            class="btn btn-primary btn-lg fw-bold ms-lg-2 rounded"
                            data-control="search-local"
                            wire:loading.class="disabled"
                        >@lang('igniter.local::default.button_search_location')</button>
                    </div>
                </x-igniter-orange::forms.form>
            </div>
            
            @if($isSearching && $searchAutocompleteEnabled)
                @include('igniter-orange::includes.local.autocomplete-suggestions')
            @endif

            <x-igniter-orange::forms.error
                field="searchQuery"
                id="searchQueryFeedback"
                class="p-2 text-danger fw-bold"
            />

            @include('igniter-orange::includes.local.saved-address-picker')
        </div>
    @endif
</div>
