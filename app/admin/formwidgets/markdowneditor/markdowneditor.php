<?php if ($this->previewMode): ?>
    <div class="form-control"><?= e($value) ?></div>
<?php else: ?>
    <div
        id="<?= $this->getId() ?>"
        class="field-markdowneditor size-<?= $size ?>"
        data-control="markdowneditor"
    ><?= e($value) ?></div>
<?php endif ?>
