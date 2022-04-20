<div
    id="{{ $filterId }}"
    class="list-filter {{ $cssClasses }}"
    data-store-name="{{ $cookieStoreName }}"
    {!! !$this->isActiveState() ? ' style="display:none"' : '' !!}
>
    <form
        id="filter-form"
        class="form-inline"
        accept-charset="utf-8"
        method="POST"
        action="{{ current_url() }}"
        role="form"
    >
        @csrf
        <div class="d-sm-flex flex-sm-wrap w-100 no-gutters">
            @if ($search)
                <div class="col col-sm-6 pb-sm-3 pr-sm-3">
                    <div class="d-flex no-gutters">
                        <div class="pr-3">
                            <button
                                class="btn btn-outline-danger"
                                type="button"
                                data-request="{{ $onClearHandler }}"
                                data-attach-loading
                            ><i class="fa fa-times"></i></button>
                        </div>
                        <div class="flex-grow-1">
                            <div class="filter-search">{!! $search !!}</div>
                        </div>
                    </div>
                </div>
            @endif

            @if (count($scopes))
                <input type="hidden" name="_handler" value="{{ $onSubmitHandler }}">

                {!! $this->makePartial('filter/filter_scopes') !!}
            @endif
        </div>
    </form>
</div>
