<tr
    id="<?= $this->getId('item-'.$indexValue) ?>"
    class="repeater-item" data-item-index="<?= $indexValue ?>">
    <?php if (!$this->previewMode AND $sortable) { ?>
        <td class="repeater-item-handle <?= $this->getId('items') ?>-handle">
            <input type="hidden" name="<?= $sortableInputName ?>[]" value="<?= $indexValue; ?>">
            <div class="btn btn-handle">
                <i class="fa fa-bars"></i>
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
                    data-prompt="<?= lang('admin::lang.alert_confirm') ?>"
                <?php } ?>
            >
                <i class="fa fa-times-circle"></i>
            </a>
        </td>
    <?php } ?>

    <?php foreach ($widget->getFields() as $field) { ?>
        <?php
        $fieldError = form_error($field->getName());
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
