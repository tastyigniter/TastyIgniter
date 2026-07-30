<div class="modal-dialog modal-dialog-scrollable">
    {!! form_open([]) !!}
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ sprintf(lang('igniter::admin.list.setup_title'), lang($this->getConfig('title') ?? ''))}}</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label class="form-label">@lang('igniter::admin.list.label_visible_columns')</label>
                <div class="help-block mb-2">@lang('igniter::admin.list.help_visible_columns')</div>
                <div>
                    @foreach($columns as $column)
                        @if ($column->type == 'button')
                            <input
                                type="hidden"
                                id="list-setup-visible-{{ $column->columnName }}"
                                name="visible_columns[]"
                                value="{{ $column->columnName }}"
                            />
                            <input
                                type="hidden"
                                id="list-setup-order-{{ $column->columnName }}"
                                name="column_order[]"
                                value="{{ $column->columnName }}"
                            />
                        @endif
                    @endforeach
                    <div class="list-group" id="lists-setup-sortable">
                        @foreach($columns as $column)
                            @if ($column->type !== 'button')
                                <div class="list-group-item bg-transparent px-2">
                                    <div class="btn btn-handle border-0 shadow-none form-check-handle mr-2">
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
            </div>
            @if ($this->showPagination)
                <div class="form-group">
                    <label class="form-label">@lang('igniter::admin.list.label_page_limit')</label>
                    <div class="help-block mb-2">@lang('igniter::admin.list.help_page_limit')</div>
                    <div class="btn-group btn-group-toggle">
                        @foreach($perPageOptions as $optionValue)
                            <input
                                type="radio"
                                id="checkbox-page-limit-{{ $optionValue }}"
                                class="btn-check"
                                name="page_limit"
                                value="{{ $optionValue }}"
                                {!! $optionValue == $pageLimit ? 'checked="checked"' : '' !!}
                            />
                            <label
                                for="checkbox-page-limit-{{ $optionValue }}"
                                class="btn btn-light"
                            >{{ $optionValue }}</label>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
        <div class="modal-footer progress-indicator-container">
            <button
                type="button"
                class="btn btn-link fw-bold text-decoration-none text-danger mr-auto"
                data-request="{{ $this->getEventHandler('onResetSetup')}}"
                data-request-before-update="$('#{{ $this->getId() }}-setup-modal').modal('hide')"
                data-progress-indicator="@lang('igniter::admin.text_resetting')"
            >@lang('igniter::admin.list.button_reset_setup')</button>
            <button
                type="button"
                class="btn btn-link fw-bold text-decoration-none"
                data-bs-dismiss="modal"
            >@lang('igniter::admin.list.button_cancel_setup')</button>
            <button
                type="button"
                class="btn btn-primary"
                data-request="{{ $this->getEventHandler('onApplySetup')}}"
                data-request-before-update="$('#{{ $this->getId() }}-setup-modal').modal('hide')"
                data-progress-indicator="@lang('igniter::admin.text_saving')"
            >@lang('igniter::admin.list.button_apply_setup')</button>
        </div>
    </div>
    {!! form_close() !!}
</div>
