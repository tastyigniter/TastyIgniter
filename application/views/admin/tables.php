<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD A NEW TABLE</h2>
	<p>If Minimum is set to 2 and Capacity is set to 4 then only reservation for 2, 3 or 4 people will be accepted for this table.</p>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
			<td><b>Name/No</b></td>
			<td><input type="text" name="table_name" value="<?php echo set_value('table_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Minimum</b></td>
			<td><input type="text" name="min_capacity" value="<?php echo set_value('min_capacity'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Capacity</b></td>
			<td><input type="text" name="max_capacity" value="<?php echo set_value('max_capacity'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="table_status">
    			<option value="0" <?php echo set_select('table_status', '0'); ?> >Disabled</option>
    			<option value="1" <?php echo set_select('table_status', '1'); ?> >Enabled</option>
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
			<th>Minimum</th>
			<th>Capacity</th>
			<th>Status</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($tables) {?>
		<?php foreach ($tables as $table) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $table['table_id']; ?>" name="delete[]" /></td>
			<td><?php echo $table['table_name']; ?></td>
			<td><?php echo $table['min_capacity']; ?></td>
			<td><?php echo $table['max_capacity']; ?></td>
			<td><?php echo $table['table_status']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $table['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="6">There are no tables added to your database.</td>
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
