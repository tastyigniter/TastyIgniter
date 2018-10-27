<?php
$fieldOptions = $field->options();
$checkedValues = (array)$field->value;
?>

<div class="field-checkbox">
    <?php if ($this->previewMode AND $field->value) { ?>
        <div
            id="<?= $field->getId() ?>"
            class="btn-group btn-group-toggle"
            data-toggle="buttons">
            <?php $index = 0;
            foreach ($fieldOptions as $value => $option) { ?>
                <?php
                $index++;
                $checkboxId = 'checkbox_'.$field->getId().'_'.$index;
                if (is_string($option)) $option = [$option];
                ?>
                <label
                    class="btn btn-light <?= in_array($value, $checkedValues) ? 'active' : ($this->previewMode ? 'disabled' : '') ?>">
                    <input
                        type="checkbox"
                        id="<?= $checkboxId ?>"
                        name="<?= $field->getName() ?>[]"
                        value="<?= $value ?>"
                        <?= in_array($value, $checkedValues) ? 'checked="checked"' : '' ?>
                        disabled="disabled">
                    <?= e((sscanf($option[0], 'lang:%s', $line) === 1) ? lang($line) : $option[0]) ?>
                </label>
            <?php } ?>
        </div>
    <?php } elseif (!$this->previewMode AND count($fieldOptions)) { ?>
        <div
            id="<?= $field->getId() ?>"
            class="btn-group btn-group-toggle"
            data-toggle="buttons">
            <?php $index = 0;
            foreach ($fieldOptions as $value => $option) { ?>
                <?php
                $index++;
                $checkboxId = 'checkbox_'.$field->getId().'_'.$index;
                if (is_string($option)) $option = [$option];
                ?>
                <label class="btn btn-light <?= in_array($value, $checkedValues) ? 'active' : '' ?>">
                    <input
                        type="checkbox"
                        id="<?= $checkboxId ?>"
                        name="<?= $field->getName() ?>[]"
                        value="<?= $value ?>"
                        <?= $field->getAttributes() ?>
                        <?= in_array($value, $checkedValues) ? 'checked="checked"' : '' ?>>
                    <?= e((sscanf($option[0], 'lang:%s', $line) === 1) ? lang($line) : $option[0]) ?>
                </label>
            <?php } ?>
        </div>
    <?php } else { ?>

        <input
            type="hidden"
            name="<?= $field->getName() ?>"
            value="0"
            <?= $this->previewMode ? 'disabled="disabled"' : '' ?>>

        <div class="custom-control custom-checkbox" tabindex="0">
            <input
                type="checkbox"
                class="custom-control-input"
                id="<?= $field->getId() ?>"
                name="<?= $field->getName() ?>"
                value="1"
                <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                <?= $field->value == 1 ? 'checked="checked"' : '' ?>
                <?= $field->getAttributes() ?>>
            <label class="custom-control-label" for="<?= $field->getId() ?>">
                <?= $field->placeholder ? e(lang($field->placeholder)) : '&nbsp;' ?>
            </label>
        </div>
    <?php } ?>
</div>
