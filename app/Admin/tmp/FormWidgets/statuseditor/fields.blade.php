<div class="form-fields p-0">
    <input type="hidden" name="context" value="{{ $this->isStatusMode ? 'status' : 'assignee' }}">
    @foreach ($formWidget->getFields() as $field)
        {!! $formWidget->renderField($field) !!}
    @endforeach
</div>
