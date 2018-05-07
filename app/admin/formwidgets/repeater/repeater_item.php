<tr
    id="<?= $this->getId('item-'.$indexValue) ?>"
    class="repeater-item" data-item-index="<?= $indexValue ?>">
    <?php if (!$this->previewMode AND $sortable) { ?>
        <td class="repeater-item-handle <?= $this->getId('items') ?>-handle">
            <input type="hidden" name="<?= $sortableName ?>" value="<?= $indexValue; ?>">
            <div class="btn btn-handle">
                <i class="fa fa-sort"></i>
            </div>
        </td>
    <?php } ?>

    <?php if ($showRadios) { ?>
        <td class="list-action">
            <div class="custom-control custom-radio">
                <input
                    type="radio"
                    id="<?= $widget->getId().'radio-'.$indexValue ?>"
                    class="custom-control-input"
                    name="<?= $radioName ?>"
                    value="<?= $indexValue; ?>"
                    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                    <?= array_key_exists($indexValue, $radioValues) ? 'checked="checked"' : ''; ?> />
                <label class="custom-control-label" for="<?= $widget->getId().'radio-'.$indexValue ?>"></label>
            </div>
        </td>
    <?php } ?>

    <?php if ($showCheckboxes) { ?>
        <td class="list-action">
            <div class="custom-control custom-checkbox">
                <input
                    type="checkbox"
                    id="<?= $widget->getId().'checkbox-'.$indexValue ?>"
                    class="custom-control-input"
                    name="<?= $checkedName ?>"
                    value="<?= $indexValue; ?>"
                    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                    <?= array_key_exists($indexValue, $checkedValues) ? 'checked="checked"' : ''; ?> />
                <label class="custom-control-label" for="<?= $widget->getId().'checkbox-'.$indexValue ?>"></label>
            </div>
        </td>
    <?php } ?>

    <?php if ($showRemoveButton) { ?>
        <td class="list-action repeater-item-remove">
            <a
                class="btn btn-outline-danger"
                role="button"
                <?php if (!$this->previewMode) { ?>
                    data-control="remove-item"
                    data-target="#<?= $this->getId('item-'.$indexValue) ?>"
                    data-prompt="<?= lang('admin::default.alert_confirm') ?>"
                <?php } ?>
            >
                <i class="fa fa-times-circle"></i>
            </a>
        </td>
    <?php } ?>

    <?php foreach ($widget->getFields() as $field) { ?>
        <?php
        $fieldError = form_error($field->getName());
        $widget->prepareVars();
        ?>

        <?php if ($field->type == 'hidden') { ?>
            <?= $widget->renderFieldElement($field) ?>
        <?php } else { ?>
            <td>
                <?= $widget->renderFieldElement($field) ?>
            </td>
        <?php } ?>
    <?php } ?>
</tr>
