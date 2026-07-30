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

    <button
        class="btn btn-light dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    ><i class="fa fa-ellipsis"></i></button>
    <ul class="dropdown-menu dropdown-menu-end">
        <li>
            <a
                class="dropdown-item {{ $previewMode ? 'disabled' : '' }}"
                href="#"
                data-toggle="record-editor"
                data-handler="{{ $this->getEventHandler('onLoadRecord') }}"
            >@lang('igniter.cart::default.stocks.button_manage_stock')</a>
        </li>
        <li>
            <a
                class="dropdown-item {{ $previewMode ? 'disabled' : '' }}"
                href="#"
                data-toggle="record-editor"
                data-handler="{{ $this->getEventHandler('onLoadHistory') }}"
            >@lang('igniter.cart::default.stocks.button_stock_history')</a>
        </li>
    </ul>
</div>
