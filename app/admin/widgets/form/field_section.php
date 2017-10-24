<div class="field-section">
    <?php if ($field->label): ?>
        <h4><?= e(lang($field->label)) ?></h4>
    <?php endif ?>

    <?php if ($field->comment): ?>
        <p class="help-block"><?= e(lang($field->comment)) ?></p>
    <?php endif ?>
</div>