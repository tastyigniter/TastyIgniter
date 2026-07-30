<div class="d-flex px-3 py-2">
    @if($search)
        <div class="filter-search flex-grow-1">{!! $search !!}</div>
    @endif
    @if(count($scopes))
        <div
            id="{{ $filterId }}"
            class="list-filter ms-auto dropdown {{ $cssClasses }}"
        >
            <button
                id="{{ $filterId }}-button"
                type="button"
                class="btn btn-light dropdown-toggle bg-transparent border-none shadow-none"
                data-bs-toggle="dropdown"
                data-bs-auto-close="outside"
                data-bs-reference=".list-table"
                aria-expanded="false"
            ><i class="fa fa-filter"></i></button>
            <div
                id="{{ $filterId }}-dropdown-menu"
                class="dropdown-menu dropdown-menu-end p-3 mt-1"
                style="min-width: 320px;"
            >
                <form
                    id="{{ $filterId }}-form"
                    accept-charset="utf-8"
                    data-request="{{ $onSubmitHandler }}"
                    role="form"
                    data-control="filter-form"
                >
                    @csrf
                    {!! $this->makePartial('filter/filter_scopes') !!}

                    <div class="text-end">
                        <button
                            class="btn btn-link p-0 fw-bold text-decoration-none"
                            type="button"
                            data-request="{{ $onClearHandler }}"
                            data-request-before-update="$('#{{ $filterId }}-button').dropdown('hide')"
                            data-attach-loading
                        >@lang('igniter::admin.text_clear')</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
