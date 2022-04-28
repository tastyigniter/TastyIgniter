<div
    class="filter-scope py-2"
    data-scope-name="{{ $scope->scopeName }}">
    <div class="form-check">
        <input
            type="checkbox"
            id="{{ $scope->getId() }}"
            class="form-check-input"
            name="{{ $this->getScopeName($scope) }}"
            value="1"
            {!! $scope->value ? 'checked' : '' !!}
            {!! $scope->disabled ? 'disabled="disabled"' : '' !!}
        >
        <label
            class="form-check-label justify-content-start"
            for="{{ $scope->getId() }}"
        >@lang($scope->label)</label>
    </div>
</div>
