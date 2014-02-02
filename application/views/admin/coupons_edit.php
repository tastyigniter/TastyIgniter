<div class="box">
	<div id="update-box" class="content">
	<h2>UPDATE: <?php echo $name; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
		<tr>
			<td><b>Coupon Name:</b></td>
			<td><input type="text" name="name" value="<?php echo set_value('name', $name); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Coupon Code:</b></td>
			<td><input type="text" name="code" value="<?php echo set_value('code', $code); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Coupon Type:</b></td>
			<td><select name="type">
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
			</select></td>
		</tr>
		<tr>
			<td><b>Coupon Discount:</b></td>
			<td><input type="text"  name="discount" value="<?php echo set_value('discount', $discount); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Minimum Total:</b></td>
			<td><input type="text"  name="min_total" value="<?php echo set_value('min_total', $min_total); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Coupon Description:</b></td>
			<td><textarea name="description" cols="50" rows="7"><?php echo set_value('description', $description); ?></textarea></td>
		</tr>
		<tr>
			<td><b>Start Date:</b></td>
			<td><input type="text"  name="start_date" id="start-date" value="<?php echo set_value('start_date', $start_date); ?>" class="textfield" size="10" /></td>
		</tr>
		<tr>
			<td><b>End Date:</b></td>
			<td><input type="text"  name="end_date" id="end-date" value="<?php echo set_value('end_date', $end_date); ?>" class="textfield" size="10" /></td>
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
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start-date, #end-date').datepicker({
		dateFormat: 'yy-mm-dd',
	});
});
//--></script>
