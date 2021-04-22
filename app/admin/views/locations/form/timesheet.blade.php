@php
    $fieldOptions = $field->options();
@endphp
<div
    class="field-timesheet"
    data-control="timesheet"
    data-days='@json($fieldOptions->daysOfWeek)'
    data-values='@json($fieldOptions->timesheet)'
    data-field-name="{{ $field->getName() }}"
    data-cell-duration="{{ $field->getConfig('cellDuration', '60') }}"
>
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead></thead>
            <tbody
                class="timesheet-editor"
            ></tbody>
        </table>
    </div>
</div>
<input type="hidden" name="{{ $field->getName() }}">
