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
		<form id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
		<div class="filter_heading">
			<div class="left">
				<select name="filter_type">
					<option value="">View all status types</option>
					<?php if ($filter_type === 'order') { ?>
						<option value="order" <?php echo set_select('filter_type', 'order', TRUE); ?> >Order</option>
						<option value="reserve" <?php echo set_select('filter_type', 'reserve'); ?> >Reservations</option>
					<?php } else if ($filter_type === 'reserve') { ?>  
						<option value="order" <?php echo set_select('filter_type', 'order'); ?> >Order</option>
						<option value="reserve" <?php echo set_select('filter_type', 'reserve', TRUE); ?> >Reservations</option>
					<?php } else { ?>  
						<option value="order" <?php echo set_select('filter_type', 'order'); ?> >Order</option>
						<option value="reserve" <?php echo set_select('filter_type', 'reserve'); ?> >Reservations</option>
					<?php } ?>  
				</select>&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-filter"></i></a>&nbsp;
				<a class="grey_icon" href="<?php echo page_url(); ?>"><i class="icon icon-cancel"></i></a>
			</div>
		</div>
		</form>
		
		<form id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table align="center" class="list list-height">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th>Status Name</th>
						<th>Status Comment</th>
						<th>Status Type</th>
						<th class="center">Notify Customer</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($statuses) {?>
					<?php foreach ($statuses as $status) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $status['status_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="edit" title="Edit" href="<?php echo $status['edit']; ?>"></a></td>
						<td><?php echo $status['status_name']; ?></td>
						<td><?php echo $status['status_comment']; ?></td>
						<td><?php echo $status['status_for']; ?></td>
						<td class="center"><?php echo $status['notify_customer']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="5" align="center"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}

$('#tabs a').tabs();
//--></script>