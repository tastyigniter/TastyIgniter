<input
    type="hidden"
    name="<?= $field->getName() ?>"
    id="<?= $field->getId() ?>"
    value="<?= e($field->value) ?>"
    placeholder="<?= e($field->placeholder) ?>"
    autocomplete="off"
    <?= $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' ?>
    <?= $field->getAttributes() ?>>
