<?php
$type = $tabs->section;
?>
<?php if ($tabs->suppressTabs) { ?>

    <div
        id="<?= $this->getId($type.'-tabs') ?>"
        class="<?= $tabs->cssClass ?>">
        <div class="form-fields">
            <?= $this->makePartial('form/form_fields', ['fields' => $tabs]) ?>
        </div>
    </div>

<?php }
else { ?>

    <div
        id="<?= $this->getId($type.'-tabs') ?>"
        class="<?= $type ?>-tabs <?= $tabs->cssClass ?>"
        data-control="form-tabs"
        data-store-name="<?= $cookieKey ?>">

        <?php if ($this->context == 'edit') { ?>
            <?= $this->makePartial('form/customize_tabs', ['tabs' => $tabs]) ?>
        <?php }
        else { ?>
            <?= $this->makePartial('form/form_tabs', ['tabs' => $tabs]) ?>
        <?php } ?>
    </div>

<?php } ?>
