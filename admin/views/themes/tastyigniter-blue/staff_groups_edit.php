<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#staff-group" data-toggle="tab">Staff Group</a></li>
				<li><a href="#permission-level" data-toggle="tab">Permission Levels</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="staff-group" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="staff_group_name" id="input-name" class="form-control" value="<?php echo set_value('staff_group_name', $staff_group_name); ?>" />
							<?php echo form_error('staff_group_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-location" class="col-sm-3 control-label">Location Access:</label>
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
					<div class="panel panel-default panel-table">
						<div class="table-responsive">
							<table class="table table-striped table-border">
                                <?php foreach ($permissions_list as $key => $permissions) { ?>
                                    <thead>
                                        <tr>
                                            <th><b><?php echo $key; ?></b></th>
                                            <th class="action text-center"><a class="clickable" onclick="var $checkbox = $('input[value*=\'access\']');$checkbox.prop('checked', !$checkbox[0].checked);">Access</a></th>
                                            <th class="action text-center"><a class="clickable" onclick="var $checkbox = $('input[value*=\'manage\']');$checkbox.prop('checked', !$checkbox[0].checked);">Manage</a></th>
                                            <th class="action text-center"><a class="clickable" onclick="var $checkbox = $('input[value*=\'add\']');$checkbox.prop('checked', !$checkbox[0].checked);">Add</a></th>
                                            <th class="action text-center"><a class="clickable" onclick="var $checkbox = $('input[value*=\'delete\']');$checkbox.prop('checked', !$checkbox[0].checked);">Delete</a></th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($permissions as $permission) { ?>
                                            <tr>
                                                <td><a class="clickable" onclick="var $checkbox = $(this).parent().parent().find(':checkbox');$checkbox.prop('checked', !$checkbox[0].checked);">
                                                        <?php echo $permission['name']; ?>
                                                    </a>
                                                </td>
                                                <?php if (!in_array('access', $permission['action'])) { ?>
                                                    <td class="action text-center"><span class="small text-muted">--</span></td>
                                                <?php } else if (in_array('access', $permission['group_permissions'])) { ?>
                                                    <td class="action text-center"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="access" checked="checked" /></td>
                                                <?php } else { ?>
                                                    <td class="action text-center"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="access" /></td>
                                                <?php } ?>
                                                <?php if (!in_array('manage', $permission['action'])) { ?>
                                                    <td class="action text-center"><span class="small text-muted">--</span></td>
                                                <?php } else if (in_array('manage', $permission['group_permissions'])) { ?>
                                                    <td class="action text-center"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="manage" checked="checked" /></td>
                                                <?php } else { ?>
                                                    <td class="action text-center"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="manage" /></td>
                                                <?php } ?>
                                                <?php if (!in_array('add', $permission['action'])) { ?>
                                                    <td class="action text-center"><span class="small text-muted">--</span></td>
                                                <?php } else if (in_array('add', $permission['group_permissions'])) { ?>
                                                    <td class="action text-center"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="add" checked="checked" /></td>
                                                <?php } else { ?>
                                                    <td class="action text-center"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="add" /></td>
                                                <?php } ?>
                                                <?php if (!in_array('delete', $permission['action'])) { ?>
                                                <td class="action text-center"><span class="small text-muted">--</span></td>
                                                <?php } else if (in_array('delete', $permission['group_permissions'])) { ?>
                                                    <td class="action text-center"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="delete" checked="checked" /></td>
                                                <?php } else { ?>
                                                    <td class="action text-center"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="delete" /></td>
                                                <?php } ?>
                                                <td><?php echo $permission['description']; ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                <?php } ?>
                            </table>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
    $(".checkbox-toggle").on("click", function () {});
});
//--></script>

<?php echo get_footer(); ?>