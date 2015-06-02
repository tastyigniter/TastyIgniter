<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#permission-details" data-toggle="tab">Permission Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="permission-details" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label">Name:
                            <span class="help-block">Permissions name are made up of 2 parts:<br />
                                Domain  - Typically the application domain name (e.g. Admin, Main, Module).<br />
                                Context - The controller class name (e.g. Menus, Orders, Locations, or Settings).
                            </span>
                        </label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
                    <div class="form-group">
                        <label for="input-navigation" class="col-sm-3 control-label">Action:
                            <span class="help-block">The permitted action (Access, Manage, Add, Delete)</span>
                        </label>
                        <div class="col-sm-5">
                            <div class="btn-group btn-group-toggle btn-group-4" data-toggle="buttons">
                                <?php foreach ($permission_actions as $key => $value) { ?>
                                    <?php if (in_array($key, $action)) { ?>
                                        <label class="btn btn-default active"><input type="checkbox" name="action[]" value="<?php echo $key; ?>" checked="checked"><?php echo $value; ?></label>
                                    <?php } else { ?>
                                        <label class="btn btn-default"><input type="checkbox" name="action[]" value="<?php echo $key; ?>"><?php echo $value; ?></label>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <?php echo form_error('action[]', '<span class="text-danger">', '</span>'); ?>
                        </div>
                    </div>
                    <div class="form-group">
						<label for="input-description" class="col-sm-3 control-label">Description:</label>
						<div class="col-sm-5">
							<textarea name="description" id="input-description" class="form-control" rows="2"><?php echo set_value('description', $description); ?></textarea>
							<?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label">Status:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($status == '1') { ?>
									<label class="btn btn-default" data-btn="btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>>Disabled</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>>Enabled</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0', TRUE); ?>>Disabled</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1'); ?>>Enabled</label>
								<?php } ?>
							</div>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo get_footer(); ?>