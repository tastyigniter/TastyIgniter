<?php $index = 0;
foreach ($fieldItems as $fieldItem) { ?>
    <?= $this->makePartial('connector/connector_item', [
        'item' => $fieldItem,
        'index' => $index,
    ]) ?>
    <?php $index++; ?>
<?php } ?>