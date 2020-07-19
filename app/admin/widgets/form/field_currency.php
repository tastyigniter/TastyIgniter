<?php
$currencyModel = \System\Models\Currencies_model::getDefault();
$symbolAfter = $currencyModel->getSymbolPosition();
$symbol = $currencyModel->getSymbol();
?>
<?php if ($this->previewMode) { ?>
    <p class="form-control-static"><?= $field->value ? currency_format($field->value) : '0' ?></p>
<?php } else { ?>
    <div class="input-group">
        <?php if (!$symbolAfter) { ?>
            <span class="input-group-prepend"><span class="input-group-text"><b><?= e($symbol) ?></b></span></span>
        <?php } ?>
        <input
            name="<?= $field->getName() ?>"
            id="<?= $field->getId() ?>"
            class="form-control"
            value="<?= number_format($field->value, 2, '.', '') ?>"
            placeholder="<?= e(lang($field->placeholder)) ?>"
            autocomplete="off"
            step="any"
            <?= $field->hasAttribute('pattern') ? '' : 'pattern="-?\d+(\.\d+)?"' ?>
            <?= $field->hasAttribute('maxlength') ? '' : 'maxlength="255"' ?>
            <?= $field->getAttributes() ?>
        />
        <?php if ($symbolAfter) { ?>
            <span class="input-group-append"><span class="input-group-text"><b><?= e($symbol) ?></b></span></span>
        <?php } ?>
    </div>
<?php } ?>
