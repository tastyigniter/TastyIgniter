<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table border="0" align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Layout</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($layouts) { ?>
		<?php foreach ($layouts as $layout) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $layout['layout_id']; ?>" name="delete[]" /></td>
			<td><?php echo $layout['name']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $layout['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="3" align="center"><?php echo $text_no_layouts; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
	</div>
</div>