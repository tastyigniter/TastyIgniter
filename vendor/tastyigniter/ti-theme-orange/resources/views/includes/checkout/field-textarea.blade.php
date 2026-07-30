<div @class(['form-floating', 'is-invalid' => has_form_error($field->getName())])>
    <textarea
        wire:model="{{$field->getName()}}"
        data-checkout-control="{{$field->fieldName}}"
        name="{{$field->getName()}}"
        id="{{$field->getId()}}"
        autocomplete="off"
        @class(['form-control', 'is-invalid' => has_form_error($field->getName())])
        placeholder="{{ $field->placeholder }}"
        aria-describedby="{{$field->getId()}}-feedback"
        {!! $field->getAttributes() !!}
    >{{ $field->value }}</textarea>
    <label for="{{$field->getId()}}">@lang($field->label)</label>
</div>
<x-igniter-orange::forms.error
    field="{{$field->getName()}}"
    id="{{$field->getId()}}-feedback"
    class="text-danger"
/>
