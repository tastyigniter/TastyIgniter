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
				<li class="active"><a href="#staff-group" data-toggle="tab">Staff Group</a></li>
				<li><a href="#permission-level" data-toggle="tab">Permission Levels</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="staff-group" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="staff_group_name" id="input-name" class="form-control" value="<?php echo set_value('staff_group_name', $staff_group_name); ?>" />
							<?php echo form_error('staff_group_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-location" class="col-sm-2 control-label">Location Access:</label>
						<div class="col-sm-5">
							<select name="location_access" id="input-location" class="form-control">
								<option value="0" <?php echo set_select('location_access', '0'); ?> >All Locations</option>
								<?php if ($location_access === '1') { ?>
									<option value="1" <?php echo set_select('location_access', '1', TRUE); ?> >Staff Location</option>
								<?php } else { ?>  
									<option value="1" <?php echo set_select('location_access', '1'); ?> >Staff Location</option>
								<?php } ?>  
							</select>
							<?php echo form_error('location_access', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="permission-level" class="tab-pane row wrap-all">
					<table class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action action-one">Access</th>
								<th class="action action-one">Modify</th>
								<th></th>
								<th></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'permission[access]\']').prop('checked', this.checked);"></th>
								<th class="action action-one"><input type="checkbox" onclick="$('input[name*=\'permission[modify]\']').prop('checked', this.checked);"></th>
								<th>Select/Unselect All</th>
								<th></th>
								<th></th>
							</tr>
							<?php foreach ($paths as $path) { ?>
							<tr>
								<?php if (in_array($path['name'], $access)) { ?>
									<td class="action action-one"><input type="checkbox" name="permission[access][]" value="<?php echo $path['name']; ?>" checked="checked" /></td>
								<?php } else { ?>
									<td class="action action-one"><input type="checkbox" name="permission[access][]" value="<?php echo $path['name']; ?>" /></td>
								<?php } ?>

								<?php if (in_array($path['name'], $modify)) { ?>
									<td class="action action-one"><input type="checkbox" name="permission[modify][]" value="<?php echo $path['name']; ?>" checked="checked" /></td>
								<?php } else { ?>
									<td class="action action-one"><input type="checkbox" name="permission[modify][]" value="<?php echo $path['name']; ?>" /></td>
								<?php } ?>
								<td><?php echo $path['name']; ?></td>
								<td><?php echo $path['description']; ?></td>
								<td></td>
							</tr>
							<?php } ?>
							<tr>
								<th class="action action-one"></th>
								<th class="action action-one"></th>
								<th>Extension: Modules</th>
								<th></th>
								<th></th>
							</tr>
							<?php foreach ($module_paths as $path) { ?>
							<tr>
								<?php if (in_array($path['name'], $access)) { ?>
									<td class="action action-one"><input type="checkbox" name="permission[access][]" value="<?php echo $path['name']; ?>" checked="checked" /></td>
								<?php } else { ?>
									<td class="action action-one"><input type="checkbox" name="permission[access][]" value="<?php echo $path['name']; ?>" /></td>
								<?php } ?>

								<?php if (in_array($path['name'], $modify)) { ?>
									<td class="action action-one"><input type="checkbox" name="permission[modify][]" value="<?php echo $path['name']; ?>" checked="checked" /></td>
								<?php } else { ?>
									<td class="action action-one"><input type="checkbox" name="permission[modify][]" value="<?php echo $path['name']; ?>" /></td>
								<?php } ?>
								<td><?php echo $path['name']; ?></td>
								<td><?php echo $path['description']; ?></td>
								<td></td>
							</tr>
							<?php } ?>
							<tr>
								<th class="action action-one"></th>
								<th class="action action-one"></th>
								<th>Extension: Payments</th>
								<th></th>
								<th></th>
							</tr>
							<?php foreach ($payment_paths as $path) { ?>
							<tr>
								<?php if (in_array($path['name'], $access)) { ?>
									<td class="action action-one"><input type="checkbox" name="permission[access][]" value="<?php echo $path['name']; ?>" checked="checked" /></td>
								<?php } else { ?>
									<td class="action action-one"><input type="checkbox" name="permission[access][]" value="<?php echo $path['name']; ?>" /></td>
								<?php } ?>

								<?php if (in_array($path['name'], $modify)) { ?>
									<td class="action action-one"><input type="checkbox" name="permission[modify][]" value="<?php echo $path['name']; ?>" checked="checked" /></td>
								<?php } else { ?>
									<td class="action action-one"><input type="checkbox" name="permission[modify][]" value="<?php echo $path['name']; ?>" /></td>
								<?php } ?>
								<td><?php echo $path['name']; ?></td>
								<td><?php echo $path['description']; ?></td>
								<td></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>