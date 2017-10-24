<div class="input-group">
    <input
        type="text"
        name="<?= $field->getName() ?>"
        id="<?= $this->getId('date') ?>"
        class="form-control"
        autocomplete="off"
        value="<?= $value ?>"
        <?= $field->getAttributes() ?>
        <?= $this->previewMode ? 'readonly="readonly"' : '' ?>
        data-control="datepicker"
        <?php if ($startDate) { ?>data-start-date="<?= $startDate ?>"<?php } ?>
        <?php if ($endDate) { ?>data-end-date="<?= $endDate ?>"<?php } ?>
        <?php if ($datesDisabled) { ?>data-dates-disabled="<?= $datesDisabled ?>"<?php } ?>
        data-format="<?= $format ?>" />
    <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
</div>
