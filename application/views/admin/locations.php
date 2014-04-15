<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table border="0" align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Name</th>
			<th>City</th>
			<th>Postcode</th>
			<th>Telephone</th>
			<th>Status</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($locations) { ?>
		<?php foreach ($locations as $location) { ?>
		<tr>
			<td><input type="checkbox" value="<?php echo $location['location_id']; ?>" name="delete[]" /></td>
			<td><?php echo $location['location_name']; ?>
				<?php if ($default_location_id === $location['location_id']) { ?>
				<b>(Default)</b>
				<?php } ?>
			</td>
			<td><?php echo $location['location_city']; ?></td>
			<td><?php echo $location['location_postcode']; ?></td>
			<td><?php echo $location['location_telephone']; ?></td>
			<td><?php echo ($location['location_status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $location['edit']; ?>"></a></td>
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