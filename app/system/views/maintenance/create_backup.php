<div id="backup-details">
    <div class="form-group">
        <label for="input-drop-table" class="control-label"><?= lang('system::maintenance.text_drop_tables'); ?></label>
        <input
            type="checkbox"
            id="input-drop-tables"
            name="drop_tables"
            data-toggle="toggle"
            data-onstyle="success" data-offstyle="danger"
            data-on="<?= e(lang('admin::default.text_enabled')) ?>"
            data-off="<?= e(lang('lang:admin::default.text_disabled')) ?>"
            value="1"
            <?= set_radio('drop_tables', '1', TRUE); ?>
        />
        <?= form_error('drop_tables', '<span class="text-danger">', '</span>'); ?>
    </div>
    <div class="form-group">
        <label for="input-drop-table" class="control-label"><?= lang('system::maintenance.text_add_inserts'); ?></label>
        <input
            type="checkbox"
            id="input-add-inserts"
            name="add_inserts"
            data-toggle="toggle"
            data-onstyle="success" data-offstyle="danger"
            data-on="<?= e(lang('admin::default.text_enabled')) ?>"
            data-off="<?= e(lang('lang:admin::default.text_disabled')) ?>"
            value="1"
            <?= set_radio('add_inserts', '1', TRUE); ?>
        />
        <?= form_error('add_inserts', '<span class="text-danger">', '</span>'); ?>
    </div>
    <div class="form-group">
        <label for="input-backup-tables"
               class="control-label"><?= lang('system::maintenance.label_backup_table'); ?></label>
        <span class="help-block"><?= lang('system::maintenance.help_select_table') ?></span>
        <select name="backup_tables[]" id="input-backup-tables" class="form-control" multiple="multiple">
            <?php foreach ($dbTables as $name => $table) { ?>
                <option value="<?= $name; ?>"><?= $table; ?></option>
            <?php } ?>
        </select>
        <?= form_error('backup_tables[]', '<span class="text-danger">', '</span>'); ?>
    </div>

    <div class="form-group">
        <button
            class="btn btn-primary"
            data-request="onBackupDatabase">
            <?= lang('system::maintenance.button_backup'); ?>
        </button>
    </div>
</div>
