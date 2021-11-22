<div
    {{ $attributes->merge(['class' => 'modal slideInDown fade', 'tabindex' => -1 , 'role'=> 'dialog', 'aria-hidden' => TRUE]) }}
>
    <div class="modal-dialog" role="document">
        <div id="{{ $modalContentId }}" class="modal-content">
            <div class="modal-body">
                <div class="progress-indicator">
                    <span class="spinner"><span class="ti-loading fa-3x fa-fw"></span></span>
                    @lang('admin::lang.text_loading')
                </div>
            </div>
        </div>
    </div>
</div>
