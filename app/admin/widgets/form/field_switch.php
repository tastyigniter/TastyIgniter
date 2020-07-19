<?php
$on = $field->config['on'] ?? 'admin::lang.text_enabled';
$off = $field->config['off'] ?? 'admin::lang.text_disabled';
$onColor = $field->config['onColor'] ?? 'success';
$offColor = $field->config['offColor'] ?? 'danger';
$labelWith = $field->config['labelWith'] ?? '120';
?>
<input
    type="hidden"
    name="<?= $field->getName() ?>"
    value="0"
    <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
/>

<div class="field-custom-container">
    <div class="custom-control custom-switch">
        <input
            type="checkbox"
            name="<?= $field->getName() ?>"
            id="<?= $field->getId() ?>"
            class="custom-control-input"
            value="1"
            <?= $this->previewMode ? 'disabled="disabled"' : '' ?>
            <?= $field->value == 1 ? 'checked="checked"' : '' ?>
            <?= $field->getAttributes() ?>
        />
        <label
            class="custom-control-label"
            for="<?= $field->getId() ?>"
        ><?= e(lang($off)) ?>/<?= e(lang($on)) ?></label>
    </div>
</div>