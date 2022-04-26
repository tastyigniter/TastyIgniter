<div
    class="filter-scope daterange form-group"
    data-control="datepicker"
    data-single-date-picker="false"
    data-opens="{{ array_get($scope->config, 'pickerPosition', 'left') }}"
    data-time-picker="{{ ($showTimePicker = array_get($scope->config, 'showTimePicker', FALSE)) ? 'true' : 'false' }}"
    data-locale='{"format": "{{ $pickerFormat = array_get($scope->config, 'pickerFormat', $showTimePicker ? 'MMM D, YYYY hh:mm A' : 'MMM D, YYYY') }}"}'
>
    <div class="input-group">
        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
        <input
            type="text"
            id="{{ $this->getScopeName($scope) }}-daterangepicker"
            class="form-control"
            value="{{ $scope->value ? sprintf('%s - %s', make_carbon($scope->value[0])->isoFormat($pickerFormat), make_carbon($scope->value[1])->isoFormat($pickerFormat)) : '' }}"
            placeholder="@lang($scope->label)"
            data-datepicker-trigger
            autocomplete="off"
            {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
        >
        <input data-datepicker-range-start type="hidden" name="{{ $this->getScopeName($scope) }}[]" value="{{ $scope->value[0] ?? '' }}">
        <input data-datepicker-range-end type="hidden" name="{{ $this->getScopeName($scope) }}[]" value="{{ $scope->value[1] ?? '' }}">
    </div>
</div>
