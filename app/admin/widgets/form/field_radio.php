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
                <label class="btn btn-light <?= $field->value == $key ? 'active' : ''; ?><?= $this->previewMode ? 'disabled' : ''; ?>">
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
    <?php } ?>
</div>