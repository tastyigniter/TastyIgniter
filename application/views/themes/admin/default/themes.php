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
					<th class="action"></th>
					<th>Name</th>
					<th>Location</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($themes) { ?>
				<?php foreach ($themes as $theme) { ?>
				<tr>
					<td class="action">
						<a class="edit" title="Edit" href="<?php echo $theme['edit']; ?>"></a>&nbsp;&nbsp;&nbsp;
						<?php if ($theme['default'] === '1') { ?>
							<a class="default" title="Default"></a>
						<?php } else {?>
							<a class="default-o" title="Set Default" href="<?php echo $theme['default']; ?>"></a>
						<?php } ?>
					</td>
					<td><?php echo $theme['name']; ?></td>
					<td><?php echo $theme['location']; ?></td>
				</tr>
				<?php } ?>
				<?php } else {?>
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
