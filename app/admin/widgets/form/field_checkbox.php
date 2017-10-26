<?php
$fieldOptions = $field->options();
$checkedValues = (array)$field->value;
?>

<div class="field-checkbox">
    <?php if ($this->previewMode AND $field->value) { ?>
        <div
            id="<?= $field->getId() ?>"
            class="btn-group"
            data-toggle="buttons">
            <?php $index = 0;
            foreach ($fieldOptions as $value => $option) { ?>
                <?php
                $index++;
                $checkboxId = 'checkbox_'.$field->getId().'_'.$index;
                if (is_string($option)) $option = [$option];
                ?>
                <label class="btn btn-default <?= in_array($value, $checkedValues) ? 'active' : ($this->previewMode ? 'disabled' : '') ?>">
                    <input
                        type="checkbox"
                        id="<?= $checkboxId ?>"
                        name="<?= $field->getName() ?>[]"
                        value="<?= $value ?>"
                        <?= in_array($value, $checkedValues) ? 'checked="checked"' : '' ?>
                        disabled="disabled">
                    <?= e(lang($option[0])) ?>
                </label>
            <?php } ?>
        </div>
    <?php } elseif (!$this->previewMode AND count($fieldOptions)) { ?>
        <div
            id="<?= $field->getId() ?>"
            class="btn-group"
            data-toggle="buttons">
            <?php $index = 0;
            foreach ($fieldOptions as $value => $option) { ?>
                <?php
                $index++;
                $checkboxId = 'checkbox_'.$field->getId().'_'.$index;
                if (is_string($option)) $option = [$option];
                ?>
                <label class="btn btn-default <?= in_array($value, $checkedValues) ? 'active' : '' ?>">
                    <input
                        type="checkbox"
                        id="<?= $checkboxId ?>"
                        name="<?= $field->getName() ?>[]"
                        value="<?= $value ?>"
                        <?= $field->getAttributes() ?>
                        <?= in_array($value, $checkedValues) ? 'checked="checked"' : '' ?>>
                    <?= e(lang($option[0])) ?>
                </label>
            <?php } ?>
        </div>
    <?php } else { ?>

        <input
            type="hidden"
            name="<?= $field->getName() ?>"
            value="0"
            <?= $this->previewMode ? 'disabled="disabled"' : '' ?>>

        <div class="checkbox" tabindex="0">
            <label>
                <input
                    type="checkbox"
                    id="<?= $field->getId() ?>"
                    name="<?= $field->getName() ?>"
                    value="1"
                    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                    <?= $field->value == 1 ? 'checked="checked"' : '' ?>
                    <?= $field->getAttributes() ?>>
                <?= $field->label ? e(lang($field->label)) : '' ?>
            </label>
        </div>
    <?php } ?>
</div>
