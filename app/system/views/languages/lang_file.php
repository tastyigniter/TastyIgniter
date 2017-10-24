<?php
$options = $field->options;
?>
<div class="table-responsive">
    <table class="table table-striped table-border table-no-spacing">
        <thead>
        <tr>
            <th class="text-right" width="30%"><?= lang('column_variable'); ?></th>
            <th width="70%"><?= lang('column_language'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($options)) { ?>
            <?php foreach ($options as $key => $value) { ?>
                <tr>
                    <td class="text-right"><span class="text-muted"><?= $key; ?></span></td>
                    <td>
                        <input
                            class="form-control"
                            name="<?= $field->getName(); ?>[<?= $key; ?>]"
                            value="<?= e($value); ?>">
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
</div>
