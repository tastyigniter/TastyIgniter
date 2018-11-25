<?php
$fieldError = form_error($field->fieldName);
?>
<div
    class="form-group<?=
    $this->previewMode ? ' form-group-preview' : ''
    ?><?= ($fieldError != '') ? ' is-invalid' : ''
    ?> <?= $field->type ?>-field span-<?= $field->span ?> <?= $field->cssClass ?>"
    <?= $field->getAttributes('container') ?>
    id="<?= $field->getId('group') ?>"><?=
    /* Must be on the same line for :empty selector */
    trim($this->makePartial('form/field', ['field' => $field]));
    ?></div>