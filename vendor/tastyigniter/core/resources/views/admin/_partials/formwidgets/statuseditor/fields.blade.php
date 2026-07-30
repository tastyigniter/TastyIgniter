<div class="form-fields">
    <input type="hidden" name="context" value="{{ $this->isStatusMode ? 'status' : 'assignee' }}">
    @foreach($formWidget->getFields() as $field)
        {!! $formWidget->renderField($field) !!}
    @endforeach
</div>
