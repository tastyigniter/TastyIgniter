<div class="modal-dialog modal-dialog-scrollable">
    {!! form_open([]) !!}
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ sprintf(lang('admin::lang.list.setup_title'), lang($this->getConfig('title')))}}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">
                    @lang('admin::lang.list.label_visible_columns')
                    <span class="help-block">@lang('admin::lang.list.help_visible_columns')</span>
                </label>
                <div
                    id="lists-setup-sortable"
                    class="list-group"
                >
                    @foreach ($columns as $column)
                        @if ($column->type == 'button')
                            <input
                                type="hidden"
                                id="list-setup-{{ $column->columnName }}"
                                name="visible_columns[]"
                                value="{{ $column->columnName }}"
                            />
                        @else
                            <div class="list-group-item bg-transparent px-2">
                                <div class="btn btn-handle form-check-handle mr-2">
                                    <i class="fa fa-arrows-alt-v text-muted"></i>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input
                                        type="checkbox"
                                        id="list-setup-{{ $column->columnName }}"
                                        class="form-check-input"
                                        name="visible_columns[]"
                                        value="{{ $column->columnName }}"
                                        {!! $column->invisible ? '' : 'checked="checked"' !!}
                                    />
                                    <input
                                        type="hidden"
                                        name="column_order[]"
                                        value="{{ $column->columnName }}"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="list-setup-{{ $column->columnName }}"
                                    ><b>@lang($column->label)</b></label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @if ($this->showPagination)
                <div class="form-group">
                    <label class="form-label">
                        @lang('admin::lang.list.label_page_limit')
                        <span class="help-block">@lang('admin::lang.list.help_page_limit')</span>
                    </label>
                    <div
                        class="btn-group btn-group-toggle"
                        data-toggle="buttons"
                    >
                        @foreach ($perPageOptions as $optionValue)
                            <label class="btn btn-light {{ $optionValue == $pageLimit ? 'active' : '' }}">
                                <input
                                    type="radio"
                                    id="checkbox_page_limit_{{ $optionValue }}"
                                    name="page_limit"
                                    value="{{ $optionValue }}"
                                    {!! $optionValue == $pageLimit ? 'checked="checked"' : '' !!}>
                                {{ $optionValue }}
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="modal-footer progress-indicator-container">
            <button
                type="button"
                class="btn btn-link text-danger mr-auto"
                data-request="{{ $this->getEventHandler('onResetSetup')}}"
                data-progress-indicator="@lang('admin::lang.text_resetting')"
            >@lang('admin::lang.list.button_reset_setup')</button>
            <button
                type="button"
                class="btn btn-link"
                data-bs-dismiss="modal"
            >@lang('admin::lang.list.button_cancel_setup')</button>
            <button
                type="button"
                class="btn btn-primary"
                data-request="{{ $this->getEventHandler('onApplySetup')}}"
                data-progress-indicator="@lang('admin::lang.text_saving')"
            >@lang('admin::lang.list.button_apply_setup')</button>
        </div>
    </div>
    {!! form_close() !!}
</div>
