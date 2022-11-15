<div
    class="filter-scope date form-group"
    data-control="datepicker"
    data-opens="{{ array_get($scope->config, 'pickerPosition', 'left') }}"
    data-time-picker="{{ array_get($scope->config, 'showTimePicker', 'false') }}"
    data-locale='{"format": "{{ $pickerFormat = array_get($scope->config, 'pickerFormat', 'MMM D, YYYY') }}"}'
>
    <div class="input-group">
        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
        <input
            type="text"
            id="{{ $this->getScopeName($scope) }}-datepicker"
            class="form-control"
            value="{{ $scope->value ? make_carbon($scope->value)->isoFormat($pickerFormat) : '' }}"
            placeholder="@lang($scope->label)"
            data-datepicker-trigger
            autocomplete="off"
            {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
        >
        <input
            data-datepicker-input
            type="hidden"
            name="{{ $this->getScopeName($scope) }}"
            value="{{ $scope->value }}"
        />
    </div>
</div>
