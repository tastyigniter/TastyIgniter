<?php foreach ($records as $record) { ?>
    <tr>
        <?php $index = $url = 0; ?>
        <?php foreach ($columns as $key => $column) { ?>
            <?php $index++; ?>
            <?php if ($column->type == 'button') { ?>
                <?php if (($key == 'install' AND $record->status) OR ($key == 'uninstall' AND !$record->status)) continue; ?>

                <td class="list-action <?= $column->cssClass ?>">
                    <?= $this->makePartial('lists/list_button', ['record' => $record, 'column' => $column]) ?>
                </td>
            <?php }
            else { ?>
                <td
                    class="list-cell-index-<?= $index ?> list-cell-name-<?= $column->getName() ?> list-cell-type-<?= $column->type ?> <?= $column->cssClass ?>"
                >
                    <?= $this->getColumnValue($record, $column) ?>
                </td>
            <?php } ?>
        <?php } ?>
    </tr>
<?php } ?>
