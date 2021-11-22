<div class="container-fluid pt-4">
    @foreach ($settings as $item => $categories)
        @continue(!count($categories))
        <h5 class="mb-2 px-3">{{ ucwords($item) }}</h5>

        <div class="row g-0 mb-3">
            @foreach ($categories as $key => $category)
                <div class="col-lg-4">
                    <a
                        class="text-reset d-block p-3 h-100"
                        href="{{ $category->url }}"
                        role="button"
                    >
                        <div class="card bg-light shadow-sm h-100">
                            <div class="card-body p-3 d-flex align-items-center">
                                <div class="pe-3">
                                    @if ($item == 'core' && count(array_get($settingItemErrors, $category->code, [])))
                                        <i
                                            class="text-danger fa fa-exclamation-triangle fs-20 fa-fw"
                                            title="@lang('system::lang.settings.alert_settings_errors')"
                                        ></i>
                                    @elseif ($category->icon)
                                        <i class="text-muted {{ $category->icon }} fs-20 fa-fw"></i>
                                    @else
                                        <i class="text-muted fa fa-puzzle-piece fs-20 fa-fw"></i>
                                    @endif
                                </div>
                                <div class="">
                                    <h5 class="mb-1 fs-16">@lang($category->label)</h5>
                                    <p class="no-margin text-muted">{!! $category->description ? lang($category->description) : '' !!}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

