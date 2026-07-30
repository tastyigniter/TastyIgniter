@php
    $fieldOptions = $field->options();
    $checkedValues = (array)$field->value;
@endphp
<div class="p-3">
    <div class="form-group">
        <input
            type="hidden"
            wire:model="{{$field->getName()}}"
            value="0"
        />
        <div
            id="{{$field->getId('container')}}"
            @class(['form-check', 'form-check-inline' => $field->placeholder])
        >
            <input
                wire:model="{{$field->getName()}}"
                data-checkout-control="{{$field->fieldName}}"
                type="checkbox"
                class="form-check-input"
                id="{{$field->getId()}}"
                name="{{$field->getName()}}"
                value="1"
                aria-describedby="{{$field->getName()}}-feedback"
            >
            @if($field->placeholder)
                <label class="form-check-label ms-2" for="{{ $field->getId() }}">@lang($field->placeholder)</label>
            @endif
        </div>
        <x-igniter-orange::forms.error field="{{$field->getName()}}" id="{{$field->getName()}}-feedback"
            class="text-danger"/>
    </div>
</div>
