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
            <div class="radio radio-primary">
                <input
                    type="radio"
                    id="<?= $widget->getId().'radio-'.$indexValue ?>"
                    class="styled"
                    name="<?= $radioName ?>"
                    value="<?= $indexValue; ?>"
                    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                    <?= array_key_exists($indexValue, $radioValues) ? 'checked="checked"' : ''; ?> />
                <label for="<?= $widget->getId().'radio-'.$indexValue ?>"></label>
            </div>
        </td>
    <?php } ?>

    <?php if ($showCheckboxes) { ?>
        <td class="list-action">
            <div class="checkbox checkbox-primary">
                <input
                    type="checkbox"
                    id="<?= $widget->getId().'checkbox-'.$indexValue ?>"
                    class="styled"
                    name="<?= $checkedName ?>"
                    value="<?= $indexValue; ?>"
                    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
                    <?= array_key_exists($indexValue, $checkedValues) ? 'checked="checked"' : ''; ?> />
                <label for="<?= $widget->getId().'checkbox-'.$indexValue ?>"></label>
            </div>
        </td>
    <?php } ?>

    <td class="list-action repeater-item-remove">
        <a
            class="btn btn-outline btn-danger"
            <?php if (!$this->previewMode) { ?>
            onclick="$(this).closest('#<?= $this->getId('item-'.$indexValue) ?>').remove()"
            <?php } ?>
        >
            <i class="fa fa-times-circle"></i>
        </a>
    </td>

    <?php foreach ($widget->getFields() as $field) { ?>
        <?
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
