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
				<li class="active"><a href="#customer-group" data-toggle="tab">Customer Group Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="customer-group" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Name:</label>
						<div class="col-sm-5">
							<input type="text" name="group_name" id="input-name" class="form-control" value="<?php echo set_value('group_name', $group_name); ?>" />
							<?php echo form_error('group_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-approval" class="col-sm-2 control-label">Approval:
							<span class="help-block">New customers must be approved before they can login.</span>
						</label>
						<div class="col-sm-5">
							<select name="approval" id="input-approval" class="form-control">
								<option value="0" <?php echo set_select('approval', '0'); ?> >Disabled</option>
								<?php if ($approval === '1') { ?>
									<option value="1" <?php echo set_select('approval', '1', TRUE); ?> >Enabled</option>
								<?php } else { ?>  
									<option value="1" <?php echo set_select('approval', '1'); ?> >Enabled</option>
								<?php } ?>  
							</select>
							<?php echo form_error('approval', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-description" class="col-sm-2 control-label">Description:</label>
						<div class="col-sm-5">
							<textarea name="description" id="input-description" class="form-control" rows="5"><?php echo set_value('description', $description); ?></textarea>
							<?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<?php echo $footer; ?>