@if ($this->previewMode)
    <div class="form-control-static">{!! $value !!}</div>
@else
    <div
        class="field-codeeditor size-{{ $size }}"
        data-control="code-editor"
        data-mode="{{ $mode }}"
        data-theme="{{ $theme }}"
        data-line-separator="{{ $lineSeparator }}"
        data-read-only="{{ $readOnly }}"
        data-height="{{ $size == 'small' ? 250 : 520 }}"
    >
        <textarea
            name="{{ $name }}"
            id="{{ $this->getId('textarea') }}"
            rows="20"
            class="form-control"
        >{{ trim($value) }}</textarea>
    </div>
@endif
