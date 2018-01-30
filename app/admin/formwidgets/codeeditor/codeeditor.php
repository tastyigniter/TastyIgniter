<?php if ($this->previewMode) { ?>
    <div class="form-control-static"><?= $value ?></div>
<?php } else { ?>
    <div
        class="field-codeeditor size-<?= $size ?>"
        data-control="code-editor"
        data-mode="<?= $mode ?>"
        data-theme="<?= $theme ?>"
        data-line-separator="<?= $lineSeparator ?>"
        data-read-only="<?= $readOnly ?>"
        data-changed-selector="#<?= $this->getId('changed') ?>"
        data-height="<?= $size == 'small' ? 350 : 600 ?>"
    >
        <textarea
            name="<?= $name ?>"
            id="<?= $this->getId('textarea') ?>"
            rows="20"
            class="form-control"
        ><?= trim(e($value)) ?></textarea>

        <input id="<?= $this->getId('changed') ?>" type="hidden" name="<?= $changedName ?>">
    </div>
<?php } ?>
