<?php namespace Admin\Controllers;

use Admin\Classes\PaymentGateways;
use AdminMenu;

class Orders extends \Admin\Classes\AdminController
{
    public $implement = [
        'Admin\Actions\ListController',
        'Admin\Actions\FormController',
    ];

    public $listConfig = [
        'list' => [
            'model'        => 'Admin\Models\Orders_model',
            'title'        => 'lang:admin::orders.text_title',
            'emptyMessage' => 'lang:admin::orders.text_empty',
            'defaultSort'  => ['date_added', 'DESC'],
            'configFile'   => 'orders_model',
        ],
    ];

    public $formConfig = [
        'name'       => 'lang:admin::orders.text_form_name',
        'model'      => 'Admin\Models\Orders_model',
        'create'     => [
            'title'         => 'lang:admin::default.form.create_title',
            'redirect'      => 'orders/edit/{order_id}',
            'redirectClose' => 'orders',
        ],
        'edit'       => [
            'title'         => 'lang:admin::default.form.edit_title',
            'redirect'      => 'orders/edit/{order_id}',
            'redirectClose' => 'orders',
        ],
        'preview'    => [
            'title'    => 'lang:admin::default.form.preview_title',
            'redirect' => 'orders',
        ],
        'delete'     => [
            'redirect' => 'orders',
        ],
        'configFile' => 'orders_model',
    ];

    protected $requiredPermissions = 'Admin.Orders';

    public function __construct()
    {
        parent::__construct();

        AdminMenu::setContext('orders', 'sales');
    }

    public function formExtendQuery($query)
    {
        $query->with([
            'status_history',
            'status_history.staff',
            'status_history.assignee',
            'status_history.status',
        ]);
    }

    public function edite()
    {
        if (post() AND $order_id = $this->_updateOrder()) {
            return $this->redirect($order_id);
        }

        $order_info = $this->Orders_model->getOrder((int)get('id'));

        $title = (isset($order_info['order_id'])) ? $order_info['order_id'] : $this->lang->line('text_new');
        Template::setTitle(sprintf($this->lang->line('text_edit_heading'), $title));
        Template::setHeading(sprintf($this->lang->line('text_edit_heading'), $title));

        Template::setButton($this->lang->line('button_save'), ['class' => 'btn btn-primary', 'onclick' => '$(\'#edit-form\').submit();']);
        Template::setButton($this->lang->line('button_save_close'), ['class' => 'btn btn-default', 'onclick' => 'saveClose();']);
        Template::setButton($this->lang->line('button_icon_back'), ['class' => 'btn btn-default', 'href' => admin_url('orders')]);

        $data = $this->getForm($order_info);

        Template::render('orders/edite', $data);
    }

    public function create_invoice()
    {
        $json = [];

        if (is_numeric(post('order_id'))) {
            $json['invoice_no'] = $this->Orders_model->createInvoiceNo(post('order_id'));

            if ($json['invoice_no'] === TRUE) {
                flash()->set('warning', $this->lang->line('alert_order_not_completed'));
            }
            else if (!empty($json['invoice_no'])) {
                flash()->set('success', sprintf($this->lang->line('alert_success'), 'Invoice generated'));
            }
            else {
                flash()->set('error', sprintf($this->lang->line('alert_error_nothing'), 'generated'));
            }

            $json['redirect'] = $this->pageUrl($this->edit_url, ['id' => post('order_id')]);
        }

        $this->output->set_output(json_encode($json));
    }

    public function invoice()
    {
        $this->output->enable_profiler(FALSE);
        $action = $this->uri->rsegment('3');

        Assets::addCss(assets_url('css/bootstrap.min.css'), 'bootstrap-css');
        Assets::addCss('css/fonts.css', 'fonts-css');

        $data = $this->getInvoice();

        if ($action === 'view') {
            $this->load->view($this->config->item(ADMINDIR, 'default_themes').'orders_invoice', $data);
        }
    }

