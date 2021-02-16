@php
    $isCheckboxMode = $scope->mode ?? 'checkbox';
    $selectMultiple = $isCheckboxMode == 'checkbox';
    $options = $this->getSelectListOptions($scope->scopeName);
    $enableFilter = (count($options['available']) > 20);
@endphp
<div class="filter-scope selectlist form-group">
    <div class="control-selectlist w-100">
        <select
            data-control="selectlist"
            name="{{ $this->getScopeName($scope).($selectMultiple ? '[]' : '') }}"
            {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
            @if ($scope->label)data-non-selected-text="@lang($scope->label)"@endif 
            {!! $selectMultiple ? 'multiple="multiple"' : '' !!}
            data-enable-filtering="{{ $enableFilter }}"
            data-enable-case-insensitive-filtering="{{ $enableFilter }}"
        >
            @if ($scope->label)<option value="">@lang($scope->label)</option>@endif 
            @foreach ($options['available'] as $key => $value)
                <option value="{{ $key }}"
                    {!! in_array($key, $options['active']) ? 'selected="selected"' : '' !!}
                >{{ (strpos($value, 'lang:') !== FALSE) ? lang($value) : $value }}</option>
            @endforeach
        </select>
    </div>
</div>
