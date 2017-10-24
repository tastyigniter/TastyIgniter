<?php if ($this->previewMode) { ?>
    <p class="form-control-static"><?= $field->value ? e($field->value) : '&nbsp;' ?></p>
<?php } else { ?>
    <textarea
        name="<?= $field->getName() ?>"
        id="<?= $field->getId() ?>"
        autocomplete="off"
        class="form-control field-textarea"
        placeholder="<?= e($field->placeholder) ?>"
        <?= $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' ?>
        <?= $field->getAttributes() ?>
    ><?= e($field->value) ?></textarea>
<?php } ?>