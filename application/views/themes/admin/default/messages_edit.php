<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table class="form">
		<tbody>
			<tr>
				<td><b>From:</b></td>
				<td><select name="sender">
					<?php foreach ($locations as $location) { ?>
					<?php if ($location['location_id'] === $default_location_id) { ?>
						<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('sender', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
					<?php } else { ?>  
						<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('sender', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
					<?php } ?>  
					<?php } ?>  
				</select></td>
			</tr>
			<tr>
				<td><b>To:</b></td>
				<td><select name="receiver">
					<option value="customers">All Customers</option>
					<option value="staffs">All Staffs</option>
				</select></td>
			</tr>
			<tr>
				<td width="15%"><b>Subject:</b></td>
				<td><input type="text" name="subject" value="<?php echo set_value('subject'); ?>" class="textfield" size="40" /></td>
			</tr>
			<tr>
				<td><b>Text:</b></td>
				<td><textarea name="body" style="height:300px;width:800px;"><?php echo set_value('body'); ?></textarea></td>
			</tr>
		</tbody>
  	</table>
	</form>

	</div>
</div>
<script src="<?php echo base_url("assets/js/ckeditor/ckeditor.js"); ?>"></script>
<script type="text/javascript"><!--
window.onload = function() {
    CKEDITOR.replace('body');
};
//--></script>