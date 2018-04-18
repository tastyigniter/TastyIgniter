<?php
$activities = null;
$news_feed = null;
$top_customers = null;
$orders = null;
?>
<div class="row content dashboard hide">
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
                                <span class="stat-text text-red sales"><?= lang('admin::dashboard.text_dash_dash'); ?></span>
                                <span class="stat-heading text-red"><?= lang('admin::dashboard.text_total_sale'); ?></span>
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
                                <span class="stat-text text-green orders"><?= lang('admin::dashboard.text_dash_dash'); ?></span>
                                <span class="stat-heading text-green"><?= lang('admin::dashboard.text_total_order'); ?></span>
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
                                <span class="stat-text text-blue customers"><?= lang('admin::dashboard.text_dash_dash'); ?></span>
                                <span class="stat-heading text-blue"><?= lang('admin::dashboard.text_total_customer'); ?></span>
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
                                <span class="stat-text text-primary tables_reserved"><?= lang('admin::dashboard.text_dash_dash'); ?></span>
                                <span class="stat-heading text-primary"><?= lang('admin::dashboard.text_total_reservation'); ?></span>
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
                                    <h3 class="panel-title">
                                        <i class="fa fa-line-chart"></i>&nbsp;&nbsp;<?= lang('admin::dashboard.text_reports_chart'); ?>
                                    </h3>
                                </div>

                                <div class="col-md-5 pull-right text-right">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <button class="btn btn-default btn-xs daterange">
                                                <i class="fa fa-calendar"></i>&nbsp;&nbsp;<span><?= lang('admin::dashboard.text_select_range'); ?></span>&nbsp;&nbsp;<i
                                                    class="fa fa-caret-down"></i>
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
                                    <h3 class="panel-title">
                                        <i class="fa fa-bar-chart-o fa-fw"></i>&nbsp;&nbsp;<?= lang('admin::dashboard.text_statistic'); ?>
                                    </h3>
                                </div>

                                <div class="col-md-5 pull-right text-right">
                                    <div class="form-group">
                                        <button type="button"
                                                class="btn btn-default btn-xs dropdown-toggle"
                                                data-toggle="dropdown">
                                            <?= lang('admin::dashboard.text_range'); ?>&nbsp;&nbsp;<span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-range pull-right" role="menu">
                                            <li><a rel="today"><?= lang('admin::dashboard.text_today'); ?></a></li>
                                            <li><a rel="week"><?= lang('admin::dashboard.text_week'); ?></a></li>
                                            <li><a rel="month"><?= lang('admin::dashboard.text_month'); ?></a></li>
                                            <li><a rel="year"><?= lang('admin::dashboard.text_year'); ?></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="statistics">
                        <ul class="list-group">
                            <li class="list-group-item"><?= lang('admin::dashboard.text_total_sale'); ?>
                                <span class="text-primary sales"><?= lang('admin::dashboard.text_zero'); ?></span></li>
                            <li class="list-group-item"><?= lang('admin::dashboard.text_total_lost_sale'); ?>
                                <span class="text-red lost_sales"><?= lang('admin::dashboard.text_zero'); ?></span></li>
                            <li class="list-group-item"><?= lang('admin::dashboard.text_total_cash_payment'); ?>
                                <span class="text-yellow cash_payments"><?= lang('admin::dashboard.text_zero'); ?></span>
                            </li>
                            <li class="list-group-item"><?= lang('admin::dashboard.text_total_customer'); ?>
                                <span class="text-blue customers"><?= lang('admin::dashboard.text_zero'); ?></span></li>
                            <li class="list-group-item"><?= lang('admin::dashboard.text_total_order'); ?>
                                <span class="text-green orders"><?= lang('admin::dashboard.text_zero'); ?></span></li>
                            <li class="list-group-item"><?= lang('admin::dashboard.text_total_delivery_order'); ?>
                                <span class="text-success delivery_orders"><?= lang('admin::dashboard.text_zero'); ?></span>
                            </li>
                            <li class="list-group-item"><?= lang('admin::dashboard.text_total_collection_order'); ?>
                                <span class="text-info collection_orders"><?= lang('admin::dashboard.text_zero'); ?></span>
                            </li>
                            <li class="list-group-item"><?= lang('admin::dashboard.text_total_completed_order'); ?>
                                <span class="text-danger orders_completed"><?= lang('admin::dashboard.text_zero'); ?></span>
                            </li>
                            <li class="list-group-item"><?= lang('admin::dashboard.text_total_reserved_table'); ?>
                                <span class="text-primary tables_reserved"><?= lang('admin::dashboard.text_zero'); ?></span>
                            </li>
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
                        <div class="panel-heading">
                            <h3 class="panel-title"><?= lang('admin::dashboard.text_complete_setup'); ?></h3>
                        </div>
                        <div class="panel-body">
                            <h5><?= lang('admin::dashboard.text_progress_summary'); ?></h5>
                        </div>
                        <div class="list-group check-list-group">
                            <a href="<?= admin_url('settings#location'); ?>" class="list-group-item">
                                <span class=""><?= lang('admin::dashboard.text_settings_progress'); ?></span>
                            </a>
                            <a href="<?= admin_url('menus'); ?>" class="list-group-item">
                                <span class=""><?= lang('admin::dashboard.text_menus_progress'); ?></span>
                            </a>
                            <a href="<?= admin_url('themes'); ?>" class="list-group-item">
                                <span class=""><?= lang('admin::dashboard.text_design_progress'); ?></span>
                            </a>
                            <a href="<?= admin_url('settings#mail'); ?>" class="list-group-item">
                                <span class=""><?= lang('admin::dashboard.text_email_progress'); ?></span>
                            </a>
                        </div>
                        <div class="panel-footer"></div>
                    </div>

                    <div class="panel panel-default panel-activities">
                        <div class="panel-heading"><h3 class="panel-title">
                                <i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?= lang('admin::dashboard.text_recent_activity'); ?>
                            </h3>
                        </div>
                        <ul class="list-group">
                            <?php if ($activities) { ?>
                                <?php foreach ($activities as $activity) { ?>
                                    <li class="list-group-item">
                                        <div class="clearfix">
                                            <div class="activity-body">
                                                <i class="<?= $activity['icon']; ?> fa-fw bg-primary"></i>
                                                <?= $activity['message']; ?>
                                                <span class="activity-time text-muted small">
                                                <span class="small"><?= $activity['time']; ?>&nbsp;-&nbsp;<?= $activity['time_elapsed']; ?></span>
                                            </span>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            <?php }
                            else { ?>
                                <?= lang('admin::dashboard.text_no_activity'); ?>
                            <?php } ?>
                        </ul>
                        <div class="panel-footer text-right">
                            <a href="<?= admin_url('activities'); ?>"><?= lang('admin::default.text_see_all_activity'); ?>&nbsp;<i
                                    class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <?php if ($news_feed) { ?>
                        <div class="panel panel-default panel-news-feed">
                            <div class="panel-heading"><h3 class="panel-title">
                                    <i class="fa fa-rss"></i>&nbsp;&nbsp;<?= lang('admin::dashboard.text_news'); ?></h3>
                            </div>
                            <div class="list-group">
                                <?php foreach ($news_feed as $feed) { ?>
                                    <a class="list-group-item" target="_blank" href="<?= $feed['link']; ?>">
                                        <h5 class="text-primary"><?= $feed['title']; ?></h5>
                                        <span class="text-muted"><?= strip_tags(substr($feed['description'], 0, 75)).'...'; ?></span>
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="panel-footer"></div>
                        </div>
                    <?php } ?>

                    <?php if ($top_customers) { ?>
                        <div class="panel panel-default panel-top-customers">
                            <div class="panel-heading"><h3 class="panel-title">
                                    <i class="fa fa-list-alt"></i>&nbsp;&nbsp;<?= lang('admin::dashboard.text_top_customers'); ?>
                                </h3></div>
                            <div class="table-responsive">
                                <table border="0" class="table table-striped table-no-spacing">
                                    <thead>
                                    <tr>
                                        <th><?= lang('admin::dashboard.column_name'); ?></th>
                                        <th class="text-center"><?= lang('admin::dashboard.column_total_orders'); ?></th>
                                        <th class="text-center"><?= lang('admin::dashboard.column_total_sale'); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($top_customers as $top_customer) { ?>
                                        <tr>
                                            <td><?= $top_customer['first_name']; ?> <?= $top_customer['last_name']; ?></td>
                                            <td class="text-center"><?= $top_customer['total_orders']; ?></td>
                                            <td class="text-center"><?= $top_customer['total_sale']; ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer text-right">
                                <a href="<?= admin_url('customers'); ?>"><?= lang('admin::default.text_see_all_customers'); ?>&nbsp;<i
                                        class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php if ($orders) { ?>
            <div class="panel panel-default panel-orders">
                <div class="panel-heading"><h3 class="panel-title">
                        <i class="fa fa-list-alt"></i>&nbsp;&nbsp;<?= lang('admin::dashboard.text_latest_order'); ?>
                    </h3></div>
                <div class="table-responsive">
                    <table border="0" class="table table-striped table-no-spacing">
                        <thead>
                        <tr>
                            <th class="action action-one"></th>
                            <th><?= lang('admin::default.column_id'); ?></th>
                            <th><?= lang('admin::dashboard.column_location'); ?></th>
                            <th><?= lang('admin::dashboard.column_name'); ?></th>
                            <th class="text-center"><?= lang('admin::dashboard.column_status'); ?></th>
                            <th class="text-center"><?= lang('admin::dashboard.column_type'); ?></th>
                            <th class="text-center"><?= lang('admin::dashboard.column_ready_type'); ?></th>
                            <th class="text-center"><?= lang('admin::dashboard.column_date_added'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td class="action action-one"><a class="btn btn-edit"
                                                                 title="<?= lang('admin::default.text_edit'); ?>"
                                                                 href="<?= $order['edit']; ?>"><i class="fa fa-pencil"></i></a>
                                </td>
                                <td><?= $order['order_id']; ?></td>
                                <td><?= $order['location_name']; ?></td>
                                <td><?= $order['first_name']; ?> <?= $order['last_name']; ?></td>
                                <td class="text-center"><span class="label label-default"
                                                              style="background-color: <?= $order['status_color']; ?>;"><?= $order['order_status']; ?></span>
                                </td>
                                <td class="text-center"><?= $order['order_type']; ?></td>
                                <td class="text-center"><?= $order['order_time']; ?></td>
                                <td class="text-center"><?= $order['date_added']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="panel-footer text-right">
                    <a href="<?= admin_url('orders'); ?>"><?= lang('admin::default.text_see_all_orders'); ?>&nbsp;<i
                            class="fa fa-arrow-right"></i></a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript"><!--
    //    $(document).on('click', '.dropdown-menu-range a', function () {
    //        if ($(this).parent().is(':not(.active)')) {
    //            $('.dropdown-menu-range li').removeClass('active')
    //            $(this).parent().addClass('active')
    //            var stat_range = $(this).attr('rel')
    //            getStatistics(stat_range)
    //        }
    //    })
    //
    //    function getStatistics(stat_range) {
    //        $.ajax({
    //            type: 'GET',
    //            url: '<?//= admin_url("dashboard/statistics?stat_range="); ?>//' + stat_range,
    //            dataType: 'json',
    //            async: false,
    //            success: function (json) {
    //                if (json) {
    //                    $('#statistics .sales, .mini-statistics .sales').html(json['sales'])
    //                    $('#statistics .lost_sales').html(json['lost_sales'])
    //                    $('#statistics .cash_payments').html(json['cash_payments'])
    //                    $('#statistics .customers, .mini-statistics .customers').html(json['customers'])
    //                    $('#statistics .orders, .mini-statistics .orders').html(json['orders'])
    //                    $('#statistics .orders_completed').html(json['orders_completed'])
    //                    $('#statistics .delivery_orders').html(json['delivery_orders'])
    //                    $('#statistics .collection_orders').html(json['collection_orders'])
    //                    $('#statistics .tables_reserved, .mini-statistics .tables_reserved').html(json['tables_reserved'])
    //                }
    //            }
    //        })
    //    }
    //
    //    $(document).ready(function () {
    //        $('button.daterange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'))
    //        getChart(moment().subtract(29, 'days').format('YYYY-MM-DD'), moment().format('YYYY-MM-DD'))
    //
    //        $('button.daterange').daterangepicker({
    //            format: 'DD/MM/YYYY',
    //            startDate: moment().subtract(29, 'days'),
    //            endDate: moment(),
    //            showDropdowns: true,
    //            ranges: {
    //                'Today': [moment(), moment()],
    //                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    //                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    //                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    //                'This Month': [moment().startOf('month'), moment().endOf('month')],
    //                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    //            },
    //            opens: 'left',
    //            buttonClasses: ['btn', 'btn-xs'],
    //            applyClass: 'btn-primary',
    //            cancelClass: 'btn-default',
    //            separator: ' to ',
    //            locale: {
    //                applyLabel: 'Submit',
    //                cancelLabel: 'Cancel',
    //                fromLabel: 'From',
    //                toLabel: 'To',
    //                customRangeLabel: 'Custom',
    //                daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
    //                monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
    //                firstDay: 1
    //            }
    //        }, function (start, end, label) {
    //            $('button.daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
    //        })
    //
    //        $('button.daterange').on('cancel.daterangepicker', function (ev, picker) {
    //            $('button.daterange').val('')
    //        })
    //
    //        $('button.daterange').on('apply.daterangepicker', function (ev, picker) {
    //            getChart(picker.startDate.format('YYYY-MM-DD'), picker.endDate.format('YYYY-MM-DD'))
    //        })
    //
    //        $('.dropdown-menu-range a[rel="today"]').trigger('click')
    //    })
    //
    //    var monthNames = [
    //        "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul",
    //        "Aug", "Sep", "Oct", "Nov", "Dec"
    //    ]
    //
    //    var myAreaChart = Morris.Area({
    //        element: 'chart-holder',
    //        data: [],
    //        xkey: 'time',
    //        ykeys: ['customers', 'orders', 'reservations', 'reviews'],
    //        labels: ['Total customer', 'Total order', 'Total reservation', 'Total reviews'],
    //        lineColors: ['#63ADD0', '#5CB85C', '#337AB7', '#D9534F'],
    //        parseTime: false,
    //        behaveLikeLine: false,
    //        resize: true,
    //        hideHover: true,
    //    })
    //
    //    function getChart(startDate, endDate) {
    //        $.ajax({
    //            type: 'GET',
    //            url: '<?//= admin_url("dashboard/chart?start_date="); ?>//' + startDate + '&end_date=' + endDate,
    //            dataType: 'json',
    //            async: false,
    //            success: function (json) {
    //                myAreaChart.setData(json.data)
    //            }
    //        })
    //    }
    //--></script>
