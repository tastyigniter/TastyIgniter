@if ($this->previewMode)
    <p class="form-control-static">{{ $field->value ? currency_format($field->value) : '0' }}</p>
@else
    <div class="field-money">
        <div class="input-group">
            <span class="input-group-text"><i class="fa fa-money"></i></span>
            <input
                type="number"
                name="{{ $field->getName() }}"
                id="{{ $field->getId() }}"
                value="{{ number_format($field->value, 2, '.', '') }}"
                placeholder="@lang($field->placeholder)"
                class="form-control"
                autocomplete="off"
                step="any"
                {!! $field->hasAttribute('pattern') ? '' : 'pattern="-?\d+(\.\d+)?"' !!}
                {!! $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' !!}
                {!! $field->getAttributes() !!}
            />
        </div>
    </div>
@endif
