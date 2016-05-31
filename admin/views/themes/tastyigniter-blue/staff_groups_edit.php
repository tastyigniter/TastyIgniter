<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#staff-group" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#permission-level" data-toggle="tab"><?php echo lang('text_tab_permission'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="staff-group" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="staff_group_name" id="input-name" class="form-control" value="<?php echo set_value('staff_group_name', $staff_group_name); ?>" />
							<?php echo form_error('staff_group_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-customer-account-access" class="col-sm-3 control-label"><?php echo lang('label_customer_account_access'); ?>
							<span class="help-block"><?php echo lang('help_customer_account_access'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($customer_account_access == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="customer_account_access" value="0" <?php echo set_radio('customer_account_access', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="customer_account_access" value="1" <?php echo set_radio('customer_account_access', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="customer_account_access" value="0" <?php echo set_radio('customer_account_access', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="customer_account_access" value="1" <?php echo set_radio('customer_account_access', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('customer_account_access', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-location" class="col-sm-3 control-label"><?php echo lang('label_location_access'); ?>
							<span class="help-block"><?php echo lang('help_location'); ?></span>
						</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($location_access == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="location_access" value="0" <?php echo set_radio('location_access', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="location_access" value="1" <?php echo set_radio('location_access', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="location_access" value="0" <?php echo set_radio('location_access', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="location_access" value="1" <?php echo set_radio('location_access', '1'); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } ?>
							</div>
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
                                            <th class="action text-center"><a class="clickable" onclick="var $checkbox = $('input[value*=\'access\']');$checkbox.prop('checked', !$checkbox[0].checked);"><?php echo lang('column_access'); ?></a></th>
                                            <th class="action text-center success"><a class="clickable" onclick="var $checkbox = $('input[value*=\'manage\']');$checkbox.prop('checked', !$checkbox[0].checked);"><?php echo lang('column_manage'); ?></a></th>
                                            <th class="action text-center info"><a class="clickable" onclick="var $checkbox = $('input[value*=\'add\']');$checkbox.prop('checked', !$checkbox[0].checked);"><?php echo lang('column_add'); ?></a></th>
                                            <th class="action text-center danger"><a class="clickable" onclick="var $checkbox = $('input[value*=\'delete\']');$checkbox.prop('checked', !$checkbox[0].checked);"><?php echo lang('column_delete'); ?></a></th>
                                            <th><?php echo lang('column_description'); ?></th>
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
                                                    <td class="action text-center success"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="manage" checked="checked" /></td>
                                                <?php } else { ?>
                                                    <td class="action text-center success"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="manage" /></td>
                                                <?php } ?>
                                                <?php if (!in_array('add', $permission['action'])) { ?>
                                                    <td class="action text-center"><span class="small text-muted">--</span></td>
                                                <?php } else if (in_array('add', $permission['group_permissions'])) { ?>
                                                    <td class="action text-center info"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="add" checked="checked" /></td>
                                                <?php } else { ?>
                                                    <td class="action text-center info"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="add" /></td>
                                                <?php } ?>
                                                <?php if (!in_array('delete', $permission['action'])) { ?>
                                                <td class="action text-center"><span class="small text-muted">--</span></td>
                                                <?php } else if (in_array('delete', $permission['group_permissions'])) { ?>
                                                    <td class="action text-center danger"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="delete" checked="checked" /></td>
                                                <?php } else { ?>
                                                    <td class="action text-center danger"><input type="checkbox" name="permissions[<?php echo $permission['permission_id']; ?>][]" value="delete" /></td>
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