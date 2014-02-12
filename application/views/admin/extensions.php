<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table border="0" align="center" class="list">
		<tr>
			<th>Module Name</th>
			<th class="right" width="10%" colspan="2">Action</th>
		</tr>
		<?php if ($extensions) { ?>
		<?php foreach ($extensions as $extension) { ?>
		<tr>
			<td><?php echo $extension['name']; ?></td>
			<td class="right" width="5%">
			<?php if (isset($extension['uninstall'])) {?>
				<a class="uninstall" title="Uninstall" href="<?php echo $extension['uninstall']; ?>"></a>
			<?php } ?>
			<?php if (isset($extension['install'])) {?>
				<a class="install" title="Install" href="<?php echo $extension['install']; ?>"></a>
			<?php } ?>
			</td>
			<td class="right" width="5%">
			<?php if (isset($extension['edit'])) {?>
				<a class="edit" title="Edit" href="<?php echo $extension['edit']; ?>"></a>
			<?php } ?>
			</td>
		</tr>
		<?php } ?>
		<?php } else {?>
		<tr>
			<td colspan="3" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>
	</div>
</div>
