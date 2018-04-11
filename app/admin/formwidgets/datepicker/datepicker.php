<?php if ($this->previewMode) { ?>
    <div class="form-control-static"><?= $value ? $value->format($formatAlias) : null ?></div>
<?php } else { ?>

    <div
        id="<?= $this->getId() ?>"
        class="control-datepicker">

        <div class="row">
            <?php if ($mode == 'date') { ?>
                <div class="col-md-6">
                    <?= $this->makePartial('datepicker/picker_date') ?>
                </div>
            <?php } elseif ($mode == 'datetime') { ?>
                <div class="col-md-6">
                    <?= $this->makePartial('datepicker/picker_datetime') ?>
                </div>
            <?php } elseif ($mode == 'time') { ?>
                <div class="col-md-6">
                    <?= $this->makePartial('datepicker/picker_time') ?>
                </div>
            <?php } ?>
        </div>

    </div>

<?php } ?>
