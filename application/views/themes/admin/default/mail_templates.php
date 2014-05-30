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
					<th class="action action-three"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
					<th class="left" width="50%">Name</th>
					<th class="right">Date Added</th>
					<th class="right">Date Updated</th>
					<th class="right">Status</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($templates) { ?>
				<?php foreach ($templates as $template) { ?>
				<tr>
					<td class="action action-three"><input type="checkbox" value="<?php echo $template['template_id']; ?>" name="delete[]" />&nbsp;&nbsp;
						<?php if ($template['default'] === '1') { ?>
							<a class="default" title="Default"></a>
						<?php } else {?>
							<a class="default-o" title="Set Default" href="<?php echo $template['default']; ?>"></a>
						<?php } ?>&nbsp;&nbsp;
						<a class="edit" title="Edit" href="<?php echo $template['edit']; ?>"></a></td>
					<td class="left"><?php echo $template['name']; ?></td>
					<td class="right"><?php echo $template['date_added']; ?></td>
					<td class="right"><?php echo $template['date_updated']; ?></td>
					<td class="right"><?php echo $template['status']; ?></td>
				</tr>
				<?php } ?>
				<?php } else {?>
				<tr>
					<td colspan="5" align="center"><?php echo $text_empty; ?></td>
				</tr>
				<?php } ?>
			<tbody>
		</table>
	</form>
	</div>
	</div>
</div>
