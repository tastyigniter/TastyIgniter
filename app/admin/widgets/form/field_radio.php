<?php
$fieldOptions = $field->options();
?>
<div class="field-radio">
    <?php if ($fieldCount = count($fieldOptions)) { ?>
        <div
            id="<?= $field->getId() ?>"
            class="btn-group btn-group-toggle"
            data-toggle="buttons">
            <?php $index = 0;
            foreach ($fieldOptions as $key => $value) { ?>
                <?php
                $index++;
                ?>
                <label class="btn btn-light <?= $this->previewMode ? 'disabled' : ($field->value == $key ? 'active' : '') ?>">
                    <input
                        type="radio"
                        id="<?= $field->getId($index) ?>"
                        name="<?= $field->getName() ?>"
                        value="<?= $key ?>"
                        <?= $field->value == $key ? 'checked="checked"' : '' ?>
                        <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                        <?= $field->getAttributes() ?>>
                    <?= e((sscanf($value, 'lang:%s', $line) === 1) ? lang($line) : $value) ?>
                </label>
            <?php } ?>
        </div>
    <?php } else { ?>
        <input
            type="hidden"
            name="<?= $field->getName() ?>"
            value="0"
            <?= $this->previewMode ? 'disabled="disabled"' : '' ?>>

        <div class="custom-control custom-control-radio">
            <input
                type="radio"
                class="custom-control-input"
                id="<?= $field->getId($index) ?>"
                name="<?= $field->getName() ?>"
                value="<?= $key ?>"
                <?= $field->value == $key ? 'checked="checked"' : '' ?>
                <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                <?= $field->getAttributes() ?>
            >
            <label class="custom-control-label">
                    <?= e((sscanf($value, 'lang:%s', $line) === 1) ? lang($line) : $value) ?>
            </label>
        </div>
    <?php } ?>
</div>