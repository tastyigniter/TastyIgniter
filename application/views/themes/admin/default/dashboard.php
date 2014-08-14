<?php echo $header; ?>
<div class="row content dashboard">
	<div class="col-md-12">
		<div id="notification">
		<?php if (!empty($alert)) { ?>
			<div class="alert alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<?php echo $alert; ?>
			</div>
		<?php } ?>
		</div>

		<div class="statistics">
			<div class="row">
				<div class="col-md-6 wrap-all">
					<div class="panel panel-default panel-statistics">
						<div class="panel-heading">
							<ul class="nav nav-tabs nav-tabs-statistics" role="tablist">
								<li><a rel="today">Today</a></li>
								<li><a rel="week">Week</a></li>
								<li><a rel="month">Month</a></li>
								<li><a rel="year">Year</a></li>
							</ul>
						</div>
						<div class="panel-body">
							<div id="statistics">
								<ul class="list-group">
									<li class="list-group-item">Total Sales <span class="sales">0</span></li>
									<li class="list-group-item">Total Lost Sales <span class="lost_sales">0</span></li>
									<li class="list-group-item">Total Customers <span class="customers">0</span></li>
									<li class="list-group-item">Total Orders <span class="orders">0</span></li>
									<li class="list-group-item">Total Delivery Orders<span class="delivery_orders">0</span></li>
									<li class="list-group-item">Total Collection Orders<span class="collection_orders">0</span></li>
									<li class="list-group-item">Total Orders Completed<span class="orders_completed">0</span></li>
									<li class="list-group-item">Total Table(s) Reserved<span class="tables_reserved">0</span></li>
								</ul>
							</div>
  						</div>
					</div>
				</div>
				<div class="col-md-6 wrap-all">
					<div class="panel panel-default">
						<div class="panel-heading"><h3 class="panel-title">Set Up Steps</h3></div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="panel panel-default panel-chart">
			<div class="panel-heading">
				<div class="form-inline">
					<div class="row">
						<div class="col-md-2 pull-left">
							<h3 class="panel-title"><i class="fa fa-bar-chart-o"></i>&nbsp;&nbsp;Reports Chart</h3>
						</div>
						
						<div class="col-md-5 pull-left text-right">
							<div class="btn-group btn-group-sm chart-picker">
								<button type="button" class="btn btn-default" data-type="customers">Customers</button>
								<button type="button" class="btn btn-default active" data-type="orders">Orders</button>
								<button type="button" class="btn btn-default" data-type="reservations">Reservations</button>
								<button type="button" class="btn btn-default" data-type="reviews">Reviews</button>
								<input type="hidden" name="type" value="" />
							</div>
						</div>
						
						<div class="col-md-5 pull-right text-right">
							<div class="form-group text-left">
								<select name="range" class="form-control input-sm" onChange="getChart()">
									<option value="">Select Period</option>  	
									<option value="today" selected="selected">Today</option>  	
									<option value="yesterday">Yesterday</option>  	
									<option value="week">This Week</option>
									<option value="last_week">Last Week</option>
									<option value="month">This Month</option>
									<option value="year">This Year</option>
								</select>
							</div>
							&nbsp;&nbsp;&nbsp; - OR - &nbsp;&nbsp;&nbsp;
							<div class="form-group text-left">
								<select name="monthly" class="form-control input-sm" onChange="getChart()">
									<option value="">Select Month</option>  	
									<?php foreach ($months as $key => $value) { ?>
										<option value="<?php echo $key; ?>" <?php echo set_select('monthly', $key); ?>><?php echo $value; ?></option>  	
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div class="panel-body">
				<div id="chart-holder" style="height: 295px; margin: auto; padding: 0px; position: relative;"></div>
			</div>
		</div>
	
		<?php if ($orders) { ?>
		<div class="panel panel-default panel-orders">
			<div class="panel-heading"><h3 class="panel-title"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;10 Latest Orders</h3></div>
			<div class="table-responsive">
				<table border="0" class="table table-striped table-border">
					<thead>
						<tr>
							<th class="action action-one"></th>
							<th>ID</th>
							<th>Location</th>
							<th>Customer Name</th>
							<th class="text-center">Status</th>
							<th class="text-center">Type</th>
							<th class="text-center">Ready Time</th>
							<th class="text-center">Date Added</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($orders as $order) { ?>
						<tr>
							<td class="action action-one"><a class="btn btn-edit" title="Edit" href="<?php echo $order['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
							<td><?php echo $order['order_id']; ?></td>
							<td><?php echo $order['location_name']; ?></td>
							<td><?php echo $order['first_name']; ?> <?php echo $order['last_name']; ?></td>
							<td class="text-center"><?php echo $order['order_status']; ?></td>
							<td class="text-center"><?php echo $order['order_type']; ?></td>
							<td class="text-center"><?php echo $order['order_time']; ?></td>
							<td class="text-center"><?php echo $order['date_added']; ?></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
<!--[if IE]>
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.flot.excanvas.js"); ?>"></script>
<![endif]--> 
<script type="text/javascript" src="<?php echo base_url("assets/js/jquery.flot.js"); ?>"></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.nav-tabs-statistics a[rel="today"]').trigger('click');
});

$(document).on('click', '.nav-tabs-statistics a', function() {
	if ($(this).parent().is(':not(.active)')) {
		$('.nav-tabs-statistics li').removeClass('active');
		$(this).parent().addClass('active');
		var stat_range = $(this).attr('rel');
		getStatistics(stat_range);
	}
});

$(document).on('click', '.chart-picker button', function() {
	if ($(this).is(':not(.active)')) {
		$('.chart-picker button').removeClass('active');
		$(this).addClass('active');
		$('input[name="type"]').val($(this).attr('data-type'));
		getChart();
	}
});
//--></script> 
<script type="text/javascript"><!--
function getStatistics(stat_range) {
	$.ajax({
		type: 'GET',
		url: '<?php echo site_url("admin/dashboard/statistics?stat_range="); ?>' + stat_range,
		dataType: 'json',
		async: false,
		success: function(json) {
			if (json) {
				$('#statistics .sales').html(json['sales']);
				$('#statistics .lost_sales').html(json['lost_sales']);
				$('#statistics .customers').html(json['customers']);
				$('#statistics .orders').html(json['orders']);
				$('#statistics .orders_completed').html(json['orders_completed']);
				$('#statistics .delivery_orders').html(json['delivery_orders']);
				$('#statistics .collection_orders').html(json['collection_orders']);
				$('#statistics .tables_reserved').html(json['tables_reserved']);
			}
		}
	});
}

function getChart(range) {
	var type = $('input[name="type"]').val();
	var range = $('select[name="range"]').val();
	var monthly = $('select[name="monthly"]').val();
	
	if (monthly) {
		var url = '<?php echo site_url("admin/dashboard/chart?range="); ?>' + monthly + '&type=' + type;
	} else {
		var url = '<?php echo site_url("admin/dashboard/chart?range="); ?>' + range + '&type=' + type;	
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
				border: '3px solid #ddd',
				padding: '10px',
				'border-radius': '10px',
				'background-color': '#FFFFFF',
				opacity: 0.80,
				'font-size': '12px',
				'color': '#000000'
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
					
					var html = '<b>' + x_axis + '</b><span>' + item.series.label + ': ' + y_axis + '</span>';
					
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
<?php echo $footer; ?>