<input
    type="hidden"
    name="<?= $field->getName() ?>"
    value="0"
    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>>

<div class="field-switch">
    <input
        type="checkbox"
        id="<?= $field->getId() ?>"
        name="<?= $field->getName() ?>"
        data-toggle="toggle"
        data-onstyle="success" data-offstyle="danger"
        data-on="<?= e(lang('admin::default.text_enabled')) ?>"
        data-off="<?= e(lang('admin::default.text_disabled')) ?>"
        value="1"
        <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
        <?= $field->value == 1 ? 'checked="checked"' : '' ?>
        <?= $field->getAttributes() ?>>
</div>