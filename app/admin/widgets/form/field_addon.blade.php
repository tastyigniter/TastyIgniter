@php
    $addonDefault = [
        'tag'        => 'span',
        'label'      => 'Label',
        'attributes' => [
            'class' => 'input-group-text',
        ],
    ];
    $addonLeft = isset($field->config['addonLeft']) ? (object)array_merge($addonDefault, $field->config['addonLeft']) : null;
    $addonRight = isset($field->config['addonRight']) ? (object)array_merge($addonDefault, $field->config['addonRight']) : null;
@endphp
<div class="input-group">
    @if ($addonLeft)
        <span class="input-group-text">
            {!! '<'.$addonLeft->tag.Html::attributes($addonLeft->attributes).'>'
            .lang($addonLeft->label).'</'.$addonLeft->tag.'>' !!}
        </span>
    @endif

    <input
        type="text"
        name="{{ $field->getName() }}"
        id="{{ $field->getId() }}"
        value="{{ $field->value }}"
        placeholder="{{ $field->placeholder }}"
        class="form-control"
        autocomplete="off"
        {!! $this->previewMode ? 'disabled' : '' !!}
        {!! $field->hasAttribute('pattern') ? '' : 'pattern="-?\d+(\.\d+)?"' !!}
        {!! $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' !!}
        {!! $field->getAttributes() !!}
    />

    @if ($addonRight)
        <span class="input-group-text">
            {!! '<'.$addonRight->tag.Html::attributes($addonRight->attributes).'>'
            .lang($addonRight->label).'</'.$addonRight->tag.'>' !!}
        </span>
    @endif
</div>
