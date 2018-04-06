<div
    id="<?= $tableId ?>"
    data-control="table"
    class="control-table"
    data-columns="<?= e(json_encode($columns)) ?>"
    data-data="<?= e($data) ?>"
    data-data-field="<?= e($recordsKeyFrom) ?>"
    data-alias="<?= e($tableAlias) ?>"
    data-field-name="<?= e($tableAlias) ?>"
    data-height="<?= e($height) ?>"
    data-dynamic-height="<?= e($dynamicHeight) ?>"
    data-page-size="<?= e($pageLimit) ?>"
    data-pagination="<?= e($showPagination) ?>"
></div>
