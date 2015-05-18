<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-title" class="col-sm-3 control-label">Title:</label>
						<div class="col-sm-5">
							<input type="text" name="title" id="input-title" class="form-control" value="<?php echo set_value('title', $title); ?>" />
							<?php echo form_error('title', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-user" class="col-sm-3 control-label">API Username:</label>
						<div class="col-sm-5">
							<input type="text" name="api_user" id="input-api-user" class="form-control" value="<?php echo set_value('api_user', $api_user); ?>" />
							<?php echo form_error('api_user', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-pass" class="col-sm-3 control-label">API Password:</label>
						<div class="col-sm-5">
							<input type="text" name="api_pass" id="input-api-pass" class="form-control" value="<?php echo set_value('api_pass', $api_pass); ?>" />
							<?php echo form_error('api_pass', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-signature" class="col-sm-3 control-label">API Signature:</label>
						<div class="col-sm-5">
							<input type="text" name="api_signature" id="input-api-signature" class="form-control" value="<?php echo set_value('api_signature', $api_signature); ?>" />
							<?php echo form_error('api_signature', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-mode" class="col-sm-3 control-label">Mode:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($api_mode === 'live') { ?>
									<label class="btn btn-default" data-btn="btn-warning"><input type="radio" name="api_mode" value="sandbox" <?php echo set_radio('api_mode', 'sandbox'); ?>>Sandbox</label>
									<label class="btn btn-default active" data-btn="btn-success"><input type="radio" name="api_mode" value="live" <?php echo set_radio('api_mode', 'live', TRUE); ?>>Go Live</label>
								<?php } else { ?>
									<label class="btn btn-default active" data-btn="btn-warning"><input type="radio" name="api_mode" value="sandbox" <?php echo set_radio('api_mode', 'sandbox', TRUE); ?>>Sandbox</label>
									<label class="btn btn-default" data-btn="btn-success"><input type="radio" name="api_mode" value="live" <?php echo set_radio('api_mode', 'live'); ?>>Go Live</label>
								<?php } ?>
							</div>
							<?php echo form_error('api_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-action" class="col-sm-3 control-label">Payment Action:</label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle" data-toggle="buttons">
								<?php if ($api_action === 'authorization') { ?>
									<label class="btn btn-default"><input type="radio" name="api_action" value="sale" <?php echo set_radio('api_action', 'sale'); ?>>SALE</label>
									<label class="btn btn-default active"><input type="radio" name="api_action" value="authorization" <?php echo set_radio('api_action', 'authorization', TRUE); ?>>AUTHORIZATION</label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="api_action" value="sale" <?php echo set_radio('api_action', 'sale', TRUE); ?>>SALE</label>
									<label class="btn btn-default"><input type="radio" name="api_action" value="authorization" <?php echo set_radio('api_action', 'authorization'); ?>>AUTHORIZATION</label>
								<?php } ?>
							</div>
							<?php echo form_error('api_action', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-total" class="col-sm-3 control-label">Order Total:</label>
						<div class="col-sm-5">
							<input type="text" name="order_total" id="input-order-total" class="form-control" value="<?php echo set_value('order_total', $order_total); ?>" />
							<?php echo form_error('order_total', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-status" class="col-sm-3 control-label">Order Status:
							<span class="help-block">Default order status when paypal is the payment method</span>
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
						<label for="input-return-url" class="col-sm-3 control-label">Return URI:</label>
						<div class="col-sm-5">
							<input type="text" name="return_uri" id="input-return-url" class="form-control" value="<?php echo set_value('return_uri', $return_uri); ?>" />
							<?php echo form_error('return_uri', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-cancel-url" class="col-sm-3 control-label">Cancel URI:</label>
						<div class="col-sm-5">
							<input type="text" name="cancel_uri" id="input-cancel-url" class="form-control" value="<?php echo set_value('cancel_uri', $cancel_uri); ?>" />
							<?php echo form_error('cancel_uri', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-priority" class="col-sm-3 control-label">Priority:</label>
						<div class="col-sm-5">
							<input type="text" name="priority" id="input-priority" class="form-control" value="<?php echo $priority; ?>" />
							<?php echo form_error('priority', '<span class="text-danger">', '</span>'); ?>
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