<div
    class="input-group control-colorpicker"
    data-control="colorpicker"
    data-color-selectors="<?= e(json_encode($availableColors)) ?>">
    <span class="component input-group-addon"><i class="fa fa-square fa-2x"></i></span>
    <input
        type="text"
        id="<?= $this->getId('input') ?>"
        name="<?= $name ?>"
        class="form-control"
        value="<?= $value ?>"
        <?= $this->previewMode ? 'disabled="disabled"' : '' ?>>
</div>
