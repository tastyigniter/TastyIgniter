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
								<th class="id"><a class="sort" href="<?php echo $sort_id; ?>"><?php echo lang('column_id'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'customer_group_id') ? $order_by_active : $order_by; ?>"></i></a></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($customer_groups) {?>
							<?php foreach ($customer_groups as $customer_group) { ?>
							<tr>
								<td class="action"><input type="checkbox" value="<?php echo $customer_group['customer_group_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
									<a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $customer_group['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
								<td><?php echo $customer_group['group_name']; ?>
									<?php if ($customer_group_id === $customer_group['customer_group_id']) { ?>
										<?php echo lang('text_default'); ?>
									<?php } ?>
								</td>
								<td class="id"><?php echo $customer_group['customer_group_id']; ?></td>
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

			<div class="pagination-bar clearfix">
				<div class="links"><?php echo $pagination['links']; ?></div>
				<div class="info"><?php echo $pagination['info']; ?></div>
			</div>
		</div>
	</div>
</div>
<?php echo get_footer(); ?>