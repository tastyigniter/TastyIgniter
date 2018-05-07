<?php if ($this->previewMode) { ?>
    <p class="form-control-static"><?= $field->value ? currency_format($field->value) : '0' ?></p>
<?php } else { ?>
    <div class="field-money">
        <div class="input-group">
            <span class="input-group-prepend">
                <span class="input-group-icon"><i class="fa fa-money"></i></span>
            </span>
            <input
                type="number"
                name="<?= $field->getName() ?>"
                id="<?= $field->getId() ?>"
                value="<?= e($field->value) ?>"
                placeholder="<?= e($field->placeholder) ?>"
                class="form-control"
                autocomplete="off"
                <?= $field->hasAttribute('pattern') ? '' : 'pattern="-?\d+(\.\d+)?"' ?>
                <?= $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' ?>
                <?= $field->getAttributes() ?>
            />
        </div>
    </div>
<?php } ?>