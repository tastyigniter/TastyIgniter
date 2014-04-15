<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Restaurant</th>
			<th>Author</th>
			<th>Rating</th>
			<th class="center">Order ID</th>
			<th class="center">Status</th>
			<th class="right">Date Added</th>
			<th class="right">Action</th>			
		</tr>
		<?php if ($reviews) { ?>
		<?php foreach ($reviews as $review) { ?>
		<tr>
			<td class="delete"><input type="checkbox" name="delete[]" value="<?php echo $review['review_id']; ?>" /></td>  
			<td><?php echo $review['location_name']; ?></td>
			<td><?php echo $review['author']; ?></td>
			<td>
  				<b>Quality:</b> <?php echo ($review['quality'] != '0') ? $ratings[$review['quality']] : 'None'; ?><br />
  				<b>Delivery:</b> <?php echo ($review['delivery'] != '0') ? $ratings[$review['delivery']] : 'None'; ?><br />
  				<b>Service:</b> <?php echo ($review['service'] != '0') ? $ratings[$review['service']] : 'None'; ?>
			</td>
			<td class="center"><?php echo $review['order_id']; ?></td>
			<td class="center"><?php echo ($review['review_status'] === '1') ? 'Approved' : 'Pending Review'; ?></td>
			<td class="right"><?php echo $review['date_added']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $review['edit']; ?>"></a></td>
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