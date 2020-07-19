<?php $lockerValue = $value ? $value->format($formatAlias) : null ?>
<div class="input-group">
    <input
        type="text"
        id="<?= $this->getId('datetime') ?>"
        class="form-control"
        autocomplete="off"
        value="<?= $lockerValue ?>"
        <?= $field->getAttributes() ?>
        <?= $this->previewMode ? 'readonly="readonly"' : '' ?>
        data-control="datepicker"
        data-toggle="datetimepicker"
        data-target="#<?= $this->getId('datetime') ?>"
        data-mode="<?= $this->mode ?>"
        <?php if ($startDate) { ?>data-start-date="<?= $startDate ?>"<?php } ?>
        <?php if ($endDate) { ?>data-end-date="<?= $endDate ?>"<?php } ?>
        <?php if ($datesDisabled) { ?>data-dates-disabled="<?= $datesDisabled ?>"<?php } ?>
        data-format="<?= $datePickerFormat ?>"
    />
    <input
        type="hidden"
        name="<?= $field->getName() ?>"
        value="<?= $value ? $value->format('Y-m-d H:i:s') : null ?>"
        data-datepicker-value
    />
    <div class="input-group-append">
        <span class="input-group-icon"><i class="fa fa-calendar-o"></i></span>
    </div>
</div>
