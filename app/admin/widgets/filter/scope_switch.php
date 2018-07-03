<div class="filter-scope switch form-group">
    <select
        name="<?= $this->getScopeName($scope) ?>"
        class="form-control"
        <?= $scope->disabled ? 'disabled="disabled"' : '' ?>
    >
        <option value=""><?= lang($scope->label) ?></option>
        <option value="1" <?= ($scope->value == '1') ? 'selected="selected"' : '' ?>><?= lang('admin::lang.text_enabled') ?></option>
        <option value="0" <?= ($scope->value == '0') ? 'selected="selected"' : '' ?>><?= lang('admin::lang.text_disabled') ?></option>
    </select>
</div>
