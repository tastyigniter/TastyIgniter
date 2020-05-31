<tr
    id="<?= $this->getId('item-'.$indexValue) ?>"
    class="repeater-item" data-item-index="<?= $indexValue ?>">
    <?php if (!$this->previewMode AND $sortable) { ?>
        <td class="repeater-item-handle">
            <input type="hidden" name="<?= $sortableInputName ?>[]" value="<?= $indexValue; ?>">
            <div class="btn <?= $this->getId('items') ?>-handle">
                <i class="fa fa-arrows-alt-v"></i>
            </div>
        </td>
    <?php } ?>

    <?php if (!$this->previewMode AND $showRemoveButton) { ?>
        <td class="list-action repeater-item-remove">
            <a
                class="btn btn-outline-danger border-none"
                role="button"
                data-control="remove-item"
                data-target="#<?= $this->getId('item-'.$indexValue) ?>"
                data-prompt="<?= lang('admin::lang.alert_confirm') ?>"
            ><i class="fa fa-trash-alt"></i></a>
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
