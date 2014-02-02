<div class="box">
	<div id="add-box" style="display:none">
	<h2>ADD NEW LOCATION</h2>
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="addForm">
	<table class="form">
		<tr>
    		<td><b>Name:</b></td>
    		<td><input type="text" name="location_name" value="<?php echo set_value('location_name'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Address 1:</b></td>
    		<td><input type="text" name="address[address_1]" value="<?php echo set_value('address[address_1]'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Address 2:</b></td>
    		<td><input type="text" name="address[address_2]" value="<?php echo set_value('address[address_2]'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>City:</b></td>
    		<td><input type="text" name="address[city]" value="<?php echo set_value('address[city]'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Postcode:</b></td>
    		<td><input type="text" name="address[postcode]" value="<?php echo set_value('address[postcode]'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Country:</b></td>
    		<td><select name="address[country]">
			<?php foreach ($countries as $country) { ?>
			<?php if ($country['country_id'] === $country_id) { ?>
  				<option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
			<?php } else { ?>  
  				<option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
			<?php } ?>  
			<?php } ?>  
    		</selec></td>
		</tr>
		<tr>
    		<td><b>Email:</b></td>
    		<td><input type="text" name="email" value="<?php echo set_value('email'); ?>" class="textfield" /></td>
		</tr>
		<tr>
    		<td><b>Telephone:</b></td>
    		<td><input type="text" name="telephone" value="<?php echo set_value('telephone'); ?>" class="textfield" /></td>
		</tr>
	</table>

	<div class="wrap-heading">
		<h3>WORKING HOURS</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
    		<td><b>Day:</b></td>
    		<?php foreach ($hours['day'] as $key => $day) { ?>
	    		<td><b><?php echo $day; ?></b></td>
    		<?php } ?>
		</tr>
		<tr>
    		<td><b>Open Hour:</b></td>
    		<?php foreach ($hours['open'] as $key => $open) { ?>
				<td><input type="text" name="hours[open][]" value="<?php echo set_value('hours[open][]', $open); ?>" class="textfield hours" size="4" /></td>
    		<?php } ?>
		</tr>
		<tr>
    		<td><b>Close Hour:</b></td>
    		<?php foreach ($hours['close'] as $key => $close) { ?>
				<td><input type="text" name="hours[close][]" value="<?php echo set_value('hours[close][]', $close); ?>" class="textfield hours" size="4" /></td>
    		<?php } ?>
		</tr>
	</table>
	</div>
		
	<div class="wrap-heading">
		<h3>TABLES</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
			<td><b>Tables:</b></td>
			<td><input type="text" name="table" value="" class="textfield" size="10" /></td>
		</tr>
		<tr>
			<td></td>
			<td><div id="table-box" class="selectbox">
			<table></table>
			</div></td>
		</tr>
	</table>
	</div>
	
	<div class="wrap-heading">
		<h3>DELIVERY</h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
    		<td><b>Offer Delivery:</b></td>
    		<td><select name="offer_delivery">
	   			<option value="0" <?php echo set_select('offer_delivery', '0'); ?> >No</option>
    			<option value="1" <?php echo set_select('offer_delivery', '1'); ?> >Yes</option>
    		</select></td>
		</tr>
		<tr>
    		<td><b>Offer Collection:</b></td>
    		<td><select name="offer_collection">
	   			<option value="0" <?php echo set_select('offer_collection', '0'); ?> >No</option>
    			<option value="1" <?php echo set_select('offer_collection', '1'); ?> >Yes</option>
    		</select></td>
		</tr>
		<tr>
    		<td><b>Delivery Radius:</b><br />
    		<font size="1">(Locations distance unit radius in kilometers or miles)</font></td>
    		<td><input type="text" name="address[radius]" value="<?php echo set_value('address[radius]'); ?>" class="textfield" size="5" /></td>
		</tr>
		<tr>
    		<td><b>Ready Time:</b><br />
    		<font size="1">(Set how many minutes before an order is delivered or ready for collection)</font></td>
    		<td><input type="text" name="ready_time" value="<?php echo set_value('ready_time'); ?>" class="textfield" size="5" /> minutes</td>
		</tr>
		<tr>
    		<td><b>Delivery Charge:</b><br />
    		<font size="1">(Set to "0.00" for free delivery charge)</font></td>
    		<td><input type="text" name="delivery_charge" value="<?php echo set_value('delivery_charge'); ?>" class="textfield" size="5" /></td>
		</tr>
		<tr>
    		<td><b>Min Delivery Total:</b><br />
    		<font size="1">(Set to "0.00" for no minimum delivery charge)</font></td>
    		<td><input type="text" name="min_delivery_total" value="<?php echo set_value('min_delivery_total'); ?>" class="textfield" size="5" /></td>
		</tr>
	</table>
	</div>
		
	<div class="wrap-heading">
		<h3></h3>
	</div>

	<div class="wrap-content">
	<table class="form">
		<tr>
    		<td><b>Status:</b></td>
    		<td><select name="location_status">
    			<option value="0" <?php echo set_select('location_status', '0'); ?> >Disabled</option>
    			<option value="1" <?php echo set_select('location_status', '1'); ?> >Enabled</option>
    		</select></td>
		</tr>
	</table>
	</div>	
	</form>
	</div>

	<div id="list-box" class="content">
	<form accept-charset="utf-8" method="post" action="<?php echo current_url(); ?>" id="listForm">
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
			<td colspan="10" align="center"><?php echo $text_no_locations; ?></td>
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