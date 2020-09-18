<?php
$location = $formModel->location;
$fieldValue = sprintf('%s (%s)', $location->location_name, format_address($location->getAddress(), false));
?>
<?php if ($this->previewMode) { ?>
    <p class="form-control-static"><?= $fieldValue ? e($fieldValue) : '&nbsp;' ?></p>
<?php } else { ?>
    <input
        type="text"
        name="<?= $field->getName() ?>"
        id="<?= $field->getId() ?>"
        value="<?= e($fieldValue) ?>"
        placeholder="<?= e($field->placeholder) ?>"
        class="form-control"
        autocomplete="off"
        <?= $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' ?>
        <?= $field->getAttributes() ?>
    />
<?php } ?>