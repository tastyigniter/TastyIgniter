<div class="box">
	<form id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
	<div class="filter_heading">
		<div class="left">
			<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search sender or subject." class="textfield" />&nbsp;&nbsp;&nbsp;
			<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
		</div>
	</div>
	</form>
	
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<table align="center" class="list">
			<thead>
				<tr>
					<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
					<th>Subject</th>
					<th>Sender</th>
					<th class="center">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($alerts) {?>
				<?php foreach ($alerts as $alert) { ?>
				<tr>
					<td class="action"><input type="checkbox" value="Delete" name="delete[<?php echo $alert['message_id']; ?>]" />&nbsp;&nbsp;&nbsp;
						<a class="view" title="View" href="<?php echo $alert['view']; ?>"></a></td>
					<td><?php echo $alert['subject']; ?><br /><font size="1"><?php echo $alert['body']; ?></font></td>
					<td><?php echo $alert['sender']; ?></td>
					<td class="center"><?php echo $alert['date']; ?></td>
				</tr>
				<?php } ?>
				<?php } else { ?>
				<tr>
					<td colspan="4" align="center"><?php echo $text_empty; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</form>

	<div class="pagination">
		<?php echo $pagination['links']; ?><?php echo $pagination['info']; ?>
	</div>
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>