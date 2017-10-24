<?php if (!$field->hidden) { ?>
    <?php if (!$this->showFieldLabels($field)) { ?>

        <?= $this->renderFieldElement($field) ?>

    <?php } else { ?>
        <?php
        $fieldComment = $field->commentHtml ? $field->comment : e($field->comment);
        ?>

        <?php if ($field->label) { ?>
            <label for="<?= $field->getId() ?>" class="control-label">
                <?= e(lang($field->label)) ?>
            </label>
        <?php } ?>

        <?php if ($field->comment AND $field->commentPosition == 'above') { ?>
            <p class="help-block before-field"><?= lang($fieldComment) ?></p>
        <?php } ?>

        <?= $this->renderFieldElement($field) ?>

        <?php if ($field->comment AND $field->commentPosition == 'below') { ?>
            <p class="help-block"><?= lang($fieldComment) ?></p>
        <?php } ?>

    <?php } ?>
<?php } ?>
