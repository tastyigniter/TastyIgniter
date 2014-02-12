<div class="box">
	<div id="update-box" class="content">
	<h2>Order Status Details</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
	<table class="form">
	<tr>
		<td><b>Name:</b></td>
    	<td><input type="text" name="status_name" value="<?php echo set_value('status_name', $status_name); ?>" id="name" class="textfield" /></td>
		<td></td>
    </tr>
	<tr>
		<td><b>Comment:</b></td>
    	<td><textarea name="status_comment" cols="50" rows="7"><?php echo set_value('status_comment', $status_comment); ?> </textarea></td>
		<td></td>
    </tr>
	<tr>
		<td><b>Notify Customer:</b></td>
		<td><?php if ($notify_customer === '1') { ?>
				<input type="checkbox" name="notify_customer" value="<?php echo $notify_customer; ?>" checked="checked" />
			<?php } else { ?>
				<input type="checkbox" name="notify_customer" value="1" />
			<?php } ?>
		</td>
	</tr>
	</table>
	</div>
	
</div>