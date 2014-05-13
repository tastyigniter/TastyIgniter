<div class="box">
	<div id="list-box" class="content">
		<form id="filter-form" accept-charset="utf-8" method="GET" action="<?php echo current_url(); ?>">
		<div class="filter_heading">
			<div class="left">
				<input type="text" name="filter_search" value="<?php echo $filter_search; ?>" placeholder="Search sender or subject." class="textfield" />&nbsp;&nbsp;&nbsp;
				<a class="grey_icon" onclick="filterList();"><i class="icon icon-search"></i></a>
			</div>
		<div class="right">
			<select name="filter_label">
			<?php if ($filter_label === 'sent') { ?>  
				<option value="" <?php echo set_select('filter_label', ''); ?> >Inbox</option>
				<option value="sent" <?php echo set_select('filter_label', 'sent', TRUE); ?> >Sent</option>
				<option value="draft" <?php echo set_select('filter_label', 'draft'); ?> >Drafts</option>
			<?php } else if ($filter_label === 'draft') { ?>  
				<option value="" <?php echo set_select('filter_label', ''); ?> >Inbox</option>
				<option value="sent" <?php echo set_select('filter_label', 'sent'); ?> >Sent</option>
				<option value="draft" <?php echo set_select('filter_label', 'draft', TRUE); ?> >Drafts</option>
			<?php } else { ?>  
				<option value="" <?php echo set_select('filter_label', ''); ?> >Inbox</option>
				<option value="sent" <?php echo set_select('filter_label', 'sent'); ?> >Sent</option>
				<option value="draft" <?php echo set_select('filter_label', 'draft'); ?> >Drafts</option>
			<?php } ?>  
			</select>&nbsp;&nbsp;&nbsp;
			<a class="grey_icon" onclick="filterList();"><i class="icon icon-filter"></i></a>&nbsp;
			<a class="grey_icon" href="<?php echo page_url(); ?>"><i class="icon icon-cancel"></i></a>
		</div>
		</div>
		</form>
	
		<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
		<table align="center" class="list">
			<thead>
				<tr>
					<th class="action"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
					<th>Sender</th>
					<th>Subject</th>
					<th class="center">Date</th>
				</tr>
			</thead>
			<tbody>
				<?php if ($messages) {?>
				<?php foreach ($messages as $message) { ?>
				<tr>
					<td class="action"><input type="checkbox" value="<?php echo $message['message_id']; ?>" name="delete[]" />&nbsp;&nbsp;&nbsp;
						<a class="view" title="View" href="<?php echo $message['view']; ?>"></a></td>
					<td><?php echo $message['sender']; ?></td>
					<td><?php echo $message['subject']; ?><br />
						<font size="1"><?php echo $message['body']; ?></font>
					</td>
					<td class="center"><?php echo $message['date']; ?></td>
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
</div>
<script type="text/javascript"><!--
function filterList() {
	$('#filter-form').submit();
}
//--></script>