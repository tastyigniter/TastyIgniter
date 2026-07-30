@php
    $saveActions = array_get($button->config, 'saveActions', ['continue', 'close', 'new']);
    $selectedAction = $this->getActiveSaveAction();
    $eventHandler = $this->getEventHandler('onChooseSaveButtonAction');
@endphp
<div
    class="btn-group me-2"
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
        data-bs-toggle="dropdown"
        data-bs-display="static"
        data-bs-reference="parent"
        aria-haspopup="true"
        aria-expanded="false"
    ><span class="sr-only">Toggle Dropdown</span></button>
    <div class="dropdown-menu dropdown-menu-left">
        <h6 class="dropdown-header px-2">After saving</h6>
        @foreach(['continue', 'close', 'new'] as $action)
            @continue($saveActions && !in_array($action, $saveActions))
            <div class="dropdown-item px-2">
                <div class="form-check">
                    <input
                        type="radio"
                        id="toolbar-button-save-action-{{$action}}"
                        class="form-check-input"
                        name="toolbar_save_action"
                        value="{{$action}}"
                        data-handler="{{ $eventHandler }}"
                        {!! $selectedAction === $action ? 'checked="checked"' : ''; !!}
                    />
                    <label
                        class="form-check-label"
                        for="toolbar-button-save-action-{{$action}}"
                    >@lang('igniter::admin.form.save_actions.'.$action)</label>
                </div>
            </div>
        @endforeach
    </div>
</div>
<input type="hidden" data-form-save-action="" name="{{$selectedAction}}" value="1">
