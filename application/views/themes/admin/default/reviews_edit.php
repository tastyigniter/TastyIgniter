<div class="box">
	<div id="update-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<div class="wrap_heading">
			<ul id="tabs">
				<li><a rel="#general" class="active">Review Details</a></li>
			</ul>
		</div>

		<div id="general" class="wrap_content" style="display:block;">
			<table class="form">
				<tbody>
					<tr>
						<td><b>Restaurant:</b></td>
						<td><select name="location_id">
							<?php foreach ($locations as $location) { ?>
							<?php if ($location['location_id'] === $location_id) { ?>
								<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location_id', $location['location_id'], TRUE); ?> ><?php echo $location['location_name']; ?></option>
							<?php } else { ?>  
								<option value="<?php echo $location['location_id']; ?>" <?php echo set_select('staff_location_id', $location['location_id']); ?> ><?php echo $location['location_name']; ?></option>
							<?php } ?>  
							<?php } ?>  
						</select></td>
					</tr>
					<tr>
						<td><b>Order ID:</b></td>
						<td><input type="text" name="order_id" class="textfield" value="<?php echo set_value('order_id', $order_id); ?>"/></td>
					</tr>
					<tr>
						<td><b>Author:</b></td>
						<td><input type="text" name="author" class="textfield" value="<?php echo set_value('author', $author); ?>"/>
							<input type="hidden" name="customer_id" value="<?php echo set_value('customer_id', $customer_id); ?>"/></td>
					</tr>
					<tr>
						<td><b>Quality Rating:</b></td>
						<td><select name="quality">
								<?php foreach ($ratings as $key => $rating) { ?>
								<?php if ($key == $quality) { ?>
									<option value="<?php echo $key; ?>" selected="selected"><?php echo $rating; ?></option>
								<?php } else { ?>
									<option value="<?php echo $key; ?>"><?php echo $rating; ?></option>
								<?php }?>
								<?php }?>
						</select></td>
					</tr>
					<tr>
						<td><b>Delivery Rating:</b></td>
						<td><select name="delivery">
								<?php foreach ($ratings as $key => $rating) { ?>
								<?php if ($key == $delivery) { ?>
									<option value="<?php echo $key; ?>" selected="selected"><?php echo $rating; ?></option>
								<?php } else { ?>
									<option value="<?php echo $key; ?>"><?php echo $rating; ?></option>
								<?php }?>
								<?php }?>
						</select></td>
					</tr>
					<tr>
						<td><b>Service Rating:</b></td>
						<td><select name="service">
								<?php foreach ($ratings as $key => $rating) { ?>
								<?php if ($key == $service) { ?>
									<option value="<?php echo $key; ?>" selected="selected"><?php echo $rating; ?></option>
								<?php } else { ?>
									<option value="<?php echo $key; ?>"><?php echo $rating; ?></option>
								<?php }?>
								<?php }?>
						</select></td>
					</tr>
					<tr>
						<td><b>Review Text:</b></td>
						<td><textarea name="review_text" rows="7" cols="50"><?php echo set_value('review_text', $review_text); ?></textarea></td>
					</tr>
					<tr>
						<td><b>Review Status:</b></td>
						<td><select name="review_status">
							<option value="0" <?php echo set_select('review_status', '0'); ?> >Pending Review</option>
						<?php if ($review_status === '1') { ?>
							<option value="1" <?php echo set_select('review_status', '1', TRUE); ?> >Approved</option>
						<?php } else { ?>  
							<option value="1" <?php echo set_select('review_status', '1'); ?> >Approved</option>
						<?php } ?>  
						</select></td>
					</tr>
				</tbody>
			</table>
		</div>
	</form>
	</div>
	
</div>
<script type="text/javascript"><!--
$('input[name=\'menu\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/menus/autocomplete"); ?>?menu=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.menu_name,
						value: item.menu_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'menu\']').val(ui.item.label);
		$('input[name=\'menu_id\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'author\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/customers/autocomplete"); ?>?customer_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.customer_name,
						value: item.customer_id
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('input[name=\'author\']').val(ui.item.label);
		$('input[name=\'customer_id\']').val(ui.item.value);
		
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>