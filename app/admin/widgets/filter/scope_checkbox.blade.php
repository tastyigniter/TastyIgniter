<div
    class="filter-scope py-2"
    data-scope-name="{{ $scope->scopeName }}">
    <div class="custom-control custom-checkbox">
        <input
            type="checkbox"
            id="{{ $scope->getId() }}"
            class="custom-control-input"
            name="{{ $this->getScopeName($scope) }}"
            value="1"
            {!! $scope->value ? 'checked' : '' !!}
            {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
        >
        <label
            class="custom-control-label justify-content-start"
            for="{{ $scope->getId() }}"
        >@lang($scope->label)</label>
    </div>
</div>
