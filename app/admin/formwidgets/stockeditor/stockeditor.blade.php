<div
    id="{{ $field->getId('container') }}"
    class="input-group"
>
    <input
        type="text"
        id="{{ $field->getId() }}"
        value="{{ $value }}"
        placeholder="{{ $field->placeholder }}"
        class="form-control"
        autocomplete="off"
        pattern="-?\d+(\.\d+)?"
        maxlength="255"
        disabled
        {!! $field->getAttributes() !!}
    />

    <a
        class="btn btn-outline-default {{ $previewMode ? 'disabled' : '' }}"
        data-toggle="record-editor"
        data-handler="{{ $this->getEventHandler('onLoadRecord') }}"
    >@lang('admin::lang.stocks.button_manage_stock')</a>
    <a
        class="btn btn-outline-default {{ $previewMode ? 'disabled' : '' }}"
        data-toggle="record-editor"
        data-handler="{{ $this->getEventHandler('onLoadHistory') }}"
    >@lang('admin::lang.stocks.button_stock_history')</a>
</div>
