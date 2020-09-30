<div
    id="{{ $toolbarId }}"
    class="toolbar btn-toolbar {{ $cssClasses }}"
>
    @if (strlen($buttonsHtml))
        <div class="toolbar-action">
            <div class="progress-indicator-container">
                {!! $buttonsHtml !!}
            </div>
        </div>
    @endif
</div>
