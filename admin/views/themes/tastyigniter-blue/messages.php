<?php echo $header; ?>
<div class="row content">
	<div class="col-md-12">
		<div class="row wrap-vertical">
			<ul id="nav-tabs" class="nav nav-tabs">
				<?php foreach ($labels as $key => $value) { ?>
					<?php if ($key === $filter_label) { ?>
						<li class="active"><a href="<?php echo $value['url']; ?>"><?php echo ucwords($key); ?> &nbsp;<span class="badge"><?php echo $value['badge']; ?></span></a></li>
					<?php } else { ?>
						<li><a href="<?php echo $value['url']; ?>"><?php echo ucwords($key); ?> &nbsp;<span class="badge"><?php echo $value['badge']; ?></span></a></li>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>

		<div class="panel panel-default panel-table">
			<div class="panel-heading">
				<h3 class="panel-title">Message List</h3>
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
										<input type="text" name="filter_search" class="form-control input-sm" value="<?php echo $filter_search; ?>" placeholder="Search sender or subject." />&nbsp;&nbsp;&nbsp;
									</div>
									<a class="btn btn-grey" onclick="filterList();" title="Search"><i class="fa fa-search"></i></a>
								</div>

								<div class="col-md-8 pull-left">
									<input type="hidden" name="filter_label" value="<?php echo $filter_label; ?>" />
									<?php if ($filter_label === 'all') { ?>
										<div class="form-group">
											<select name="filter_recipient" class="form-control input-sm">
												<option value="">View all recipients</option>
												<option value="all_newsletters" <?php echo set_select('filter_recipient', 'all_newsletters'); ?> >All Newsletter Subscribers</option>
												<option value="all_customers" <?php echo set_select('filter_recipient', 'all_customers'); ?> >All Customers</option>
												<option value="customer_group" <?php echo set_select('filter_recipient', 'customer_group'); ?> >Customer Group</option>
												<option value="customers" <?php echo set_select('filter_recipient', 'customers'); ?> >Customers</option>
												<option value="all_staffs" <?php echo set_select('filter_recipient', 'all_staffs'); ?> >All Staffs</option>
												<option value="staff_group" <?php echo set_select('filter_recipient', 'staff_group'); ?> >Staff Group</option>
												<option value="staffs" <?php echo set_select('filter_recipient', 'staffs'); ?> >Staffs</option>
											</select>
										</div>
									<?php } ?>
									<div class="form-group">
										<select name="filter_type" class="form-control input-sm">
											<option value="">View all send types</option>
											<?php if ($filter_type === 'account') { ?>
												<option value="account" <?php echo set_select('filter_type', 'account', TRUE); ?> >Account</option>
												<option value="email" <?php echo set_select('filter_type', 'email'); ?> >Email</option>
											<?php } else if ($filter_type === 'email') { ?>
												<option value="account" <?php echo set_select('filter_type', 'account'); ?> >Account</option>
												<option value="email" <?php echo set_select('filter_type', 'email', TRUE); ?> >Email</option>
											<?php } else { ?>
												<option value="account" <?php echo set_select('filter_type', 'account'); ?> >Account</option>
												<option value="email" <?php echo set_select('filter_type', 'email'); ?> >Email</option>
											<?php } ?>
										</select>&nbsp;&nbsp;
									</div>
									<div class="form-group">
										<select name="filter_date" class="form-control input-sm">
											<option value="">View all dates</option>
											<?php foreach ($message_dates as $key => $value) { ?>
											<?php if ($key === $filter_date) { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
											<?php } else { ?>
												<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
											<?php } ?>
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

			<form role="form" id="message-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
				<div class="table-responsive">
				<table border="0" class="table table-striped table-border">
					<thead>
						<tr>
							<th class="action">
								<?php if ($filter_label !== 'all') { ?>
								<div class="input-group input-group-more">
									<input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
									<div class="input-group-btn">
										<button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
											<span class="fa fa-angle-double-down"></span>
											<span class="sr-only">Toggle Dropdown</span>
										</button>
										<ul class="dropdown-menu dropdown-menu-sm" role="menu">
											<?php if ($filter_label === 'inbox') { ?>
												<li><a onclick="markAsUnread()">Mark As Unread</a></li>
												<li><a onclick="markAsRead()">Mark As Read</a></li>
												<li><a onclick="moveToTrash();">Move To Trash</a></li>
											<?php } else if ($filter_label === 'trash') { ?>
												<li><a onclick="markAsUnread()">Mark As Unread</a></li>
												<li><a onclick="markAsRead()">Mark As Read</a></li>
												<li><a onclick="moveToInbox();">Move To Inbox</a></li>
											<?php } ?>
										</ul>
									</div>
								</div>
								<?php } else { ?>
									<input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);">
								<?php } ?>
							</th>
							<th>From</th>
							<th>To</th>
							<th>Subject</th>
							<th><a class="sort" href="<?php echo $sort_type; ?>">Type<i class="fa fa-sort-<?php echo ($sort_by == 'send_type') ? $order_by_active : $order_by; ?>"></i></a></th>
							<th class="text-center"><a class="sort" href="<?php echo $sort_date; ?>">Time - Date<i class="fa fa-sort-<?php echo ($sort_by == 'messages.date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($messages) {?>
						<?php foreach ($messages as $message) { ?>
						<tr class="<?php echo $message['state']; ?>">
							<td class="action"><input type="checkbox" value="<?php echo $message['message_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
								<a class="btn btn-view" title="View" href="<?php echo $message['view']; ?>"><i class="fa fa-eye"></i></a></td>
							<td><?php echo $message['from']; ?></td>
							<td><?php echo $message['recipient']; ?></td>
							<td><?php echo $message['subject']; ?><br />
								<font size="1"><?php echo $message['body']; ?></font>
							</td>
							<td><i title="<?php echo $message['send_type']; ?>" class="fa fa-<?php echo $message['type_icon']; ?>"></i></td>
							<td class="text-center"><?php echo $message['date_added']; ?></td>
						</tr>
						<?php } ?>
						<?php } else { ?>
						<tr>
							<td colspan="6"><?php echo $text_empty; ?></td>
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
<script type="text/javascript">
function markAsRead() {
	if ($('#message-form input:checkbox:checked').length > 0) {
		$('#message-form').append('<input type="hidden" name="message_state" value="read" />');
		$('#message-form').submit();
	}
}

function markAsUnread() {
	if ($('#message-form input:checkbox:checked').length > 0) {
		$('#message-form').append('<input type="hidden" name="message_state" value="unread" />');
		$('#message-form').submit();
	}
}

function moveToInbox() {
	if ($('#message-form input:checkbox:checked').length > 0) {
		$('#message-form').append('<input type="hidden" name="message_state" value="inbox" />');
		$('#message-form').submit();
	}
}

function moveToTrash() {
	if (confirm('Are you sure you want to do this?')) {
		$('#message-form').append('<input type="hidden" name="message_state" value="trash" />');
		$('#message-form').submit();
	} else {
		return false;
	}
}
</script>
<?php echo $footer; ?>