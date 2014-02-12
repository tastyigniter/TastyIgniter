<div class="box">
	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>">
	<table border="0" align="center" class="list">
		<tr>
			<th width="1" style="text-align:center;"><input type="checkbox" onclick="$('input[name*=\'delete\']').prop('checked', this.checked);"></th>
			<th>Name</th>
			<th>City</th>
			<th>Postcode</th>
			<th>Telephone</th>
			<th>Status</th>
			<th class="right">Action</th>
		</tr>
		<?php if ($locations) { ?>
		<?php foreach ($locations as $location) { ?>
		<tr>
			<td><input type="checkbox" value="<?php echo $location['location_id']; ?>" name="delete[]" /></td>
			<td><?php echo $location['location_name']; ?></td>
			<td><?php echo $location['location_city']; ?></td>
			<td><?php echo $location['location_postcode']; ?></td>
			<td><?php echo $location['location_telephone']; ?></td>
			<td><?php echo ($location['location_status'] === '1') ? 'Enabled' : 'Disabled'; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $location['edit']; ?>"></a></td>
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
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.hours').timepicker({
		timeFormat: 'HH:mm',
	});
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'table\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: '<?php echo site_url("admin/tables/autocomplete"); ?>?table_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						value: item.table_id,
						label: item.table_name,
						min: item.min_capacity,
						max: item.max_capacity
					}
				}));
			}
		});
	},
	select: function(event, ui) {
		$('#table-box' + ui.item.value).remove();
		$('#table-box table').append('<tr id="table-box' + ui.item.value + '"><td class="name">' + ui.item.label + '</td><td>' + ui.item.min + '</td><td>' + ui.item.max + '</td><td class="img">' + '<img src="<?php echo base_url('assets/img/delete.png'); ?>" onclick="$(this).parent().parent().remove();" />' + '<input type="hidden" name="tables[]" value="' + ui.item.value + '" /></td></tr>');

		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>