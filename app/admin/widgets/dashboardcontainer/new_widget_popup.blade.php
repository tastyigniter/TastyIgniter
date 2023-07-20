{!! form_open(current_url()) !!}
<div class="modal-header">
    <h4 class="modal-title">@lang('admin::lang.dashboard.text_add_widget')</h4>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
</div>
<div class="modal-body">
    <div class="form-group">
        <label class="form-label">@lang('admin::lang.dashboard.label_widget')</label>
        <select class="form-select" name="widget">
            <option value="">@lang('admin::lang.dashboard.text_select_widget')</option>
            @foreach ($widgets as $code => $label)
                <option value="{{ $code }}">@lang($label)</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="form-label">@lang('admin::lang.dashboard.label_widget_columns')</label>
        <select class="form-select" name="size">
            <option></option>
            @foreach ($gridColumns as $column => $name)
                <option
                    value="{{ $column }}"
                    @if ($column == 12) selected="selected" @endif
                >{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="modal-footer">
    <button
        type="button"
        class="btn btn-primary"
        data-request="{{ $this->getEventHandler('onAddWidget') }}"
        data-bs-dismiss="modal"
    >@lang('admin::lang.button_add')</button>
    <button
        type="button"
        class="btn btn-default"
        data-bs-dismiss="modal"
    >@lang('admin::lang.button_close')</button>
</div>
{!! form_close() !!}
