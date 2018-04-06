<?php
$fieldOptions = $field->options();
$selectMultiple = (isset($field->config['mode']) AND $field->config['mode'] == 'checkbox');
$checkedValues = (array)$field->value;
$enableFilter = (count($fieldOptions) > 20);
?>
<div class="control-selectlist">
    <select
        data-control="selectlist"
        id="<?= $field->getId() ?>"
        name="<?= $field->getName() ?><?= $selectMultiple ? '[]' : '' ?>"
        <?php if ($field->placeholder) { ?>data-non-selected-text="<?= e(lang($field->placeholder)) ?>"<?php } ?>
        <?= $selectMultiple ? 'multiple="multiple"' : '' ?>
        data-enable-filtering="<?= $enableFilter; ?>"
        data-enable-case-insensitive-filtering="<?= $enableFilter; ?>"
        <?= $field->getAttributes() ?>>

        <?php if ($field->placeholder) { ?>
            <option value=""><?= e(lang($field->placeholder)) ?></option>
        <?php } ?>

        <?php foreach ($fieldOptions as $value => $option) { ?>
            <?php
            if (!is_array($option)) $option = [$option];
            ?>
            <option
                <?= in_array($value, $checkedValues) ? 'selected="selected"' : '' ?>
                value="<?= $value ?>">
                <?= e((sscanf($option[0], 'lang:%s', $line) === 1) ? lang($line) : $option[0]) ?>
                <?php if (isset($option[1])) { ?>
                    <span><?= e((sscanf($option[1], 'lang:%s', $line) === 1) ? lang($line) : $option[1]) ?></span>
                <?php } ?>
            </option>
        <?php } ?>
    </select>
</div>
