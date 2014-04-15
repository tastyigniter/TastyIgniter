<div class="box">
	<div id="update-box" class="content">
		<form accept-charset="utf-8" method="post" action="<?php echo $action; ?>">
		<table align="" class="list">
			<tr class="filter">
				<td class="left">Select:  <select name="month">
					<?php foreach ($months as $key => $value) { ?>
					<?php if ($key === $month) { ?>
						<option value="<?php echo $key; ?>" selected="selected"><?php echo $value; ?></option>
					<?php } else { ?>
						<option value="<?php echo $key; ?>"><?php echo $value; ?></option>
					<?php } ?>
					<?php } ?>
				</select> 
				<select name="year">
					<?php foreach ($years as $key => $value) { ?>
					<?php if ($value === $year) { ?>
						<option value="<?php echo $value; ?>" selected="selected"><?php echo $value; ?></option>
					<?php } else { ?>
						<option value="<?php echo $value; ?>"><?php echo $value; ?></option>
					<?php } ?>
					<?php } ?>
				</select></td>
				<td class="left">Location:  <select name="location">
					<option value="">- please select -</option>
					<?php foreach ($locations as $location) { ?>
					<?php if ($location['location_id'] === $location_id) { ?>
						<option value="<?php echo $location['location_id']; ?>" selected="selected"><?php echo $location['location_name']; ?></option>
					<?php } else { ?>
						<option value="<?php echo $location['location_id']; ?>"><?php echo $location['location_name']; ?></option>
					<?php } ?>
					<?php } ?>
				</select></td>
				<td></td>
				<td></td>
				<td></td>
				<td class="right"><a class="button add_button" onclick="filterCalendar();">Filter</a>  <img onclick="filterClear();" title="Clear Filter" src="<?php echo base_url('assets/img/delete.png'); ?>" /></td>
			</tr>
		</table>
		</form>
		<?php echo $calendar; ?>
		<div class="order-info" style="display:none;">
			<div class="order-heading"></div>
			<div id="order-info"></div>
		</div>
		<div class="legends"><h3>Legends:</h3> <br />
			<span class="no_booking"></span> No Bookings <br />
			<span class="half_booked"></span> Half Booked <br />
			<span class="booked"></span> Fully Booked <br />
		</div>
	</div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
  	$('.view_details').on('click', function(){
  		if($('.paypal_details').is(':visible')){
     		$('.paypal_details').fadeOut();
   			$('.view_details').attr('class', '');
		} else {
   			$('.paypal_details').fadeIn();
   			$('.view_details').attr('class', 'active');
		}
	});	
});	

$('#tabs a').tabs();
//--></script>
<script type="text/javascript"><!--
$('.filter input, .filter select').on('change', function() {
	filterCalendar();
});
function filterCalendar() {
	var year = $('select[name=\'year\']').val();
	var month = $('select[name=\'month\']').val();
	var day = $('select[name=\'day\']').val();
	var location_id = $('select[name=\'location\']').val();

	url = '<?php echo current_url(); ?>';
	
	if (year != '') {
		url += '?year=' + encodeURIComponent(year);
	} else {
		url += '?year=';
	}

	if (month != '') {
		url += '&month=' + encodeURIComponent(month);
	} else {
		url += '&month=';
	}
	
	if (location_id != '') {
		url += '&location=' + encodeURIComponent(location_id);
	} else {
		url += '&location=';
	}
	
	location = url;
}

function filterClear() {
	url = '<?php echo current_url(); ?>';
	
	location = url;
}

jQuery(document).ready(function($){
	var remoteCache = new Array();
	var filter_location = $('select[name=\'location\']').val();
	var url = '<?php echo site_url("admin/reservations"); ?>';
	
	var loc_url = '';
	if (filter_location != '') {
		loc_url = '&location=' + encodeURIComponent(filter_location);
	}
	
	$('.calendar .day a, .calendar .today a').each(function(i,item){
		var link_id = item.id;
		var link_url = url + '?reserve_date=' + link_id + loc_url + ' #list-box > *';
		
		$(this).click(function(){			
			var orderBox = $('.order-info');			
			var orderInfo = $('#order-info');			
			var MyDate = new Date();
			var jheading  = '<h2>' + $.datepicker.formatDate('dd M yy', new Date(link_id)) + ' - Reservations</h2>';
				jheading += '<a class="save_button" id="' + link_id + '">Add Booking</a>';
			
			$('.order-heading').html(jheading);
			$('.calendar .day a, .calendar .today a').removeClass('selected');
			$(this).addClass('selected');
			
			orderBox.slideUp('fast',function(){			
				if( remoteCache[link_id] != undefined ) { 
					orderInfo.html(remoteCache[link_id]);
					orderBox.slideDown('fast');
				} else {
					orderInfo.load(link_url,function(){
						remoteCache[link_id] = orderInfo.html();
						orderBox.slideDown('fast');
					});
				}
			});
			
			return false;
		});
	});
	
	//$('.calendar .today a').click();
});
//--></script>