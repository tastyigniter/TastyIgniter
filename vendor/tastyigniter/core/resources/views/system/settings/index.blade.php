<div class="container-fluid pt-4">
    <div class="px-2 mb-3">
        @foreach($settings as $item => $categories)
            @continue(!count($categories))
            @unless($item == 'core')
                <h4 class="py-2 my-4 border-bottom"></h4>
            @endunless

            <div class="row g-3">
                @foreach($categories as $key => $category)
                    @php($hasErrors = count(array_get($settingItemErrors, $category->code, [])))
                    <div class="col-lg-4">
                        <a
                            class="text-reset d-block h-100"
                            href="{{ $category->url }}"
                            role="button"
                        >
                            <div @class(['card card-hover h-100', 'border-danger' => $hasErrors])>
                                <div class="card-body d-flex align-items-center">
                                    <div class="pr-3">
                                        @if ($item == 'core' && $hasErrors)
                                            <i
                                                class="text-danger fa fa-exclamation-triangle fa-fw fs-4"
                                                title="@lang('igniter::system.settings.alert_settings_errors')"
                                            ></i>
                                        @elseif ($category->icon)
                                            <i class="text-black-50 {{ $category->icon }} fa-fw fs-4"></i>
                                        @else
                                            <i class="text-black-50 fa fa-puzzle-piece fa-fw fs-4"></i>
                                        @endif
                                    </div>
                                    <div class="">
                                        <h5 class="mb-1 fw-bold">@lang($category->label)</h5>
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
</div>
