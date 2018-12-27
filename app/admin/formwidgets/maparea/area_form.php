<div class="form-fields bg-light h-100">
    <?php foreach ($widget->getFields() as $field) { ?>
        <?= $widget->renderField($field) ?>
    <?php } ?>
</div>
