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

		<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
			<div class="filter-bar">
				<div class="form-inline">
					<div class="row">
						<div class="col-md-8">
							<div class="form-group">
								<select name="filter_type" class="form-control input-sm">
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
								</select>
							</div>
							<a class="btn btn-grey input-sm" onclick="filterList();" title="Filter"><i class="fa fa-filter"></i></a>&nbsp;
							<a class="btn btn-grey input-sm" href="<?php echo page_url(); ?>" title="Clear"><i class="fa fa-times"></i></a>
						</div>
					</div>
				</div>
			</div>
		</form>
		
		<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table class="table table-striped table-border">
				<thead>
					<tr>
						<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
						<th>Status Name</th>
						<th>Status Comment</th>
						<th>Status Type</th>
						<th class="text-center">Notify Customer</th>
					</tr>
				</thead>
				<tbody>
					<?php if ($statuses) {?>
					<?php foreach ($statuses as $status) { ?>
					<tr>
						<td class="action"><input type="checkbox" value="<?php echo $status['status_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
							<a class="btn btn-edit" title="Edit" href="<?php echo $status['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
						<td><?php echo $status['status_name']; ?></td>
						<td><?php echo $status['status_comment']; ?></td>
						<td><?php echo $status['status_for']; ?></td>
						<td class="text-center"><?php echo $status['notify_customer']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="5"><?php echo $text_empty; ?></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</form>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>
<?php echo $footer; ?>