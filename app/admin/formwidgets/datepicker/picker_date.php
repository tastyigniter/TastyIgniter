<div class="input-group">
    <input
        type="text"
        name="<?= $field->getName() ?>"
        id="<?= $this->getId('date') ?>"
        class="form-control"
        autocomplete="off"
        value="<?= $value ? $value->format($dateFormat) : null ?>"
        <?= $field->getAttributes() ?>
        <?= $this->previewMode ? 'readonly="readonly"' : '' ?>
        data-control="datepicker"
        <?php if ($startDate) { ?>data-start-date="<?= $startDate ?>"<?php } ?>
        <?php if ($endDate) { ?>data-end-date="<?= $endDate ?>"<?php } ?>
        <?php if ($datesDisabled) { ?>data-dates-disabled="<?= $datesDisabled ?>"<?php } ?>
        data-format="<?= $datePickerFormat ?>"
    />
    <span class="input-group-prepend">
        <span class="input-group-icon"><i class="fa fa-calendar-o"></i></span> 
    </span>
</div>
