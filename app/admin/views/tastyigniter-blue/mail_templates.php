<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table border="0" class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action action-three">
									<div class="checkbox checkbox-primary">
										<input type="checkbox" id="checkbox-all" class="styled" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
										<label for="checkbox-all"></label>
									</div>
								</th>
								<th width="50%"><?php echo lang('column_name'); ?></th>
								<th class="text-right"><?php echo lang('column_date_added'); ?></th>
								<th class="text-right"><?php echo lang('column_date_updated'); ?></th>
								<th class="text-right"><?php echo lang('column_status'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($templates) { ?>
							<?php foreach ($templates as $template) { ?>
							<tr>
								<td class="action action-three">
									<div class="checkbox checkbox-primary">
										<input type="checkbox" class="styled" id="checkbox-<?php echo $template['template_id']; ?>" value="<?php echo $template['template_id']; ?>" name="delete[]" />
										<label for="checkbox-<?php echo $template['template_id']; ?>"></label>
									</div>
									<a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $template['edit']; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
									<?php if ($template['default'] == '1') { ?>
										<a class="btn btn-info" title="<?php echo lang('text_is_default'); ?>" disabled="disabled"><i class="fa fa-star"></i></a>
									<?php } else {?>
										<a class="btn btn-info" title="<?php echo lang('text_set_default'); ?>" href="<?php echo $template['default']; ?>"><i class="fa fa-star-o"></i></a>
									<?php } ?>
								</td>
								<td><?php echo $template['name']; ?></td>
								<td class="text-right"><?php echo $template['date_added']; ?></td>
								<td class="text-right"><?php echo $template['date_updated']; ?></td>
								<td class="text-center"><?php echo ($template['status'] == '1') ? lang('text_enabled') : lang('text_disabled'); ?></td>
							</tr>
							<?php } ?>
							<?php } else {?>
							<tr>
								<td colspan="5"><?php echo lang('text_empty'); ?></td>
							</tr>
							<?php } ?>
						<tbody>
					</table>
				</div>
			</form>

			<div class="pagination-bar row">
				<div class="links col-sm-8"><?php echo $pagination['links']; ?></div>
				<div class="info col-sm-4"><?php echo $pagination['info']; ?></div>
			</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>