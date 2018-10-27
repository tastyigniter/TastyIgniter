<tr>
    <?php if ($showDragHandle) { ?>
        <th class="list-action"></th>
    <?php } ?>

    <?php if ($showCheckboxes) { ?>
        <th class="list-action">
            <div class="custom-control custom-checkbox">
                <input
                    type="checkbox" id="<?= 'checkboxAll-'.$listId ?>"
                    class="custom-control-input" onclick="$('input[name*=\'checked\']').prop('checked', this.checked)"/>
                <label class="custom-control-label" for="<?= 'checkboxAll-'.$listId ?>">&nbsp;</label>
            </div>
        </th>
    <?php } ?>

    <?php foreach ($columns as $key => $column) { ?>
        <?php if ($column->type != 'button') continue; ?>
        <th class="list-action <?= $column->cssClass ?>"></th>
    <?php } ?>
    <?php foreach ($columns as $key => $column) { ?>
        <?php if ($column->type == 'button') continue; ?>

        <?php if ($showSorting AND $column->sortable) { ?>
            <th
                class="list-cell-name-<?= $column->getName() ?> list-cell-type-<?= $column->type ?> <?= $column->cssClass ?>"
                <?php if ($column->width) {
                    echo 'style="width: '.$column->width.'"';
                } ?>>
                <a
                    class="sort-col"
                    data-request="<?= $this->getEventHandler('onSort') ?>"
                    data-request-form="#list-form"
                    data-request-data="sort_by: '<?= $column->columnName ?>'">
                    <?= $this->getHeaderValue($column) ?>
                    <i class="fa fa-sort-<?= ($sortColumn == $column->columnName) ? strtoupper($sortDirection).' active' : 'ASC' ?>"></i>
                </a>
            </th>
        <?php } else { ?>
            <th
                <?php if ($column->width): ?>style="width: <?= $column->width ?>"<?php endif ?>
                class="list-cell-name-<?= $column->getName() ?> list-cell-type-<?= $column->type ?>"
            >
                <span><?= $this->getHeaderValue($column) ?></span>
            </th>
        <?php } ?>
    <?php } ?>

    <?php if ($showSetup) { ?>
        <th class="list-setup">
            <button
                type="button"
                class="btn btn-outline-default btn-sm border-none"
                title="<?= lang('admin::lang.list.text_setup') ?>"
                data-toggle="modal"
                data-target="#<?= $listId ?>-setup-modal"
                data-request="<?= $this->getEventHandler('onLoadSetup'); ?>"
            >
                <i class="fa fa-sliders"></i>
            </button>
        </th>
    <?php } ?>
</tr>