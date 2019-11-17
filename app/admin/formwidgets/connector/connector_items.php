<?php $index = 0;
foreach ($fieldItems as $fieldItem) { ?>
    <?php $index++; ?>
    <?= $this->makePartial('connector/connector_item', [
        'item' => $fieldItem,
        'index' => $index,
    ]) ?>
<?php } ?>