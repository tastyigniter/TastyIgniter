<div class="row-fluid">
    <div class="card border-none">
        @foreach ($settings as $item => $categories)
            @continue(!count($categories))
            <div class="card-header">
                <h5 class="card-title mb-0">{{ ucwords($item) }}</h5>
            </div>
            <div class="list-group list-group-flush shadow-sm">
                @foreach ($categories as $key => $category)
                    <a
                        class="list-group-item list-group-item-action"
                        href="{{ $category->url }}"
                        role="button"
                    >
                        <div class="d-flex align-items-center">
                            <div class="pr-3">
                                <h5>
                                    @if ($item == 'core' AND count(array_get($settingItemErrors, $category->code, [])))
                                        <i
                                            class="text-danger fa fa-exclamation-triangle fa-fw"
                                            title="@lang('system::lang.settings.alert_settings_errors')"
                                        ></i>
                                    @elseif ($category->icon)
                                        <i class="text-muted {{ $category->icon }} fa-fw"></i>
                                    @else
                                        <i class="text-muted fa fa-puzzle-piece fa-fw"></i>
                                    @endif
                                </h5>
                            </div>
                            <div class="">
                                <h5>@lang($category->label)</h5>
                                <p class="no-margin">{!! $category->description ? lang($category->description) : '' !!}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endforeach
    </div>
</div>

