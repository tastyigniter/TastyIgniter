<?php
$addonCssClass = isset($field->config['addonCssClass']) ? $field->config['addonCssClass'] : ['input-group-addon'];
$addonLeft = isset($field->config['addonLeft']) ? $field->config['addonLeft'] : null;
$addonRight = isset($field->config['addonRight']) ? $field->config['addonRight'] : null;
?>
<div class="input-group">
    <?php if ($addonLeft) { ?>
        <span class="<?= implode(' ', $addonCssClass) ?>"><?= $addonLeft ?></span>
    <?php } ?>

    <input
        type="text"
        name="<?= $field->getName() ?>"
        id="<?= $field->getId() ?>"
        value="<?= e($field->value) ?>"
        placeholder="<?= e($field->placeholder) ?>"
        class="form-control"
        autocomplete="off"
        <?= $this->previewMode ? 'disabled' : '' ?>
        <?= $field->hasAttribute('pattern') ? '' : 'pattern="-?\d+(\.\d+)?"' ?>
        <?= $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' ?>
        <?= $field->getAttributes() ?>
    />

    <?php if ($addonRight) { ?>
        <span class="<?= implode(' ', $addonCssClass) ?>"><?= $addonRight ?></span>
    <?php } ?>
</div>
