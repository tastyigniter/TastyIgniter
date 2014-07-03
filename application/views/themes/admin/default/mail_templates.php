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
						<th class="action action-three"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th width="50%">Name</th>
						<th class="text-right">Date Added</th>
						<th class="text-right">Date Updated</th>
						<th class="text-right">Status</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($templates) { ?>
					<?php foreach ($templates as $template) { ?>
					<tr>
						<td class="action action-three"><input type="checkbox" value="<?php echo $template['template_id']; ?>" name="delete[]" />&nbsp;&nbsp;
							<a class="btn btn-edit" title="Edit" href="<?php echo $template['edit']; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
							<?php if ($template['default'] === '1') { ?>
								<a class="btn btn-favorite" title="Default"><i class="fa fa-star"></i></a>
							<?php } else {?>
								<a class="btn btn-favorite-o" title="Set Default" href="<?php echo $template['default']; ?>"><i class="fa fa-star-o"></i></a>
							<?php } ?>
						</td>
						<td><?php echo $template['name']; ?></td>
						<td class="text-right"><?php echo $template['date_added']; ?></td>
						<td class="text-right"><?php echo $template['date_updated']; ?></td>
						<td class="text-right"><?php echo $template['status']; ?></td>
					</tr>
					<?php } ?>
					<?php } else {?>
					<tr>
						<td colspan="5"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				<tbody>
			</table>
		</form>
	</div>
</div>
<?php echo $footer; ?>