<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<li class="active"><a href="#general" data-toggle="tab"><?php echo lang('text_tab_general'); ?></a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="POST" action="<?php echo $_action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="row">
						<div class="col-xs-12 col-sm-4">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_general'); ?></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_reservation_id'); ?></label>
										<div class="">
											#<?php echo $reservation_id; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_guest'); ?></label>
										<div class="">
											<?php echo $guest_num; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_reservation_date'); ?></label>
										<div class="">
											<?php echo $reserve_date; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_reservation_time'); ?></label>
										<div class="">
											<?php echo $reserve_time; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_occasion'); ?></label>
										<div class="">
											<?php echo $occasions[$occasion]; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_customer'); ?></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_customer_name'); ?></label>
										<div class="">
											<?php echo $first_name; ?> <?php echo $last_name; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_customer_email'); ?></label>
										<div class="">
											<?php echo $email; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_customer_telephone'); ?></label>
										<div class="">
											<?php echo $telephone; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4">
							<div class="panel panel-default">
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_date_added'); ?></label>
										<div class="">
											<?php echo $date_added; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_date_modified'); ?></label>
										<div class="">
											<?php echo $date_modified; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('column_notify'); ?></label>
										<div class="">
											<?php if ($notify === '1') { ?>
												<?php echo lang('text_email_sent'); ?>
											<?php } else { ?>
												<?php echo lang('text_email_not_sent'); ?>
											<?php } ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_ip_address'); ?></label>
										<div class="">
											<?php echo $ip_address; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_user_agent'); ?></label>
										<div class="">
											<?php echo $user_agent; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_restaurant'); ?> - <span class="text-muted"><?php echo $location_name; ?></span></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<div class="">
											<span>
												<?php echo $location_address_1; ?>,<br />
												<?php echo $location_city; ?>,
												<?php echo $location_postcode; ?>,
												<?php echo $location_country; ?>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-xs-12 col-sm-6">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_table'); ?></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_table_name'); ?></label>
										<div class="">
											<?php echo $table_name; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_table_min_capacity'); ?></label>
										<div class="">
											<?php echo $min_capacity; ?>
										</div>
									</div>
									<div class="form-group col-xs-12">
										<label for="" class="control-label"><?php echo lang('label_table_capacity'); ?></label>
										<div class="">
											<?php echo $max_capacity; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('label_comment'); ?> - <span class="text-muted"><?php echo $location_name; ?></span></h3></div>
								<div class="panel-body">
									<div class="form-group col-xs-12">
										<div class="">
											<?php echo $comment; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_status_history'); ?></h3></div>
								<div class="panel-body">
									<div class="table-responsive">
										<table height="auto" class="table table-striped table-border table-no-spacing" id="history">
											<thead>
											<tr>
												<th><?php echo lang('column_time_date'); ?></th>
												<th><?php echo lang('column_staff'); ?></th>
												<th><?php echo lang('column_assignee'); ?></th>
												<th><?php echo lang('column_status'); ?></th>
												<th class="left" width="35%"><?php echo lang('column_comment'); ?></th>
												<th class="text-center"><?php echo lang('column_notify'); ?></th>
											</tr>
											</thead>
											<tbody>
											<?php if ($status_history) { ?>
												<?php foreach ($status_history as $history) { ?>
													<tr>
														<td><?php echo $history['date_time']; ?></td>
														<td><?php echo $history['staff_name']; ?></td>
														<td>
															<?php foreach ($staffs as $staff) { ?>
																<?php if ($staff['staff_id'] === $history['assignee_id']) { ?>
																	<?php echo $staff['staff_name']; ?>
																<?php } ?>
															<?php } ?>
														</td>
														<td><span class="label label-default" style="background-color: <?php echo $history['status_color']; ?>;"><?php echo $history['status_name']; ?></span></td>
														<td class="left"><?php echo $history['comment']; ?></td>
														<td class="text-center"><?php echo ($history['notify'] === '1') ? $this->lang->line('text_yes') : $this->lang->line('text_no'); ?></td>
													</tr>
												<?php } ?>
											<?php } else { ?>
												<tr>
													<td colspan="6"><?php echo lang('text_no_status_history'); ?></td>
												</tr>
											<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<div class="panel panel-default">
								<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_tab_status'); ?></h3></div>
								<div class="panel-body">
									<div class="col-xs-12 col-sm-3">
										<input type="hidden" name="old_assignee_id" value="<?php echo $assignee_id; ?>" />
										<input type="hidden" name="old_status_id" value="<?php echo $status_id; ?>" />
										<label for="input-assign-staff" class="control-label"><?php echo lang('label_assign_staff'); ?></label>
										<div class="">
											<select name="assignee_id" class="form-control">
												<option value=""><?php echo lang('text_please_select'); ?></option>
												<?php foreach ($staffs as $staff) { ?>
													<?php if ($staff['staff_id'] === $assignee_id) { ?>
														<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('assignee_id', $staff['staff_id'], TRUE); ?> ><?php echo $staff['staff_name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('assignee_id', $staff['staff_id']); ?> ><?php echo $staff['staff_name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
											<?php echo form_error('assignee_id', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-xs-12 col-sm-2">
										<label for="input-status" class="control-label"><?php echo lang('label_status'); ?></label>
										<div class="">
											<select name="status" class="form-control" onChange="getStatusComment();">
												<?php foreach ($statuses as $status) { ?>
													<?php if ($status['status_id'] === $status_id) { ?>
														<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('status', $status['status_id'], TRUE); ?> ><?php echo $status['status_name']; ?></option>
													<?php } else { ?>
														<option value="<?php echo $status['status_id']; ?>" <?php echo set_select('status', $status['status_id']); ?> ><?php echo $status['status_name']; ?></option>
													<?php } ?>
												<?php } ?>
											</select>
											<?php echo form_error('status', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-xs-12 col-sm-5">
										<label for="input-comment" class="control-label"><?php echo lang('label_comment'); ?></label>
										<div class="">
											<textarea name="status_comment" rows="3" class="form-control"><?php echo set_value('status_comment'); ?></textarea>
											<?php echo form_error('status_comment', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
									<div class="col-xs-12 col-sm-2">
										<label for="input-notify" class="control-label"><?php echo lang('label_notify'); ?></label>
										<div class="">
											<div id="input-notify" class="btn-group btn-group-switch" data-toggle="buttons">
												<?php if ($notify == '1') { ?>
													<label class="btn btn-danger"><input type="radio" name="notify" value="0" <?php echo set_radio('notify', '0'); ?>><?php echo lang('text_no'); ?></label>
													<label class="btn btn-success active"><input type="radio" name="notify" value="1" <?php echo set_radio('notify', '1', TRUE); ?>><?php echo lang('text_yes'); ?></label>
												<?php } else { ?>
													<label class="btn btn-danger active"><input type="radio" name="notify" value="0" <?php echo set_radio('notify', '0', TRUE); ?>><?php echo lang('text_no'); ?></label>
													<label class="btn btn-success"><input type="radio" name="notify" value="1" <?php echo set_radio('notify', '1'); ?>><?php echo lang('text_yes'); ?></label>
												<?php } ?>
											</div>
											<?php echo form_error('notify', '<span class="text-danger">', '</span>'); ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
  	$('.view_details').on('click', function(){
  		if($('.paypal_details').is(':visible')){
     		$('.paypal_details').fadeOut();
   			$('.view_details').attr('class', '');
		} else {
   			$('.paypal_details').fadeIn();
   			$('.view_details').attr('class', 'active');
		}
	});
});
</script>
<script type="text/javascript"><!--
function getStatusComment() {
	if ($('select[name="status"]').val()) {
		$.ajax({
			url: js_site_url('statuses/comment_notify?status_id=') + encodeURIComponent($('select[name="status"]').val()),
			dataType: 'json',
			success: function(json) {
				$('textarea[name="status_comment"]').html(json['comment']);
			}
		});
	}
};

$('select[name="status"]').trigger('change');
//--></script>
<?php echo get_footer(); ?>