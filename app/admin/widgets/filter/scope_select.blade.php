@php $options = $this->getSelectOptions($scope->scopeName) @endphp
<div class="filter-scope select form-group">
    <select
        name="{{ $this->getScopeName($scope) }}"
        data-control="selectlist"
        data-placeholder-text="@lang($scope->label)"
        data-show-search="{{ count($options['available']) > 10 }}"
        {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
    >
        <option data-placeholder="true"></option>
        @foreach ($options['available'] as $key => $value)
            <option
                value="{{ $key }}"
                {!! ($options['active'] == $key) ? 'selected="selected"' : '' !!}
            >{{ (strpos($value, 'lang:') !== false) ? lang($value) : $value }}</option>
        @endforeach
    </select>
</div>
