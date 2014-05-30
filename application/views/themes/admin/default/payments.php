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
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($payments) { ?>
				<?php foreach ($payments as $payment) { ?>
				<tr>
					<td class="action">
					<?php if (isset($payment['edit'])) {?>
						<a class="edit" title="Edit" href="<?php echo $payment['edit']; ?>"></a>
					<?php } ?>&nbsp;&nbsp;
					<?php if (isset($payment['uninstall'])) {?>
						<a class="uninstall" title="Uninstall" href="<?php echo $payment['uninstall']; ?>"></a>
					<?php } ?>
					<?php if (isset($payment['install'])) {?>
						<a class="install" title="Install" href="<?php echo $payment['install']; ?>"></a>
					<?php } ?>
					</td>
					<td><?php echo $payment['name']; ?></td>
					<td></td>
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
