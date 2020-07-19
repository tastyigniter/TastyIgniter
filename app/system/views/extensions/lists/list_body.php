<?php foreach ($records as $record) { ?>
    <div class="card <?= ($record->status) ? 'bg-light shadow-sm' : 'disabled'; ?> mb-3">
        <div class="card-body p-3">
            <div class="d-flex w-100 align-items-center">
                <?php $icon = $record->icon; ?>
                <div class="mr-4">
                    <span
                        class="extension-icon rounded"
                        style="<?= $icon['styles'] ?? ''; ?>"
                    ><i class="<?= $icon['class'] ?? ''; ?>"></i></span>
                </div>
                <div class="list-action mr-3">
                    <?php foreach ($columns as $key => $column) { ?>
                        <?php if ($column->type != 'button') continue; ?>
                        <?php if (($key == 'install' AND $record->status) OR ($key == 'uninstall' AND !$record->status)) continue; ?>
                        <?= $this->makePartial('lists/list_button', ['record' => $record, 'column' => $column]) ?>
                    <?php } ?>
                </div>

                <?php $index = $url = 0; ?>
                <?php foreach ($columns as $key => $column) { ?>
                    <?php $index++; ?>
                    <?php if ($column->type == 'button') continue; ?>
                    <div class="flex-grow-1">
                        <?= $this->getColumnValue($record, $column) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>
