<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD A NEW COUPON</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form" width="">
		<tr>
			<td><b>Coupon Name:</b></td>
			<td><input type="text" name="name" value="<?php echo set_value('name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Coupon Code:</b></td>
			<td><input type="text" name="code" value="<?php echo set_value('code'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Coupon Type:</b></td>
			<td><select name="type">
				<option value="F" <?php echo set_select('type', 'F'); ?> >Fixed Amount</option>
				<option value="P" <?php echo set_select('type', 'P'); ?> >Percentage</option>
			</select></td>
		</tr>
		<tr>
			<td><b>Coupon Discount:</b></td>
			<td><input type="text"  name="discount" value="<?php echo set_value('discount'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Minimum Total:</b></td>
			<td><input type="text"  name="min_total" value="<?php echo set_value('min_total'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Coupon Description:</b></td>
			<td><textarea name="description" cols="50" rows="7"><?php echo set_value('description'); ?></textarea></td>
		</tr>
		<tr>
			<td><b>Start Date:</b></td>
			<td><input type="text"  name="start_date" id="start-date" value="<?php echo set_value('start_date'); ?>" class="textfield" size="10" /></td>
		</tr>
		<tr>
			<td><b>End Date:</b></td>
			<td><input type="text"  name="end_date" id="end-date" value="<?php echo set_value('end_date'); ?>" class="textfield" size="10" /></td>
		</tr>
		<tr>
			<td><b>Status:</b></td>
			<td><select name="status">
				<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
				<option value="1" <?php echo set_select('status', '1'); ?> >Enabled</option>
			</select></td>
		</tr>
  	</table>
	</form>
	</div>
	
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Name</th>
			<th>Code</th>
			<th>Type</th>
			<th>Discount</th>
			<th class="right">Status</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($coupons) {?>
		<?php foreach ($coupons as $coupon) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $coupon['coupon_id']; ?>" name="delete[]" /></td>
			<td><?php echo $coupon['name']; ?></td>
			<td><?php echo $coupon['code']; ?></td>
			<td><?php echo $coupon['type']; ?></td>
			<td><?php echo $coupon['discount']; ?></td>
			<td class="right"><?php echo ($coupon['status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $coupon['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="7" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>

	<div class="pagination">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div> 
	</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start-date, #end-date').datepicker({
		dateFormat: 'yy-mm-dd',
	});
});
//--></script>