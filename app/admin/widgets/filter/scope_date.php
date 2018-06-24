<div class="filter-scope date form-group">
    <select
        name="<?= $this->getScopeName($scope) ?>"
        class="form-control"
        <?= $scope->disabled ? 'disabled="disabled"' : '' ?>
    >
        <option value=""><?= lang($scope->label) ?></option>
        <?php $options = $this->getSelectOptions($scope->scopeName) ?>
        <?php foreach ($options['available'] as $key => $value) { ?>
            <option value="<?= $key ?>" <?= ($options['active'] == $key) ? 'selected="selected"' : '' ?> >
                <?= (strpos($value, 'lang:') !== FALSE) ? lang($value) : $value ?>
            </option>
        <?php } ?>
    </select>
</div>
