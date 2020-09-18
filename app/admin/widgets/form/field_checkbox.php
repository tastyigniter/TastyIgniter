<?php
$fieldOptions = $field->options();
$checkedValues = (array)$field->value;
?>

<div class="field-checkbox">
    <?php if (count($fieldOptions)) { ?>
        <?php $index = 0;
        foreach ($fieldOptions as $value => $option) { ?>
            <?php
            $index++;
            $checkboxId = 'checkbox_'.$field->getId().'_'.$index;
            if (is_string($option)) $option = [$option];
            ?>
            <div
                id="<?= $field->getId() ?>"
                class="custom-control custom-radio custom-control-inline"
            >
                <input
                    type="checkbox"
                    id="<?= $checkboxId ?>"
                    class="custom-control-input"
                    name="<?= $field->getName() ?>[]"
                    value="<?= $value ?>"
                    <?= in_array($value, $checkedValues) ? 'checked="checked"' : '' ?>
                    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                    <?= $field->getAttributes() ?>
                />
                <label
                    class="custom-control-label"
                    for="<?= $checkboxId ?>"
                ><?= e(is_lang_key($option[0]) ? lang($option[0]) : $option[0]) ?></label>
            </div>
        <?php } ?>
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
                <?= $field->getAttributes() ?>
            />
            <label class="custom-control-label" for="<?= $field->getId() ?>">
                <?= $field->placeholder ? e(lang($field->placeholder)) : '&nbsp;' ?>
            </label>
        </div>
    <?php } ?>
</div>
