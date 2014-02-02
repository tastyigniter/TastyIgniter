<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD NEW REVIEW</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
    		<td><b>Author:</b></td>
    		<td><input type="text" name="author" class="textfield" value="<?php echo set_value('author'); ?>"/>
    			<input type="hidden" name="customer_id" value="<?php echo set_value('customer_id'); ?>"/></td>
   		</tr>
		<tr>
    		<td><b>Menu Name:</b></td>
    		<td><input type="text" name="menu" class="textfield" value="<?php echo set_value('menu'); ?>"/>
    			<input type="hidden" name="menu_id" value="<?php echo set_value('menu_id'); ?>"/>
   		</tr>
		<tr>
    		<td><b>Rating Name:</b></td>
    		<td><select name="rating">
					<option value="">select rating</option>
					<?php foreach ($ratings as $key => $rating) { ?>
						<option value="<?php echo $key; ?>"  <?php echo set_select('rating', $key); ?>><?php echo $rating; ?></option>
					<?php }?>
			</select></td>
   		</tr>
   		<tr>
   		    <td><b>Review Text:</b></td>
    		<td><textarea name="review_text" rows="7" cols="50"><?php echo set_value('review_text'); ?></textarea></td>
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
	</table>
	</form>
	</div>

	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Author</th>
			<th>Menu Name</th>
			<th>Rating Name</th>
			<th class="right">Status</th>
			<th class="right">Date Added</th>
			<th class="right">Action</th>			
		</tr>
		<?php if ($reviews) { ?>
		<?php foreach ($reviews as $review) { ?>
		<tr>
			<td class="delete"><input type="checkbox" name="delete[]" value="<?php echo $review['review_id']; ?>" /></td>  
			<td><?php echo $review['author']; ?></td>
			<td><?php echo $review['menu_name']; ?></td>
			<td><?php echo $review['rating_name']; ?></td>
			<td class="right"><?php echo ($review['review_status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
			<td class="right"><?php echo $review['date_added']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $review['edit']; ?>"></a></td>
		</tr>

		<?php } ?>
		<?php } else { ?>
		<tr>
			<td colspan="8">There are no reviews added to your database.</td>
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