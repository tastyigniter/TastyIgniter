<?php namespace Admin\Controllers;

use AdminAuth;
use AdminMenu;
use Request;
use Template;

class Dashboard extends \Admin\Classes\AdminController
{
    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('dashboard');
    }

    public function index()
    {
        if (is_null(Request::segment(2)))
            return $this->redirect('dashboard');

        Template::setTitle(lang('admin::dashboard.text_title'));
        Template::setHeading(lang('admin::dashboard.text_heading'));

//        Assets::addCss(assets_url('js/daterange/daterangepicker-bs3.css'), 'daterangepicker-css');
//        Assets::addJs(assets_url('js/daterange/moment.min.js'), 'daterange-moment-js');
//        Assets::addJs(assets_url('js/daterange/daterangepicker.js'), 'daterangepicker-js');
//        Assets::addCss(assets_url('js/morris/morris.css'), 'chart-css');
//        Assets::addJs(assets_url('js/morris/raphael-min.js'), 'raphael-min-js');
//        Assets::addJs(assets_url('js/morris/morris.min.js'), 'morris-min-js');

//        $data['activities'] = $this->getActivities();
//        $data['top_customers'] = $this->getTopCustomers();
//        $data['orders'] = $this->getRecentOrders();
//        $data['news_feed'] = $this->Dashboard_model->getNewsFeed();  // Get four items from the feed
//
//        if ($this->config->item('auto_update_currency_rates') == '1') {
//            $this->load->model('Currencies_model');
//            if ($this->Currencies_model->updateRates()) {
//                flash()->success_now(lang('system::currencies.alert_rates_updated'));
//            }
//        }
//
//        if (!$this->updates_manager->isLastCheckDue()) {
//            flash()->success_now(sprintf(lang('admin::dashboard.text_last_version_check'), admin_url('updates')));
//        }

        return $this->makeView('dashboard');
    }

