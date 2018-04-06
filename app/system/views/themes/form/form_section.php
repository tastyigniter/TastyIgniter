<?php
$type = $tabs->section;
?>
<?php if ($tabs->suppressTabs) { ?>

    <div
        id="<?= $this->getId($type.'Tabs') ?>"
        class="<?= $tabs->cssClass ?>">
        <div class="panel">
            <div class="panel-body">
                <?= $this->makePartial('form/form_fields', ['fields' => $tabs]) ?>
            </div>
        </div>
    </div>

<?php }
else { ?>

    <div
        id="<?= $this->getId($type.'Tabs') ?>"
        class="<?= $type ?>-tabs <?= $tabs->cssClass ?>">

        <?php if ($this->context == 'edit') { ?>
            <?= $this->makePartial('themes/customize_tabs', ['tabs' => $tabs]) ?>
        <?php }
        else { ?>
            <?= $this->makePartial('form/form_tabs', ['tabs' => $tabs]) ?>
        <?php } ?>
    </div>

<?php } ?>
