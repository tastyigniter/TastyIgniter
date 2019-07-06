<?php if ($this->previewMode) { ?>
    <div class="form-control-static"><?= $value ? $value->format($formatAlias) : null ?></div>
<?php } else { ?>

    <div
        id="<?= $this->getId() ?>"
        class="control-datepicker"
    >
        <?php if ($mode == 'date') { ?>
            <?= $this->makePartial('datepicker/picker_date') ?>
        <?php } elseif ($mode == 'datetime') { ?>
            <?= $this->makePartial('datepicker/picker_datetime') ?>
            <?php $lockerValue = $value ? $value->format($dateTimeFormat) : null ?>
        <?php } elseif ($mode == 'time') { ?>
            <?= $this->makePartial('datepicker/picker_time') ?>
            <?php $lockerValue = $value ? $value->format($timeFormat) : null ?>
        <?php } ?>
    </div>

<?php } ?>
