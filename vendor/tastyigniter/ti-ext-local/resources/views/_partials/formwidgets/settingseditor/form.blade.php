{!! form_open([
    'id' => $this->getId('record-editor-form'),
    'role' => 'form',
    'method' => 'PATCH',
    'class' => 'w-100',
]) !!}
<input type="hidden" name="recordId" value="{{ $formRecordId }}">
@foreach($formWidget->getFields() as $field)
    {!! $formWidget->renderField($field) !!}
@endforeach
<button
    type="button"
    class="btn btn-primary"
    data-request="{{ $this->alias }}::onSaveRecord"
>
    @lang('igniter::admin.button_save')
</button>

{!! form_close() !!}
