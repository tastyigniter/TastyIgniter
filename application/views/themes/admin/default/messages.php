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
			<div class="right">
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search sender or subject." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
			<div class="left">
				<select name="filter_label">
				<?php if ($filter_label === 'all') { ?>  
					<option value="inbox" <?php echo set_select('filter_label', 'inbox'); ?> >Inbox</option>
					<option value="all" <?php echo set_select('filter_label', 'all', TRUE); ?> >All Messages</option>
					<option value="trash" <?php echo set_select('filter_label', 'trash'); ?> >Trash</option>
				<?php } else if ($filter_label === 'trash') { ?>  
					<option value="inbox" <?php echo set_select('filter_label', 'inbox'); ?> >Inbox</option>
					<option value="all" <?php echo set_select('filter_label', 'all'); ?> >All Messages</option>
					<option value="trash" <?php echo set_select('filter_label', 'trash', TRUE); ?> >Trash</option>
				<?php } else { ?>  
					<option value="inbox" <?php echo set_select('filter_label', 'inbox'); ?> >Inbox</option>
					<option value="all" <?php echo set_select('filter_label', 'all'); ?> >All Messages</option>
					<option value="trash" <?php echo set_select('filter_label', 'trash'); ?> >Trash</option>
				<?php } ?>  
				</select>&nbsp;&nbsp;
				<?php if ($filter_label === 'all') { ?>  
				<select name="filter_recipient">
					<option value="">View all recipients</option>
					<option value="all_newsletters" <?php echo set_select('filter_recipient', 'all_newsletters'); ?> >All Newsletter Subscribers</option>
					<option value="all_customers" <?php echo set_select('filter_recipient', 'all_customers'); ?> >All Customers</option>
					<option value="customer_group" <?php echo set_select('filter_recipient', 'customer_group'); ?> >Customer Group</option>
					<option value="customers" <?php echo set_select('filter_recipient', 'customers'); ?> >Customers</option>
					<option value="all_staffs" <?php echo set_select('filter_recipient', 'all_staffs'); ?> >All Staffs</option>
					<option value="staff_group" <?php echo set_select('filter_recipient', 'staff_group'); ?> >Staff Group</option>
					<option value="staffs" <?php echo set_select('filter_recipient', 'staffs'); ?> >Staffs</option>
				</select>
				<?php } ?>  
				<select name="filter_type">
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
				<select name="filter_date">
					<option value="">View all dates</option>
					<?php foreach ($message_dates as $key => $value) { ?>
					<?php if ($key === $filter_date) { ?>				
						<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
					<?php } else { ?>
						<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
					<?php } ?>
					<?php } ?>
				</select>&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-filter"></i></a>&nbsp;
				<a class="grey_icon" href="<?php echo page_url(); ?>"><i class="icon icon-cancel"></i></a>
				<?php if ($filter_label !== 'all') { ?>  
				&nbsp;<a class="dropdown-toggle grey_icon">More<i class="icon icon-arrow-down"></i></a>
				<ul class="dropdown-menu" style="display:none">
					<?php if ($filter_label === 'inbox') { ?>  
						<li><a class="white_button" onclick="markAsUnread()">Mark As Unread</a></li>
						<li><a class="white_button" onclick="markAsRead()">Mark As Read</a></li>
						<li><a class="white_button" onclick="moveToTrash();">Move To Trash</a></li>
					<?php } else if ($filter_label === 'trash') { ?>
						<li><a class="white_button" onclick="markAsUnread()">Mark As Unread</a></li>
						<li><a class="white_button" onclick="markAsRead()">Mark As Read</a></li>
						<li><a class="white_button" onclick="moveToInbox();">Move To Inbox</a></li>
					<?php } ?>  
				</ul>
				<?php } ?>  
			</div>
		</div>
		</form>
	
		<form id="message-form" accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<table align="center" class="list message-list">
			<thead>
				<tr>
					<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
					<th>From</th>
					<th>To</th>
					<th>Subject</th>
					<th><a href="<?php echo $sort_type; ?>">Type<i class="icon icon-sort-<?php echo ($sort_by == 'send_type') ? $order_by_active : $order_by; ?>"></i></a></th>
					<th class="center"><a href="<?php echo $sort_date; ?>">Time - Date<i class="icon icon-sort-<?php echo ($sort_by == 'messages.date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($messages) {?>
				<?php foreach ($messages as $message) { ?>
				<tr class="<?php echo $message['state']; ?>">
					<td class="action"><input type="checkbox" value="<?php echo $message['message_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
						<a class="view" title="View" href="<?php echo $message['view']; ?>"></a></td>
					<td><?php echo $message['from']; ?></td>
					<td><?php echo $message['recipient']; ?></td>
					<td><?php echo $message['subject']; ?><br />
						<font size="1"><?php echo $message['body']; ?></font>
					</td>
					<td><i title="<?php echo $message['send_type']; ?>" class="icon icon-<?php echo $message['send_type']; ?>"></i></td>
					<td class="center"><?php echo $message['date_added']; ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="6" align="center"><?php echo $text_empty; ?></td>
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