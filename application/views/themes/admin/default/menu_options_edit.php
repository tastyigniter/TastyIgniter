<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Option Name:</b></td>
						<td><input type="text" name="option_name" value="<?php echo set_value('option_name'), $option_name; ?>" id="name" class="textfield" /></td>
						<td></td>
					</tr>
					<tr>
						<td><b>Option Price:</b></td>
						<td><input type="text" name="option_price" value="<?php echo set_value('option_price'), $option_price; ?>" id="price" size="5" class="textfield" /></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
</div>