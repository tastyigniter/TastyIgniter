<div id="box-content">
	<div id="notification">
		<?php if (validation_errors()) { ?>
			<?php echo validation_errors('<span class="error">', '</span>'); ?>
		<?php } ?>
		<?php if (!empty($alert)) { ?>
			<?php echo $alert; ?>
		<?php } ?>
	</div>

	<div class="box">
	<div id="list-box" class="content">
	<form id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<table border="0" align="center" class="list list-height">
			<thead>
				<tr>
					<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
					<th>Layout</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($layouts) { ?>
				<?php foreach ($layouts as $layout) { ?>
				<tr>
					<td class="action"><input type="checkbox" value="<?php echo $layout['layout_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
						<a class="edit" title="Edit" href="<?php echo $layout['edit']; ?>"></a></td>
					<td><?php echo $layout['name']; ?></td>
					<td></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="3" align="center"><?php echo $text_empty; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</form>
	</div>
	</div>
</div>