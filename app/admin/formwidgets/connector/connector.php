<div
    id="<?= $this->getId('items-container') ?>"
    class="field-connector"
    data-control="connector"
    data-alias="<?= $this->alias ?>"
    data-sortable-container="#<?= $this->getId('items') ?>"
    data-sortable-handle=".<?= $this->getId('items') ?>-handle"
>
    <div
        id="<?= $this->getId('items') ?>"
        role="tablist"
        aria-multiselectable="true">

        <?php $index = 0; foreach ($fieldItems as $fieldItem) { ?>
            <?php $index++; ?>
            <?= $this->makePartial('connector/connector_item', [
                'item' => $fieldItem,
                'index'  => $index,
            ]) ?>
        <?php } ?>
    </div>
</div>
