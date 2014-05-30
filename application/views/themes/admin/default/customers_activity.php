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
	<div id="update-box" class="content">
		<form id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
		<div class="filter_heading">
			<div class="right">
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search ip, customer or browser." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
			<div class="left">
				<select name="filter_type">
					<option value="">View all types</option>
				<?php if ($filter_type === 'all') { ?>
					<option value="all" <?php echo set_select('filter_type', 'all', TRUE); ?> >All</option>
					<option value="online" <?php echo set_select('filter_type', 'mobile'); ?> >Online</option>
				<?php } else if ($filter_type === 'online') { ?>  
					<option value="all" <?php echo set_select('filter_type', 'online'); ?> >All</option>
					<option value="online" <?php echo set_select('filter_type', 'online', TRUE); ?> >Online</option>
				<?php } else { ?>  
					<option value="all" <?php echo set_select('filter_type', 'all'); ?> >All</option>
					<option value="online" <?php echo set_select('filter_type', 'online'); ?> >Online</option>
				<?php } ?>  
				</select>&nbsp;
				<select name="filter_access">
					<option value="">View all access</option>
				<?php if ($filter_access === 'browser') { ?>
					<option value="browser" <?php echo set_select('filter_access', 'browser', TRUE); ?> >Browser</option>
					<option value="mobile" <?php echo set_select('filter_access', 'mobile'); ?> >Mobile</option>
					<option value="robot" <?php echo set_select('filter_access', 'robot'); ?> >Robot</option>
				<?php } else if ($filter_access === 'mobile') { ?>  
					<option value="browser" <?php echo set_select('filter_access', 'browser'); ?> >Browser</option>
					<option value="mobile" <?php echo set_select('filter_access', 'mobile', TRUE); ?> >Mobile</option>
					<option value="robot" <?php echo set_select('filter_access', 'robot'); ?> >Robot</option>
				<?php } else if ($filter_access === 'robot') { ?>  
					<option value="browser" <?php echo set_select('filter_access', 'browser'); ?> >Browser</option>
					<option value="mobile" <?php echo set_select('filter_access', 'mobile'); ?> >Mobile</option>
					<option value="robot" <?php echo set_select('filter_access', 'robot', TRUE); ?> >Robot</option>
				<?php } else { ?>  
					<option value="browser" <?php echo set_select('filter_access', 'browser'); ?> >Browser</option>
					<option value="mobile" <?php echo set_select('filter_access', 'mobile'); ?> >Mobile</option>
					<option value="robot" <?php echo set_select('filter_access', 'robot'); ?> >Robot</option>
				<?php } ?>  
				</select>&nbsp;
				<select name="filter_date">
					<option value="">View all activities</option>
					<?php foreach ($activity_dates as $key => $value) { ?>
					<?php if ($key === $filter_date) { ?>				
						<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key, TRUE); ?> ><?php echo $value; ?></option>
					<?php } else { ?>
						<option value="<?php echo $key; ?>" <?php echo set_select('filter_date', $key); ?> ><?php echo $value; ?></option>
					<?php } ?>
					<?php } ?>
				</select>&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-filter"></i></a>&nbsp;
				<a class="grey_icon" href="<?php echo page_url(); ?>"><i class="icon icon-cancel"></i></a>
			</div>
		</div>
		</form>
		
		<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<table border="0" class="list list-height">
			<thead>
				<tr>
					<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
					<th>IP</th>
					<th>Customer</th>
					<th>Access</th>
					<th>Browser</th>
					<th style="width:22%;">Request URL</th>
					<th style="width:22%;">Referrer URL</th>
					<th><a href="<?php echo $sort_date; ?>">Last Activity<i class="icon icon-sort-<?php echo ($sort_by == 'date_added') ? $order_by_active : $order_by; ?>"></i></a></th>
				</tr>
			</thead>
			<tbody>
				<?php if ($activities) { ?>
				<?php foreach ($activities as $activity) { ?>
				<tr>
					<td class="action"><input type="checkbox" value="<?php echo $activity['activity_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
						<a class="blacklist" title="Blacklist" href="<?php echo $activity['blacklist']; ?>"></a></td>
					<td><?php echo $activity['ip_address']; ?>&nbsp;&nbsp;<img class="flag" title="<?php echo $activity['country_name']; ?>" width="16" src="<?php echo $activity['country_code']; ?>" /></td>
					<td><?php echo $activity['customer_name']; ?></td>
					<td><?php echo $activity['access_type']; ?></td>
					<td><?php echo $activity['browser']; ?></td>
					<td><?php echo $activity['request_uri']; ?></td>
					<td><?php echo $activity['referrer_uri']; ?></td>
					<td><?php echo $activity['date_added']; ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="8" align="center"><?php echo $text_empty; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="pagination">
			<?php echo $pagination['links']; ?><?php echo $pagination['info']; ?>
		</div>
		</form>
	</div>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>