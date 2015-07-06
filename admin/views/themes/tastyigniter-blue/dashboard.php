<?php echo get_header(); ?>
<div class="row content dashboard">
	<div class="col-md-12">
        <div class="mini-statistics">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-8">
                                    <span class="stat-heading"><?php echo lang('text_total_sale'); ?></span>
                                </div>
                                <div class="col-xs-4 text-right">
                                    <i class="stat-icon fa fa-line-chart fa-4x"></i>
                                </div>
                                <div class="col-xs-12"><span class="stat-text sales"><?php echo lang('text_dash_dash'); ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-9">
                                    <span class="stat-heading"><?php echo lang('text_total_customer'); ?></span>
                                </div>
                                <div class="col-xs-3 text-right">
                                    <i class="stat-icon fa fa-users fa-4x"></i>
                                </div>
                                <div class="col-xs-12"><span class="stat-text customers"><?php echo lang('text_dash_dash'); ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-9">
                                    <span class="stat-heading"><?php echo lang('text_total_order'); ?></span>
                                </div>
                                <div class="col-xs-3 text-right">
                                    <i class="stat-icon fa fa-shopping-cart fa-4x"></i>
                                </div>
                                <div class="col-xs-12"><span class="stat-text orders"><?php echo lang('text_dash_dash'); ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-9">
                                    <span class="stat-heading"><?php echo lang('text_total_reservation'); ?></span>
                                </div>
                                <div class="col-xs-3 text-right">
                                    <i class="stat-icon fa fa-calendar fa-4x"></i>
                                </div>
                                <div class="col-xs-12"><span class="stat-text tables_reserved"><?php echo lang('text_dash_dash'); ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="statistics">
			<div class="row">
				<div class="col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_complete_setup'); ?></h3></div>
						<div class="panel-body">
                            <div class="progress">
                                <div data-percentage="0%" style="width: 60%;" class="progress-bar progress-bar-info" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                    <span class="sr-only"><?php echo lang('text_progress_count'); ?> <?php echo lang('text_progress'); ?></span>
                                </div>
                                <span class="progress-type"><?php echo lang('text_progress_type'); ?></span>
                                <span class="progress-completed"><?php echo lang('text_progress_count'); ?></span>
                            </div>
							<span class="text-center"><?php echo lang('text_progress_summary'); ?></span><br />
							<div class="list-group check-list-group">
								<a href="#" class="list-group-item">
                                    <span class="check-icon pull-left"><i class="fa fa-check"></i></span>
                                    <span class="check-info"><?php echo lang('text_initial_progress'); ?></span>
                                </a>
								<a href="#" class="list-group-item">
                                    <span class="check-icon pull-left"><i class="fa fa-check"></i></span>
                                    <span class="check-info"><?php echo lang('text_settings_progress'); ?></span>
                                </a>
								<a href="#" class="list-group-item">
                                    <span class="check-icon pull-left"><i class="fa fa-check"></i></span>
                                    <span class="check-info"><?php echo lang('text_menus_progress'); ?></span>
                                </a>
								<a href="#" class="list-group-item">
                                    <span class="check-icon pull-left"><i class="fa fa-check"></i></span>
                                    <span class="check-info"><?php echo lang('text_design_progress'); ?></span>
                                </a>
								<a href="#" class="list-group-item">
                                    <span class="check-icon pull-left"><i class="fa fa-check"></i></span>
                                    <span class="check-info"><?php echo lang('text_email_progress'); ?></span>
                                </a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-default panel-statistics">
						<div class="panel-heading">
                            <div class="form-inline">
                                <div class="row">
                                    <div class="col-md-5 pull-left">
                                        <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_statistic'); ?></h3>
                                    </div>

                                    <div class="col-md-5 pull-right text-right">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                                <?php echo lang('text_range'); ?>&nbsp;&nbsp;<span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-range pull-right" role="menu">
                                                <li><a rel="today"><?php echo lang('text_today'); ?></a></li>
                                                <li><a rel="week"><?php echo lang('text_week'); ?></a></li>
                                                <li><a rel="month"><?php echo lang('text_month'); ?></a></li>
                                                <li><a rel="year"><?php echo lang('text_year'); ?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</div>
						<div class="panel-body">
							<div id="statistics">
								<ul class="list-group text-sm">
									<li class="list-group-item"><?php echo lang('text_total_sale'); ?> <span class="label label-default sales"><?php echo lang('text_zero'); ?></span></li>
									<li class="list-group-item"><?php echo lang('text_total_lost_sale'); ?> <span class="label label-default lost_sales"><?php echo lang('text_zero'); ?></span></li>
									<li class="list-group-item"><?php echo lang('text_total_customer'); ?> <span class="label label-default customers"><?php echo lang('text_zero'); ?></span></li>
									<li class="list-group-item"><?php echo lang('text_total_order'); ?> <span class="label label-default orders"><?php echo lang('text_zero'); ?></span></li>
									<li class="list-group-item"><?php echo lang('text_total_delivery_order'); ?> <span class="label label-default delivery_orders"><?php echo lang('text_zero'); ?></span></li>
									<li class="list-group-item"><?php echo lang('text_total_collection_order'); ?> <span class="label label-default collection_orders"><?php echo lang('text_zero'); ?></span></li>
									<li class="list-group-item"><?php echo lang('text_total_completed_order'); ?> <span class="label label-default orders_completed"><?php echo lang('text_zero'); ?></span></li>
									<li class="list-group-item"><?php echo lang('text_total_reserved_table'); ?><span class="label label-default tables_reserved"><?php echo lang('text_zero'); ?></span></li>
								</ul>
							</div>
  						</div>
					</div>
				</div>
			</div>
		</div>

        <div class="row">
            <div class="col-sm-4">
                <div class="panel panel-default panel-activities">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php echo lang('text_recent_activity'); ?></h3></div>
                    <ul class="list-group">
                        <?php if ($orders) { ?>
                            <?php foreach ($activities as $activity) { ?>
                                <li class="list-group-item">
                                    <div class="clearfix">
                                        <span class="activity-body"><i class="<?php echo $activity['icon']; ?> fa-fw"></i>
                                            <span class="small text-muted"><?php echo $activity['time']; ?>&nbsp;-&nbsp;</span>
                                            <?php echo $activity['message']; ?>
                                        </span>
                                        <span class="activity-time text-muted text-right small"><?php echo $activity['time_elapsed']; ?></span>
                                    </div>
                                </li>
                            <?php } ?>
                        <?php } else { ?>
                            <?php echo lang('text_no_activity'); ?>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col-sm-8">
                <?php if ($orders) { ?>
                <div class="panel panel-default panel-orders">
                    <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;<?php echo lang('text_latest_order'); ?></h3></div>
                    <div class="table-responsive">
                        <table border="0" class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="action action-one"></th>
                                    <th><?php echo lang('column_id'); ?></th>
                                    <th><?php echo lang('column_location'); ?></th>
                                    <th><?php echo lang('column_name'); ?></th>
                                    <th class="text-center"><?php echo lang('column_status'); ?></th>
                                    <th class="text-center"><?php echo lang('column_type'); ?></th>
                                    <th class="text-center"><?php echo lang('column_ready_type'); ?></th>
                                    <th class="text-center"><?php echo lang('column_date_added'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order) { ?>
                                <tr>
                                    <td class="action action-one"><a class="btn btn-edit" title="<?php echo lang('text_edit'); ?>" href="<?php echo $order['edit']; ?>"><i class="fa fa-pencil"></i></a></td>
                                    <td><?php echo $order['order_id']; ?></td>
                                    <td><?php echo $order['location_name']; ?></td>
                                    <td><?php echo $order['first_name']; ?> <?php echo $order['last_name']; ?></td>
                                    <td class="text-center"><span class="label label-default" style="background-color: <?php echo $order['status_color']; ?>;"><?php echo $order['order_status']; ?></span></td>
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

        <div class="panel panel-default panel-chart">
            <div class="panel-heading">
                <div class="form-inline">
                    <div class="row">
                        <div class="col-md-4 pull-left">
                            <h3 class="panel-title"><i class="fa fa-line-chart"></i>&nbsp;&nbsp;<?php echo lang('text_reports_chart'); ?></h3>
                        </div>

                        <div class="col-md-5 pull-right text-right">
                            <div class="form-group">
                                <div class="input-group">
                                    <button class="btn btn-default btn-sm daterange">
                                        <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span><?php echo lang('text_select_range'); ?></span>&nbsp;&nbsp;<i class="fa fa-caret-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="chart-legend"></div>
                <div class="chart-responsive">
                    <canvas id="chart-holder" width="960px" height="295px"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('.dropdown-menu-range a[rel="today"]').trigger('click');
});

$(document).on('click', '.dropdown-menu-range a', function() {
	if ($(this).parent().is(':not(.active)')) {
		$('.dropdown-menu-range li').removeClass('active');
		$(this).parent().addClass('active');
		var stat_range = $(this).attr('rel');
		getStatistics(stat_range);
	}
});

//--></script>
<script type="text/javascript"><!--
function getStatistics(stat_range) {
	$.ajax({
		type: 'GET',
		url: '<?php echo site_url("dashboard/statistics?stat_range="); ?>' + stat_range,
		dataType: 'json',
		async: false,
		success: function(json) {
			if (json) {
				$('#statistics .sales, .mini-statistics .sales').html(json['sales']);
				$('#statistics .lost_sales').html(json['lost_sales']);
				$('#statistics .customers, .mini-statistics .customers').html(json['customers']);
				$('#statistics .orders, .mini-statistics .orders').html(json['orders']);
				$('#statistics .orders_completed').html(json['orders_completed']);
				$('#statistics .delivery_orders').html(json['delivery_orders']);
				$('#statistics .collection_orders').html(json['collection_orders']);
				$('#statistics .tables_reserved, .mini-statistics .tables_reserved').html(json['tables_reserved']);
			}
		}
	});
}

$(document).ready(function() {
    $('button.daterange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
    getChart(moment().subtract(29, 'days').format('YYYY-MM-DD'), moment().format('YYYY-MM-DD'));

    $('button.daterange').daterangepicker({
        format: 'DD/MM/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        showDropdowns: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'left',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
        $('button.daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });

    $('button.daterange').on('cancel.daterangepicker', function(ev, picker) {
        $('button.daterange').val('');
    });

    $('button.daterange').on('apply.daterangepicker', function(ev, picker) {
        getChart(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'));
    });
});

function getChart(startDate, endDate) {
    var ctx = $("#chart-holder").get(0).getContext("2d");
    var myLineChart;

	$.ajax({
		type: 'GET',
		url: '<?php echo site_url("dashboard/chart?start_date="); ?>' + startDate + '&end_date=' + endDate,
		dataType: 'json',
		async: false,
		success: function(json) {
            var myChartData = {
                labels: json.labels,
                datasets: [
                    {
                        label: json.customers.label,
                        fillColor: "rgba(" + json.customers.color + ",0.2)",
                        strokeColor:  "rgba(" + json.customers.color + ",1)",
                        pointColor:  "rgba(" + json.customers.color + ",1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke:  json.customers.color, //"rgba(220,220,220,1)",
                        data:  json.customers.data
                    },
                    {
                        label: json.orders.label,
                        fillColor: "rgba(" + json.orders.color + ",0.2)",
                        strokeColor:  "rgba(" + json.orders.color + ",1)",
                        pointColor:  "rgba(" + json.orders.color + ",1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke:  "rgba(" + json.orders.color + ",1)",
                        data:  json.orders.data
                    },
                    {
                        label: json.reservations.label,
                        fillColor: "rgba(" + json.reservations.color + ",0.2)",
                        strokeColor:  "rgba(" + json.reservations.color + ",1)",
                        pointColor:  "rgba(" + json.reservations.color + ",1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke:  "rgba(" + json.reservations.color + ",1)",
                        data:  json.reservations.data
                    },
                    {
                        label: json.reviews.label,
                        fillColor: "rgba(" + json.reviews.color + ",0.2)",
                        strokeColor:  "rgba(" + json.reviews.color + ",1)",
                        pointColor:  "rgba(" + json.reviews.color + ",1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke:  "rgba(" + json.reviews.color + ",1)",
                        data:  json.reviews.data
                    }
                ]
            };

            myLineChart = new Chart(ctx).Line(myChartData, {
                responsive: true,
                legendTemplate : "<p class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><span class=\"label label-default\" style=\"background-color:<%=datasets[i].pointColor%>\"><%if(datasets[i].label){%><%=datasets[i].label%><%}%></span><%}%></p>"
            });

            $('.chart-legend').html(myLineChart.generateLegend());
        }
	});
}
//--></script>
<?php echo get_footer(); ?>