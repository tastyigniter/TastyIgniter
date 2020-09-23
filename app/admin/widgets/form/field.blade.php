@unless ($field->hidden)
    @unless ($this->showFieldLabels($field))
        {!! $this->renderFieldElement($field) !!}
    @else
        @if ($field->label)
            <label for="{{ $field->getId() }}" class="control-label">@lang($field->label)</label>
        @endif

        @if ($field->comment AND $field->commentPosition == 'above')
            <p class="help-block before-field">
                @if ($field->commentHtml) {!! $field->comment !!} @else @lang($field->comment) @endif
            </p>
        @endif

        {!! $this->renderFieldElement($field) !!}

        @if ($field->comment AND $field->commentPosition == 'below')
            <p class="help-block">
                @if ($field->commentHtml) {!! $field->comment !!} @else @lang($field->comment) @endif
            </p>
        @endif

    @endunless
@endunless
