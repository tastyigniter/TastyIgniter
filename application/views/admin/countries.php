<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD A NEW COUNTRY</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form" width="">
		<tr>
			<td><b>Country:</b></td>
			<td><input type="text" name="country_name" value="<?php echo set_value('country_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>ISO Code (2):</b></td>
			<td><input type="text" name="iso_code_2" value="<?php echo set_value('iso_code_2'); ?>" class="textfield" size="5" /></td>
		</tr>
		<tr>
			<td><b>ISO Code (3):</b></td>
			<td><input type="text" name="iso_code_3" value="<?php echo set_value('iso_code_3'); ?>" class="textfield" size="5" /></td>
		</tr>
		<tr>
			<td><b>Format:</b></td>
			<td><textarea name="format" cols="50" rows="7"><?php echo set_value('format'); ?></textarea></td>
		</tr>
		<tr>
			<td><b>Status:</b></td>
			<td><select name="status">
				<option value="1" <?php echo set_select('status', '1', TRUE); ?> >Enabled</option>
				<option value="0" <?php echo set_select('status', '0'); ?> >Disabled</option>
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
			<th>Country</th>
			<th>Status</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($countries) {?>
		<?php foreach ($countries as $country) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $country['country_id']; ?>" name="delete[]" /></td>
			<td><?php echo $country['name']; ?></td>
			<td><?php echo ($country['status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $country['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="6"><?php echo $text_empty; ?></td>
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
