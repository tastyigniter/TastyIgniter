<div class="box">
	<div id="update-box" class="content">
	<h2>Review Details</h2>
	<table class="form">
	<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<tr>
    		<td><b>Author:</b></td>
    		<td><input type="text" name="author" class="textfield" value="<?php echo set_value('author', $author); ?>"/>
    			<input type="hidden" name="customer_id" value="<?php echo set_value('customer_id', $customer_id); ?>"/></td>
   		</tr>
		<tr>
    		<td><b>Menu Name:</b></td>
    		<td><input type="text" name="menu" class="textfield" value="<?php echo set_value('menu', $menu_name); ?>"/>
    			<input type="hidden" name="menu_id" value="<?php echo set_value('menu_id', $menu_id); ?>"/>
   		</tr>
		<tr>
    		<td><b>Rating Name:</b></td>
    		<td><select name="rating">
					<option value="">select rating</option>
					<?php foreach ($ratings as $key => $rating) { ?>
					<?php if ($key == $rating_id) { ?>
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
	   			<option value="0" <?php echo set_select('review_status', '0'); ?> >Disabled</option>
     		<?php if ($review_status === '1') { ?>
    			<option value="1" <?php echo set_select('review_status', '1', TRUE); ?> >Enabled</option>
			<?php } else { ?>  
    			<option value="1" <?php echo set_select('review_status', '1'); ?> >Enabled</option>
			<?php } ?>  
    		</select></td>
		</tr>
	</form>
	</table>
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