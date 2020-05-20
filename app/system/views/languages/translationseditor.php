<?php
$translationStrings = $field->options;
?>
<div
    id="<?= $this->getId('items-container') ?>"
    class="field-translationseditor"
    data-control="translationseditor"
    data-alias="<?= $this->alias ?>"
>
    <label
        for="<?= $this->getId('items') ?>"
    ><?= sprintf(lang('system::lang.languages.text_locale_strings'), $translatedProgress, $totalStrings) ?></label>
    <div
        id="<?= $this->getId('items') ?>"
        class="table-responsive"
    >
        <table class="table mb-0 border-bottom">
            <thead>
            <tr>
                <th width="45%"><?= lang('system::lang.languages.column_variable') ?></th>
                <th><?= sprintf(lang('system::lang.languages.column_language'), $this->model->name) ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $index = 0;
            if ($translationStrings AND $translationStrings->count()) { ?>
            <?php foreach ($translationStrings as $key => $value) { ?>
                <?php $index++; ?>
                    <tr>
                        <td>
                            <p><?= e($value['source']); ?></p>
                            <span class="text-muted"><?= $key ?></span>
                        </td>
                        <td>
                            <input
                                type="hidden"
                                name="<?= $field->getName(); ?>[<?= $key; ?>][source]"
                                value="<?= e($value['source']); ?>"
                            />
                            <textarea
                                class="form-control"
                                rows="3"
                                name="<?= $field->getName(); ?>[<?= $key; ?>][translation]"
                            ><?= e($value['translation']); ?></textarea>
                        </td>
                    </tr>
            <?php } ?>
                <tr class="border-top">
                    <td colspan="999">
                        <div class="d-flex justify-content-end">
                            <?= $translationStrings->render(); ?>
                        </div>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td colspan="999"><?= lang('system::lang.languages.text_empty_translations') ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
