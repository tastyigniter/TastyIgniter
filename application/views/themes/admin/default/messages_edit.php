<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table class="form" id="message-table">
		<tbody>
			<tr>
				<td><b>To:</b></td>
				<td><select name="recipient">
					<option value="all_newsletters">All Newsletter Subscribers</option>
					<option value="all_customers">All Customers</option>
					<option value="customer_group">Customer Group</option>
					<option value="customers">Customers</option>
					<option value="all_staffs">All Staffs</option>
					<option value="staff_group">Staff Group</option>
					<option value="staffs">Staffs</option>
				</select></td>
			</tr>
		</tbody>
		<tbody id="recipient-customer-group" class="recipient">
            <tr>
            	<td><b>Customer Group:</b></td>
              	<td><select name="customer_group_id">
            	<?php foreach ($customer_groups as $customer_group) { ?>
    				<option value="<?php echo $customer_group['customer_group_id']; ?>" <?php echo set_select('customer_group_id', $customer_group['customer_group_id']); ?>><?php echo $customer_group['group_name']; ?></option>
                <?php } ?>
                </select></td>
            </tr>
		</tbody>
		<tbody id="recipient-staff-group" class="recipient">
            <tr>
            	<td><b>Staff Group:</b></td>
              	<td><select name="staff_group_id">
            	<?php foreach ($staff_groups as $staff_group) { ?>
    				<option value="<?php echo $staff_group['staff_group_id']; ?>" <?php echo set_select('staff_group_id', $staff_group['staff_group_id']); ?>><?php echo $staff_group['staff_group_name']; ?></option>
                <?php } ?>
                </select></td>
            </tr>
		</tbody>
		<tbody id="recipient-customers" class="recipient">
			<tr>
				<td><b>Customers:</b></td>
				<td><input type="text" name="customer" value="" placeholder="Start typing customer name..." /></td>
			</tr>
			<tr id="customers-box">
				<td></td>
				<td><div class="selectbox mini-selectbox">
					<table class="list">
						<tbody></tbody>
					</table>
				</div></td>
			</tr>
		</tbody>
		<tbody id="recipient-staffs" class="recipient">
			<tr>
				<td><b>Staffs:</b></td>
				<td><input type="text" name="staff" value="" placeholder="Start typing staff name..." /></td>
			</tr>
			<tr id="staffs-box">
				<td></td>
				<td><div class="selectbox mini-selectbox">
					<table class="list">
						<tbody></tbody>
					</table>
				</div></td>
			</tr>
		</tbody>
		<tbody id="send-type" class="">
			<tr>
				<td><b>Send Type:</b></td>
				<td><select name="send_type">
					<option value="account" <?php echo set_select('send_type', 'account'); ?> >Account</option>
					<option value="email" <?php echo set_select('send_type', 'email'); ?> >Email</option>
				</select></td>
			</tr>
		</tbody>
		<tbody>
			<tr>
				<td><b>Subject:</b></td>
				<td><input type="text" name="subject" value="<?php echo set_value('subject'); ?>" class="textfield" size="40" /></td>
			</tr>
			<tr>
				<td><b>Body:</b></td>
				<td><textarea name="body" style="height:300px;width:800px;"><?php echo set_value('body'); ?></textarea></td>
			</tr>
		</tbody>
  	</table>
	</form>
	</div>
	</div>
</div>
<script src="<?php echo base_url("assets/js/ckeditor/ckeditor.js"); ?>"></script>
<script type="text/javascript"><!--
window.onload = function() {
    CKEDITOR.replace('body');
};
//--></script>
<script type="text/javascript"><!--	
$('select[name="recipient"]').on('change', function() {
	$('#message-table .recipient').hide();
	
	$('#message-table #recipient-' + $(this).val().replace('_', '-')).show();
});

$('select[name=\'recipient\']').trigger('change');
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'customer\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/customers/autocomplete"); ?>?customer_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.customer_name,
						value: item.customer_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#customer' + ui.item.value).remove();
		$('#customers-box table tbody').append('<tr id="customer' + ui.item.value + '"><td class="name">' + ui.item.label + '</td><td class="img">' + '<a><i class="icon icon-delete" onclick="$(this).parent().parent().remove();"></i></a>' + '<input type="hidden" name="customers[]" value="' + ui.item.value + '" /></td></tr>');

		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'staff\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/staffs/autocomplete"); ?>?staff_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.staff_name,
						value: item.staff_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#staff' + ui.item.value).remove();
		$('#staffs-box table tbody').append('<tr id="staff' + ui.item.value + '"><td class="name">' + ui.item.label + '</td><td class="img">' + '<a><i class="icon icon-delete" onclick="$(this).parent().parent().remove();"></i></a>' + '<input type="hidden" name="staffs[]" value="' + ui.item.value + '" /></td></tr>');

		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>