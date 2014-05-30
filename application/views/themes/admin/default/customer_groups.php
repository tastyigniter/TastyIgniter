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
			<table class="list list-height">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th>Name</th>
						<th class="id"><a href="<?php echo $sort_id; ?>">ID<i class="icon icon-sort-<?php echo ($sort_by == 'customer_group_id') ? $order_by_active : $order_by; ?>"></i></a></th>
					</tr>
				</thead>
				<tbody>
					<?php if ($customer_groups) {?>
					<?php foreach ($customer_groups as $customer_group) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $customer_group['customer_group_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="edit" title="Edit" href="<?php echo $customer_group['edit']; ?>"></a></td>
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
						<td colspan="3" align="center"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	
		<div class="pagination">
			<?php echo $pagination['links']; ?><?php echo $pagination['info']; ?>
		</div>
	</div>
	</div>
</div>