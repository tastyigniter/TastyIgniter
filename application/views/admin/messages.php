<div class="box">
	<div id="add-box" style="display:none">
	<h2>SEND MESSAGE TO ALL CUSTOMERS</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
			<td><b>To:</b></td>
			<td><select name="to">
				<option value="customers">All Customers</option>
				<?php foreach ($staffs as $staff) { ?>
					<option value="<?php echo $staff['staff_id']; ?>" <?php echo set_select('to', $staff['staff_id']); ?> ><?php echo $staff['staff_name']; ?></option>
				<?php } ?>  
			</select></td>
		</tr>
		<tr>
			<td width="15%"><b>Subject:</b></td>
			<td><input type="text" name="subject" value="<?php echo set_value('subject'); ?>" class="textfield" /></td>
		</tr>
		<tr>
			<td><b>Text:</b></td>
			<td><textarea name="body" style="height:200px;width:400px;"><?php echo set_value('body'); ?></textarea></td>
		</tr>
  	</table>
	</form>
	</div>

	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Sender</th>
			<th>Subject</th>
			<th class="right">Date</th>
			<th class="right">Time</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($messages) {?>
		<?php foreach ($messages as $message) { ?>
		<tr>
			<td class="delete"><input type="checkbox" value="<?php echo $message['message_id']; ?>" name="delete[]" /></td>
			<td><?php echo $message['sender']; ?></td>
			<td><?php echo $message['subject']; ?><br /><font size="1"><?php echo $message['body']; ?></font></td>
			<td class="right"><?php echo $message['date']; ?></td>
			<td class="right"><?php echo $message['time']; ?></td>
			<td class="right"><a class="view" title="View" href="<?php echo $message['view']; ?>"></a></td>
		</tr>
		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="7" align="center"><?php echo $text_empty; ?></td>
		</tr>
		<?php } ?>
	</table>
	</form>

	<div class="pagination">
		<div class="links"><?php echo $pagination['links']; ?></div>
		<div class="info"><?php echo $pagination['info']; ?></div> 
	</div>
	</div>
</div>
<script src="<?php echo base_url("assets/js/ckeditor/ckeditor.js"); ?>"></script>
<script type="text/javascript"><!--
window.onload = function() {
    CKEDITOR.replace('body');
};
//--></script>
