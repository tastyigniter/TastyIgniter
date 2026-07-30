<div>
    <div class="row">
        <div class="col-sm-3">
            <div class="d-flex bg-white border rounded p-3 mb-3">
                <h5 class="mb-0 d-inline-block flex-grow-1">
                    <i class="fa fa-map-marker"></i>&nbsp;&nbsp;
                    @if ($searchQueryPosition->isValid())
                        {{ $searchQueryPosition->getLocality() }}
                    @else
                        ---
                    @endif
                </h5>
                <a
                    role="button"
                    class="text-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addressPickerModal"
                >@lang('igniter.local::default.search.text_change')</a>
            </div>
            <div class="bg-white border rounded p-3 mb-3">
                @include('igniter-orange::includes.local.list-filter-items', ['filters' => $this->orderTypes, 'field' => 'orderType'])
            </div>
            <div class="bg-white border rounded p-3 mb-3">
                <div
                    role="button"
                    class="bg-white accordion-button shadow-none p-0 fw-bold"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseSortBy"
                    aria-expanded="false"
                    aria-controls="collapseSortBy"
                >@lang('igniter.orange::default.text_sort')</div>
                <div class="collapse show" id="collapseSortBy">
                    <div class="pt-3">
                        @include('igniter-orange::includes.local.list-filter-items', ['filters' => $this->sorters, 'field' => 'sortBy'])
                    </div>
                </div>
            </div>
            @foreach($this->filters as $fieldName => $filter)
                <div class="bg-white border rounded p-3 mb-3">
                    <div
                        role="button"
                        class="bg-white accordion-button shadow-none p-0 fw-bold"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse-{{$fieldName}}"
                        aria-expanded="false"
                        aria-controls="collapse-{{$fieldName}}"
                    >{{lang($filter['title'])}}</div>
                    <div class="collapse show" id="collapse-{{$fieldName}}">
                        <div class="pt-3">
                            @include('igniter-orange::includes.local.list-filter-items', ['filters' => $filter['options'](), 'field' => 'filter.'.$fieldName])
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-sm-9">
            <div class="mb-4">
                <div class="input-group input-group-lg bg-white rounded border p-1 mb-3 mb-lg-0">
                    <input
                        wire:model.live="search"
                        wire:loading.attr="disabled"
                        type="search"
                        class="bg-white form-control shadow-none border-none"
                        name="search"
                        placeholder="@lang('igniter.local::default.text_filter_search')"
                    />
                    <button
                        class="btn btn-secondary btn-lg fw-bold ms-lg-3 rounded"
                        type="button"
                    ><i class="fa fa-search"></i></button>
                </div>
            </div>

            @if (count($locationsList))
                <div class="local-group">
                    @foreach ($locationsList as $locationData)
                        @include('igniter-orange::includes.local.location-card')
                    @endforeach
                </div>

                <div class="pagination-bar text-right">
                    <div class="links">{!! $locationsList->links() !!}</div>
                </div>
            @else
                <div class="panel panel-local">
                    <div class="panel-body">
                        <p>@lang('igniter.local::default.text_filter_no_match')</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div
        wire:ignore.self
        class="modal fade"
        id="addressPickerModal"
        tabindex="-1"
        aria-labelledby="addressPickerModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-dialog-centered">
            <x-igniter-orange::forms.form class="w-100" wire:submit="onUpdateSearchQuery">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="input-group bg-white rounded border p-1 mb-3 mb-lg-0">
                            <input
                                wire:model="searchQuery"
                                type="text"
                                id="search-query"
                                class="bg-white form-control shadow-none border-none"
                                placeholder="@lang('igniter.local::default.label_search_query')"
                            />
                            <button
                                type="button"
                                data-control="user-position"
                                class="btn shadow-none"
                                wire:loading.class="disabled"
                            ><i class="fa fa-location-arrow fs-5 align-bottom"></i></button>
                        </div>

                        <x-igniter-orange::forms.error
                            field="searchQuery"
                            id="searchQueryFeedback"
                            class="text-danger"
                        />
                    </div>
                    <div class="modal-footer border-none">
                        <button
                            type="submit"
                            data-control="search-local"
                            class="btn btn-primary w-100"
                            wire:loading.class="disabled"
                        >@lang('igniter.local::default.search.text_change')</button>
                    </div>
                </div>
            </x-igniter-orange::forms.form>
        </div>
    </div>
</div>
