<div id="content">
	<hr>
	<h2 align="center">UPDATE DEAL (<?php echo $deal_name; ?>)</h2>
	<hr>
	<form method="post" accept-charset="utf-8" action="<?php echo $action; ?>">
	<table border="0" width="50%" align="center">
		<tr>
			<td><b>Deal Name:</b></td>
	    	<td><input type="text" name="deal_name" id="name" value="<?php echo set_value('deal_name', $deal_name); ?>" class="textfield" /></td>
		</tr>
    	<tr>
    		<td><b>Deal Description:</b></td>
    		<td><textarea name="deal_description" id="description" rows="5" cols="45"><?php echo set_value('deal_description', $deal_description); ?></textarea></td>
    	</tr>
    	<tr>
    		<td><b>Deal Price:</b></td>
    		<td><input type="text" name="deal_price" id="price" value="<?php echo set_value('deal_price'), $deal_price; ?>" class="textfield" size="5"/></td>
    	</tr>
    	<tr>
    		<td><b>Start Date:</b></td>
    		<td><input type="date" name="start_date" id="start-date" value="<?php echo set_value('start_date'), $start_date; ?>" class="textfield" /></td>
    	</tr>
    	<tr>
    		<td><b>End Date:</b></td>
    		<td><input type="date" name="end_date" id="end-date" value="<?php echo set_value('end_date'), $end_date; ?>" class="textfield" /></td>
    	</tr>
    	<tr>
    		<td><b>Deal Photo:</b></td>
    		<td><input type="file" name="deal_photo" id="photo"/></td>
    	</tr>
    	<tr>
    		<td><b>Delete:</b></td>
    		<td><input type="checkbox" name="delete" value="1" /></td>
	    </tr>
		<tr>
   			<td colspan="2" align="center"><input type="submit" name="submit" value="Update" /></td>
		</tr>
	</table>
	</form>
</div>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#start-date, #end-date').datepicker({
		dateFormat: 'yy-mm-dd',
	});
});
//--></script>