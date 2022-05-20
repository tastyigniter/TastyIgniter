@php
    $staffState = \Admin\Classes\UserState::forUser()
@endphp
<div
    class="modal fade"
    id="editStaffStatusModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="editStaffStatusModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('admin::lang.staff_status.text_set_status')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
            </div>
            <form
                method="POST"
                accept-charset="UTF-8"
                data-request="mainmenu::onSetUserStatus"
                data-request-success="jQuery('#editStaffStatusModal').modal('hide')"
            >
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-select" name="status">
                            @foreach($staffState::getStatusDropdownOptions() as $key => $column)
                                <option
                                    value="{{ $key }}"
                                    {!! $key == $staffState->getStatus() ? 'selected="selected"' : '' !!}
                                >@lang($column)</option>
                            @endforeach
                        </select>
                    </div>
                    <div
                        class="form-group"
                        data-trigger="[name='status']"
                        data-trigger-action="show"
                        data-trigger-condition="value[4]"
                        data-trigger-closest-parent="form"
                    >
                        <input
                            type="text"
                            class="form-control"
                            name="message"
                            value="{{ $staffState->getMessage() }}"
                            placeholder="@lang('admin::lang.staff_status.text_lunch_break')"
                        >
                    </div>
                    <div
                        class="form-group"
                        data-trigger="[name='status']"
                        data-trigger-action="show"
                        data-trigger-condition="value[4]"
                        data-trigger-closest-parent="form"
                    >
                        <select class="form-select" name="clear_after" id="staffClearStatusAfter">
                            @foreach($staffState::getClearAfterMinutesDropdownOptions() as $key => $column)
                                <option
                                    value="{{ $key }}"
                                    {!! $key == $staffState->getClearAfterMinutes() ? 'selected="selected"' : '' !!}
                                >@lang($column)</option>
                            @endforeach
                        </select>
                        @if($statusUpdatedAt = $staffState->getUpdatedAt())
                            <span class="help-block">{{ time_elapsed($statusUpdatedAt) }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button
                        type="button"
                        class="btn btn-link"
                        data-bs-dismiss="modal"
                    >@lang('admin::lang.button_close')</button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >@lang('admin::lang.button_save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
