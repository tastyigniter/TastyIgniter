<?php if ($field->value) { ?>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th class="list-action"></th>
                <th>
                    <b><?= lang('system::mail_templates.column_code'); ?></b> - <?= lang('system::mail_templates.column_title'); ?>
                </th>
                <th class="text-right"><?= lang('system::mail_templates.column_date_updated'); ?></th>
                <th class="text-right"><?= lang('system::mail_templates.column_date_added'); ?></th>
            </tr>
            </thead>
            <tbody>
            <?php $index = 0;
            foreach ($field->value as $template) { ?>
                <?php $index++; ?>
                <tr>
                    <td class="list-action">
                        <a class="btn btn-edit"
                           href="<?= admin_url('mail_templates/edit/'.$template->template_data_id); ?>">
                            <i class="fa fa-pencil"></i>
                        </a>
                    </td>
                    <td><b><?= $template->code; ?></b> - <?= $template->title; ?></td>
                    <td class="text-right"><?= $template->date_updated; ?></td>
                    <td class="text-right"><?= $template->date_added; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<?php } ?>
