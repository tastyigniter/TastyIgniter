<div class="filter-scope select form-group">
    <select
        name="{{ $this->getScopeName($scope) }}"
        class="form-select"
        {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
    >
        <option value="">@lang($scope->label)</option>
        @php $options = $this->getSelectOptions($scope->scopeName) @endphp
        @foreach ($options['available'] as $key => $value)
            <option
                value="{{ $key }}"
                {!! ($options['active'] == $key) ? 'selected="selected"' : '' !!}
            >{{ (strpos($value, 'lang:') !== false) ? lang($value) : $value }}</option>
        @endforeach
    </select>
</div>
