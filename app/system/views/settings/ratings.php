<div id="ratings-field">
    <table class="table table-sortable">
        <thead>
        <tr>
            <th class="list-action"></th>
            <th class="list-action"></th>
            <th><?= lang('admin::lang.label_name'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php $table_row = 1; ?>
        <?php foreach ((array)$formValue as $key => $value) { ?>
            <tr id="table-row<?= $table_row; ?>">
                <td class="list-action text-center handle"><i class="fa fa-bars"></i></td>
                <td class="list-action handle">
                    <a
                        class="btn btn-outline-danger border-none"
                        role="button"
                        onclick="confirm('<?= lang('admin::lang.alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false"
                    ><i class="fa fa-trash-alt"></i></a>
                </td>
                <td>
                    <input type="text"
                           name="<?= $field->getName(); ?>[<?= $table_row; ?>]"
                           class="form-control"
                           value="<?= set_value('ratings['.$table_row.']', $value); ?>"/>
                    <?= form_error('ratings['.$table_row.']', '<span class="text-danger">', '</span>'); ?>
                </td>
            </tr>
            <?php $table_row++; ?>
        <?php } ?>
        </tbody>
        <tfoot>
        <tr id="tfoot">
            <td class="list-action text-center">
                <a
                    class="btn btn-primary btn-lg"
                    role="button"
                    data-control="ratings"
                    data-table-row="<?= $table_row; ?>"
                    data-confirm-message="<?= lang('admin::lang.alert_warning_confirm'); ?>"
                ><i class="fa fa-plus"></i></a>
            </td>
            <td></td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>