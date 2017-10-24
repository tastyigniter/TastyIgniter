<?php if ($this->previewMode) { ?>
    <p class="form-control-static"><?= $field->value ? e($field->value) : '0' ?></p>
<?php } else { ?>
    <input
        type="number"
        name="<?= $field->getName() ?>"
        id="<?= $field->getId() ?>"
        value="<?= e($field->value) ?>"
        placeholder="<?= e($field->placeholder) ?>"
        class="form-control"
        autocomplete="off"
        <?= $field->hasAttribute('pattern') ? '' : 'pattern="-?\d+(\.\d+)?"' ?>
        <?= $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' ?>
        <?= $field->getAttributes() ?>
    />
<?php } ?>