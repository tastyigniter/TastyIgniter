<?php foreach ($fields as $field) { ?>
    <?= $this->makePartial('form/field_container', ['field' => $field]) ?>
<?php } ?>
