<div class="field-paymenteditor"
     data-control="payment-editor">

    <div id="<?= $this->getId() ?>">
        <div class="input-group">
            <span class="form-control" data-payment-name><?= $title ? e(lang($title)) : '&nbsp;'; ?></span>
            <span class="input-group-btn">
                <button
                    class="btn btn-default"
                    type="button"
                    data-toggle="modal"
                    data-target="#<?= $this->getId('form-modal') ?>"
                    <?= ($this->previewMode) ? 'disabled="disabled"' : '' ?>>
                <i class="fa fa-pencil"></i>&nbsp;&nbsp;<?= $formPrompt ? e(lang($formPrompt)) : '' ?>
                </button>
                <button
                    class="btn btn-info"
                    type="button"
                    data-toggle="modal"
                    data-target="#<?= $this->getId('activity-modal') ?>">
                        <i class="fa fa-file-text-o"></i>&nbsp;&nbsp;<?= $listPrompt ? e(lang($listPrompt)) : '' ?>
                </button>
            </span>
        </div>
    </div>
    <input
        type="hidden"
        name="<?= $field->getName() ?>"
        id="<?= $field->getId() ?>"
        value="<?= e($field->value) ?>"
        data-payment-value>

    <?php if (!$this->previewMode) { ?>
        <?= $this->makePartial('paymenteditor/form') ?>
    <?php } ?>

    <?= $this->makePartial('paymenteditor/list') ?>
</div>

