<div class="field-connector"
     data-control="connector"
     data-sortable-container="#<?= $this->getId('items') ?>"
     data-sortable-handle=".<?= $this->getId('items') ?>-handle">

    <?php if (!$this->previewMode AND count($fieldOptions)) { ?>
    <div
        id="<?= $this->getId('options') ?>"
        class="margin-bottom">
        <select
            class="form-control"
            data-control="add-item"
            data-request="<?= $this->getEventHandler('onAddItem') ?>">

            <option value=""><?= $prompt ? e(lang($prompt)) : '' ?></option>
            <?php foreach ($fieldOptions as $key => $value) { ?>
                <option value="<?= $key ?>" ><?= $value ?></option>
            <?php } ?>
        </select>
    </div>
    <br>
    <?php } ?>

    <div
        id="<?= $this->getId('items') ?>"
        class="panel-group"
        role="tablist"
        aria-multiselectable="true">

        <?php foreach ($this->formWidgets as $index => $widget) { ?>
            <?= $this->makePartial('connector/connector_item', [
                'widget' => $widget,
                'index'  => $index,
            ]) ?>
        <?php } ?>
    </div>
</div>
