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
						<label for="input-api-login-id" class="col-sm-3 control-label"><?php echo lang('label_api_login_id'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="api_login_id" id="input-api-login-id" class="form-control" value="<?php echo set_value('api_login_id', $api_login_id); ?>" />
							<?php echo form_error('api_login_id', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-transaction-key" class="col-sm-3 control-label"><?php echo lang('label_transaction_key'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="transaction_key" id="input-transaction-key" class="form-control" value="<?php echo set_value('transaction_key', $transaction_key); ?>" />
							<?php echo form_error('transaction_key', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-transaction-mode" class="col-sm-3 control-label"><?php echo lang('label_transaction_mode'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-3 btn-group-toggle" data-toggle="buttons">
								<?php if ($transaction_mode === 'test_live') { ?>
									<label class="btn btn-success"><input type="radio" name="transaction_mode" value="live" <?php echo set_radio('transaction_mode', 'live'); ?>><?php echo lang('text_go_live'); ?></label>
									<label class="btn btn-danger"><input type="radio" name="transaction_mode" value="test" <?php echo set_radio('transaction_mode', 'test'); ?>><?php echo lang('text_test'); ?></label>
									<label class="btn btn-danger active"><input type="radio" name="transaction_mode" value="test_live" <?php echo set_radio('transaction_mode', 'test_live', TRUE); ?>><?php echo lang('text_test_live'); ?></label>
								<?php } else if ($transaction_mode === 'test') { ?>
									<label class="btn btn-success"><input type="radio" name="transaction_mode" value="live" <?php echo set_radio('transaction_mode', 'live'); ?>><?php echo lang('text_go_live'); ?></label>
									<label class="btn btn-danger active"><input type="radio" name="transaction_mode" value="test" <?php echo set_radio('transaction_mode', 'test', TRUE); ?>><?php echo lang('text_test'); ?></label>
									<label class="btn btn-danger"><input type="radio" name="transaction_mode" value="test_live" <?php echo set_radio('transaction_mode', 'test_live'); ?>><?php echo lang('text_test_live'); ?></label>
								<?php } else { ?>
									<label class="btn btn-success active"><input type="radio" name="transaction_mode" value="live" <?php echo set_radio('api_mode', 'live', TRUE); ?>><?php echo lang('text_go_live'); ?></label>
									<label class="btn btn-danger"><input type="radio" name="transaction_mode" value="test" <?php echo set_radio('transaction_mode', 'test'); ?>><?php echo lang('text_test'); ?></label>
									<label class="btn btn-danger"><input type="radio" name="transaction_mode" value="test_live" <?php echo set_radio('transaction_mode', 'test_live'); ?>><?php echo lang('text_test_live'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('transaction_mode', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-api-action" class="col-sm-3 control-label"><?php echo lang('label_transaction_type'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($transaction_type === 'auth_only') { ?>
									<label class="btn btn-success"><input type="radio" name="transaction_type" value="auth_capture" <?php echo set_radio('transaction_type', 'auth_capture'); ?>><?php echo lang('text_auth_capture'); ?></label>
									<label class="btn btn-success active"><input type="radio" name="transaction_type" value="auth_only" <?php echo set_radio('transaction_type', 'auth_only', TRUE); ?>><?php echo lang('text_auth_only'); ?></label>
								<?php } else { ?>
									<label class="btn btn-success active"><input type="radio" name="transaction_type" value="auth_capture" <?php echo set_radio('transaction_type', 'auth_capture', TRUE); ?>><?php echo lang('text_auth_capture'); ?></label>
									<label class="btn btn-success"><input type="radio" name="transaction_type" value="auth_only" <?php echo set_radio('transaction_type', 'auth_only'); ?>><?php echo lang('text_auth_only'); ?></label>
								<?php } ?>
							</div>
							<?php echo form_error('transaction_type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-accepted-cards" class="col-sm-3 control-label"><?php echo lang('label_accepted_cards'); ?></label>
						<div class="col-sm-5">
							<select name="accepted_cards[]" id="input-accepted-cards" class="form-control" multiple>
								<?php foreach ($list_accepted_cards as $key => $value) { ?>
									<?php if (in_array($key, $accepted_cards)) { ?>
										<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
									<?php } else { ?>
										<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('accepted_cards', '<span class="text-danger">', '</span>'); ?>
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