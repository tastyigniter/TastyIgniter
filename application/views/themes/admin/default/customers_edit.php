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
				<li class="active"><a href="#general" data-toggle="tab">Customer</a></li>
				<li><a href="#addresses" data-toggle="tab">Address</a></li>
				<li><a href="#orders" data-toggle="tab">Orders</a></li>
				<li><a href="#recent-activity" data-toggle="tab">Recent Activity</a></li>
			</ul>
		</div>

		<form role="form" id="edit-form" class="form-horizontal" accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
			<div class="tab-content">
				<div id="general" class="tab-pane row wrap-all active">
					<div class="form-group">
						<label for="input-first-name" class="col-sm-2 control-label">First Name:</label>
						<div class="col-sm-5">
							<input type="text" name="first_name" id="input-first-name" class="form-control" value="<?php echo set_value('first_name', $first_name); ?>" />
							<?php echo form_error('first_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-last-name" class="col-sm-2 control-label">Last Name:</label>
						<div class="col-sm-5">
							<input type="text" name="last_name" id="input-last-name" class="form-control" value="<?php echo set_value('last_name', $last_name); ?>" />
							<?php echo form_error('last_name', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-email" class="col-sm-2 control-label">Email:</label>
						<div class="col-sm-5">
							<input type="text" name="email" id="input-email" class="form-control" value="<?php echo set_value('email', $email); ?>" />
							<?php echo form_error('email', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-telephone" class="col-sm-2 control-label">Telephone:</label>
						<div class="col-sm-5">
							<input type="text" name="telephone" id="input-telephone" class="form-control" value="<?php echo set_value('telephone', $telephone); ?>" />
							<?php echo form_error('telephone', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-password" class="col-sm-2 control-label">Password:
							<span class="help-block">Leave blank to leave password unchanged</span>
						</label>
						<div class="col-sm-5">
							<input type="password" name="password" id="input-password" class="form-control" value="<?php echo set_value('password'); ?>" autocomplete="off" />
							<?php echo form_error('password', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-confirm-password" class="col-sm-2 control-label">Confirm Password:</label>
						<div class="col-sm-5">
							<input type="password" name="confirm_password" id="input-confirm-password" class="form-control" value="" />
							<?php echo form_error('confirm_password', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-security-question" class="col-sm-2 control-label">Security Question:</label>
						<div class="col-sm-5">
							<select name="security_question" id="input-security-question" class="form-control">
								<option value="">— Select —</option>
								<?php foreach ($questions as $question) { ?>
									<?php if ($question['id'] === $security_question) { ?>
										<option value="<?php echo $question['id']; ?>" selected="selected"><?php echo $question['text']; ?></option>
									<?php } else { ?>
										<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
									<?php } ?>
								<?php } ?>
							</select>
							<?php echo form_error('security_question', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-security-answer" class="col-sm-2 control-label">Security Answer:</label>
						<div class="col-sm-5">
							<input type="text" name="security_answer" id="input-security-answer" class="form-control" value="<?php echo set_value('security_answer', $security_answer); ?>" />
							<?php echo form_error('security_answer', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-newsletter" class="col-sm-2 control-label">Newsletter:</label>
						<div class="col-sm-5">
							<select name="newsletter" id="input-newsletter" class="form-control">
								<option value="0" <?php echo set_select('newsletter', '0'); ?> >Disabled</option>
								<?php if ($newsletter === '1') { ?>
									<option value="1" <?php echo set_select('newsletter', '1', TRUE); ?> >Enabled</option>
								<?php } else { ?>  
									<option value="1" <?php echo set_select('newsletter', '1'); ?> >Enabled</option>
								<?php } ?>  
							</select>
							<?php echo form_error('newsletter', '<span class="text-danger">', '</span>'); ?>
						</div>
					</div>
					<div class="form-group">
						<label for="input-customer-group-id" class="col-sm-2 control-label">Customer Group:</label>
						<div class="col-sm-5">
							<select name="customer_group_id" id="input-customer-group-id" class="form-control">
							<?php foreach ($customer_groups as $customer_group) { ?>
								<?php if ($customer_group['customer_group_id'] === $customer_group_id) { ?>
									<option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo set_select('customer_group_id', $customer_group['customer_group_id'], TRUE); ?> ><?php echo $customer_group['group_name']; ?></option>
								<?php } else { ?>  
									<option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo set_select('customer_group_id', $customer_group['customer_group_id']); ?> ><?php echo $customer_group['group_name']; ?></option>
								<?php } ?>  
							<?php } ?>  
							</select>
							<?php echo form_error('customer_group_id', '<span class="text-danger">', '</span>'); ?>
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
	
				<div id="addresses" class="row wrap-all">
					<ul id="sub-tabs" class="nav nav-tabs">
						<?php $table_row = 1; ?>
						<?php foreach ($addresses as $address) { ?>
							<li><a href="#address<?php echo $table_row; ?>" data-toggle="tab">Address <?php echo $table_row; ?>&nbsp;&nbsp;<i class="fa fa-times-circle" onclick="$('#sub-tabs a[rel=#address1]').trigger('click'); $('#address<?php echo $table_row; ?>').remove(); $(this).parent().parent().remove(); return false;"></i></a></li>
							<?php $table_row++; ?>
						<?php } ?>
						<li class="add_address"><a onclick="addAddress();"><i class="fa fa-book"></i>&nbsp;<i class="fa fa-plus"></i></a></li>
					</ul>

					<div id="new-address" class="tab-content">
					<?php $table_row = 1; ?>
					<?php if ($addresses) { ?>
						<?php foreach ($addresses as $address) { ?>
						<div id="address<?php echo $table_row; ?>" class="tab-pane row wrap-all">
							<input type="hidden" name="address[<?php echo $table_row; ?>][address_id]" value="<?php echo set_value('address[<?php echo $table_row; ?>][address_id]', $address['address_id']); ?>" />
							<div class="form-group">
								<label for="input-name" class="col-sm-2 control-label">Address 1:</label>
								<div class="col-sm-5">
									<input type="text" name="address[<?php echo $table_row; ?>][address_1]" id="" class="form-control" value="<?php echo set_value('address[<?php echo $table_row; ?>][address_1]', $address['address_1']); ?>" />
									<?php echo form_error('address['.$table_row.'][address_1]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">Address 2:</label>
								<div class="col-sm-5">
									<input type="text" name="address[<?php echo $table_row; ?>][address_2]" id="" class="form-control" value="<?php echo set_value('address[<?php echo $table_row; ?>][address_2]', $address['address_2']); ?>" />
									<?php echo form_error('address['.$table_row.'][address_2]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="col-sm-2 control-label">City:</label>
								<div class="col-sm-5">
									<input type="text" name="address[<?php echo $table_row; ?>][city]" id="" class="form-control" value="<?php echo set_value('address[<?php echo $table_row; ?>][city]', $address['city']); ?>" />
									<?php echo form_error('address['.$table_row.'][city]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="input-name" class="col-sm-2 control-label">Postcode:</label>
								<div class="col-sm-5">
									<input type="text" name="address[<?php echo $table_row; ?>][postcode]" id="" class="form-control" value="<?php echo set_value('address[<?php echo $table_row; ?>][postcode]', $address['postcode']); ?>" />
									<?php echo form_error('address['.$table_row.'][postcode]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
							<div class="form-group">
								<label for="input-name" class="col-sm-2 control-label">Country:</label>
								<div class="col-sm-5">
									<select name="address[<?php echo $table_row; ?>][country_id]" id="" class="form-control">
									<?php foreach ($countries as $country) { ?>
										<?php if ($country['country_id'] === $address['country_id']) { ?>
											<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
										<?php } else { ?>  
											<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
										<?php } ?>  
									<?php } ?>  
									</select>
									<?php echo form_error('address['.$table_row.'][country_id]', '<span class="text-danger">', '</span>'); ?>
								</div>
							</div>
						</div>
						<?php $table_row++; ?>
						<?php } ?>
					<?php } ?>
					</div>
				</div>
		
				<div id="orders" class="tab-pane row wrap-all">
					<table border="0" class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
								<th>ID</th>
								<th>Location</th>
								<th>Customer Name</th>
								<th>Status</th>
								<th>Type</th>
								<th class="text-center">Ready Time</th>
								<th class="text-center">Date Added</th>
							</tr>
						</thead>
						<tbody>
							<?php if ($orders) { ?>
							<?php foreach ($orders as $order) { ?>
							<tr>
								<td class="action"><input type="checkbox" value="<?php echo $order['order_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
									<a class="btn btn-edit" title="Edit" href="<?php echo $order['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
								<td class="id"><?php echo $order['order_id']; ?></td>
								<td><?php echo $order['location_name']; ?></td>
								<td><?php echo $order['first_name'] .' '. $order['last_name']; ?></td>
								<td><?php echo $order['order_status']; ?></td>
								<td><?php echo $order['order_type']; ?></td>
								<td class="text-center"><?php echo $order['order_time']; ?></td>
								<td class="text-center"><?php echo $order['date_added']; ?></td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td colspan="8"><?php echo $text_empty; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
			
					<div class="pagination-bar clearfix">
						<div class="links"><?php echo $pagination['links']; ?></div>
						<div class="info"><?php echo $pagination['info']; ?></div> 
					</div>
				</div>

				<div id="recent-activity" class="tab-pane row wrap-all">
					<table border="0" class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action action-one"></th>
								<th>Last Activity</th>
								<th>IP</th>
								<th>Customer</th>
								<th>Access</th>
								<th>Browser</th>
								<th style="width:22%;">Request URL</th>
								<th style="width:22%;">Referrer URL</th>
							</tr>
						</thead>
						<tbody>
							<?php if ($activities) { ?>
							<?php foreach ($activities as $activity) { ?>
							<tr>
								<td class="action action-one"><a class="blacklist" title="Blacklist" href="<?php echo $activity['blacklist']; ?>"></a></td>
								<td><?php echo $activity['date_added']; ?></td>
								<td><?php echo $activity['ip_address']; ?></td>
								<td><?php echo $activity['customer_name']; ?></td>
								<td><?php echo $activity['access_type']; ?></td>
								<td><?php echo $activity['browser']; ?></td>
								<td><?php echo $activity['request_uri']; ?></td>
								<td><?php echo $activity['referrer_uri']; ?></td>
							</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td colspan="8"><?php echo $text_empty_activity; ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addAddress() {	
	html  = '<div id="address' + table_row + '" class="tab-pane row wrap-all">';
	html += '<input type="hidden" name="address[' + table_row + '][address_id]" id="" class="form-control" value="<?php echo set_value("address[' + table_row + '][address_id]"); ?>" />';
	html += '<div class="form-group">';
	html += '	<label for="input-name" class="col-sm-2 control-label">Address 1:</label>';
	html += '	<div class="col-sm-5">';
	html += '		<input type="text" name="address[' + table_row + '][address_1]" id="" class="form-control" value="<?php echo set_value("address[' + table_row + '][address_1]"); ?>" />';
	html += '	</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '	<label for="input-name" class="col-sm-2 control-label">Address 2:</label>';
	html += '	<div class="col-sm-5">';
	html += '		<input type="text" name="address[' + table_row + '][address_2]" id="" class="form-control" value="<?php echo set_value("address[' + table_row + '][address_2]"); ?>" />';
	html += '	</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '	<label for="input-name" class="col-sm-2 control-label">City:</label>';
	html += '	<div class="col-sm-5">';
	html += '		<input type="text" name="address[' + table_row + '][city]" id="" class="form-control" value="<?php echo set_value("address[' + table_row + '][city]"); ?>" />';
	html += '	</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '	<label for="input-name" class="col-sm-2 control-label">Postcode:</label>';
	html += '	<div class="col-sm-5">';
	html += '		<input type="text" name="address[' + table_row + '][postcode]" id="" class="form-control" value="<?php echo set_value("address[' + table_row + '][postcode]"); ?>" />';
	html += '	</div>';
	html += '</div>';
	html += '<div class="form-group">';
	html += '	<label for="input-name" class="col-sm-2 control-label">Country:</label>';
	html += '	<div class="col-sm-5">';
	html += '		<select name="address[' + table_row + '][country_id]" id="" class="form-control">';
				<?php foreach ($countries as $country) { ?>
				<?php if ($country['country_id'] === $country_id) { ?>
	html += '			<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo addslashes($country['name']); ?></option>';
				<?php } else { ?>
	html += '			<option value="<?php echo $country['country_id']; ?>"><?php echo addslashes($country['name']); ?></option>';
				<?php } ?>
				<?php } ?>
	html += '		</select>';
	html += '	</div>';
	html += '</div>';
	html += '</div>';
	
	$('#new-address').append(html);
	
	$('.add_address').before('<li><a href="#address' + table_row + '" data-toggle="tab">Address ' + table_row + '&nbsp;&nbsp;<i class="fa fa-times-circle" onclick="$(\'#sub-tabs a[rel=#address1]\').trigger(\'click\'); $(\'#address' + table_row + '\').remove(); $(this).parent().parent().remove(); return false;"></i></a></li>');
	
	$('#sub-tabs a[href="#address' + table_row + '"]').tab('show');
	$('select.form-control').selectpicker();

	table_row++;
}

$('#sub-tabs a:first').tab('show');
//--></script>
<?php echo $footer; ?>