    public function getList()
    {
        if ($data['user_strict_location'] = AdminAuth::isStrictLocation()) {
            $this->setFilter('filter_location', AdminAuth::getLocationId());
        }

        $data = array_merge($this->getFilter(), $this->getSort(), $data);

        $payments = PaymentGateways::instance()->listGateways();

        $data['orders'] = [];
        $results = $this->Orders_model->paginateWithFilter($this->getFilter());
        foreach ($results->list as $result) {
            $payment_title = '--';
            if (isset($payments[$result['payment']]) AND $payment = $payments[$result['payment']]) {
                $payment_title = !empty($payment['name']) ? $this->lang->line($payment['name']) : $payment['code'];
            }

            $data['orders'][] = array_merge($result, [
                'payment'      => $payment_title,
                'order_time'   => mdate('%H:%i', strtotime($result['order_time'])),
                'order_date'   => day_elapsed($result['order_date']),
                'order_status' => $result['status_name'],
                'order_total'  => $this->currency->format($result['order_total']),
                'date_added'   => day_elapsed($result['date_added']),
                'edit'         => $this->pageUrl($this->edit_url, ['id' => $result['order_id']]),
            ]);
        }

        $data['pagination'] = $results->pagination;

        $data['locations'] = $this->Locations_model->isEnabled()->dropdown('location_name');
        $data['statuses'] = $this->Statuses_model->dropdown('status_name');

        $data['payments'] = [];
        foreach ($payments as $payment) {
            $data['payments'][] = [
                'code' => $payment['code'],
                'name' => !empty($payment['name']) ? $this->lang->line($payment['name']) : $payment['code'],
            ];
        }

        $data['order_dates'] = $this->Orders_model->getOrderDates();

        return $data;
    }

    public function getForm($order_info = [])
    {
        $data = $order_info;

        if (!empty($order_info['order_id'])) {
            $order_id = $order_info['order_id'];
            $data['_action'] = $this->pageUrl($this->edit_url, ['id' => $order_id]);
        }
        else {
            $order_id = 0;
            //$data['_action']	= $this->pageUrl($this->create_url);
            return $this->redirectBack();
        }

        AdminAuth::restrictLocation($order_info['location_id'], 'Admin.Orders', $this->index_url);

        $data['invoice_no'] = !empty($order_info['invoice_no']) ? $order_info['invoice_prefix'].$order_info['invoice_no'] : '';
        $data['customer_edit'] = $this->pageUrl('customers/edit?id='.$order_info['customer_id']);
        $data['date_added'] = mdate('%d %M %y - %H:%i', strtotime($order_info['date_added']));
        $data['date_modified'] = mdate('%d %M %y', strtotime($order_info['date_modified']));
        $data['order_time'] = mdate('%H:%i', strtotime($order_info['order_time']));
        $data['order_type'] = ($order_info['order_type'] == '1') ? $this->lang->line('text_delivery') : $this->lang->line('text_collection');
        $data['check_order_type'] = $order_info['order_type'];

        $data['paypal_details'] = [];
        $data['payment'] = $this->lang->line('text_no_payment');
        $payments = \Admin\Classes\PaymentGateways::instance()->listGateways();
        if (isset($payments[$order_info['payment']]) AND $payment = $payments[$order_info['payment']]) {
            if ($payment['code'] === 'paypal_express') {
                $this->load->model('paypal_express/Paypal_model');
                $data['paypal_details'] = (isset($this->Paypal_model)) ? $this->Paypal_model->getPaypalDetails($order_info['order_id'], $order_info['customer_id']) : [];
            }

            $data['payment'] = !empty($payment['name']) ? $this->lang->line($payment['name']) : $payment['code'];
        }

        $data['staffs'] = $this->Staffs_model->isEnabled()->dropdown('staff_name');

        $data['statuses'] = [];
        $statuses = $this->Statuses_model->getStatuses('order');
        foreach ($statuses as $status) {
            $data['statuses'][] = array_merge($status, [
                'status_comment' => nl2br($status['status_comment']),
            ]);
        }

        $data['status_history'] = [];
        $status_history = $this->Statuses_model->getStatusHistories('order', $order_id);
        foreach ($status_history as $history) {
            $data['status_history'][] = array_merge($history, [
                'history_id' => $history['status_history_id'],
                'date_time'  => mdate('%d %M %y - %H:%i', strtotime($history['date_added'])),
                'comment'    => nl2br($history['comment']),
            ]);
        }

        $this->load->library('country');
        $data['location_name'] = $data['location_address'] = '';
        if (!empty($order_info['location_id'])) {
            $location_address = $this->Locations_model->getAddress($order_info['location_id']);
            if ($location_address) {
                $data['location_name'] = $location_address['location_name'];
                $data['location_address'] = $this->country->addressFormat($location_address);
            }
        }

        $data['customer_address'] = '';
        if (!empty($order_info['customer_id'])) {
            $customer_address = $this->Addresses_model->getAddress($order_info['customer_id'], $order_info['address_id']);
            $data['customer_address'] = $this->country->addressFormat($customer_address);
        }
        else if (!empty($order_info['address_id'])) {
            $customer_address = $this->Addresses_model->getGuestAddress($order_info['address_id']);
            $data['customer_address'] = $this->country->addressFormat($customer_address);
        }

        $data['cart_items'] = [];
        $cart_items = $this->Orders_model->getOrderMenus($order_info['order_id']);
        $menu_options = $this->Orders_model->getOrderMenuOptions($order_info['order_id']);
        $options = $this->Menu_options_model->getMenuOptions();
        $options = array_column($options, 'option_name', 'menu_option_id');
        foreach ($cart_items as $cart_item) {
            $option_data = [];
            if (!empty($menu_options)) {
                foreach ($menu_options as $menu_option) {
                    if ($cart_item['order_menu_id'] == $menu_option['order_menu_id']) {
                        $option_name = (isset($options[$menu_option['order_menu_option_id']]))
                            ? $options[$menu_option['order_menu_option_id']] : null;
                        $option_data[] = sprintf($this->lang->line('text_menu_options'),
                            $option_name, $menu_option['order_option_name'], $this->lang->line('text_equals'),
                            $this->currency->format($menu_option['order_option_price'])
                        );
                    }
                }
            }

            $data['cart_items'][] = array_merge($cart_item, [
                'id'       => $cart_item['menu_id'],
                'qty'      => $cart_item['quantity'],
                'price'    => $this->currency->format($cart_item['price']),
                'subtotal' => $this->currency->format($cart_item['subtotal']),
                'options'  => implode('<br /> ', $option_data),
            ]);
        }

        $data['totals'] = [];
        $order_totals = $this->Orders_model->getOrderTotals($order_info['order_id']);
        foreach ($order_totals as $total) {
            if ($order_info['order_type'] == '2' AND $total['code'] == 'delivery') continue;
            $data['totals'][] = array_merge($total, [
                'title' => htmlspecialchars_decode($total['title']),
                'value' => $this->currency->format($total['value']),
            ]);
        }

        $data['order_total'] = $this->currency->format($order_info['order_total']);
        $data['total_items'] = $order_info['total_items'];

        return $data;
    }

