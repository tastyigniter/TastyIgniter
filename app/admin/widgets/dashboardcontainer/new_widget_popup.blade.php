<x-modal.form>
    <x-slot name="title">@lang('admin::lang.dashboard.text_add_widget')</x-slot>

    <div class="form-group">
        <label class="control-label">@lang('admin::lang.dashboard.label_widget')</label>
        <select class="form-select" name="className">
            <option value="">@lang('admin::lang.dashboard.text_select_widget')</option>
            @foreach ($widgets as $className => $widgetName)
                <option value="{{ $className }}">{{ $widgetName }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="control-label">@lang('admin::lang.dashboard.label_widget_columns')</label>
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

    <x-slot name="footer">
        <button
            type="button"
            class="btn btn-link"
            data-bs-dismiss="modal"
        >@lang('admin::lang.button_close')</button>
        <button
            type="button"
            class="btn btn-primary"
            data-request="{{ $this->getEventHandler('onAddWidget') }}"
            data-bs-dismiss="modal"
        >@lang('admin::lang.button_add')</button>
    </x-slot>
</x-modal.form>
