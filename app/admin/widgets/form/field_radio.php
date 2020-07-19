<?php
$fieldOptions = $field->options();
?>
<div class="field-radio">
    <?php if ($fieldCount = count($fieldOptions)) { ?>
        <?php $index = 0;
        foreach ($fieldOptions as $key => $value) { ?>
            <?php
            $index++;
            ?>
            <div
                id="<?= $field->getId() ?>"
                class="custom-control custom-radio custom-control-inline"
            >
                <input
                    type="radio"
                    id="<?= $field->getId($index) ?>"
                    class="custom-control-input"
                    name="<?= $field->getName() ?>"
                    value="<?= $key ?>"
                    <?= $field->value == $key ? 'checked="checked"' : '' ?>
                    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                    <?= $field->getAttributes() ?>
                />
                <label
                    class="custom-control-label"
                    for="<?= $field->getId($index) ?>"
                ><?= e(is_lang_key($value) ? lang($value) : $value) ?></label>
            </div>
        <?php } ?>
    <?php } ?>
</div>