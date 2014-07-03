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
			<table class="table table-striped table-border">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th>Name</th>
						<th class="id"><a class="sort" href="<?php echo $sort_id; ?>">ID<i class="fa fa-sort-<?php echo ($sort_by == 'customer_group_id') ? $order_by_active : $order_by; ?>"></i></a></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($customer_groups) {?>
					<?php foreach ($customer_groups as $customer_group) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $customer_group['customer_group_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="btn btn-edit" title="Edit" href="<?php echo $customer_group['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
						<td><?php echo $customer_group['group_name']; ?>
							<?php if ($customer_group_id === $customer_group['customer_group_id']) { ?>
								<b>(Default)</b>
							<?php } ?>
						</td>
						<td class="id"><?php echo $customer_group['customer_group_id']; ?></td>
					</tr>
					<?php } ?>
					<?php } else {?>
					<tr>
						<td colspan="3"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	
		<div class="pagination-bar clearfix">
			<div class="links"><?php echo $pagination['links']; ?></div>
			<div class="info"><?php echo $pagination['info']; ?></div>
		</div>
	</div>
</div>
<?php echo $footer; ?>