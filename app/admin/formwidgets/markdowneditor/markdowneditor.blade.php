@if ($this->previewMode)
    <div class="form-control">{!! $value !!}</div>
@else
    <div
        id="{{ $this->getId() }}"
        class="field-markdowneditor size-{{ $size }}"
        data-control="markdowneditor"
    >
        <textarea
            name="{{ $name }}"
            id="{{ $this->getId('textarea') }}"
            rows="20"
            class="form-control"
            {!! $this->previewMode ? 'disabled="disabled"' : '' !!}
        >{!! $value !!}</textarea>
    </div>
@endif
