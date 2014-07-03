<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div id="notification">
			<div class="alert alert-dismissable">
				<?php if (!empty($alert)) { ?>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<?php echo $alert; ?>
				<?php } ?>
				<?php if (validation_errors()) { ?>
					<p class="alert-danger">Sorry but validation has failed, please check for errors.</p>
				<?php } ?>
			</div>
		</div>

		<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table border="0" class="table table-striped table-border">
				<thead>
					<tr>
						<th class="action action-one"></th>
						<th class="action action-one text-center">Status</th>
						<th>Name</th>
						<th class="id">ID</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($extensions) { ?>
					<?php foreach ($extensions as $extension) { ?>
					<tr>
						<td class="action action-one text-center">
							<?php if ($extension['action'] === 'uninstall') {?>
								<a class="btn btn-edit" title="Edit" href="<?php echo $extension['edit']; ?>"><i class="fa fa-pencil"></i></a>
							<?php } ?>
						</td>
						<td class="action action-one text-center">
							<?php if ($extension['action'] === 'uninstall') {?>
								<a class="btn btn-times" title="Uninstall" href="<?php echo $extension['manage']; ?>"><i class="fa fa-times"></i></a>
							<?php } else if ($extension['action'] === 'install') {?>
								<a class="btn btn-enable" title="Install" href="<?php echo $extension['manage']; ?>"><i class="fa fa-check"></i></a>
							<?php } ?>
						</td>
						<td><?php echo $extension['name']; ?></td>
						<td class="id"><?php echo $extension['extension_id']; ?></td>
					</tr>
					<?php } ?>
					<?php } else {?>
					<tr>
						<td colspan="4"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	</div>
</div>
<?php echo $footer; ?>