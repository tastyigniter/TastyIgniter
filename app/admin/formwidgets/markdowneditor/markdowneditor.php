<?php if ($this->previewMode): ?>
    <div class="form-control"><?= e($value) ?></div>
<?php else: ?>
    <div
        id="<?= $this->getId() ?>"
        class="field-markdowneditor size-<?= $size ?>"
        data-control="markdowneditor"
    >
        <textarea
            name="<?= $name ?>"
            id="<?= $this->getId('textarea') ?>"
            rows="20"
            class="form-control"
        ><?= trim(e($value)) ?></textarea>
    </div>
<?php endif ?>
