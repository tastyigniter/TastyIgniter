<div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
        @if($updates)
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
            <span class="fa-stack fa-3x text-warning">
                <i class="fa-solid fa-circle fa-stack-2x"></i>
                <i class="fa-solid fa-exclamation fa-stack-1x fa-inverse"></i>
            </span>
                <p class="lead mt-4">{{sprintf(lang('igniter::system.languages.text_title_update_available'), $locale)}}</p>
                <ul class="list-group mb-4 text-left">
                    @foreach($updates as $update)
                        <li class="list-group-item">
                            <strong>{{ $update['name'] }}</strong>
                            <p class="text-muted mb-0">{{ $update['description'] }}</p>
                        </li>
                    @endforeach
                </ul>
                <div class="alert alert-info">@lang('igniter::system.languages.text_update_available')</div>
            </div>
        @else
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <div class="modal-body text-center">
            <span class="fa-stack fa-3x text-muted">
                <i class="fa-solid fa-circle fa-stack-2x"></i>
                <i class="fa-solid fa-check fa-stack-1x fa-inverse"></i>
            </span>
                <p class="lead mt-4">{{sprintf(lang('igniter::system.languages.text_no_update_available'), $locale)}}</p>
            </div>
        @endif
        <div class="modal-footer progress-indicator-container">
            <button
                type="button"
                class="btn btn-link"
                data-bs-dismiss="modal"
            >@lang('igniter::admin.button_close')</button>
            @if($updates)
                <button
                    type="submit"
                    id="apply-updates"
                    class="btn btn-primary"
                    data-control="apply-updates"
                    data-progress-indicator="@lang('igniter::admin.text_loading')"
                >@lang('igniter::system.languages.button_apply_update')</button>
            @endif
        </div>
    </div>
</div>
