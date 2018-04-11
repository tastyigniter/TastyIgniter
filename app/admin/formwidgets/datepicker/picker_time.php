<div class="input-group"
     data-control="clockpicker"
     data-autoclose="true">
    <input
        type="text"
        name="<?= $field->getName() ?>"
        id="<?= $this->getId('time') ?>"
        class="form-control"
        autocomplete="off"
        value="<?= $value ? $value->format($timeFormat) : null ?>"
        <?= $field->getAttributes() ?>
        <?= $this->previewMode ? 'readonly="readonly"' : '' ?>
    />
    <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
</div>
