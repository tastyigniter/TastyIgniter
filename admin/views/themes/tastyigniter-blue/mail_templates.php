<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Mail Template List</h3>
			</div>
			<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
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
										<a class="btn btn-info" title="Default" disabled="disabled"><i class="fa fa-star"></i></a>
									<?php } else {?>
										<a class="btn btn-info" title="Set Default" href="<?php echo $template['default']; ?>"><i class="fa fa-star-o"></i></a>
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
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>