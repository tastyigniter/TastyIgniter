<div class="box">
	<div class="wrap_content">
		<ul class="numbers">
			<li><span><?php echo $total_sales; ?></span>Total Sales</li>
			<li><span><?php echo $total_sales_by_year; ?></span>Total Sales This Year</li>
			<li><span><?php echo $total_lost_sales; ?></span>Total Lost Sales</li>
			<li><span><?php echo $total_customers; ?></span>Total Customers</li>
			<li><span><?php echo $total_delivery_orders; ?></span>Total Delivery Orders</li>
			<li><span><?php echo $total_collection_orders; ?></span>Total Collection Orders</li>
			<li><span><?php echo $total_orders; ?></span>Total Orders</li>
			<li><span><?php echo $total_orders_completed; ?></span>Total Orders Completed</li>
			<li><span><?php echo $total_tables_reserved; ?></span>Total Table(s) Reserved</li>
		</ul>
	</div>
	
	<div class="chart wrap_content">
		<div class="dashboard_heading">
			<h2>Reports Chart</h2>
			<div class="search">
				Period: 
				<select name="range" onChange="getChart(this.value)">
					<option value="today" checked="checked">Today</option>  	
					<option value="yesterday">Yesterday</option>  	
					<option value="week">This Week</option>
					<option value="last_week">Last Week</option>
					<option value="month">This Month</option>
					<option value="year">This Year</option>
				</select>&nbsp;&nbsp;&nbsp; - OR - &nbsp;&nbsp;&nbsp;
				Monthly: 
				<select name="monthly" onChange="getChart(this.value)">
					<option value="" checked="checked">select</option>  	
					<?php foreach ($months as $key => $value) { ?>
						<option value="<?php echo $key; ?>" <?php echo set_select('monthly', $key); ?>><?php echo $value; ?></option>  	
					<?php } ?>
				</select>
			</div>
		</div>
		<div id="chart-picker">
			<ul id="tabs">
				<li class="customers"><a rel="customers">Customers</a></li>
				<li class="orders active"><a rel="orders">Orders</a></li>
				<li class="reservations"><a rel="reservations">Reservations</a></li>
				<li class="reviews"><a rel="reviews">Reviews</a></li>
			</ul>
			<input type="hidden" name="type" value="" />
		</div>
		<div id="chart-holder" style="width:1155px; height: 295px; margin: auto; padding: 0px; position: relative;"></div>
	</div>
	<br />
	<br />
	
	<?php if ($orders) { ?>
	<div class="wrap_content">
		<div class="dashboard_heading">
			<h2>10 Latest Orders</h2>
		</div>
		<table border="0" align="center" class="list list-height">
			<thead>
				<tr>
					<th class="action action-one"></th>
					<th>ID</th>
					<th>Location</th>
					<th>Customer Name</th>
					<th class="center">Status</th>
					<th class="center">Type</th>
					<th class="center">Ready Time</th>
					<th class="center">Date Added</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($orders as $order) { ?>
				<tr>
					<td class="action action-one"><a class="edit" title="Edit" href="<?php echo $order['edit']; ?>"></a></td>
					<td><?php echo $order['order_id']; ?></td>
					<td><?php echo $order['location_name']; ?></td>
					<td><?php echo $order['first_name']; ?> <?php echo $order['last_name']; ?></td>
					<td class="center"><?php echo $order['order_status']; ?></td>
					<td class="center"><?php echo $order['order_type']; ?></td>
					<td class="center"><?php echo $order['order_time']; ?></td>
					<td class="center"><?php echo $order['date_added']; ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<?php } ?>
</div>
<!--[if IE]>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.flot.excanvas.js"); ?>"></script>
<![endif]--> 
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.flot.js"); ?>"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#chart-picker').on('click', 'a', function() {
		if ($(this).is(':not(.active)')) {
			$('#chart-picker li').removeClass('active');
			$(this).parent().addClass('active');
			$('input[name="type"]').val($(this).attr('rel'));
			getChart($('select[name="range"]').val());
		}
	});
});
//--></script> 
<script type="text/javascript"><!--
function getChart(range) {
	var type = $('input[name="type"]').val();
	if (range) {
		var url = '<?php echo site_url("admin/dashboard/chart?range="); ?>' + range + '&type=' + type;
	} else {
		var url = '<?php echo site_url("admin/dashboard/chart?range="); ?>' + $('select[name="range"]').val() + '&type=' + type;	
	}

	$.ajax({
		type: 'GET',
		url: url,
		dataType: 'json',
		async: false,
		success: function(json) {
			var option = {	
				shadowSize: 0,
				lines: { 
					show: true,
					fill: true,
					lineWidth: 4
				},
				points: {
					show: true 
				},
				grid: {
					backgroundColor: '#FFFFFF',
					borderWidth: 1,
					borderColor: '#DDDDD',
					hoverable: true,
					clickable: true
				},	
				legend: {
					position: 'nw'
				},
				xaxis: {
            		ticks: json.xaxis,
					font: {
						size: 12,
						lineHeight: 14,
						height: 'normal',
						color: '#000'
					}
				},
				yaxis: {
            		tickDecimals: 0,
					font: {
						size: 12,
						lineHeight: 14,
						weight: 'normal',
						color: '#000'
					},
					min: 0
				}
			}

			$.plot($('#chart-holder'), [json.totals], option);

			$('<div id="chart-tooltip"></div>').css({
				position: 'absolute',
				display: 'none',
				border: '1px solid #ddd',
				padding: '10px',
				'background-color': '#eee',
				opacity: 0.80,
				'font-size': '12px'
			}).appendTo('body');

			$('#chart-holder').bind('plothover', function (event, pos, item) {
				if (item) {
					for (i = 0; i < json.xaxis.length; i++) {
						var x_array = json.xaxis[i];
						if (x_array[0] == item.datapoint[0]) {
							var x_axis = x_array[1];
						}
					}
					
					var y_axis = item.datapoint[1];
					
					var html = '<span>' + x_axis + '</span>' + item.series.label + ': <b>' + y_axis + '</b>';
					
					$('#chart-tooltip').html(html)
						.css({top: item.pageY+5, left: item.pageX+5})
						.fadeIn(200);
				} else {
					$('#chart-tooltip').hide();
				}
			});
		}
	});
}

getChart($('select[name="range"]').val());
//--></script> 