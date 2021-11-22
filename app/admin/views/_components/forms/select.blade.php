@props([
    'label' => null,
    'placeholder' => null,
    'options' => [],
    'size' => null,
    'help' => null,
])

@php
    $key = $attributes->get('name', '');
    $id = $attributes->get('id', '');
@endphp
<div class="mb-3">
    <x-forms.label :label="$label" :for="$id"/>

    <select {{ $attributes->class([
        'form-select',
        'form-select-' . $size => $size,
        'is-invalid' => $errors->has($key),
    ])->merge([
        'id' => $id
    ]) }}>
        @isset($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endisset

        @foreach($options as $value => $label)
            <option value="{{ $value }}">{{ $label }}</option>
        @endforeach
    </select>

    <x-forms.error :key="$key"/>
    <x-forms.help :label="$help"/>
</div>
