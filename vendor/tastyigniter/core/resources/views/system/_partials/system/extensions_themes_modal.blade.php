<div
    class="modal fade"
    id="extensions-themes-modal"
    tabindex="-1"
    aria-labelledby="extensions-themes-modal-label"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="extensions-themes-modal-label">
                    @lang('igniter::system.system.checks.extensions_themes')
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                @if(!empty($result->meta['extensions']))
                    <div class="px-3 pt-3 pb-2 border-bottom bg-light">
                        <h6 class="mb-0 fw-bold">@lang('igniter::system.system.checks.extensions_heading')</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($result->meta['extensions'] as $extension)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $extension['name'] }}</span>
                                <span class="fw-bold">{{ $extension['version'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if(!empty($result->meta['theme']))
                    <div class="px-3 pt-3 pb-2 border-bottom bg-light">
                        <h6 class="mb-0 fw-bold">@lang('igniter::system.system.checks.theme_heading')</h6>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $result->meta['theme']['name'] }}</span>
                            <span class="fw-bold">{{ $result->meta['theme']['version'] }}</span>
                        </li>
                    </ul>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                    @lang('igniter::admin.button_close')
                </button>
            </div>
        </div>
    </div>
</div>
