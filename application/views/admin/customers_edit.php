<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general">Customer</a></li>
				<li><a rel="#addresses">Address</a></li>
				<li><a rel="#orders">Orders</a></li>
				<li><a rel="#recent-activity">Recent Activity</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tr>
					<td><b>First Name:</b></td>
					<td><input type="text" name="first_name" value="<?php echo set_value('first_name', $first_name); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Last Name:</b></td>
					<td><input type="text" name="last_name" value="<?php echo set_value('last_name', $last_name); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Email:</b></td>
					<td><input type="text" name="email" value="<?php echo set_value('email', $email); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Telephone:</b></td>
					<td><input type="text" name="telephone" value="<?php echo set_value('telephone', $telephone); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Password:</b><br />
					<font size="1">Leave blank to leave password unchanged</font></td>
					<td><input type="password" name="password" value="<?php echo set_value('password'); ?>" class="textfield" autocomplete="off" /></td>
				</tr>
				<tr>
					<td><b>Confirm Password:</b></td>
					<td><input type="password" name="confirm_password" value="" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Security Question:</b></td>
					<td><select name="security_question">
					<option value=""> please select </option>
					<?php foreach ($questions as $question) { ?>
					<?php if ($question['id'] === $security_question) { ?>
						<option value="<?php echo $question['id']; ?>" selected="selected"><?php echo $question['text']; ?></option>
					<?php } else { ?>
						<option value="<?php echo $question['id']; ?>"><?php echo $question['text']; ?></option>
					<?php } ?>
					<?php } ?>
					</select></td>
				</tr>
				<tr>
					<td><b>Security Answer:</b></td>
					<td><input type="text" name="security_answer" value="<?php echo set_value('security_answer', $security_answer); ?>" class="textfield" /></td>
				</tr>
				<tr>
					<td><b>Status:</b></td>
					<td><select name="status">
						<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
					<?php if ($status === '1') { ?>
						<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
					<?php } else { ?>  
						<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
					<?php } ?>  
					</select></td>
				</tr>
			</table>
		</div>
	
		<div id="addresses" class="wrap_content" style="display:none;">
			<ul id="sub-tabs">
				<?php $table_row = 1; ?>
				<?php foreach ($addresses as $address) { ?>
					<li><a rel="#address<?php echo $table_row; ?>">Address <?php echo $table_row; ?><img src="<?php echo base_url('assets/img/delete.png'); ?>" onclick="$('#sub-tabs a[rel=#address1]').trigger('click'); $('#address<?php echo $table_row; ?>').remove(); $(this).parent().parent().remove(); return false;" /></a></li>
					<?php $table_row++; ?>
				<?php } ?>
				<li class="add_address"><span onclick="addAddress();">Add Address<img src="<?php echo base_url('assets/img/add.png'); ?>" /></span></li>
			</ul>

			<?php $table_row = 1; ?>
			<?php if ($addresses) { ?>
			<?php foreach ($addresses as $address) { ?>
			<div id="address<?php echo $table_row; ?>" class="wrap_content" style="display:none;">
				<input type="hidden" name="address[<?php echo $table_row; ?>][address_id]" value="<?php echo set_value('address[<?php echo $table_row; ?>][address_id]', $address['address_id']); ?>" />
				<table class="form">
					<tr>
						<td><b>Address 1:</b></td>
						<td><input type="text" name="address[<?php echo $table_row; ?>][address_1]" value="<?php echo set_value('address[<?php echo $table_row; ?>][address_1]', $address['address_1']); ?>" /></td>
					</tr>
					<tr>
						<td><b>Address 2:</b></td>
						<td><input type="text" name="address[<?php echo $table_row; ?>][address_2]" value="<?php echo set_value('address[<?php echo $table_row; ?>][address_2]', $address['address_2']); ?>" /></td>
					</tr>
					<tr>
						<td><b>City:</b></td>
						<td><input type="text" name="address[<?php echo $table_row; ?>][city]" value="<?php echo set_value('address[<?php echo $table_row; ?>][city]', $address['city']); ?>" /></td>
					</tr>
					<tr>
						<td><b>Postcode:</b></td>
						<td><input type="text" name="address[<?php echo $table_row; ?>][postcode]" value="<?php echo set_value('address[<?php echo $table_row; ?>][postcode]', $address['postcode']); ?>" /></td>
					</tr>
					<tr>
						<td><b>Country:</b></td>
						<td><select name="address[<?php echo $table_row; ?>][country]">
						<?php foreach ($countries as $country) { ?>
						<?php if ($country['country_id'] === $address['country_id']) { ?>
							<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
						<?php } else { ?>  
							<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
						<?php } ?>  
						<?php } ?>  
						</select></td>
					</tr>
				</table>
			</div>
			<?php $table_row++; ?>
			<?php } ?>
			<?php } ?>
		
			<div id="new-address"></div>
		</div>
		
		<div id="orders" class="wrap_content" style="display:none;">
			<table border="0" class="list">
				<tr>
					<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
					<th>Order ID</th>
					<th>Location</th>
					<th>Customer Name</th>
					<th>Status</th>
					<th>Assigned Staff</th>
					<th>Type</th>
					<th class="center">Ready Time</th>
					<th class="center">Date Added</th>
					<th class="right">Action</th>
				</tr>
				<?php if ($orders) { ?>
				<?php foreach ($orders as $order) { ?>
				<tr>
					<td class="delete"><input type="checkbox" value="<?php echo $order['order_id']; ?>" name="delete[]" /></td>
					<td class="id"><?php echo $order['order_id']; ?></td>
					<td><?php echo $order['location_name']; ?></td>
					<td><?php echo $order['first_name'] .' '. $order['last_name']; ?></td>
					<td><?php echo $order['order_status']; ?></td>
					<td><?php echo $order['order_type']; ?></td>
					<td class="center"><?php echo $order['order_time']; ?></td>
					<td class="center"><?php echo $order['date_added']; ?></td>
					<td class="right"><a class="edit" title="Edit" href="<?php echo $order['edit']; ?>"></a></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="11" align="center"><?php echo $text_empty; ?></td>
				</tr>
				<?php } ?>
			</table>
	
			<div class="pagination">
				<div class="links"><?php echo $pagination['links']; ?></div>
				<div class="info"><?php echo $pagination['info']; ?></div> 
			</div>
		</div>

		<div id="recent-activity" class="wrap_content" style="display:none;">
			<table border="0" class="list">
				<tr>
					<th>Date/Time</th>
					<th>Country (IP Address)</th>
					<th>Access Type (Browser)</th>
					<th class="right">Action</th>
				</tr>
				<?php if ($activities) { ?>
				<?php foreach ($activities as $activity) { ?>
				<tr>
					<td><?php echo $activity['date_time']; ?></td>
					<td><?php echo $activity['country_name']; ?> (<?php echo $activity['ip_address']; ?>) 
						<img src="http://api.hostip.info/flag.php?ip=<?php echo $activity['ip_address']; ?>" width="18px" height="14px"/></td>
					<td><?php echo $activity['access_type']; ?> (<?php echo $activity['browser']; ?>)</td>
					<td class="right"><a class="blacklist" title="Blacklist" href="<?php echo $activity['blacklist']; ?>"></a></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="4" align="center"><?php echo $text_empty_activity; ?></td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</form>
	</div>
</div>
<script type="text/javascript"><!--
var table_row = <?php echo $table_row; ?>;

function addAddress() {	
	html  = '<div id="address' + table_row + '" class="wrap_content" style="display:none;">';
	html += '<input type="hidden" name="address[' + table_row + '][address_id]" value="<?php echo set_value("address[' + table_row + '][address_id]"); ?>" />';
	html += '<table class="form">';
	html += '<tr>';
	html += '	<td><b>Address 1:</b></td>';
	html += '	<td><input type="text" name="address[' + table_row + '][address_1]" value="<?php echo set_value("address[' + table_row + '][address_1]"); ?>" /></td>';
	html += '</tr>';
	html += '<tr>';
	html += '	<td><b>Address 2:</b></td>';
	html += '	<td><input type="text" name="address[' + table_row + '][address_2]" value="<?php echo set_value("address[' + table_row + '][address_2]"); ?>" /></td>';
	html += '</tr>';
	html += '<tr>';
	html += '	<td><b>City:</b></td>';
	html += '	<td><input type="text" name="address[' + table_row + '][city]" value="<?php echo set_value("address[' + table_row + '][city]"); ?>" /></td>';
	html += '</tr>';
	html += '<tr>';
	html += '	<td><b>Postcode:</b></td>';
	html += '	<td><input type="text" name="address[' + table_row + '][postcode]" value="<?php echo set_value("address[' + table_row + '][postcode]"); ?>" /></td>';
	html += '</tr>';
	html += '<tr>';
	html += '	<td><b>Country:</b></td>';
	html += '	<td><select name="address[' + table_row + '][country]">';
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $country_id) { ?>
	html += '		<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo addslashes($country['name']); ?></option>';
			<?php } else { ?>
	html += '		<option value="<?php echo $country['country_id']; ?>"><?php echo addslashes($country['name']); ?></option>';
			<?php } ?>
			<?php } ?>
	html += '	</select></td>';
	html += '</tr>';
	html += '</table>';
	html += '</div>';
	
	$('#new-address').before(html);
	
	$('.add_address').before('<li><a rel="#address' + table_row + '">Address ' + table_row + '<img src="<?php echo base_url('assets/img/delete.png'); ?>" onclick="$(\'#sub-tabs a[rel=#address1]\').trigger(\'click\'); $(\'#address' + table_row + '\').remove(); $(this).parent().parent().remove(); return false;" /></a></li>');
	
	$('#sub-tabs a').tabs();

	$('#sub-tabs a[rel="#address' + table_row + '"]').trigger('click');

	table_row++;
}

//--></script>
<script type="text/javascript"><!--
$('#tabs a').tabs();
$('#sub-tabs a').tabs();
//--></script>
