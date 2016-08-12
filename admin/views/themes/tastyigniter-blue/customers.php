<?php echo get_header(); ?>
<div class="row content">
	<div class="col-md-12">
		<div class="panel panel-default panel-table">
			<div class="panel-body panel-filter">
				<form role="form" id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
					<div class="filter-bar">
						<div class="form-inline">
							<div class="row">
								<div class="col-md-3 pull-right text-right">
									<div class="form-group">
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="<?php echo lang('text_filter_search'); ?>" />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_search'); ?>"><i class="fa fa-search"></i></a>
								</div>

								<div class="col-md-8 pull-left">
									<div class="form-group">
										<select name="filter_date" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_date'); ?></option>
											<?php foreach ($customer_dates as $key => $value) { ?>
											<?php if ($key == $filter_date) { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
											<?php } ?>
											<?php } ?>
										</select>&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_status" class="form-control input-sm">
											<option value=""><?php echo lang('text_filter_status'); ?></option>
										<?php if ($filter_status === '1') { ?>
											<option value="1" <?php echo set_select('filter_status', '1', TRUE); ?> ><?php echo lang('text_enabled'); ?></option>
											<option value="0" <?php echo set_select('filter_status', '0'); ?> ><?php echo lang('text_disabled'); ?></option>
										<?php } else if ($filter_status === '0') { ?>
											<option value="1" <?php echo set_select('filter_status', '1'); ?> ><?php echo lang('text_enabled'); ?></option>
											<option value="0" <?php echo set_select('filter_status', '0', TRUE); ?> ><?php echo lang('text_disabled'); ?></option>
										<?php } else { ?>
											<option value="1" <?php echo set_select('filter_status', '1'); ?> ><?php echo lang('text_enabled'); ?></option>
											<option value="0" <?php echo set_select('filter_status', '0'); ?> ><?php echo lang('text_disabled'); ?></option>
										<?php } ?>
										</select>
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="<?php echo lang('text_filter'); ?>"><i class="fa fa-filter"></i></a>&nbsp;
									<a class="btn btn-grey" href="<?php echo page_url(); ?>" title="<?php echo lang('text_clear'); ?>"><i class="fa fa-times"></i></a>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>

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
							<th><a class="sort" href="<?php echo $sort_first_name; ?>"><?php echo lang('column_first_name'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'first_name') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_last_name; ?>"><?php echo lang('column_last_name'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'last_name') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><a class="sort" href="<?php echo $sort_email; ?>"><?php echo lang('column_email'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'email') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th><?php echo lang('column_telephone'); ?></th>
							<th><a class="sort" href="<?php echo $sort_date_added; ?>"><?php echo lang('column_date_added'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th class="text-center"><?php echo lang('column_status'); ?></th>
							<th class="id"><a class="sort" href="<?php echo $sort_customer_id; ?>"><?php echo lang('column_id'); ?><i class="fa fa-sort-<?php echo ($sort_by == 'customer_id') ? $order_by_active : $order_by; ?>"></i></a></th>
						</tr>
					</thead>
					<tbody>
					<?php if ($customers) { ?>
					<?php foreach ($customers as $customer) { ?>
					<tr>
						<td class="action">
							<div class="checkbox checkbox-primary">
								<input type="checkbox" class="styled" id="checkbox-<?php echo $customer['customer_id']; ?>" value="<?php echo $customer['customer_id']; ?>" name="delete[]" />
								<label for="checkbox-<?php echo $customer['customer_id']; ?>"></label>
							</div>
							<a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $customer['edit']; ?>"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
							<a class="btn btn-info <?php echo empty($access_customer_account) ? 'disabled' : ''; ?>" title="<?php echo lang('text_login_as_customer'); ?>" href="<?php echo $customer['login']; ?>" target="_blank"><i class="fa fa-user"></i>&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></a>
						</td>
						<td><?php echo $customer['first_name']; ?></td>
						<td><?php echo $customer['last_name']; ?></td>
						<td><?php echo $customer['email']; ?></td>
						<td><?php echo $customer['telephone']; ?></td>
						<td><?php echo $customer['date_added']; ?></td>
						<td class="text-center"><?php echo ($customer['status'] === '1') ? lang('text_enabled') : lang('text_disabled'); ?></td>
						<td class="id"><?php echo $customer['customer_id']; ?></td>
					</tr>
					<?php } ?>
					<?php } else { ?>
					<tr>
						<td colspan="8"><?php echo lang('text_empty'); ?></td>
					</tr>
					<?php } ?>
					</tbody>
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