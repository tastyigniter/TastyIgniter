<textarea
    name="<?= $field->getName() ?>"
    id="<?= $field->getId() ?>"
    autocomplete="off"
    class="form-control field-textarea"
    placeholder="<?= e($field->placeholder) ?>"
    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
    <?= $field->getAttributes() ?>
><?= e($field->value) ?></textarea>
