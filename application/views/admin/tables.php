<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
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
			<td colspan="6" align="center"><?php echo $text_empty; ?></td>
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
