@if ($this->previewMode)
    <p class="form-control-static">{{  $field->value ? e($field->value) : '&nbsp;'  }}</p>
@else
    <input
        type="text"
        name="{{  $field->getName()  }}"
        id="{{  $field->getId()  }}"
        value="{{ $field->value }}"
        placeholder="{{ $field->placeholder }}"
        class="form-control"
        autocomplete="off"
        {!! $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' !!}
        {!! $field->getAttributes() !!}
    />
@endif
