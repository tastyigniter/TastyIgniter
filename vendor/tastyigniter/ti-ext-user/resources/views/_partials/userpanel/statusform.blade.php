<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">@lang('igniter.user::default.staff_status.text_set_status')</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
        </div>
        <form
          method="POST"
          accept-charset="UTF-8"
          data-request="{{$this->getEventHandler('onSetStatus')}}"
        >
            <div class="modal-body">
                <div class="form-group">
                    <select data-control="selectlist" name="status">
                        @foreach($statuses as $key => $column)
                            <option
                              value="{{ $key }}"
                              {!! $key == $userStatus ? 'selected="selected"' : '' !!}
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
                      value="{{ $message }}"
                      placeholder="@lang('igniter.user::default.staff_status.text_lunch_break')"
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
                        @foreach($clearAfterOptions as $key => $column)
                            <option
                              value="{{ $key }}"
                              {!! $key == $clearAfterMinutes ? 'selected="selected"' : '' !!}
                            >@lang($column)</option>
                        @endforeach
                    </select>
                    @if($statusUpdatedAt)
                        <span class="help-block">{{ time_elapsed($statusUpdatedAt) }}</span>
                    @endif
                </div>
            </div>
            <div class="modal-footer text-right">
                <button
                    type="button"
                    class="btn btn-link fw-bold text-decoration-none"
                    data-bs-dismiss="modal"
                >@lang('igniter::admin.button_close')</button>
                <button
                  type="submit"
                  class="btn btn-primary"
                >@lang('igniter::admin.button_save')</button>
            </div>
        </form>
    </div>
</div>
