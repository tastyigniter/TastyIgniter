<div class="filter-scope date form-group">
    <input type="hidden" name="<?= $this->getScopeName($scope) ?>" value="<?= $scope->value ?>" data-datepicker-value="">
    <div class="input-group">
        <input
            type="text"
            id="<?= $this->getScopeName($scope) ?>-datepicker"
            class="form-control"
            autocomplete="off"
            value="<?= mdate('%d-%m-%Y', strtotime($scope->value)) ?>"
            data-control="datepicker"
            data-format="dd-mm-yyyy"
        >
        <div class="input-group-append">
            <span class="input-group-icon"><i class="fa fa-calendar"></i></span>
        </div>
    </div>
</div>
