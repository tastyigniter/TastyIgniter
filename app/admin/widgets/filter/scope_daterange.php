<div class="filter-scope date form-group">
    <input type="hidden" name="<?= $this->getScopeName($scope) ?>" value="" data-datepicker-value=""/>
    <button
        id="<?= $this->getScopeName($scope) ?>"
        class="btn btn-light text-nowrap"
        data-control="daterange"
        type="button"
        value="<?= $scope->value; ?>"
        <?= $scope->disabled ? 'disabled="disabled"' : '' ?>
    >
        <i class="fa fa-calendar"></i>&nbsp;&nbsp;
        <span><?= lang($scope->label) ?></span>&nbsp;&nbsp;
        <i class="fa fa-caret-down"></i>
    </button>
</div>
