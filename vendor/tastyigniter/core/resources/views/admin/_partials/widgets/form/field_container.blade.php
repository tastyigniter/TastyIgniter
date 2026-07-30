<div
    @class(['form-group',
        'form-group-preview' => $this->previewMode,
        'is-invalid' => form_error($field->fieldName) != '',
        $field->type.'-field', 'span-'.$field->span, $field->cssClass
    ])
    @if ($depends = $this->getFieldDepends($field))data-field-depends='@json($depends)' @endif
    {!! $field->getAttributes('container') !!}
    data-field-name="{{ $field->fieldName }}"
    id="{{ $field->getId('group') }}"
>{!!
    /* Must be on the same line for :empty selector */
    trim($this->makePartial('form/field', ['field' => $field]));
!!}</div>
