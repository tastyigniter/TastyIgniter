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
            if ($field->disabled AND !in_array($value, $checkedValues)) continue;
            ?>
            <option
                <?= in_array($value, $checkedValues) ? 'selected="selected"' : '' ?>
                value="<?= $value ?>">
                <?= e(is_lang_key($option[0]) ? lang($option[0]) : $option[0]) ?>
                <?php if (isset($option[1])) { ?>
                    <span><?= e(is_lang_key($option[1]) ? lang($option[1]) : $option[1]) ?></span>
                <?php } ?>
            </option>
        <?php } ?>
    </select>
</div>
