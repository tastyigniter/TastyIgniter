<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#backup" data-toggle="tab">Backup</a></li>
                <li><a href="#restore" data-toggle="tab">Restore</a></li>
                <li><a href="#download-backup" data-toggle="tab">Download Backup</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo site_url('database'); ?>" enctype="multipart/form-data" id="database">
			<div class="tab-content">
				<div id="backup" class="tab-pane row wrap-all active">
					<div class="panel panel-default panel-table">
						<div class="table-responsive">
							<table class="table table-striped table-border">
								<thead>
									<tr>
										<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'backup\']').prop('checked', this.checked);"></th>
										<th>Select tables to backup</th>
										<th># Records</th>
										<th>Data Size</th>
										<th>Index Size</th>
										<th>Data Free</th>
										<th>Engine</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($db_tables as $key => $db_table) { ?>
									<tr>
										<td><input type="checkbox" name="backup[]" id="input-table-<?php echo $key; ?>" value="<?php echo $db_table['name']; ?>" <?php echo set_checkbox('backup[]', $db_table['name']); ?> /></td>
										<td><i><?php echo $db_table['name']; ?></i></td>
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
					</div>
				</div>

				<div id="restore" class="tab-pane row wrap-all">
                    <div class="table-responsive">
                        <table class="table table-striped table-border">
                            <thead>
                                <tr>
                                    <th>Upload SQL restore file.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="file" name="restore" value="" id="" /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
				</div>

                <div id="download-backup" class="tab-pane row wrap-all">
                    <ul class="list-group">
                        <?php if ($backup_files) { ?>
                            <?php foreach ($backup_files as $backup_file) { ?>
                                <li class="list-group-item">
                                    <a href="<?php echo $backup_file['download']; ?>"><i class="fa fa-download"></i>&nbsp;&nbsp;<?php echo $backup_file['filename']; ?></a>
                                    <a href="<?php echo $backup_file['delete']; ?>" class="btn btn-danger pull-right"><i class="fa fa-times-circle"></i></a>
                                </li>
                            <?php } ?>
                        <?php } else { ?>
                            <li class="list-group-item">No database backup available.</li>
                        <?php } ?>
                    </ul>
                </div>
			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>