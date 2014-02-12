<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Name</th>
			<th>Price</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($menu_options) {?>
		<?php foreach ($menu_options as $menu_option) { ?>
		<tr>
			<td><input type="checkbox" value="<?php echo $menu_option['option_id']; ?>" name="delete[]" /></td>
			<td><?php echo $menu_option['option_name']; ?></td>
			<td><?php echo $menu_option['option_price']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $menu_option['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="7"><?php echo $text_empty; ?></td>
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
