<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab">Details</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
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
						<label for="input-order-total" class="col-sm-3 control-label">Minimum Total:</label>
						<div class="col-sm-5">
							<input type="text" name="order_total" id="input-order-total" class="form-control" value="<?php echo $order_total; ?>" />
							<?php echo form_error('order_total', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-status" class="col-sm-3 control-label">Order Status:
							<span class="help-block">Default order status when cod is the payment method</span>
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