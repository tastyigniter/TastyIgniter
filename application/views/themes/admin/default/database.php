<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#backup" data-toggle="tab">Backup</a></li>
				<li><a href="#restore" data-toggle="tab">Restore</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo site_url(ADMIN_URI.'/database'); ?>" enctype="multipart/form-data" id="database">
			<div class="tab-content">
				<div id="backup" class="tab-pane row wrap-all active">
					<div class="table-responsive">
						<table class="table table-striped table-border">
							<thead>
								<tr>
									<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'backup\']').prop('checked', this.checked);"></th>
									<th>Select tables to backup</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($db_tables as $key => $value) { ?>
								<tr>
									<td><input type="checkbox" name="backup[]" id="input-table-<?php echo $key; ?>" value="<?php echo $value; ?>" <?php echo set_checkbox('backup[]', $value); ?> /></td>
									<td><i><?php echo $value; ?></i></td>
									<td></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
				
				<div id="restore" class="tab-pane row wrap-all">
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
		</form>
	</div>
</div>
<?php echo $footer; ?>