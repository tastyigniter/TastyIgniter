<div class="box">
	<div id="update-box" class="content">
	<h2>UPDATE: <?php echo $table_name; ?></h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="updateForm">
	<table class="form">
		<tr>
    		<td><b>Name:</b></td>
    		<td><input type="text" name="table_name" value="<?php echo set_value('table_name', $table_name); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Minimum:</b></td>
    		<td><input type="text" name="min_capacity" value="<?php echo set_value('min_capacity', $min_capacity); ?>" class="textfield" /></td>
		</tr>
 		<tr>
    		<td><b>Capacity:</b></td>
    		<td><input type="text" name="max_capacity" value="<?php echo set_value('max_capacity', $max_capacity); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="table_status">
	   			<option value="0" <?php echo set_select('table_status', '0'); ?> >Disabled</option>
     		<?php if ($table_status === '1') { ?>
    			<option value="1" <?php echo set_select('table_status', '1', TRUE); ?> >Enabled</option>
			<?php } else { ?>  
    			<option value="1" <?php echo set_select('table_status', '1'); ?> >Enabled</option>
			<?php } ?>  
    		</select></td>
		</tr>
	</table>
	</form>
	</div>
	
</div>