    public function _status_exists($str)
    {
        $order_status_exists = $this->Statuses_model->statusExists('order', get('id'), $str);
        if ($order_status_exists) {
            $this->form_validation->set_message('_status_exists', $this->lang->line('error_status_exists'));

            return FALSE;
        }
        else {
            return TRUE;
        }
    }

    protected function getInvoice()
    {
        $invoice_info = $this->Orders_model->getInvoice($this->uri->rsegment('4'));

        $data = $this->getForm($invoice_info);

        $this->load->model('Image_tool_model');
        $data['invoice_logo'] = Image_tool_model::resize($this->config->item('site_logo'));

        return $data;
    }

    protected function _updateOrder()
    {
        if (is_numeric(get('id')) AND $this->validateForm() === TRUE) {
            if ($order_id = $this->Orders_model->updateOrder(get('id'), post())) {
                log_activity(AdminAuth::getStaffId(), 'updated', 'orders', get_activity_message('activity_custom',
                    ['{staff}', '{action}', '{context}', '{link}', '{item}'],
                    [AdminAuth::getStaffName(), 'updated', 'order', current_url(), '#'.get('id')]
                ));

                if (post('assignee_id') AND post('old_assignee_id') !== post('assignee_id')) {
                    $staff = $this->Staffs_model->getStaff(post('assignee_id'));
                    $staff_assignee = $this->pageUrl('staffs/edit?id='.$staff['staff_id']);

                    log_activity(AdminAuth::getStaffId(), 'assigned', 'orders', get_activity_message('activity_assigned',
                        ['{staff}', '{action}', '{context}', '{link}', '{item}', '{assignee}'],
                        [AdminAuth::getStaffName(), 'assigned', 'order', current_url(), '#'.get('id'), "<a href=\"{$staff_assignee}\">{$staff['staff_name']}</a>"]
                    ));
                }

                flash()->set('success', sprintf($this->lang->line('alert_success'), 'Order updated'));
            }
            else {
                flash()->set('warning', sprintf($this->lang->line('alert_error_nothing'), 'updated'));
            }

            return get('id');
        }
    }

    protected function _deleteOrder()
    {
        if (post('delete')) {
            $deleted_rows = $this->Orders_model->deleteOrder(post('delete'));
            if ($deleted_rows > 0) {
                $prefix = ($deleted_rows > 1) ? '['.$deleted_rows.'] Orders' : 'Order';
                flash()->set('success', sprintf($this->lang->line('alert_success'), $prefix.' '.$this->lang->line('text_deleted')));
            }
            else {
                flash()->set('warning', sprintf($this->lang->line('alert_error_nothing'), $this->lang->line('text_deleted')));
            }

            return TRUE;
        }
    }

    protected function validateForm()
    {
        $rules = [
            ['order_status', 'lang:admin::default.label_status', 'required|integer|callback__status_exists'],
            ['assignee_id', 'lang:admin::orders.label_assign_staff', 'integer'],
        ];

        return $this->validatePasses($rules)->run();
    }
}