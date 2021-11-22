<div
    id="{{ $toolbarId }}"
    class="toolbar card shadow-none mb-2 {{ $cssClasses }}"
>
    @if ($availableButtons)
        <div class="toolbar-action p-3">
            <div class="progress-indicator-container">
                @foreach ($availableButtons as $buttonObj)
                    {!! $this->renderButtonMarkup($buttonObj) !!}
                @endforeach
            </div>
        </div>
    @endif
</div>
