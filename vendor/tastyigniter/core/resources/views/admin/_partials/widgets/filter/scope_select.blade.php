<div class="filter-scope select form-group mb-0">
    <select
        name="{{ $this->getScopeName($scope) }}"
        data-control="selectlist"
        {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
    >
        <option value="">@lang($scope->label ?: 'igniter::admin.text_please_select')</option>
        @php $options = $this->getSelectOptions($scope->scopeName) @endphp
        @foreach($options['available'] as $key => $value)
            <option
                value="{{ $key }}"
                {!! ($options['active'] == $key) ? 'selected="selected"' : '' !!}
            >@lang($value)</option>
        @endforeach
    </select>
</div>
