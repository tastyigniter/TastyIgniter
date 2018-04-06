<?php if ($outsideTabs->hasFields()) { ?>
    <?= $this->makePartial('form/form_section', ['tabs' => $outsideTabs]) ?>
<?php } ?>

<?php if ($primaryTabs->hasFields()) { ?>
    <?= $this->makePartial('form/form_section', ['tabs' => $primaryTabs]) ?>
<?php } ?>

