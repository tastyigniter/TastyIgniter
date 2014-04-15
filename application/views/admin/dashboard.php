<div class="box">
	<div class="wrap_content">
		<ul class="numbers">
			<li>Total Sales<span><?php echo $total_sales; ?></span></li>
			<li>Total Sales This Year<span><?php echo $total_sales_by_year; ?></span></li>
			<li>Total Lost Sales<span><?php echo $total_lost_sales; ?></span></li>
			<li>Total Customers<span><?php echo $total_customers; ?></span></li>
			<li>Total Delivery Orders<span><?php echo $total_delivery_orders; ?></span></li>
			<li>Total Collection Orders<span><?php echo $total_collection_orders; ?></span></li>
			<li>Total Orders<span><?php echo $total_orders; ?></span></li>
			<li>Total Orders Completed<span><?php echo $total_orders_completed; ?></span></li>
			<li>Total Table(s) Reserved<span><?php echo $total_tables_reserved; ?></span></li>
		</ul>
	</div>
	<br />
	<br />
	
	<div class="chart wrap_content">
		<div class="dashboard_heading">
			<h2>Reports</h2>
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
				<?php foreach ($months as $key => $value) { ?>
					<option value="<?php echo $key; ?>" <?php echo set_select('monthly', $key); ?>><?php echo $value; ?></option>  	
				<?php } ?>
				</select>
				<a class="add_button" onClick="getChart()">Go</a>
			</div>
		</div>
		<div id="chart-holder" style="width:100%; height: 245px; margin: auto; padding: 0px; position: relative;"></div>
	</div>
	<br />
	<br />
	
	<?php if ($orders) { ?>
	<div class="wrap_content">
		<div class="dashboard_heading">
			<h2>10 Latest Orders</h2>
		</div>
		<table border="0" align="center" class="list">
		<tr>
			<th>Order ID</th>
			<th>Location</th>
			<th>Customer Name</th>
			<th class="center">Status</th>
			<th class="center">Type</th>
			<th class="center">Ready Time</th>
			<th class="center">Date Added</th>
			<th class="right">Action</th>
		</tr>
		<?php foreach ($orders as $order) { ?>
		<tr>
			<td class="id"><?php echo $order['order_id']; ?></td>
			<td><?php echo $order['location_name']; ?></td>
			<td><?php echo $order['first_name']; ?> <?php echo $order['last_name']; ?></td>
			<td class="center"><?php echo $order['order_status']; ?></td>
			<td class="center"><?php echo $order['order_type']; ?></td>
			<td class="center"><?php echo $order['order_time']; ?></td>
			<td class="center"><?php echo $order['date_added']; ?></td>
			<td class="right"><a class="edit" title="Edit" href="<?php echo $order['edit']; ?>"></a></td>
		</tr>
		<?php } ?>
		</table>
	</div>
	<?php } ?>
</div>
<!--[if IE]>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.flot.excanvas.js"); ?>"></script>
<![endif]--> 
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.flot.js"); ?>"></script>
<script type="text/javascript"><!--
function getChart(range) {
	if (range) {
		var url = '<?php echo site_url("admin/dashboard/chart?range="); ?>' + range;
	} else {
		var url = '<?php echo site_url("admin/dashboard/chart?range="); ?>' + $('select[name="range"]').val();	
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
					lineWidth: 1
				},
				points: {
					show: true 
				},
				grid: {
					backgroundColor: '#FFFFFF',
					borderWidth: 1,
					borderColor: '#DDDDD',
					hoverable: true,
				},	
				legend: {
					position: 'nw'
				},
				xaxis: {
            		ticks: json.xaxis,
					font: {
						size: 12,
						lineHeight: 14,
						weight: 'normal',
						color: '#000'
					}
				},
				yaxis: {
					font: {
						size: 12,
						lineHeight: 14,
						weight: 'normal',
						color: '#000'
					},
					min: 0
				}
			}

			$.plot($('#chart-holder'), [json.customers, json.orders, json.reservations], option);
		}
	});
}

getChart($('select[name="range"]').val());
//--></script> 
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery-ui-timepicker-addon.js"); ?>"></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#from-range, #to-range').datepicker({
		dateFormat: 'dd-mm-yy',
	});
});
//--></script>