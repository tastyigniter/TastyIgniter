<div class="filter-scope checkbox"
     data-scope-name="<?= $scope->scopeName ?>">
    <input
        type="checkbox"
        id="<?= $scope->getId() ?>"
        name="<?= $this->getScopeName($scope) ?>"
        value="1" <?= $scope->value ? 'checked' : '' ?>>
    <label for="<?= $scope->getId() ?>"><?= e(lang($scope->label)) ?></label>
</div>