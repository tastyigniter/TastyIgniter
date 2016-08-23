<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-title" class="col-sm-3 control-label"><?php echo lang('label_title'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-user" class="col-sm-3 control-label"><?php echo lang('label_api_user'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="api_user" id="input-api-user" class="form-control" value="<?php echo set_value('api_user', $api_user); ?>" />
							<?php echo form_error('api_user', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-pass" class="col-sm-3 control-label"><?php echo lang('label_api_pass'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="api_pass" id="input-api-pass" class="form-control" value="<?php echo set_value('api_pass', $api_pass); ?>" />
							<?php echo form_error('api_pass', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-signature" class="col-sm-3 control-label"><?php echo lang('label_api_signature'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="api_signature" id="input-api-signature" class="form-control" value="<?php echo set_value('api_signature', $api_signature); ?>" />
							<?php echo form_error('api_signature', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-mode" class="col-sm-3 control-label"><?php echo lang('label_api_mode'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($api_mode === 'live') { ?>
									<label class="btn btn-warning"><input type="radio" name="api_mode" value="sandbox" <?php echo set_radio('api_mode', 'sandbox'); ?>><?php echo lang('text_sandbox'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="api_mode" value="live" <?php echo set_radio('api_mode', 'live', TRUE); ?>><?php echo lang('text_go_live'); ?></label>
								<?php } else { ?>
									<label class="btn btn-warning active"><input type="radio" name="api_mode" value="sandbox" <?php echo set_radio('api_mode', 'sandbox', TRUE); ?>><?php echo lang('text_sandbox'); ?></label>
									<label class="btn btn-success"><input type="radio" name="api_mode" value="live" <?php echo set_radio('api_mode', 'live'); ?>><?php echo lang('text_go_live'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('api_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-action" class="col-sm-3 control-label"><?php echo lang('label_api_action'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($api_action === 'authorization') { ?>
									<label class="btn btn-default"><input type="radio" name="api_action" value="sale" <?php echo set_radio('api_action', 'sale'); ?>><?php echo lang('text_sale'); ?></label>
									<label class="btn btn-default active"><input type="radio" name="api_action" value="authorization" <?php echo set_radio('api_action', 'authorization', TRUE); ?>><?php echo lang('text_authorization'); ?></label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="api_action" value="sale" <?php echo set_radio('api_action', 'sale', TRUE); ?>><?php echo lang('text_sale'); ?></label>
									<label class="btn btn-default"><input type="radio" name="api_action" value="authorization" <?php echo set_radio('api_action', 'authorization'); ?>><?php echo lang('text_authorization'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('api_action', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-total" class="col-sm-3 control-label"><?php echo lang('label_order_total'); ?>
							<span class="help-block"><?php echo lang('help_order_total'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="order_total" id="input-order-total" class="form-control" value="<?php echo set_value('order_total', $order_total); ?>" />
							<?php echo form_error('order_total', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-status" class="col-sm-3 control-label"><?php echo lang('label_order_status'); ?>
							<span class="help-block"><?php echo lang('help_order_status'); ?></span>
						</label>
						<div class="col-sm-5">
							<select name="order_status" id="input-order-status" class="form-control">
								<?php foreach ($statuses as $stat) { ?>
								<?php if ($stat['status_id'] === $order_status) { ?>
									<option value="<?php echo $stat['status_id']; ?>" selected="selected"><?php echo $stat['status_name']; ?></option>
								<?php } else { ?>
									<option value="<?php echo $stat['status_id']; ?>"><?php echo $stat['status_name']; ?></option>
								<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('order_status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-priority" class="col-sm-3 control-label"><?php echo lang('label_priority'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="priority" id="input-priority" class="form-control" value="<?php echo $priority; ?>" />
							<?php echo form_error('priority', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-3 control-label"><?php echo lang('label_status'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($status == '1') { ?>
									<label class="btn btn-danger"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0'); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1', TRUE); ?>><?php echo lang('text_enabled'); ?></label>
								<?php } else { ?>
									<label class="btn btn-danger active"><input type="radio" name="status" value="0" <?php echo set_radio('status', '0', TRUE); ?>><?php echo lang('text_disabled'); ?></label>
									<label class="btn btn-success"><input type="radio" name="status" value="1" <?php echo set_radio('status', '1'); ?>><?php echo lang('text_enabled'); ?></label>
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