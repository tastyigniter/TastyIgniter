<div class="box">
	<div id="list-box" class="content">
		<div class="wrap_heading">
			<ul id="tabs">
				<?php foreach ($labels as $key => $value) { ?>
				<?php if ($key == $label) {?>
					<li><a href="<?php echo $value; ?>" class="active"><?php echo ucfirst($key); ?></a></li>
				<?php } else { ?>
					<li><a href="<?php echo $value; ?>"><?php echo ucfirst($key); ?></a></li>
				<?php } ?>
				<?php } ?>
			</ul>
		</div>

		<div id="" class="wrap_content" style="display:block;">
			<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
			<table align="center" class="list">
			<tr>
				<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
				<th>Sender</th>
				<th>Subject</th>
				<th class="right">Date</th>
				<th class="right">Action</th>
			</tr>
			<?php if ($messages) {?>
			<?php foreach ($messages as $message) { ?>
			<tr>
				<td class="delete"><input type="checkbox" value="<?php echo $message['message_id']; ?>" name="delete[]" /></td>
				<td><?php echo $message['sender']; ?></td>
				<td><?php echo $message['subject']; ?><br />
					<font size="1"><?php echo $message['body']; ?></font>
				</td>
				<td class="right"><?php echo $message['date']; ?></td>
				<td class="right"><a class="view" title="View" href="<?php echo $message['view']; ?>"></a></td>
			</tr>
			<?php } ?>
			<?php } else { ?>
			<tr>
				<td colspan="6" align="center"><?php echo $text_empty; ?></td>
			</tr>
			<?php } ?>
			</table>
			</form>
		</div>
		<div class="pagination">
			<div class="links"><?php echo $pagination['links']; ?></div>
			<div class="info"><?php echo $pagination['info']; ?></div> 
		</div>
	</div>
</div>