<?php
$statusItem = isset($fieldOptions[$value]) ? $fieldOptions[$value] : [];
?>
<div
    id="<?= $this->getId() ?>"
    class="control-statuseditor"
    data-control="status-editor"
    data-data="<?= e(json_encode($fieldOptions)) ?>">

    <div class="input-group" data-toggle="modal"
         data-target="#<?= $this->getId('form-modal') ?>">
            <span class="input-group-addon">
                <i class="fa fa-2x fa-square"
                   data-status-color
                   style="color: <?= $statusItem ? e($statusItem[$colorFrom]) : '' ?>"></i>
            </span>
        <span data-status-name class="form-control"><?= $statusItem ? e(lang($statusItem[$nameFrom])) : '' ?></span>
        <span class="input-group-btn">
                <button
                    class="btn btn-default"
                    type="button"
                    <?= ($this->previewMode) ? 'disabled="disabled"' : '' ?>>
                <i class="fa fa-pencil"></i>&nbsp;&nbsp;<?= $buttonLabel ? e(lang($buttonLabel)) : '' ?>
                </button>
            </span>
    </div>
    <input
        type="hidden"
        name="<?= $field->getName() ?>"
        id="<?= $field->getId() ?>"
        value="<?= e($field->value) ?>"
        data-status-value>

    <?php if (!$this->previewMode) { ?>
        <?= $this->makePartial('statuseditor/form') ?>
    <?php } ?>

</div>
