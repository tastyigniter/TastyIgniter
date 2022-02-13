<div class="field-section">
    @if ($field->label)
        <h5 class="section-title">@lang($field->label)</h5>
    @endif

    @if ($field->comment)
        <p class="help-block">@lang($field->comment)</p>
    @endif
</div>
