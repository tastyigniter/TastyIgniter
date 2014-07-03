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
				<li class="active"><a href="#general" data-toggle="tab">Coupon</a></li>
				<li><a href="#coupon-history" data-toggle="tab">History</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-2 control-label">Coupon Name:</label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-2 control-label">Code:</label>
						<div class="col-sm-5">
							<input type="text" name="code" id="input-code" class="form-control" value="<?php echo set_value('code', $code); ?>" />
							<?php echo form_error('code', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-type" class="col-sm-2 control-label">Type:
							<span class="help-block">Whether to subtract a fixed amount or percentage from order total.</span>
						</label>
						<div class="col-sm-5">
							<select name="type" id="input-type" class="form-control">
								<?php if ($type === 'F') { ?>
									<option value="F" <?php echo set_select('type', 'F', TRUE); ?> >Fixed Amount</option>
									<option value="P" <?php echo set_select('type', 'P'); ?> >Percentage</option>
								<?php } else if ($type === 'P') { ?>
									<option value="F" <?php echo set_select('type', 'F'); ?> >Fixed Amount</option>
									<option value="P" <?php echo set_select('type', 'P', TRUE); ?> >Percentage</option>
								<?php } else { ?>  
									<option value="F" <?php echo set_select('type', 'F'); ?> >Fixed Amount</option>
									<option value="P" <?php echo set_select('type', 'P'); ?> >Percentage</option>
								<?php } ?>  
							</select>
							<?php echo form_error('type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-discount" class="col-sm-2 control-label">Discount:</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="discount" id="input-discount" class="form-control" value="<?php echo set_value('discount', $discount); ?>" />
								<span id="discount-addon" class="input-group-addon">.00</span>
							</div>
							<?php echo form_error('discount', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-redemptions" class="col-sm-2 control-label">Redemptions:
							<span class="help-block">The total number of times this coupon can be redeem. Enter 0 for unlimited redemptions.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="redemptions" id="input-redemptions" class="form-control" value="<?php echo set_value('redemptions', $redemptions); ?>" />
							<?php echo form_error('redemptions', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-customer-redemptions" class="col-sm-2 control-label">Customer Redemptions:
							<span class="help-block">The number of times a specific customer can redeem this coupon. Enter 0 for unlimited redemptions.</span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="customer_redemptions" id="input-customer-redemptions" class="form-control" value="<?php echo set_value('customer_redemptions', $customer_redemptions); ?>" />
							<?php echo form_error('customer_redemptions', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-min-total" class="col-sm-2 control-label">Minimum Total:</label>
						<div class="col-sm-5">
							<input type="text" name="min_total" id="input-min-total" class="form-control" value="<?php echo set_value('min_total', $min_total); ?>" />
							<?php echo form_error('min_total', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-description" class="col-sm-2 control-label">Description:</label>
						<div class="col-sm-5">
							<textarea name="description" id="input-description" class="form-control" rows="7"><?php echo set_value('description', $description); ?></textarea>
							<?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="start-date" class="col-sm-2 control-label">Start Date:</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="start_date" id="start-date" class="form-control" value="<?php echo set_value('start_date', $start_date); ?>" />
								<span id="discount-addon" class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
							<?php echo form_error('start_date', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="end-date" class="col-sm-2 control-label">End Date:</label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="end_date" id="end-date" class="form-control" value="<?php echo set_value('end_date', $end_date); ?>" />
								<span id="discount-addon" class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
							<?php echo form_error('end_date', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-status" class="col-sm-2 control-label">Status:</label>
						<div class="col-sm-5">
							<select name="status" id="input-status" class="form-control">
								<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
							<?php if ($status === '1') { ?>
								<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
							<?php } else { ?>  
								<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
							<?php } ?>  
							</select>
							<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
				</div>

				<div id="coupon-history" class="tab-pane row wrap-all">
					<table height="auto" class="table table-striped table-border" id="history">
						<tr>
							<th class="">Order ID</th>
							<th width="55%">Customer</th>
							<th class="text-center">Code</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Used</th>
							<th class="text-right">Date Used</th>
						</tr>
						<?php if ($coupon_histories) { ?>
						<?php foreach ($coupon_histories as $coupon_history) { ?>
						<tr>
							<td class=""><?php echo $coupon_history['order_id']; ?></td>
							<td><?php echo $coupon_history['customer_name']; ?></td>
							<td class="text-center"><?php echo $coupon_history['code']; ?></td>
							<td class="text-center"><?php echo $coupon_history['amount']; ?></td>
							<td class="text-center"><a href="<?php echo $coupon_history['used_url']; ?>"><?php echo $coupon_history['used']; ?></a></td>
							<td class="text-right"><?php echo $coupon_history['date_used']; ?></td>
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="6"><?php echo $text_empty; ?></td>
						</tr>
						<?php } ?>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start-date, #end-date').datepicker({
		dateFormat: 'dd-mm-yy',
	});
	
	$('#input-type').on('change', function() {
		if (this.value === 'P') {
			$('#discount-addon').html('%');
		} else {
			$('#discount-addon').html('.00');
		}
	});

	$('#input-type').trigger('change');
});
//--></script>
<?php echo $footer; ?>