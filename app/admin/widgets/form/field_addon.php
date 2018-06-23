<?php
$addonDefault = [
    'tag'        => 'span',
    'label'      => 'Label',
    'attributes' => [
        'class' => 'input-group-text',
    ],
];
$addonLeft = isset($field->config['addonLeft']) ? (object)array_merge($addonDefault, $field->config['addonLeft']) : null;
$addonRight = isset($field->config['addonRight']) ? (object)array_merge($addonDefault, $field->config['addonRight']) : null;
?>
<div class="input-group">
    <?php if ($addonLeft) { ?>
        <span class="input-group-append">
            <?= '<'.$addonLeft->tag.Html::attributes($addonLeft->attributes).'>'
            .lang($addonLeft->label).'</'.$addonLeft->tag.'>'; ?>
        </span>
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
        <span class="input-group-prepend">
            <?= '<'.$addonRight->tag.Html::attributes($addonRight->attributes).'>'
            .lang($addonRight->label).'</'.$addonRight->tag.'>'; ?>
        </span>
    <?php } ?>
</div>
