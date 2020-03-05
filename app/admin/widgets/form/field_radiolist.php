<?php
$fieldOptions = $field->options();
$checkedValues = (array)$field->value;
$isScrollable = count($fieldOptions) > 10;
?>
<?php if ($this->previewMode && $field->value) { ?>

    <div class="field-radiolist">
        <?php $index = 0;
        foreach ($fieldOptions as $value => $option) { ?>
            <?php
            $index++;
            $radioId = 'radio_'.$field->getId().'_'.$index;
            if (!in_array($value, $checkedValues)) continue;
            if (!is_array($option)) $option = [$option];
            ?>
            <div class="custom-control custom-radio mb-2">
                <input
                    type="radio"
                    id="<?= $radioId ?>"
                    class="custom-control-input"
                    name="<?= $field->getName() ?>"
                    value="<?= $value ?>"
                    disabled="disabled"
                    checked="checked"
                >
                <label class="custom-control-label" for="<?= $radioId ?>">
                    <?= e(is_lang_key($option[0]) ? lang($option[0]) : $option[0]) ?>
                    <?php if (isset($option[1])) { ?>
                        <p class="help-block font-weight-normal"><?= e(is_lang_key($option[1]) ? lang($option[1]) : $option[1]) ?></p>
                    <?php } ?>
                </label>
            </div>
        <?php } ?>
    </div>

<?php } elseif (!$this->previewMode AND count($fieldOptions)) { ?>

    <div class="field-radiolist <?= $isScrollable ? 'is-scrollable' : '' ?>">
        <?php if ($isScrollable) { ?>
        <div class="field-radiolist-scrollable">
            <div class="scrollbar">
                <?php } ?>

                <input
                    type="hidden"
                    name="<?= $field->getName() ?>"
                    value="0"/>

                <?php $index = 0;
                foreach ($fieldOptions as $value => $option) { ?>
                    <?php
                    $index++;
                    $radioId = 'radio_'.$field->getId().'_'.$index;
                    if (is_string($option)) $option = [$option];
                    ?>
                    <div class="custom-control custom-radio mb-2">
                        <input
                            type="radio"
                            id="<?= $radioId ?>"
                            class="custom-control-input"
                            name="<?= $field->getName() ?>"
                            value="<?= $value ?>"
                            <?= in_array($value, $checkedValues) ? 'checked="checked"' : '' ?>>

                        <label class="custom-control-label" for="<?= $radioId ?>">
                            <?= isset($option[0]) ? e(lang($option[0])) : '&nbsp;' ?>
                            <?php if (isset($option[1])) { ?>
                                <p class="help-block font-weight-normal"><?= e(lang($option[1])) ?></p>
                            <?php } ?>
                        </label>
                    </div>
                <?php } ?>

                <?php if ($isScrollable) { ?>
            </div>
        </div>
    <?php } ?>

    </div>

<?php } else { ?>

    <?php if ($field->placeholder) { ?>
        <p><?= e(lang($field->placeholder)) ?></p>
    <?php } ?>

<?php } ?>
