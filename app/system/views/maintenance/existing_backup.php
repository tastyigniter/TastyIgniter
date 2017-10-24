<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th class="text-center"></th>
            <th><?= lang('system::maintenance.column_name'); ?></th>
            <th><?= lang('system::maintenance.column_size'); ?></th>
            <th><?= lang('system::maintenance.column_date'); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if ($existingBackups) { ?>
            <?php foreach ($existingBackups as $backupFile) { ?>
                <tr>
                    <td class="list-action text-center">
                        <button
                            class="btn btn-success"
                            title="<?= lang('system::maintenance.column_download'); ?>"
                            data-request="onDownloadBackup"
                            data-request-data="file: '<?= e($backupFile['filename']); ?>'"
                        >
                            <i class="fa fa-download"></i>
                        </button>
                    </td>
                    <td class="list-action text-center">
                        <button
                            class="btn btn-primary"
                            title="<?= lang('system::maintenance.column_restore'); ?>"
                            data-request="onRestoreBackup"
                            data-request-data="file: '<?= e($backupFile['filename']); ?>'"
                        >
                            <i class="fa fa-history"></i>
                        </button>
                    </td>
                    <td class="list-action text-center">
                        <button
                            class="btn btn-danger"
                            title="<?= lang('system::maintenance.column_delete'); ?>"
                            data-request="onDeleteBackup"
                            data-request-confirm="<?= lang('lang:admin::default.alert_warning_confirm'); ?>"
                            data-request-data="file: '<?= e($backupFile['filename']); ?>'"
                        >
                            <i class="fa fa-times-circle"></i>
                        </button>
                    </td>
                    <td><?= $backupFile['filename']; ?></td>
                    <td><?= number_format($backupFile['size'], 1).'MB'; ?></td>
                    <td><?= time_elapsed(mdate('%d-%m-%Y %H:%i:%s', $backupFile['time'])); ?></td>
                </tr>
            <?php } ?>
        <?php }
        else { ?>
            <tr>
                <td colspan="5"><?= lang('system::maintenance.text_no_backup'); ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>