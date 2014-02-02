<div class="content">
	<h2 align="center">ADD A NEW DEAL</h2>
	<?php echo form_open_multipart('admin/specials') ?>
	<table align="center">
	<tr>
		<td><b>Deal Name:</b></td>
	    <td><input type="text" name="deal_name" id="name" value="<?php echo set_value('deal_name'); ?>" class="textfield" /></td>
	</tr>
    <tr>
    	<td><b>Deal Description:</b></td>
    	<td><textarea name="deal_description" id="description" rows="5" cols="45"><?php echo set_value('deal_description'); ?></textarea></td>
    </tr>
    <tr>
    	<td><b>Deal Price:</b></td>
    	<td><input type="text" name="deal_price" id="price" value="<?php echo set_value('deal_price'); ?>" class="textfield" size="5"/></td>
    </tr>
    <tr>
    	<td><b>Start Date:</b></td>
    	<td><input type="date" name="start_date" id="start-date" value="<?php echo set_value('start_date'); ?>" class="textfield" /></td>
    </tr>
    <tr>
    	<td><b>End Date:</b></td>
    	<td><input type="date" name="end_date" id="end-date" value="<?php echo set_value('end_date'); ?>" class="textfield" /></td>
    </tr>
    <tr>
    	<td><b>Deal Photo:</b></td>
    	<td><input type="file" name="deal_photo" value="<?php echo set_value('deal_photo'); ?>" id="photo"/></td>
    </tr>
    <tr>
    	<td><b>Action:</b></td>
    	<td><input type="submit" name="submit" value="Add" /></td>
    </tr>
	</table>
	</form>
<hr>
	<h2 align="center">AVAILABLE DEALS</h2>
<hr>
	<?php echo form_open('admin/specials') ?>
	<table width="100%" align="center" class="list">
		<tr>
			<th>Deal ID</th>
			<th>Deal Photo</th>
			<th>Deal Name</th>
			<th>Deal Description</th>
			<th>Deal Price</th>
			<th>Start Date</th>
			<th>End Date</th>
			<th>Delete</th>
			<th>Action(s)</th>
		</tr>
		<?php if ($deals) {?>
		<?php foreach ($deals as $deal) { ?>
		<tr id="<?php echo $deal['deal_id']; ?>">
			<td><?php echo $deal['deal_id']; ?></td>
			<td><a href="" alt="click to view full image" target="_blank"><img src="<?php echo $deal['deal_photo']; ?>" width="80" height="70"></a></td>
			<td class="deal_name"><?php echo $deal['deal_name']; ?></td>
			<td><?php echo $deal['deal_description']; ?></td>
			<td><?php echo $deal['deal_price']; ?></td>
			<td><?php echo $deal['start_date']; ?></td>
			<td><?php echo $deal['end_date']; ?></td>
			<td><input type="checkbox" value="Delete" name="delete[<?php echo $deal['deal_id']; ?>]" /></td>
			<td>(<a class="edit" title="Edit" href="<?php echo $deal['edit']; ?>">View/</a></td>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="8" align="right"><input type="submit" name="submit" value="Delete" /></td>
			<td></td>
		</tr>
		<?php } else { ?>
		<tr>
			<td colspan="7"><?php echo $text_no_deals; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start-date, #end-date').datepicker({
		dateFormat: 'yy-mm-dd',
		showButtonPanel: false
	});
});
//--></script>