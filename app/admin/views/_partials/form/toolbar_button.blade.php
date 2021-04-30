@php
    $selectedAction = @json_decode($d = array_get($_COOKIE, 'ti_activeFormSaveAction'), TRUE);
@endphp
<div
    class="btn-group"
    data-control="form-save-actions"
>
    <button
        type="button"
        tabindex="0"
        {!! $button->getAttributes() !!}
    >{!! $button->label ?: $button->name !!}</button>
    <button
        type="button"
        class="{{ $button->cssClass }} dropdown-toggle dropdown-toggle-split"
        data-toggle="dropdown"
        data-display="static"
        aria-haspopup="true"
        aria-expanded="false"
    ><span class="sr-only">Toggle Dropdown</span></button>
    <div class="dropdown-menu dropdown-menu-right">
        <h6 class="dropdown-header px-2">After saving</h6>
        @foreach (['continue', 'close', 'new'] as $action)
            <div class="dropdown-item px-2">
                <div class="custom-control custom-radio">
                    <input
                        type="radio"
                        id="toolbar-button-save-action-{{$action}}"
                        class="custom-control-input"
                        name="toolbar_save_action"
                        value="{{$action}}"
                        {!! $selectedAction === $action ? 'checked="checked"' : ''; !!}
                    />
                    <label
                        class="custom-control-label"
                        for="toolbar-button-save-action-{{$action}}"
                    >@lang('admin::lang.form.save_actions.'.$action)</label>
                </div>
            </div>
        @endforeach
    </div>
</div>
<input type="hidden" data-form-save-action="">
