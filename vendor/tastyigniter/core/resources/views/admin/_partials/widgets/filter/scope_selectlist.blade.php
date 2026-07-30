@php
    $isCheckboxMode = $scope->mode ?? 'checkbox';
    $selectMultiple = $isCheckboxMode == 'checkbox';
    $options = $this->getSelectOptions($scope->scopeName);
    $enableFilter = (count($options['available']) > 20);
@endphp
<div class="filter-scope selectlist form-group mb-0">
    <div class="control-selectlist w-100">
        <select
            name="{{ $this->getScopeName($scope).($selectMultiple ? '[]' : '') }}"
            data-control="selectlist"
            {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
            {!! $selectMultiple ? 'multiple="multiple"' : '' !!}
        >
            <option value="">@lang($scope->label ?: 'igniter::admin.text_please_select')</option>
            @foreach($options['available'] as $key => $value)
                @php
                    if (!is_array($options['active'])) $options['active'] = [$options['active']];
                @endphp
                <option
                    value="{{ $key }}"
                    {!! in_array($key, $options['active']) ? 'selected="selected"' : '' !!}
                >@lang($value)</option>
            @endforeach
        </select>
    </div>
</div>
