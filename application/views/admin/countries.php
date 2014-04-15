<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Country</th>
			<th class="right">Status</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($countries) {?>
		<?php foreach ($countries as $country) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $country['country_id']; ?>" name="delete[]" /></td>
			<td><?php echo $country['name']; ?>
				<?php if ($country_id === $country['country_id']) { ?>
				<b>(Default)</b>
				<?php } ?>
			</td>
			<td class="right"><?php echo ($country['status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $country['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="4" align="center"><?php echo $text_empty; ?></td>
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
