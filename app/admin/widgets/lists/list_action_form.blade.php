<div
    class="modal slideInDown fade"
    id="{{ $this->getId('modal') }}"
    tabindex="-1"
    role="dialog"
    aria-labelledby="{{ $this->getId('modal-title') }}"
    aria-hidden="true"
>
    <div class="modal-dialog" role="document">
        <div id="{{ $this->getId('modal-content') }}" class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">{{ sprintf(lang($this->popupTitle),  $records->total())}}</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-primary"
                    data-request="{{ $this->getEventHandler('onBulkAction') }}"
                    data-dismiss="modal"
                >@lang('admin::lang.button_add')</button>
                <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                >@lang('admin::lang.button_close')</button>
            </div>
        </div>
    </div>
</div>
