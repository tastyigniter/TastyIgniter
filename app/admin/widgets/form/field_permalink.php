<?php if ($this->previewMode) { ?>
    <p class="form-control-static"><?= e($field->value) ?></p>
<?php } else { ?>
    <div class="field-permalink">
        <div class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-text"><?= root_url(); ?></span>
            </span>
            <input
                type="text"
                name="<?= $field->getName() ?>"
                id="input-slug"
                class="form-control"
                value="<?= e($field->value); ?>"/>
        </div>
    </div>
<?php } ?>
