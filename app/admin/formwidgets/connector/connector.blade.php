<div
    id="{{ $this->getId('items-container') }}"
    class="field-connector"
    data-control="connector"
    data-alias="{{ $this->alias }}"
    data-sortable-container="#{{ $this->getId('items') }}"
    data-sortable-handle=".{{ $this->getId('items') }}-handle"
    data-editable="{{ ($this->previewMode || !$this->editable) ? 'false' : 'true' }}"
>
    <div
        id="{{ $this->getId('items') }}"
        role="tablist"
        aria-multiselectable="true">
        {!! $this->makePartial('connector/connector_items') !!}
    </div>

    @unless ($this->previewMode || $this->hideNewButton)
        <div>
            <button
                type="button"
                class="btn btn-outline-default"
                data-control="load-item"
            ><i class="fa fa-plus"></i>&nbsp;&nbsp;{{ $newRecordTitle }}</button>
        </div>
    @endunless
</div>
