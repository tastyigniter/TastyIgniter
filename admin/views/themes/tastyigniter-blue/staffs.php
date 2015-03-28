<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Staff List</h3>
				<div class="pull-right">
					<button class="btn btn-default btn-xs btn-filter"><i class="fa fa-filter"></i></button>
				</div>
			</div>
			<div class="panel-body panel-filter">
				<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
					<div class="filter-bar">
						<div class="form-inline">
							<div class="row">
								<div class="col-md-3 pull-right text-right">
									<div class="form-group">
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search location, name or email." />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
								</div>

								<div class="col-md-8 pull-left">
									<div class="form-group">
										<select name="filter_group" class="form-control input-sm">
											<option value="">View all groups</option>
											<?php foreach ($staff_groups as $group) { ?>
											<?php if ($group['staff_group_id'] === $filter_group) { ?>
												<option value="<?php echo $group['staff_group_id']; ?>" <?php echo set_select('filter_group', $group['staff_group_id'], TRUE); ?> ><?php echo $group['staff_group_name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $group['staff_group_id']; ?>" <?php echo set_select('filter_group', $group['staff_group_id']); ?> ><?php echo $group['staff_group_name']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_location" class="form-control input-sm">
											<option value="">View all locations</option>
											<?php foreach ($locations as $location) { ?>
											<?php if ($location['location_id'] === $filter_location) { ?>
												<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
											<?php } else { ?>
												<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('filter_location', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
											<?php } ?>
											<?php } ?>
										</select>&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_date" class="form-control input-sm">
											<option value="">View all dates</option>
											<?php foreach ($staff_dates as $key => $value) { ?>
											<?php if ($key === $filter_date) { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
											<?php } ?>
											<?php } ?>
										</select>&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_status" class="form-control input-sm">
											<option value="">View all status</option>
											<?php if ($filter_status === '1') { ?>
												<option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> >Enabled</option>
												<option value="0" <?php echo set_select('filter_status', '0'); ?> >Disabled</option>
											<?php } else if ($filter_status === '0') { ?>
												<option value="1" <?php echo set_select('filter_status', '1'); ?> >Enabled</option>
												<option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> >Disabled</option>
											<?php } else { ?>
												<option value="1" <?php echo set_select('filter_status', '1'); ?> >Enabled</option>
												<option value="0" <?php echo set_select('filter_status', '0'); ?> >Disabled</option>
											<?php } ?>
										</select>
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="Filter"><i class="fa fa-filter"></i></a>&nbsp;
									<a class="btn btn-grey" href="<?php echo page_url(); ?>" title="Clear"><i class="fa fa-times"></i></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

			<form role="form" id="list-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
					<table border="0" class="table table-striped table-border">
						<thead>
							<tr>
								<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
								<!--<th><a class="sort" href="<?php echo $sort_location; ?>">Location<i class="fa fa-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>-->
								<th><a class="sort" href="<?php echo $sort_name; ?>">Name<i class="fa fa-sort-<?php echo ($sort_by == 'staff_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th>Email</th>
								<th><a class="sort" href="<?php echo $sort_group; ?>">Staff Group<i class="fa fa-sort-<?php echo ($sort_by == 'staff_group_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_location; ?>">Location<i class="fa fa-sort-<?php echo ($sort_by == 'location_name') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th><a class="sort" href="<?php echo $sort_date; ?>">Date Added<i class="fa fa-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
								<th class="text-center">Status</th>
								<th><a class="sort" href="<?php echo $sort_id; ?>">ID<i class="fa fa-sort-<?php echo ($sort_by == 'staff_id') ? $order_by_active : $order_by; ?>"></i></a></th>
							</tr>
						</thead>
						<tbody>
							<?php if ($staffs) { ?>
							<?php foreach ($staffs as $staff) { ?>
							<tr>
								<td class="action"><input type="checkbox" value="<?php echo $staff['staff_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
									<a class="btn btn-edit" title="Edit" href="<?php echo $staff['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
								<!--<td><?php echo $staff['location_name']; ?></td>-->
								<td><?php echo $staff['staff_name']; ?></td>
								<td><?php echo $staff['staff_email']; ?></td>
								<td><?php echo $staff['staff_group_name']; ?></td>
								<td><?php echo $staff['location_name']; ?></td>
								<td><?php echo $staff['date_added']; ?></td>
								<td class="text-center"><?php echo $staff['staff_status']; ?></td>
								<td class="id"><?php echo $staff['staff_id']; ?></td>
							</tr>
							<?php } ?>
							<?php } else {?>
							<tr>
								<td colspan="7"><?php echo $text_empty; ?></td>
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
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>
<?php echo $footer; ?>