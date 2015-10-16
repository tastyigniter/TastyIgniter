<?php echo get_header(); ?>
<div class="row content">
<?php if (empty($backup_tables)) { ?>
    <div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#backup" data-toggle="tab"><?php echo lang('text_tab_backup'); ?></a></li>
                <li><a href="#existing-backup" data-toggle="tab"><?php echo lang('text_tab_existing_backup'); ?></a></li>
                <li><a href="#migrations" data-toggle="tab"><?php echo lang('text_tab_migrations'); ?></a></li>
			</ul>
		</div>

			<div class="tab-content">
				<div id="backup" class="tab-pane row wrap-all active">
					<div class="panel panel-default panel-table">
                        <form role="form" id="tables-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo site_url('maintenance'); ?>">
                            <div class="table-responsive">
                                <table class="table table-striped table-border table-no-spacing">
                                    <thead>
                                        <tr>
                                            <th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'tables\']').prop('checked', this.checked);"></th>
                                            <th><?php echo lang('column_select_tables'); ?></th>
                                            <th><?php echo lang('column_records'); ?></th>
                                            <th><?php echo lang('column_data_size'); ?></th>
                                            <th><?php echo lang('column_index_size'); ?></th>
                                            <th><?php echo lang('column_data_free'); ?></th>
                                            <th><?php echo lang('column_engine'); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($db_tables as $key => $db_table) { ?>
                                        <tr>
                                            <td><input type="checkbox" name="tables[]" id="input-table-<?php echo $key; ?>" value="<?php echo $db_table['name']; ?>" <?php echo set_checkbox('tables[]', $db_table['name']); ?> /></td>
                                            <td><a href="<?php echo $db_table['browse']; ?>"><i><?php echo $db_table['name']; ?></i></a></td>
                                            <td><i><?php echo $db_table['records']; ?></i></td>
                                            <td><?php echo $db_table['data_length']; ?></td>
                                            <td><?php echo $db_table['index_length']; ?></td>
                                            <td><?php echo $db_table['data_free']; ?></td>
                                            <td><?php echo $db_table['engine']; ?></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
				</div>

                <div id="existing-backup" class="tab-pane row wrap-all">
                    <div class="table-responsive">
                        <table class="table table-striped table-border">
                            <thead>
                                <tr>
                                    <th><?php echo lang('column_name'); ?></th>
                                    <th class="text-center"><?php echo lang('column_download'); ?></th>
                                    <th class="text-center"><?php echo lang('column_restore'); ?></th>
                                    <th class="text-center"><?php echo lang('column_delete'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($backup_files) { ?>
                                    <?php foreach ($backup_files as $backup_file) { ?>
                                        <tr>
                                            <td><?php echo $backup_file['filename']; ?></td>
                                            <td class="text-center"><a class="btn btn-primary" href="<?php echo $backup_file['download']; ?>"><i class="fa fa-download"></i></a></td>
                                            <td class="text-center"><a class="btn btn-primary" href="<?php echo $backup_file['restore']; ?>"><i class="fa fa-history"></i></a></td>
                                            <td class="text-center"><a class="btn btn-danger" href="<?php echo $backup_file['delete']; ?>"><i class="fa fa-times-circle"></i></a></td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="4"><?php echo lang('text_no_backup'); ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="migrations" class="tab-pane row wrap-all">
                    <form role="form" id="migrate-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo site_url('maintenance'); ?>" id="backup-database">
                        <div class="alert alert-danger">
                            <p><?php echo lang('alert_warning_migration'); ?></p>
                        </div>
                        <div class="alert alert-info">
                            <p>
                                <?php echo lang('text_installed_version'); ?>: <b><?php echo $installed_version; ?></b> <br />
                                <?php echo lang('text_latest_version'); ?>: <b><?php echo $latest_version; ?></b> <br />
                            </p>
                        </div>
                        <div class="form-group">
                            <label for="input-migrate" class="col-sm-3 control-label"><?php echo lang('label_migrate_version'); ?></label>
                            <div class="col-sm-5">
                                <select name="migrate" id="input-migrate" class="form-control">
                                    <option value="" selected="selected"><?php echo lang('text_select_version'); ?></option>
                                    <?php foreach ($migration_files as $version => $migration_file) { ?>
                                        <option value="<?php echo $version; ?>"><?php echo $migration_file; ?></option>
                                    <?php } ?>
                                </select>
                                <?php echo form_error('migrate', '<span class="text-danger">', '</span>'); ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
	</div>
<?php } else { ?>
    <div class="col-md-12">
        <div class="row wrap-vertical">
            <ul id="nav-tabs" class="nav nav-tabs">
                <li class="active"><a href="#backup-details" data-toggle="tab"><?php echo lang('text_tab_create_backup'); ?></a></li>
            </ul>
        </div>

        <form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo site_url('maintenance/backup'); ?>">
            <div class="tab-content">
                <div id="backup-details" class="tab-pane row wrap-all active">
                    <div class="alert alert-info">
                        <?php echo lang('alert_info_memory_limit'); ?>
                    </div>
                    <div class="form-group">
                        <label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_file_name'); ?></label>
                        <div class="col-sm-5">
                            <input type="text" name="file_name" id="input-name" class="form-control" value="<?php echo set_value('file_name', $file_name); ?>" />
                            <?php echo form_error('file_name', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-drop-table" class="col-sm-3 control-label"><?php echo lang('text_drop_tables'); ?></label>
                        <div class="col-sm-5">
                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                <?php if ($drop_tables == '1') { ?>
                                    <label class="btn btn-success active"><input type="radio" name="drop_tables" value="1" <?php echo set_radio('drop_tables', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
                                    <label class="btn btn-danger"><input type="radio" name="drop_tables" value="0" <?php echo set_radio('drop_tables', '0'); ?>><?php echo lang('text_no'); ?></label>
                                <?php } else { ?>
                                    <label class="btn btn-success"><input type="radio" name="drop_tables" value="1" <?php echo set_radio('drop_tables', '1'); ?>><?php echo lang('text_yes'); ?></label>
                                    <label class="btn btn-danger active"><input type="radio" name="drop_tables" value="0" <?php echo set_radio('drop_tables', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
                                <?php } ?>
                            </div>
                            <?php echo form_error('drop_tables', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-drop-table" class="col-sm-3 control-label"><?php echo lang('text_add_inserts'); ?></label>
                        <div class="col-sm-5">
                            <div class="btn-group btn-group-switch" data-toggle="buttons">
                                <?php if ($add_inserts == '1') { ?>
                                    <label class="btn btn-success active"><input type="radio" name="add_inserts" value="1" <?php echo set_radio('add_inserts', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
                                    <label class="btn btn-danger"><input type="radio" name="add_inserts" value="0" <?php echo set_radio('add_inserts', '0'); ?>><?php echo lang('text_no'); ?></label>
                                <?php } else { ?>
                                    <label class="btn btn-success"><input type="radio" name="add_inserts" value="1" <?php echo set_radio('add_inserts', '1'); ?>><?php echo lang('text_yes'); ?></label>
                                    <label class="btn btn-danger active"><input type="radio" name="add_inserts" value="0" <?php echo set_radio('add_inserts', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
                                <?php } ?>
                            </div>
                            <?php echo form_error('add_inserts', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-drop-table" class="col-sm-3 control-label"><?php echo lang('label_compression'); ?>
                            <span class="help-block"><?php echo lang('help_compression'); ?></span>
                        </label>
                        <div class="col-sm-5">
                            <div class="btn-group btn-group-3 btn-group-toggle" data-toggle="buttons">
                                <?php if ($compression === 'none') { ?>
                                    <label class="btn btn-success active"><input type="radio" name="compression" value="none" <?php echo set_radio('compression', 'none', TRUE); ?>><?php echo lang('text_none'); ?></label>
                                    <label class="btn btn-success disabled"><input type="radio" name="compression" value="gzip" <?php echo set_radio('compression', 'gzip'); ?>><?php echo lang('text_gzip'); ?></label>
                                    <label class="btn btn-success disabled"><input type="radio" name="compression" value="zip" <?php echo set_radio('compression', 'zip'); ?>><?php echo lang('text_zip'); ?></label>
                                <?php } else if ($compression === 'gzip') { ?>
                                    <label class="btn btn-success active"><input type="radio" name="compression" value="none" <?php echo set_radio('compression', 'none'); ?>><?php echo lang('text_none'); ?></label>
                                    <label class="btn btn-success disabled"><input type="radio" name="compression" value="gzip" <?php echo set_radio('compression', 'gzip', TRUE); ?>><?php echo lang('text_gzip'); ?></label>
                                    <label class="btn btn-success disabled"><input type="radio" name="compression" value="zip" <?php echo set_radio('compression', 'zip'); ?>><?php echo lang('text_zip'); ?></label>
                                <?php } else if ($compression === 'zip') { ?>
                                    <label class="btn btn-success active"><input type="radio" name="compression" value="none" <?php echo set_radio('compression', 'none'); ?>><?php echo lang('text_none'); ?></label>
                                    <label class="btn btn-success disabled"><input type="radio" name="compression" value="gzip" <?php echo set_radio('compression', 'gzip', TRUE); ?>><?php echo lang('text_gzip'); ?></label>
                                    <label class="btn btn-success disabled"><input type="radio" name="compression" value="zip" <?php echo set_radio('compression', 'zip'); ?>><?php echo lang('text_zip'); ?></label>
                                <?php } else { ?>
                                    <label class="btn btn-success active"><input type="radio" name="compression" value="none" <?php echo set_radio('compression', 'none', TRUE); ?>><?php echo lang('text_none'); ?></label>
                                    <label class="btn btn-success disabled"><input type="radio" name="compression" value="gzip" <?php echo set_radio('compression', 'gzip'); ?>><?php echo lang('text_gzip'); ?></label>
                                    <label class="btn btn-success disabled"><input type="radio" name="compression" value="zip" <?php echo set_radio('compression', 'zip'); ?>><?php echo lang('text_zip'); ?></label>
                                <?php } ?>
                            </div>
                            <?php echo form_error('compression', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="input-backup-tables" class="col-sm-3 control-label"><?php echo lang('label_backup_table'); ?></label>
                        <div class="col-sm-5">
                            <select name="tables[]" id="input-backup-tables" class="form-control" multiple="multiple">
                                <?php foreach ($tables as $table) { ?>
                                    <option value="<?php echo $table; ?>" selected="selected"><?php echo $table; ?></option>
                                <?php } ?>
                            </select>
                            <?php echo form_error('tables[]', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php } ?>
</div>
<?php echo get_footer(); ?>