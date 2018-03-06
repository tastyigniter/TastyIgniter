<?php
$fieldOptions = $field->options();
$useSearch = $field->getConfig('showSearch', FALSE);
$multiOption = $field->getConfig('multiOption', FALSE);
$fieldValue = !is_array($field->value) ? [$field->value] : $field->value;
?>
<?php if ($this->previewMode) { ?>
    <div class="form-control-static"><?= (isset($fieldOptions[$field->value])) ? e(lang($fieldOptions[$field->value])) : '' ?></div>
<?php } else { ?>
    <select
        id="<?= $field->getId() ?>"
        name="<?= $field->getName() ?><?= $multiOption ? '[]' : '' ?>"
        class="form-control"
        <?= $multiOption ? 'multiple="multiple"' : '' ?>
        <?= $field->getAttributes() ?>>

        <?php if ($field->placeholder) { ?>
            <option value=""><?= e(lang($field->placeholder)) ?></option>
        <?php } ?>
        <?php foreach ($fieldOptions as $value => $option) { ?>
            <?php
            if (!is_array($option)) $option = [$option];
            ?>
            <option
                <?= in_array($value, $fieldValue) ? 'selected="selected"' : '' ?>
                <?php if (isset($option[1])): ?>data-<?= strpos($option[1], '.') ? 'image' : 'icon' ?>="<?= $option[1] ?>"<?php endif ?>
                value="<?= $value ?>">
                <?= e((sscanf($option[0], 'lang:%s', $line) === 1) ? lang($line) : $option[0]) ?>
            </option>
        <?php } ?>
    </select>
<?php } ?>
