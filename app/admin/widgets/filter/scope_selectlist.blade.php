@php
    $isCheckboxMode = $scope->mode ?? 'checkbox';
    $selectMultiple = $isCheckboxMode == 'checkbox';
    $options = $this->getSelectOptions($scope->scopeName);
    $enableSearch = (count($options['available']) > 20);
@endphp
<div class="filter-scope selectlist form-group">
    <div class="control-selectlist w-100">
        <select
            data-control="selectlist"
            name="{{ $this->getScopeName($scope).($selectMultiple ? '[]' : '') }}"
            {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
            @if ($scope->label)data-placeholder-text="@lang($scope->label)" @endif
            {!! $selectMultiple ? 'multiple="multiple"' : '' !!}
            data-show-search="{{ $enableSearch }}"
            data-max-values-shown="2"
        >
            @if (!$selectMultiple && $scope->label)<option data-placeholder="true"></option>@endif
            @foreach ($options['available'] as $key => $value)
                @php
                    if (!is_array($options['active'])) $options['active'] = [$options['active']];
                @endphp
                <option
                    value="{{ $key }}"
                    {!! in_array($key, $options['active']) ? 'selected="selected"' : '' !!}
                >{{ (strpos($value, 'lang:') !== FALSE) ? lang($value) : $value }}</option>
            @endforeach
        </select>
    </div>
</div>
