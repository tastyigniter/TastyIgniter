<div
    class="form-group{{ ($this->previewMode ? ' form-group-preview' : '')
     .(form_error($field->fieldName) != '' ? ' is-invalid' : '')
     .' '.$field->type.'-field span-'.$field->span.' '.$field->cssClass }}"
    {!! $field->getAttributes('container') !!}
    data-field-name="{{ $field->fieldName }}"
    id="{{ $field->getId('group') }}"
>{!!
    /* Must be on the same line for :empty selector */
    trim($this->makePartial('form/field', ['field' => $field]));
!!}</div>
