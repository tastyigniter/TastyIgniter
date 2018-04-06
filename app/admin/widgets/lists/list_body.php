<?php foreach ($records as $record) { ?>
    <tr>
        <?php if ($showDragHandle) { ?>
            <td class="list-action">
                <div class="btn btn-handle">
                    <i class="fa fa-sort handle"></i>
                </div>
            </td>
        <?php } ?>

        <?php if ($showCheckboxes) { ?>
            <td class="list-action">
                <div class="checkbox checkbox-primary">
                    <input
                        type="checkbox" id="<?= 'checkbox-'.$record->getKey() ?>"
                        class="styled" value="<?= $record->getKey(); ?>" name="checked[]"/>
                    <label for="<?= 'checkbox-'.$record->getKey() ?>"></label>
                </div>
            </td>
        <?php } ?>

        <?php $index = $url = 0; ?>
        <?php foreach ($columns as $key => $column) { ?>
            <?php $index++; ?>
            <?php if ($column->type == 'button') { ?>
                <td class="list-action <?= $column->cssClass ?>">
                    <?= $this->makePartial('lists/list_button', ['record' => $record, 'column' => $column]) ?>
                </td>
            <?php } else { ?>
                <td
                    class="list-cell-index-<?= $index ?> list-cell-name-<?= $column->getName() ?> list-cell-type-<?= $column->type ?> <?= $column->cssClass ?>"
                >
                    <?= $this->getColumnValue($record, $column) ?>
                </td>
            <?php } ?>
        <?php } ?>

        <?php if ($showSetup) { ?>
            <td class="list-setup">&nbsp;</td>
        <?php } ?>
    </tr>
<?php } ?>
