<div class="field-section">
    <?php if ($field->label) { ?>
        <h5 class="section-title"><?= e(lang($field->label)) ?></h5>
    <?php } ?>

    <?php if ($field->comment) { ?>
        <p class="help-block"><?= lang($field->comment) ?></p>
    <?php } ?>
</div>