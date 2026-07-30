<div
    class="filter-scope date form-group mb-0"
>
    <div class="input-group">
        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
        <input
            type="date"
            data-control="datepicker"
            id="{{ $this->getScopeName($scope) }}-datepicker"
            class="form-control datepicker-input"
            name="{{ $this->getScopeName($scope) }}"
            value="{{ $scope->value ? make_carbon($scope->value)->format('Y-m-d') : '' }}"
            placeholder="@lang($scope->label)"
            autocomplete="off"
            pattern="\d{4}-\d{2}-\d{2}"
            {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
        />
    </div>
</div>
