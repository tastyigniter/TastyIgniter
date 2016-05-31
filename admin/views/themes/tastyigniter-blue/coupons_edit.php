<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
				<li><a href="#coupon-history" data-toggle="tab"><?php echo lang('text_tab_history'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-name" class="col-sm-3 control-label"><?php echo lang('label_name'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="name" id="input-name" class="form-control" value="<?php echo set_value('name', $name); ?>" />
							<?php echo form_error('name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-code" class="col-sm-3 control-label"><?php echo lang('label_code'); ?></label>
						<div class="col-sm-5">
							<input type="text" name="code" id="input-code" class="form-control" value="<?php echo set_value('code', $code); ?>" />
							<?php echo form_error('code', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-type" class="col-sm-3 control-label"><?php echo lang('label_type'); ?>
							<span class="help-block"><?php echo lang('help_type'); ?></span>
						</label>
						<div class="col-sm-5">
							<div id="coupon-type" class="btn-group btn-group-switch" data-toggle="buttons">
								<?php if ($type === 'P') { ?>
									<label class="btn btn-success"><input type="radio" name="type" value="F" <?php echo set_radio('type', 'F'); ?>>Fixed Amount</label>
									<label class="btn btn-success active"><input type="radio" name="type" value="P" <?php echo set_radio('type', 'P', TRUE); ?>>Percentage</label>
								<?php } else { ?>
									<label class="btn btn-success active"><input type="radio" name="type" value="F" <?php echo set_radio('type', 'F', TRUE); ?>>Fixed Amount</label>
									<label class="btn btn-success"><input type="radio" name="type" value="P" <?php echo set_radio('type', 'P'); ?>>Percentage</label>
								<?php } ?>
							</div>
							<?php echo form_error('type', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-discount" class="col-sm-3 control-label"><?php echo lang('label_discount'); ?></label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="discount" id="input-discount" class="form-control" value="<?php echo set_value('discount', $discount); ?>" />
								<span id="discount-addon" class="input-group-addon"><?php echo lang('text_leading_zeros'); ?></span>
							</div>
							<?php echo form_error('discount', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-redemptions" class="col-sm-3 control-label"><?php echo lang('label_redemption'); ?>
							<span class="help-block"><?php echo lang('help_redemption'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="redemptions" id="input-redemptions" class="form-control" value="<?php echo set_value('redemptions', $redemptions); ?>" />
							<?php echo form_error('redemptions', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-customer-redemptions" class="col-sm-3 control-label"><?php echo lang('label_customer_redemption'); ?>
							<span class="help-block"><?php echo lang('help_customer_redemption'); ?></span>
						</label>
						<div class="col-sm-5">
							<input type="text" name="customer_redemptions" id="input-customer-redemptions" class="form-control" value="<?php echo set_value('customer_redemptions', $customer_redemptions); ?>" />
							<?php echo form_error('customer_redemptions', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-min-total" class="col-sm-3 control-label"><?php echo lang('label_min_total'); ?></label>
						<div class="col-sm-5">
							<div class="input-group">
								<input type="text" name="min_total" id="input-min-total" class="form-control" value="<?php echo set_value('min_total', $min_total); ?>" />
								<span class="input-group-addon"><?php echo lang('text_leading_zeros'); ?></span>
							</div>
							<?php echo form_error('min_total', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-validity" class="col-sm-3 control-label"><?php echo lang('label_validity'); ?></label>
						<div class="col-sm-5">
							<div class="btn-group btn-group-toggle btn-group-4" data-toggle="buttons">
								<?php if ($validity === 'forever') { ?>
									<label class="btn btn-success active"><input type="radio" name="validity" value="forever" <?php echo set_radio('validity', 'forever', TRUE); ?>>Forever</label>
								<?php } else { ?>
									<label class="btn btn-success"><input type="radio" name="validity" value="forever" <?php echo set_radio('validity', 'forever'); ?>>Forever</label>
								<?php } ?>
								<?php if ($validity === 'fixed') { ?>
									<label class="btn btn-success active"><input type="radio" name="validity" value="fixed" <?php echo set_radio('validity', 'fixed', TRUE); ?>>Fixed</label>
								<?php } else { ?>
									<label class="btn btn-success"><input type="radio" name="validity" value="fixed" <?php echo set_radio('validity', 'fixed'); ?>>Fixed</label>
								<?php } ?>
								<?php if ($validity === 'period') { ?>
									<label class="btn btn-success active"><input type="radio" name="validity" value="period" <?php echo set_radio('validity', 'period', TRUE); ?>>Period</label>
								<?php } else { ?>
									<label class="btn btn-success"><input type="radio" name="validity" value="period" <?php echo set_radio('validity', 'period'); ?>>Period</label>
								<?php } ?>
								<?php if ($validity === 'recurring') { ?>
									<label class="btn btn-success active"><input type="radio" name="validity" value="recurring" <?php echo set_radio('validity', 'recurring', TRUE); ?>>Recurring</label>
								<?php } else { ?>
									<label class="btn btn-success"><input type="radio" name="validity" value="recurring" <?php echo set_radio('validity', 'recurring'); ?>>Recurring</label>
								<?php } ?>
							</div>
							<?php echo form_error('validity', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div id="validity-fixed">
						<div class="form-group">
							<label for="start-date" class="col-sm-3 control-label"><?php echo lang('label_date'); ?></label>
							<div class="col-sm-5">
								<div class="input-group date">
									<input type="text" name="validity_times[fixed_date]" id="fixed-date" class="form-control" value="<?php echo set_value('validity_times[fixed_date]', $fixed_date); ?>" />
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
								</div>
								<?php echo form_error('validity_times[fixed_date]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"><?php echo lang('label_fixed_time'); ?></label>
							<div class="col-sm-5">
								<div class="">
									<div class="btn-group btn-group-switch wrap-bottom" data-toggle="buttons">
										<?php if ($fixed_time == '24hours') { ?>
											<label class="btn btn-success active"><input type="radio" name="fixed_time" value="24hours" checked="checked"><?php echo lang('text_24_hour'); ?></label>
											<label class="btn btn-success"><input type="radio" name="fixed_time" value="custom"><?php echo lang('text_custom'); ?></label>
										<?php } else { ?>
											<label class="btn btn-success"><input type="radio" name="fixed_time" value="24hours"><?php echo lang('text_24_hour'); ?></label>
											<label class="btn btn-success active"><input type="radio" name="fixed_time" value="custom" checked="checked"><?php echo lang('text_custom'); ?></label>
										<?php } ?>
									</div>
									<div class="input-group time wrap-bottom">
										<span class="input-group-addon"><b><?php echo lang('label_fixed_from_time'); ?></b></span>
										<input type="text" name="validity_times[fixed_from_time]" id="fixed-from-time" class="form-control" value="<?php echo set_value('validity_times[fixed_from_time]', $fixed_from_time); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<div class="input-group time wrap-bottom">
										<span class="input-group-addon"><b><?php echo lang('label_fixed_to_time'); ?></b></span>
										<input type="text" name="validity_times[fixed_to_time]" id="fixed-to-time" class="form-control" value="<?php echo set_value('validity_times[fixed_to_time]', $fixed_to_time); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
								</div>
								<?php echo form_error('fixed_time', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('validity_times[fixed_from_time]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('validity_times[fixed_to_time]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div id="validity-period">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"><?php echo lang('label_date'); ?></label>
							<div class="col-sm-5">
								<div class="">
									<div class="input-group date wrap-bottom">
										<span class="input-group-addon"><b><?php echo lang('label_period_start_date'); ?></b></span>
										<input type="text" name="validity_times[period_start_date]" id="period-start-date" class="form-control" value="<?php echo set_value('validity_times[period_start_date]', $period_start_date); ?>" />
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
									<div class="input-group date wrap-bottom">
										<span class="input-group-addon"><b><?php echo lang('label_period_end_date'); ?></b></span>
										<input type="text" name="validity_times[period_end_date]" id="period-end-date" class="form-control" value="<?php echo set_value('validity_times[period_end_date]', $period_end_date); ?>" />
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
								</div>
								<?php echo form_error('validity_times[period_start_date]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('validity_times[period_end_date]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div id="validity-recurring">
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"><?php echo lang('label_recurring_every'); ?></label>
							<div class="col-sm-5">
								<div class="btn-group btn-group-toggle btn-group-7" data-toggle="buttons">
									<?php foreach ($weekdays as $key => $value) { ?>
										<?php if (in_array($key, $recurring_every)) { ?>
											<label class="btn btn-success active"><input type="checkbox" name="validity_times[recurring_every][]" value="<?php echo $key; ?>" checked="checked"><?php echo $value; ?></label>
										<?php } else { ?>
											<label class="btn btn-success"><input type="checkbox" name="validity_times[recurring_every][]" value="<?php echo $key; ?>"><?php echo $value; ?></label>
										<?php } ?>
									<?php } ?>
								</div>
								<?php echo form_error('validity_times[recurring_every][]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-3 control-label"><?php echo lang('label_recurring_time'); ?></label>
							<div class="col-sm-5">
								<div class="">
									<div class="btn-group btn-group-switch wrap-bottom" data-toggle="buttons">
										<?php if ($recurring_time == '24hours') { ?>
											<label class="btn btn-success active"><input type="radio" name="recurring_time" value="24hours" checked="checked"><?php echo lang('text_24_hour'); ?></label>
											<label class="btn btn-success"><input type="radio" name="recurring_time" value="custom"><?php echo lang('text_custom'); ?></label>
										<?php } else { ?>
											<label class="btn btn-success"><input type="radio" name="recurring_time" value="24hours"><?php echo lang('text_24_hour'); ?></label>
											<label class="btn btn-success active"><input type="radio" name="recurring_time" value="custom" checked="checked"><?php echo lang('text_custom'); ?></label>
										<?php } ?>
									</div>
									<div class="input-group time wrap-bottom">
										<span class="input-group-addon"><b><?php echo lang('label_recurring_from_time'); ?></b></span>
										<input type="text" name="validity_times[recurring_from_time]" id="recurring-from-time" class="form-control" value="<?php echo set_value('validity_times[recurring_from_time]', $recurring_from_time); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
									<div class="input-group time wrap-bottom">
										<span class="input-group-addon"><b><?php echo lang('label_recurring_to_time'); ?></b></span>
										<input type="text" name="validity_times[recurring_to_time]" id="recurring-to-time" class="form-control" value="<?php echo set_value('validity_times[recurring_to_time]', $recurring_to_time); ?>" />
										<span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
									</div>
								</div>
								<?php echo form_error('recurring_time', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('validity_times[recurring_from_time]', '<span class="text-danger">', '</span>'); ?>
								<?php echo form_error('validity_times[recurring_to_time]', '<span class="text-danger">', '</span>'); ?>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="input-order-restriction" class="col-sm-3 control-label"><?php echo lang('label_order_restriction'); ?>
							<span class="help-block"><?php echo lang('help_order_restriction'); ?></span>
						</label>
						<div class="col-sm-5">
							<div id="order-restriction" class="btn-group btn-group-3 btn-group-toggle" data-toggle="buttons">
								<?php if ($order_restriction === '1') { ?>
									<label class="btn btn-default"><input type="radio" name="order_restriction" value="0" <?php echo set_radio('order_restriction', '0'); ?>>None</label>
									<label class="btn btn-default active"><input type="radio" name="order_restriction" value="1" <?php echo set_radio('order_restriction', '1', TRUE); ?>>Delivery Only</label>
									<label class="btn btn-default"><input type="radio" name="order_restriction" value="2" <?php echo set_radio('order_restriction', '2'); ?>>Collection Only</label>
								<?php } else if ($order_restriction === '2') { ?>
									<label class="btn btn-default"><input type="radio" name="order_restriction" value="0" <?php echo set_radio('order_restriction', '0'); ?>>None</label>
									<label class="btn btn-default"><input type="radio" name="order_restriction" value="1" <?php echo set_radio('order_restriction', '1'); ?>>Delivery Only</label>
									<label class="btn btn-default active"><input type="radio" name="order_restriction" value="2" <?php echo set_radio('order_restriction', '2', TRUE); ?>>Collection Only</label>
								<?php } else { ?>
									<label class="btn btn-default active"><input type="radio" name="order_restriction" value="0" <?php echo set_radio('order_restriction', '0', TRUE); ?>>None</label>
									<label class="btn btn-default"><input type="radio" name="order_restriction" value="1" <?php echo set_radio('order_restriction', '1'); ?>>Delivery Only</label>
									<label class="btn btn-default"><input type="radio" name="order_restriction" value="2" <?php echo set_radio('order_restriction', '2'); ?>>Collection Only</label>
								<?php } ?>
							</div>
							<?php echo form_error('order_restriction', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-description" class="col-sm-3 control-label"><?php echo lang('label_description'); ?></label>
						<div class="col-sm-5">
							<textarea name="description" id="input-description" class="form-control" rows="7"><?php echo set_value('description', $description); ?></textarea>
							<?php echo form_error('description', '<span class="text-danger">', '</span>'); ?>
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

				<div id="coupon-history" class="tab-pane row wrap-left wrap-right">
                    <div class="table-responsive">
                        <table height="auto" class="table table-striped table-border" id="history">
                            <thead>
                                <tr>
                                    <th class=""><?php echo lang('column_order_id'); ?></th>
                                    <th width="55%"><?php echo lang('column_customer'); ?></th>
                                    <th class="text-center"><?php echo lang('column_amount'); ?></th>
                                    <th class="text-right"><?php echo lang('column_date_used'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($coupon_histories) { ?>
                                <?php foreach ($coupon_histories as $history) { ?>
                                <tr>
                                    <td class=""><a href="<?php echo $history['view']; ?>"><?php echo $history['order_id']; ?></a></td>
                                    <td><?php echo $history['customer_name']; ?></td>
                                    <td class="text-center"><?php echo $history['amount']; ?></td>
                                    <td class="text-right"><?php echo $history['date_used']; ?></td>
                                </tr>
                                <?php } ?>
                                <?php } else { ?>
                                <tr>
                                    <td colspan="6"><?php echo lang('text_no_history'); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {

	$('.date').datepicker({
		format: 'dd-mm-yyyy'
	});

	$('#fixed-from-time, #fixed-to-time, #recurring-from-time, #recurring-to-time').timepicker({
		defaultTime: ''
	});

	$(document).on('change', '#coupon-type input[type="radio"]', function() {
		if (this.value === 'P') {
			$('#discount-addon').html('%');
		} else {
			$('#discount-addon').html('<?php echo lang('text_leading_zeros'); ?>');
		}
	});

	$(document).on('change', 'input[name="validity"]', function() {
		$('#validity-fixed, #validity-period, #validity-recurring').fadeOut();
		if (this.value == 'fixed' || this.value == 'period' || this.value == 'recurring') {
			$('#validity-' + this.value).fadeIn();
		}
	});

	$(document).on('change', 'input[name="fixed_time"], input[name="recurring_time"]', function() {
		$(this).parent().parent().parent().find('.input-group').fadeOut();
		if (this.value == 'custom') {
			$(this).parent().parent().parent().find('.input-group').fadeIn();
		}
	});
});
//--></script>
<?php echo get_footer(); ?>