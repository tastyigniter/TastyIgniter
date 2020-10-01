@php
    $fieldOptions = $field->value;
    $timesheet = [];
    $daysOfWeek = [];
    foreach ($formModel->getWeekDaysOptions() as $key => $day){
        $daysOfWeek[] = ['name' => $day];
        $timesheet[] = $fieldOptions[$key] ?? ['day' => $key, 'open' => '00:00', 'close' => '23:59', 'status' => 1];
    }
@endphp
<div class="field-flexible-hours">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead></thead>
            <tbody 
                class="timesheet-editor" 
                data-days='@json($daysOfWeek)'
                data-values='@json($timesheet)'
            ></tbody>
        </table>
    </div>
</div>
