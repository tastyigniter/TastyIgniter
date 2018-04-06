<div class="row-fluid">

    <?php if ($layoutChanges) { ?>

        <?= form_open(current_url(),
            [
                'id'   => 'edit-form',
                'role' => 'form',
                'method' => 'PATCH'
            ]
        ); ?>

        <div class="toolbar">
            <div class="toolbar-action">
                <button type="submit"
                        class="btn btn-primary"
                        data-request="onApplyChanges"><?= lang('button_save'); ?></button>
                <a class="btn btn-default"
                   href="<?= admin_url('mail_layouts/edit/'.$layoutModel->template_id); ?>"><?= lang('button_icon_back'); ?></a>
            </div>
        </div>

        <div class="panel panel-default panel-table">
            <?php foreach ($layoutChanges as $key => $templates) { ?>
                <?php if (count($templates)) { ?>
                    <div class="panel-heading">
                        <h4><?= lang("text_{$key}_changes"); ?></h4>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th><?= lang('column_title'); ?></th>
                                <th><?= lang('column_date_added'); ?></th>
                                <th><?= lang('column_date_updated'); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($templates as $template) { ?>
                                <tr>
                                    <td>
                                        <div class="checkbox checkbox-primary pull-left">
                                            <input
                                                type="checkbox"
                                                class="styled"
                                                id="checkbox-<?= $template['template_data_id']; ?>"
                                                value="<?= $template['template_data_id']; ?>"
                                                name="changes[<?= $key ?>][template_data_id]"/>
                                            <label for="checkbox-<?= $template['template_data_id']; ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <b><?= $template['code']; ?></b> - <?= $template['title']; ?>
                                    </td>
                                    <td><?= $template['date_updated']; ?></td>
                                    <td><?= $template['date_added']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>

        <?= form_close(); ?>

    <?php } ?>
</div>
