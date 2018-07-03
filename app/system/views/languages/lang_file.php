<?php
$options = $field->options;
?>
<div class="table-responsive">
    <table class="table table-striped table-border table-no-spacing">
        <thead>
        <tr>
            <th class="text-right" width="20%"><?= lang('system::lang.languages.column_variable'); ?></th>
            <th width="80%"><?= lang('system::lang.languages.column_language'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($options)) { ?>
            <?php foreach ($options as $key => $value) { ?>
                <tr>
                    <td class="text-right"><span class="text-muted"><?= $key; ?></span></td>
                    <td>
                        <textarea
                            class="form-control"
                            rows="1"
                            name="<?= $field->getName(); ?>[<?= $key; ?>]"
                        ><?= e($value); ?></textarea>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
</div>
