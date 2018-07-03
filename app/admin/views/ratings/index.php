<div class="row-fluid">

    <?= $this->widgets['toolbar']->render(); ?>

    <div class="panel panel-light panel-table">
        <?= form_open(current_url(),
            [
                'id'     => 'edit-form',
                'role'   => 'form',
                'method' => 'PATCH',
            ]
        ); ?>

        <table class="table table-striped table-border table-sortable">
            <thead>
            <tr>
                <th class="list-action"></th>
                <th class="list-action"></th>
                <th><?= lang('admin::lang.ratings.column_name'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $table_row = 1; ?>
            <?php foreach ($ratings as $key => $value) { ?>
                <tr id="table-row<?= $table_row; ?>">
                    <td class="list-action text-center handle"><i class="fa fa-bars"></i></td>
                    <td class="list-action handle">
                        <a
                            class="btn btn-outline-danger"
                            role="button"
                            onclick="confirm('<?= lang('admin::lang.alert_warning_confirm'); ?>') ? $(this).parent().parent().remove() : false"><i
                                class="fa fa-times-circle"
                            ></i></a>
                    </td>
                    <td>
                        <input type="text"
                               name="ratings[<?= $table_row; ?>]"
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
                    <a class="btn btn-primary btn-lg" role="button" onclick="addRating()"><i class="fa fa-plus"></i></a>
                </td>
                <td></td>
                <td></td>
            </tr>
            </tfoot>
        </table>
        <?= form_close(); ?>
    </div>
</div>
<script type="text/javascript"><!--
    var table_row = <?= $table_row; ?>

        function addRating() {
            html = '<tr id="table-row' + table_row + '">'
            html += '	<td class="list-action text-center handle"><i class="fa fa-bars"></i></td>'
            html += '	<td class="list-action handle"><a role="button" class="btn btn-outline-danger" onclick="confirm(\'<?= lang('admin::lang.alert_warning_confirm'); ?>\') ? $(this).parent().parent().remove() : false;"><i class="fa fa-times-circle"></i></a></td>'
            html += '	<td><input type="text" name="ratings[' + table_row + ']" class="form-control" value="<?= set_value("ratings[' + table_row + ']"); ?>" /></td>'
            html += '</tr>'

            $('.table-sortable tbody').append(html)

            table_row++
        }
    //--></script>
<script type="text/javascript"><!--
    $(function () {
        $('.table-sortable').sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            placeholder: '<tr class="placeholder"><td colspan="2"></td></tr>',
            handle: '.handle'
        })
    })
    //--></script>