//    public function statistics()
//    {
//        $json = [];
//
//        $stat_range = 'today';
//        if (get('stat_range')) {
//            $stat_range = get('stat_range');
//        }
//
//        $result = $this->Dashboard_model->getStatistics($stat_range);
//        $json['sales'] = (empty($result['sales'])) ? $this->currency->format('0.00') : $this->currency->format($result['sales']);
//        $json['lost_sales'] = (empty($result['lost_sales'])) ? $this->currency->format('0.00') : $this->currency->format($result['lost_sales']);
//        $json['cash_payments'] = (empty($result['cash_payments'])) ? $this->currency->format('0.00') : $this->currency->format($result['cash_payments']);
//        $json['customers'] = (empty($result['customers'])) ? '0' : $result['customers'];
//        $json['orders'] = (empty($result['orders'])) ? '0' : $result['orders'];
//        $json['orders_completed'] = (empty($result['orders_completed'])) ? '0' : $result['orders_completed'];
//        $json['delivery_orders'] = (empty($result['delivery_orders'])) ? '0' : $result['delivery_orders'];
//        $json['collection_orders'] = (empty($result['collection_orders'])) ? '0' : $result['collection_orders'];
//        $json['tables_reserved'] = (empty($result['tables_reserved'])) ? '0' : $result['tables_reserved'];
//
//        $this->output->set_output(json_encode($json));
//    }
//
//    public function chart()
//    {
//        $json = [];
//        $results = [];
//
//        $json['labels'] = ['Total Customers', 'Total Orders', 'Total Reservations', 'Total Reviews'];
//        $json['colors'] = ['#63ADD0', '#5CB85C', '#337AB7', '#D9534F'];
//
//        $dateRanges = '1';
//        if (get('start_date') AND get('start_date') !== 'undefined') {
//            if (get('end_date') AND get('end_date') !== 'undefined') {
//                $dateRanges = $this->getDatesFromRange(get('start_date'), get('end_date'));
//            }
//        }
//
//        $timestamp = strtotime(get('start_date'));
//
//        if (count($dateRanges) <= 1) {
//            for ($i = 0; $i < 24; $i++) {
//                $data = $this->Dashboard_model->getTodayChart($i);
//                $data['time'] = mdate('%H:%i', mktime($i, 0, 0, date('n', $timestamp), date('j', $timestamp), date('Y', $timestamp)));
//                $results[] = $data;
//            }
//        } else {
//            for ($i = 0; $i < count($dateRanges); $i++) {
//                $data = $this->Dashboard_model->getDateChart($dateRanges[$i]);
//                $data['time'] = mdate('%d %M', strtotime($dateRanges[$i]));
//                $results[] = $data;
//            }
//        }
//
//        if (!empty($results)) {
//            foreach ($results as $key => $value) {
//                $json['data'][] = $value;
//            }
//        }
//
//        $this->output->set_output(json_encode($json));
//    }

    protected function getActivities()
    {
        $activities = [];
        $this->load->model('Activities_model');
        $this->setFilter(['page' => '1', 'limit' => '5']);
        $results = $this->Activities_model->paginateWithFilter($this->getFilter());
        foreach ($results->list as $result) {
            $activities[] = [
                'activity_id'  => $result['activity_id'],
                'icon'         => 'fa fa-tasks',
                'message'      => $result['message'],
                'time'         => mdate('%h:%i %A', strtotime($result['date_added'])),
                'time_elapsed' => time_elapsed($result['date_added']),
                'state'        => $result['status'] == '1' ? 'read' : 'unread',
            ];
        }

        return $activities;
    }

    protected function getTopCustomers()
    {
        $top_customers = [];
        $this->setFilter(['limit' => '6']);
        $results = $this->Dashboard_model->getTopCustomers($this->getFilter());
        foreach ($results as $result) {
            $top_customers[] = [
                'first_name'   => $result['first_name'],
                'last_name'    => $result['last_name'],
                'total_orders' => $result['total_orders'],
                'total_sale'   => $this->currency->format($result['total_sale']),
            ];
        }

        return $top_customers;
    }

    protected function getRecentOrders()
    {
        $filter = [];
        $filter['limit'] = 10;
        $filter['sort_by'] = 'orders.date_added';
        $filter['order_by'] = 'DESC';

        if (AdminAuth::user()->hasStrictLocationAccess()) {
            $filter['filter_location'] = AdminAuth::getLocationId();
        }

        $this->setFilter($filter);

        $orders = [];
        $this->load->model('Orders_model');
        $results = $this->Orders_model->paginateWithFilter($this->getFilter());
        foreach ($results->list as $result) {
            $current_date = mdate('%d-%m-%Y', time());
            $date_added = mdate('%d-%m-%Y', strtotime($result['date_added']));

            $date_added = $current_date == $date_added ? lang('admin::dashboard.text_today') : mdate('%d %M %y', strtotime($date_added));

            $orders[] = [
                'order_id'      => $result['order_id'],
                'location_name' => $result['location_name'],
                'first_name'    => $result['first_name'],
                'last_name'     => $result['last_name'],
                'order_status'  => $result['status_name'],
                'status_color'  => $result['status_color'],
                'order_time'    => mdate('%H:%i', strtotime($result['order_time'])),
                'order_type'    => ($result['order_type'] == '1') ? lang('admin::dashboard.text_delivery') : lang('admin::dashboard.text_collection'),
                'date_added'    => $date_added,
                'edit'          => $this->pageUrl('orders/edit?id='.$result['order_id']),
            ];
        }

        return $orders;
    }

    protected function getDatesFromRange($start, $end)
    {
        $interval = new DateInterval('P1D');

        $realEnd = new DateTime($end);
        $realEnd->add($interval);

        $period = new DatePeriod(
            new DateTime($start),
            $interval,
            $realEnd
        );

        foreach ($period as $date) {
            $array[] = $date->format('Y-m-d');
        }

        return $array;
    }
}