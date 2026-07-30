<div @class(['form-floating', 'is-invalid' => has_form_error($field->getName())])>
    <input
        wire:model="{{$field->getName()}}"
        data-checkout-control="{{$field->fieldName}}"
        type="email"
        id="{{$field->getId()}}"
        @class(['form-control', 'is-invalid' => has_form_error($field->getName())])
        placeholder="{{ $field->placeholder }}"
        aria-describedby="{{$field->getId()}}-feedback"
        autocomplete="off"
        {!! $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' !!}
        {!! $field->getAttributes() !!}
    />
    <label for="{{$field->getId()}}">@lang($field->label)</label>
</div>
<x-igniter-orange::forms.error
    field="{{$field->getName()}}"
    id="{{$field->getId()}}-feedback"
    class="text-danger"
/>
