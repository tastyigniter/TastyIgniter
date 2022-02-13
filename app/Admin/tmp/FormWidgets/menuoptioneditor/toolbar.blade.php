<div
    class="input-group" data-toggle="modal"
    data-target="#{{ $this->getId('form-modal') }}"
>
    <select
        id="{{ $this->getId('picker') }}"
        class="form-control"
        data-control="choose-item"
        {!! ($this->previewMode) ? 'disabled="disabled"' : '' !!}
    >
        <option value="0">@lang($pickerPlaceholder)</option>
        @foreach ($formField->options() as $value => $option)
            @php if (!is_array($option)) $option = [$option] @endphp
            <option value="{{ $value }}">{{ is_lang_key($option[0]) ? lang($option[0]) : $option[0] }}</option>
        @endforeach
    </select>
    <div class="input-group-append ml-1">
        <button
            type="button"
            class="btn btn-default"
            data-control="assign-item"
            {!! ($this->previewMode) ? 'disabled="disabled"' : '' !!}
        ><i class="fa fa-long-arrow-down"></i>&nbsp;&nbsp;@lang('admin::lang.menu_options.button_assign')</button>
    </div>
</div>
