<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo lang('text_list'); ?></h3>
			</div>
			<form role="form" id="list-form" accept-charset="utf-8" method="POST" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
								<th><?php echo lang('column_name'); ?></th>
								<th class="text-center"><?php echo lang('column_users'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($staff_groups) {?>
							<?php foreach ($staff_groups as $staff_group) { ?>
							<tr>
								<td class="action"><input type="checkbox" value="<?php echo $staff_group['staff_group_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
									<a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $staff_group['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
								<td><?php echo $staff_group['staff_group_name']; ?></td>
								<td class="text-center"><?php echo $staff_group['users_count']; ?></td>
							</tr>
							<?php } ?>
							<?php } else {?>
							<tr>
								<td colspan="3"><?php echo lang('text_empty'); ?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</form>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>