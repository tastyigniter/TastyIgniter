<?php
$fieldValue = $field->value;
$fieldPlaceholder = $field->placeholder ?: $this->emptyOption;
?>
<div
    id="<?= $this->getId() ?>"
    class="control-recordeditor"
    data-control="record-editor"
    data-alias="<?= $this->alias ?>"
>
    <div
        class="input-group" data-toggle="modal"
        data-target="#<?= $this->getId('form-modal') ?>"
    >
        <?php if ($addonLeft) { ?>
            <div class="input-group-prepend"><?= $addonLeft ?></div>
        <?php } ?>
        <select
            id="<?= $field->getId() ?>"
            name="<?= $field->getName() ?>"
            class="form-control"
            data-control="choose-record"
            <?= $field->getAttributes() ?>>

            <?php if ($fieldPlaceholder) { ?>
                <option value="0"><?= e(lang($fieldPlaceholder)) ?></option>
            <?php } ?>
            <?php foreach ($fieldOptions as $value => $option) { ?>
                <?php
                if (!is_array($option)) $option = [$option];
                ?>
                <option
                    <?= $value == $fieldValue ? 'selected="selected"' : '' ?>
                    <?php if (isset($option[1])): ?>data-<?= strpos($option[1], '.') ? 'image' : 'icon' ?>="<?= $option[1] ?>"<?php endif ?>
                    value="<?= $value ?>">
                    <?= e((sscanf($option[0], 'lang:%s', $line) === 1) ? lang($line) : $option[0]) ?>
                </option>
            <?php } ?>
        </select>
        <div class="input-group-prepend ml-1">
            <?php if ($addonRight) { ?>
                <?= $addonRight ?>
            <?php } ?>
            <button
                type="button"
                class="btn btn-outline-default"
                data-control="create-record"
                <?= ($this->previewMode) ? 'disabled="disabled"' : '' ?>
            ><i class="fa fa-plus"></i>&nbsp;&nbsp;<?= e(lang($addLabel).' '.lang($this->formName)) ?></button>
            <button
                type="button"
                class="btn btn-outline-default"
                data-control="edit-record"
                <?= ($this->previewMode) ? 'disabled="disabled"' : '' ?>
            ><i class="fa fa-pencil"></i>&nbsp;&nbsp;<?= e(lang($editLabel).' '.lang($this->formName)) ?></button>
            <button
                type="button"
                class="btn btn-outline-danger"
                title="<?= e(lang($deleteLabel).' '.lang($this->formName)) ?>"
                data-control="delete-record"
                data-confirm-message="<?= lang('admin::lang.alert_warning_confirm') ?>"
                <?= ($this->previewMode) ? 'disabled="disabled"' : '' ?>
            ><i class="fa fa-trash"></i></button>
        </div>
    </div>
</div>
