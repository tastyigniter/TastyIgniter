<?php echo get_header(); ?>
<div class="row content dashboard">
	<div class="col-md-12">
        <div class="row mini-statistics">
            <div class="col-xs-12 col-sm-6 col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4 stat-icon">
                                <span class="bg-red"><i class="fa fa-line-chart fa-2x"></i></span>
                            </div>
                            <div class="col-xs-8 stat-content">
                                <span class="stat-text text-red sales"><?php echo lang('text_dash_dash'); ?></span>
                                <span class="stat-heading text-red"><?php echo lang('text_total_sale'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4 stat-icon">
                                <span class="bg-blue"><i class="stat-icon fa fa-users fa-2x"></i></span>
                            </div>
                            <div class="col-xs-8 stat-content">
                                <span class="stat-text text-blue customers"><?php echo lang('text_dash_dash'); ?></span>
                                <span class="stat-heading text-blue"><?php echo lang('text_total_customer'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4 stat-icon">
                                <span class="bg-green"><i class="stat-icon fa fa-shopping-cart fa-2x"></i></span>
                            </div>
                            <div class="col-xs-8 stat-content">
                                <span class="stat-text text-green orders"><?php echo lang('text_dash_dash'); ?></span>
                                <span class="stat-heading text-green"><?php echo lang('text_total_order'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-4 stat-icon">
                                <span class="bg-primary"><i class="stat-icon fa fa-calendar fa-2x"></i></span>
                            </div>
                            <div class="col-xs-8 stat-content">
                                <span class="stat-text text-primary tables_reserved"><?php echo lang('text_dash_dash'); ?></span>
                                <span class="stat-heading text-primary"><?php echo lang('text_total_reservation'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row statistics">
        	<div class="col-sm-12 col-md-8">
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
                                            <button class="btn btn-default btn-xs daterange">
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
                            <div id="chart-holder" width="600px" height="295px"></div>
                        </div>
                    </div>
                </div>
        	</div>
            <div class="col-sm-12 col-md-4">
                <div class="panel panel-default panel-statistics">
                    <div class="panel-heading">
                        <div class="form-inline">
                            <div class="row">
                                <div class="col-md-5 pull-left">
                                    <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>&nbsp;&nbsp;<?php echo lang('text_statistic'); ?></h3>
                                </div>

                                <div class="col-md-5 pull-right text-right">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
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
                    <div id="statistics">
                        <ul class="list-group text-sm">
                            <li class="list-group-item"><?php echo lang('text_total_sale'); ?> <span class="text-red sales"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_lost_sale'); ?> <span class="text-yellow lost_sales"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_cash_payment'); ?><span class="text-primary cash_payments"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_customer'); ?> <span class="text-blue customers"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_order'); ?> <span class="text-green orders"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_delivery_order'); ?> <span class="text-success delivery_orders"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_collection_order'); ?> <span class="text-info collection_orders"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_completed_order'); ?> <span class="text-danger orders_completed"><?php echo lang('text_zero'); ?></span></li>
                            <li class="list-group-item"><?php echo lang('text_total_reserved_table'); ?><span class="text-primary tables_reserved"><?php echo lang('text_zero'); ?></span></li>
                        </ul>
                    </div>
                    <div class="panel-footer"></div>
                </div>
            </div>
        </div>


        <div>
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<div class="panel panel-default">
						<div class="panel-heading"><h3 class="panel-title"><?php echo lang('text_complete_setup'); ?></h3></div>
						<div class="panel-body">
                            <h5><?php echo lang('text_progress_summary'); ?></h5>
						</div>
                        <div class="list-group check-list-group">
                            <a href="<?php echo site_url('settings#location'); ?>" class="list-group-item">
                                <span class=""><?php echo lang('text_settings_progress'); ?></span>
                            </a>
                            <a href="<?php echo site_url('menus'); ?>" class="list-group-item">
                                <span class=""><?php echo lang('text_menus_progress'); ?></span>
                            </a>
                            <a href="<?php echo site_url('themes'); ?>" class="list-group-item">
                                <span class=""><?php echo lang('text_design_progress'); ?></span>
                            </a>
                            <a href="<?php echo site_url('settings#mail'); ?>" class="list-group-item">
                                <span class=""><?php echo lang('text_email_progress'); ?></span>
                            </a>
                        </div>
                        <div class="panel-footer"></div>
                    </div>

                    <div class="panel panel-default panel-activities">
                        <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php echo lang('text_recent_activity'); ?></h3></div>
                        <ul class="list-group">
                            <?php if ($activities) { ?>
                                <?php foreach ($activities as $activity) { ?>
                                    <li class="list-group-item">
                                        <div class="clearfix">
                                            <div class="activity-body"><i class="<?php echo $activity['icon']; ?> fa-fw bg-primary"></i>
                                                <?php echo $activity['message']; ?>
                                                <span class="activity-time text-muted small">
                                                <span class="small"><?php echo $activity['time']; ?>&nbsp;-&nbsp;<?php echo $activity['time_elapsed']; ?></span>
                                            </span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } else { ?>
                                <?php echo lang('text_no_activity'); ?>
                            <?php } ?>
                        </ul>
                        <div class="panel-footer text-right">
                            <a href="<?php echo site_url('activities'); ?>"><?php echo lang('text_see_all_activity'); ?>&nbsp;<i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <?php if ($news_feed) { ?>
                        <div class="panel panel-default panel-news-feed">
                            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-rss"></i>&nbsp;&nbsp;<?php echo lang('text_news'); ?></h3></div>
                            <div class="list-group">
                                <?php foreach ($news_feed as $feed) { ?>
                                    <a class="list-group-item" target="_blank" href="<?php echo $feed['link']; ?>">
                                        <h5 class="text-primary"><?php echo $feed['title']; ?></h5>
                                        <span class="text-muted"><?php echo strip_tags(substr($feed['description'], 0, 75)).'...'; ?></span>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="panel-footer"></div>
                        </div>
                    <?php } ?>

                    <?php if ($top_customers) { ?>
                        <div class="panel panel-default panel-top-customers">
                            <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;<?php echo lang('text_top_customers'); ?></h3></div>
                            <div class="table-responsive">
                                <table border="0" class="table table-striped table-no-spacing">
                                    <thead>
                                    <tr>
                                        <th><?php echo lang('column_name'); ?></th>
                                        <th class="text-center"><?php echo lang('column_total_orders'); ?></th>
                                        <th class="text-center"><?php echo lang('column_total_sale'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($top_customers as $top_customer) { ?>
                                        <tr>
                                            <td><?php echo $top_customer['first_name']; ?> <?php echo $top_customer['last_name']; ?></td>
                                            <td class="text-center"><?php echo $top_customer['total_orders']; ?></td>
                                            <td class="text-center"><?php echo $top_customer['total_sale']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer text-right">
                                <a href="<?php echo site_url('customers'); ?>"><?php echo lang('text_see_all_customers'); ?>&nbsp;<i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
			</div>
		</div>

        <?php if ($orders) { ?>
            <div class="panel panel-default panel-orders">
                <div class="panel-heading"><h3 class="panel-title"><i class="fa fa-list-alt"></i>&nbsp;&nbsp;<?php echo lang('text_latest_order'); ?></h3></div>
                <div class="table-responsive">
                    <table border="0" class="table table-striped table-no-spacing">
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
                <div class="panel-footer text-right">
                    <a href="<?php echo site_url('orders'); ?>"><?php echo lang('text_see_all_orders'); ?>&nbsp;<i class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript"><!--
$(document).on('click', '.dropdown-menu-range a', function() {
	if ($(this).parent().is(':not(.active)')) {
		$('.dropdown-menu-range li').removeClass('active');
		$(this).parent().addClass('active');
		var stat_range = $(this).attr('rel');
		getStatistics(stat_range);
	}
});

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
                $('#statistics .cash_payments').html(json['cash_payments']);
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
        buttonClasses: ['btn', 'btn-xs'],
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

    $('.dropdown-menu-range a[rel="today"]').trigger('click');
});

var monthNames = [
    "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
    "Aug", "Sep", "Oct", "Nov", "Dec"
];

var myAreaChart = Morris.Area({
    element: 'chart-holder',
    data: [],
    xkey: 'time',
    ykeys: ['customers', 'orders', 'reservations', 'reviews'],
    labels: ['Total customer', 'Total order', 'Total reservation', 'Total reviews'],
    lineColors: ['#63ADD0', '#5CB85C', '#337AB7', '#D9534F'],
    parseTime: false,
    behaveLikeLine: false,
    resize: true,
    hideHover: true,
});

function getChart(startDate, endDate) {
    $.ajax({
		type: 'GET',
		url: '<?php echo site_url("dashboard/chart?start_date="); ?>' + startDate + '&end_date=' + endDate,
		dataType: 'json',
		async: false,
		success: function(json) {
            myAreaChart.setData(json.data);
        }
	});
}
//--></script>
<?php echo get_footer(); ?>