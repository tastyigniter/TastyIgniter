<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Orders Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Orders_model.php
 * @link           http://docs.tastyigniter.com
 */
class Orders_model extends TI_Model {

    public function getCount($filter = array()) {
        if (APPDIR === ADMINDIR) {
            if ( ! empty($filter['filter_search'])) {
                $this->db->like('order_id', $filter['filter_search']);
                $this->db->or_like('location_name', $filter['filter_search']);
                $this->db->or_like('first_name', $filter['filter_search']);
                $this->db->or_like('last_name', $filter['filter_search']);
            }

            if ( ! empty($filter['filter_location'])) {
                $this->db->where('orders.location_id', $filter['filter_location']);
            }

            if (isset($filter['filter_type']) AND is_numeric($filter['filter_type'])) {
                $this->db->where('order_type', $filter['filter_type']);
            }

            if ( ! empty($filter['filter_payment'])) {
                $this->db->where('payment', $filter['filter_payment']);
            }

            if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
                $this->db->where('orders.status_id', $filter['filter_status']);
            }

            if ( ! empty($filter['filter_date'])) {
                $date = explode('-', $filter['filter_date']);
                $this->db->where('YEAR(date_added)', $date[0]);
                $this->db->where('MONTH(date_added)', $date[1]);
            }
        } else {
            if ( ! empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
                $this->db->where('customer_id', $filter['customer_id']);
            }

            $this->db->where('orders.status_id !=', '0');
        }

        $this->db->from('orders');
        $this->db->join('locations', 'locations.location_id = orders.location_id', 'left');

        return $this->db->count_all_results();
    }

    public function getList($filter = array()) {
        if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
            $filter['page'] = ($filter['page'] - 1) * $filter['limit'];
        }

        if ($this->db->limit($filter['limit'], $filter['page'])) {
            $this->db->select('*, orders.status_id, status_name, status_color, orders.date_added, orders.date_modified');
            $this->db->from('orders');
            $this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
            $this->db->join('locations', 'locations.location_id = orders.location_id', 'left');

            if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
                $this->db->order_by($filter['sort_by'], $filter['order_by']);
            }

            if ( ! empty($filter['customer_id']) AND is_numeric($filter['customer_id'])) {
                $this->db->where('customer_id', $filter['customer_id']);
            }

            if ( ! empty($filter['filter_location'])) {
                $this->db->where('orders.location_id', $filter['filter_location']);
            }

            if ( ! empty($filter['filter_search'])) {
                $this->db->like('order_id', $filter['filter_search']);
                $this->db->or_like('location_name', $filter['filter_search']);
                $this->db->or_like('first_name', $filter['filter_search']);
                $this->db->or_like('last_name', $filter['filter_search']);
            }

            if (isset($filter['filter_type']) AND is_numeric($filter['filter_type'])) {
                $this->db->where('order_type', $filter['filter_type']);
            }

            if ( ! empty($filter['filter_payment'])) {
                $this->db->where('payment', $filter['filter_payment']);
            }

            if (APPDIR === MAINDIR) {
                $this->db->where('orders.status_id !=', '0');
            } else {
                if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
                    $this->db->where('orders.status_id', $filter['filter_status']);
                } else {
                    $this->db->where('orders.status_id !=', '0');
                }
            }

            if ( ! empty($filter['filter_date'])) {
                $date = explode('-', $filter['filter_date']);
                $this->db->where('YEAR(date_added)', $date[0]);
                $this->db->where('MONTH(date_added)', $date[1]);
            }

            $query = $this->db->get();
            $result = array();

            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }

            return $result;
        }
    }

    public function getOrder($order_id = FALSE, $customer_id = '') {
        if ( ! empty($order_id)) {
            $this->db->from('orders');
            $this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
            $this->db->join('locations', 'locations.location_id = orders.location_id', 'left');
            $this->db->where('order_id', $order_id);

            if ( ! empty($customer_id)) {
                $this->db->where('customer_id', $customer_id);
            }

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
        }

        return $order_id;
    }

    public function getInvoice($order_id = NULL) {
        if ( ! empty($order_id) AND is_numeric($order_id)) {
            $this->db->from('orders');
            $this->db->join('statuses', 'statuses.status_id = orders.status_id', 'left');
            $this->db->join('locations', 'locations.location_id = orders.location_id', 'left');
            $this->db->where('order_id', $order_id);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
        }

        return FALSE;
    }

    public function getCheckoutOrder($order_id, $customer_id) {
        if (isset($order_id, $customer_id)) {
            $this->db->from('orders');

            $this->db->where('order_id', $order_id);
            $this->db->where('customer_id', $customer_id);
            $this->db->where('status_id', NULL);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
        }

        return FALSE;
    }

    public function getOrderMenus($order_id) {
        $this->db->from('order_menus');
        $this->db->where('order_id', $order_id);

        $query = $this->db->get();
        $result = array();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function getOrderMenuOptions($order_id) {
        $result = array();

        if ( ! empty($order_id)) {
            $this->db->from('order_options');
            $this->db->where('order_id', $order_id);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $result[] = $row;
                }
            }
        }

        return $result;
    }

    public function getOrderTotals($order_id) {
        $this->db->from('order_totals');
        $this->db->order_by('priority', 'ASC');
        $this->db->where('order_id', $order_id);

        $query = $this->db->get();
        $result = array();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function getOrderCoupon($order_id) {
        $this->db->from('coupons_history');
        $this->db->where('order_id', $order_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
    }

    public function getOrderDates() {
        $this->db->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
        $this->db->from('orders');
        $this->db->group_by('MONTH(date_added)');
        $this->db->group_by('YEAR(date_added)');
        $query = $this->db->get();
        $result = array();

        if ($query->num_rows() > 0) {
            $result = $query->result_array();
        }

        return $result;
    }

    public function isOrderPlaced($order_id) {
        $this->db->from('orders');
        $this->db->where('order_id', $order_id);
        $this->db->where('status_id >', '0');

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return TRUE;
        }

        return FALSE;
    }

    public function updateOrder($order_id = NULL, $update = array()) {
        $query = FALSE;

        if (isset($update['order_status'])) {
            $this->db->set('status_id', $update['order_status']);
        }

        if (isset($update['assignee_id'])) {
            $this->db->set('assignee_id', $update['assignee_id']);
        }

        if (isset($update['notify'])) {
            $this->db->set('notify', $update['notify']);
        }

        $this->db->set('date_modified', mdate('%Y-%m-%d', time()));

        if (is_numeric($order_id)) {
            $this->db->where('order_id', $order_id);
            $query = $this->db->update('orders');

            if ($query === TRUE) {
                $this->load->model('Statuses_model');
                $status = $this->Statuses_model->getStatus($update['order_status']);

                if (isset($update['status_notify']) AND $update['status_notify'] === '1') {
                    $mail_data = $this->getMailData($order_id);

                    $mail_data['status_name'] = $status['status_name'];
                    $mail_data['status_comment'] = ! empty($update['status_comment']) ? $update['status_comment'] : $this->lang->line('text_no_comment');

                    $this->load->model('Mail_templates_model');
                    $mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'order_update');
                    $update['status_notify'] = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
                }

                if ((int) $update['old_status_id'] !== (int) $update['order_status']) {
                    if (APPDIR === ADMINDIR) {
                        $update['staff_id'] = $this->user->getStaffId();
                    }

                    $status_update['object_id']    = (int) $order_id;
                    $status_update['status_id']    = (int) $update['order_status'];
                    $status_update['comment']      = isset($update['status_comment']) ? $update['status_comment'] : $status['status_comment'];
                    $status_update['notify']       = isset($update['status_notify']) ? $update['status_notify'] : $status['notify_customer'];
                    $status_update['date_added']   = mdate('%Y-%m-%d %H:%i:%s', time());

                    $this->Statuses_model->addStatusHistory('order', $status_update);
                }

                if ($this->config->item('auto_invoicing') === '1' AND in_array($update['order_status'], (array) $this->config->item('completed_order_status'))) {
                    $this->createInvoiceNo($order_id);
                }

                if (in_array($update['order_status'], (array) $this->config->item('processing_order_status'))) {
                    $this->subtractStock($order_id);

                    $this->load->model('Coupons_model');
                    $this->Coupons_model->redeemCoupon($order_id);
                }
            }
        }

        return $query;
    }

    public function createInvoiceNo($order_id = NULL) {

        $order_status_exists = $this->Statuses_model->statusExists('order', $order_id, $this->config->item('completed_order_status'));
        if ($order_status_exists !== TRUE) return TRUE;

        $order_info = $this->getOrder($order_id);

        if ($order_info AND empty($order_info['invoice_no'])) {
            $order_info['invoice_prefix'] = str_replace('{year}', date('Y'), str_replace('{month}', date('m'), str_replace('{day}', date('d'), $this->config->item('invoice_prefix'))));

            $this->db->select_max('invoice_no');
            $this->db->from('orders');
            $this->db->where('invoice_prefix', $order_info['invoice_prefix']);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $invoice_no = $row['invoice_no'] + 1;
            } else {
                $invoice_no = 1;
            }

            $this->db->set('invoice_prefix', $order_info['invoice_prefix']);
            $this->db->set('invoice_no', $invoice_no);
            $this->db->set('invoice_date', mdate('%Y-%m-%d %H:%i:%s', time()));
            $this->db->where('order_id', $order_id);
            $this->db->update('orders');

            return $order_info['invoice_prefix'].$invoice_no;
        }

        return FALSE;
    }

    public function addOrder($order_info = array(), $cart_contents = array()) {
        if (empty($order_info) OR empty($cart_contents)) return FALSE;

        if (isset($order_info['location_id'])) {
            $this->db->set('location_id', $order_info['location_id']);
        }

        if (isset($order_info['customer_id'])) {
            $this->db->set('customer_id', $order_info['customer_id']);
        } else {
            $this->db->set('customer_id', '0');
        }

        if (isset($order_info['first_name'])) {
            $this->db->set('first_name', $order_info['first_name']);
        }

        if (isset($order_info['last_name'])) {
            $this->db->set('last_name', $order_info['last_name']);
        }

        if (isset($order_info['email'])) {
            $this->db->set('email', $order_info['email']);
        }

        if (isset($order_info['telephone'])) {
            $this->db->set('telephone', $order_info['telephone']);
        }

        if (isset($order_info['order_type'])) {
            $this->db->set('order_type', $order_info['order_type']);
        }

        if (isset($order_info['order_time'])) {
            $current_time = time();
            $order_time = (strtotime($order_info['order_time']) < strtotime($current_time)) ? $current_time : $order_info['order_time'];
            $this->db->set('order_time', mdate('%H:%i', strtotime($order_time)));
            $this->db->set('order_date', mdate('%Y-%m-%d', strtotime($order_time)));
            $this->db->set('date_added', mdate('%Y-%m-%d %H:%i:%s', $current_time));
            $this->db->set('date_modified', mdate('%Y-%m-%d', $current_time));
            $this->db->set('ip_address', $this->input->ip_address());
            $this->db->set('user_agent', $this->input->user_agent());
        }

        if (isset($order_info['address_id'])) {
            $this->db->set('address_id', $order_info['address_id']);
        }

        if (isset($order_info['payment'])) {
            $this->db->set('payment', $order_info['payment']);
        }

        if (isset($order_info['comment'])) {
            $this->db->set('comment', $order_info['comment']);
        }

        if (isset($cart_contents['order_total'])) {
            $this->db->set('order_total', $cart_contents['order_total']);
        }

        if (isset($cart_contents['total_items'])) {
            $this->db->set('total_items', $cart_contents['total_items']);
        }

        if ( ! empty($order_info)) {
            if (isset($order_info['order_id'])) {
                $_action = 'updated';
                $this->db->where('order_id', $order_info['order_id']);
                $query = $this->db->update('orders');
                $order_id = $order_info['order_id'];
            } else {
                $_action = 'added';
                $query = $this->db->insert('orders');
                $order_id = $this->db->insert_id();
            }

            if ($query AND $order_id) {
                if (isset($order_info['address_id'])) {
                    $this->load->model('Addresses_model');
                    $this->Addresses_model->updateDefault($order_info['customer_id'], $order_info['address_id']);
                }

                $this->addOrderMenus($order_id, $cart_contents);

                $this->addOrderTotals($order_id, $cart_contents);

                if ( ! empty($cart_contents['coupon'])) {
                    $this->addOrderCoupon($order_id, $order_info['customer_id'], $cart_contents['coupon']);
                }

                return $order_id;
            }
        }
    }

    public function completeOrder($order_id, $order_info, $cart_contents = array()) {

        if ($order_id AND ! empty($order_info)) {

            $notify = $this->sendConfirmationMail($order_id);

            $update = array(
                'old_status_id' => '',
                'order_status'  => ! empty($order_info['status_id']) ? (int) $order_info['status_id'] : (int) $this->config->item('default_order_status'),
                'notify'        => $notify,
            );

            if ($this->updateOrder($order_id, $update)) {
                if (APPDIR === MAINDIR) {
                    log_activity($order_info['customer_id'], 'created', 'orders', get_activity_message('activity_created_order',
                        array('{customer}', '{link}', '{order_id}'),
                        array($order_info['first_name'] . ' ' . $order_info['last_name'], admin_url('orders/edit?id=' . $order_id), $order_id)
                    ));
                }

                Events::trigger('after_create_order', array('order_id' => $order_id));

                return TRUE;
            }
        }
    }

    public function addOrderMenus($order_id, $cart_contents = array()) {
        if (is_array($cart_contents) AND ! empty($cart_contents) AND $order_id) {
            $this->db->where('order_id', $order_id);
            $this->db->delete('order_menus');

            foreach ($cart_contents as $key => $item) {
                if (is_array($item) AND isset($item['rowid']) AND $key === $item['rowid']) {

                    if (isset($item['id'])) {
                        $this->db->set('menu_id', $item['id']);
                    }

                    if (isset($item['name'])) {
                        $this->db->set('name', $item['name']);
                    }

                    if (isset($item['qty'])) {
                        $this->db->set('quantity', $item['qty']);
                    }

                    if (isset($item['price'])) {
                        $this->db->set('price', $item['price']);
                    }

                    if (isset($item['subtotal'])) {
                        $this->db->set('subtotal', $item['subtotal']);
                    }

                    if (isset($item['comment'])) {
                        $this->db->set('comment', $item['comment']);
                    }

                    if ( ! empty($item['options'])) {
                        $this->db->set('option_values', serialize($item['options']));
                    }

                    $this->db->set('order_id', $order_id);

                    if ($query = $this->db->insert('order_menus')) {
                        $order_menu_id = $this->db->insert_id();

                        if ( ! empty($item['options'])) {
                            $this->addOrderMenuOptions($order_menu_id, $order_id, $item['id'], $item['options']);
                        }
                    }
                }
            }

            return TRUE;
        }
    }

    public function addOrderMenuOptions($order_menu_id, $order_id, $menu_id, $menu_options) {
        if ( ! empty($order_id) AND ! empty($menu_id) AND ! empty($menu_options)) {
            $this->db->where('order_menu_id', $order_menu_id);
            $this->db->where('order_id', $order_id);
            $this->db->where('menu_id', $menu_id);
            $this->db->delete('order_options');

            foreach ($menu_options as $menu_option_id => $options) {
                foreach ($options as $option) {
                    $this->db->set('order_menu_option_id', $menu_option_id);
                    $this->db->set('order_menu_id', $order_menu_id);
                    $this->db->set('order_id', $order_id);
                    $this->db->set('menu_id', $menu_id);
                    $this->db->set('menu_option_value_id', $option['value_id']);
                    $this->db->set('order_option_name', $option['value_name']);
                    $this->db->set('order_option_price', $option['value_price']);

                    $this->db->insert('order_options');
                }
            }
        }
    }

    public function addOrderTotals($order_id, $cart_contents) {
        if (is_numeric($order_id) AND ! empty($cart_contents['totals'])) {
            $this->db->where('order_id', $order_id);
            $this->db->delete('order_totals');

            $this->load->model('cart_module/Cart_model');
            $order_totals = $this->Cart_model->getTotals();

            $cart_contents['totals']['cart_total']['amount'] = (isset($cart_contents['cart_total'])) ? $cart_contents['cart_total'] : '';
            $cart_contents['totals']['order_total']['amount'] = (isset($cart_contents['order_total'])) ? $cart_contents['order_total'] : '';

            foreach ($cart_contents['totals'] as $name => $total) {
                foreach ($order_totals as $total_name => $order_total) {
                    if ($name === $total_name AND is_numeric($total['amount'])) {
                        $total['title'] = empty($total['title']) ? $order_total['title'] : $total['title'];

                        if (isset($total['code'])) {
                            $total['title'] = str_replace('{coupon}', $total['code'], $total['title']);
                        } else if (isset($total['tax'])) {
                            $total['title'] = str_replace('{tax}', $total['tax'], $total['title']);
                        }

                        $this->db->set('order_id', $order_id);
                        $this->db->set('code', $name);
                        $this->db->set('title', htmlspecialchars($total['title']));
                        $this->db->set('priority', $order_total['priority']);

                        if ($name === 'coupon') {
                            $this->db->set('value', 0 - $total['amount']);
                        } else {
                            $this->db->set('value', $total['amount']);
                        }

                        $this->db->insert('order_totals');
                    }
                }
            }

            return TRUE;
        }
    }

    public function addOrderCoupon($order_id, $customer_id, $coupon) {
        if (is_array($coupon) AND is_numeric($coupon['discount'])) {
            $this->db->where('order_id', $order_id);
            $this->db->delete('coupons_history');

            $this->load->model('Coupons_model');
            $temp_coupon = $this->Coupons_model->getCouponByCode($coupon['code']);

            $this->db->set('order_id', $order_id);
            $this->db->set('customer_id', empty($customer_id) ? '0' : $customer_id);
            $this->db->set('coupon_id', $temp_coupon['coupon_id']);
            $this->db->set('code', $temp_coupon['code']);
            $this->db->set('amount', '-' . $coupon['discount']);
            $this->db->set('date_used', mdate('%Y-%m-%d %H:%i:%s', time()));

            if ($this->db->insert('coupons_history')) {
                return $this->db->insert_id();
            }
        }
    }

    public function subtractStock($order_id) {
        $this->load->model('Menus_model');

        $order_menus = $this->getOrderMenus($order_id);

        foreach ($order_menus as $order_menu) {
            $this->Menus_model->updateStock($order_menu['menu_id'], $order_menu['quantity'], 'subtract');
        }
    }

    public function sendConfirmationMail($order_id) {
        $this->load->model('Mail_templates_model');

        $mail_data = $this->getMailData($order_id);
        $config_order_email = is_array($this->config->item('order_email')) ? $this->config->item('order_email') : array();

        $notify = '0';
        if ($this->config->item('customer_order_email') === '1' OR in_array('customer', $config_order_email)) {
            $mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'order');
            $notify = $this->sendMail($mail_data['email'], $mail_template, $mail_data);
        }

        if ($this->location->getEmail() AND ($this->config->item('location_order_email') === '1' OR in_array('location', $config_order_email))) {
            $mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'order_alert');
            $this->sendMail($this->location->getEmail(), $mail_template, $mail_data);
        }

        if (in_array('admin', $config_order_email)) {
            $mail_template = $this->Mail_templates_model->getTemplateData($this->config->item('mail_template_id'), 'order_alert');
            $this->sendMail($this->config->item('site_email'), $mail_template, $mail_data);
        }

        return $notify;
    }

    public function getMailData($order_id) {
        $data = array();

        $result = $this->getOrder($order_id);
        if ($result) {
            $this->load->library('country');
            $this->load->library('currency');

            $data['order_number'] = $result['order_id'];
            $data['order_view_url'] = root_url('account/orders/view/' . $result['order_id']);
            $data['order_type'] = ($result['order_type'] === '1') ? 'delivery' : 'collection';
            $data['order_time'] = mdate('%H:%i', strtotime($result['order_time'])) . ' ' . mdate('%d %M', strtotime($result['order_date']));
            $data['order_date'] = mdate('%d %M %y', strtotime($result['date_added']));
            $data['first_name'] = $result['first_name'];
            $data['last_name'] = $result['last_name'];
            $data['email'] = $result['email'];
            $data['telephone'] = $result['telephone'];
            $data['order_comment'] = $result['comment'];

            if ($payment = $this->extension->getPayment($result['payment'])) {
                $data['order_payment'] = !empty($payment['ext_data']['title']) ? $payment['ext_data']['title']: $payment['title'];
            } else {
                $data['order_payment'] = $this->lang->line('text_no_payment');
            }

            $data['order_menus'] = array();
            $menus = $this->getOrderMenus($result['order_id']);
            $options = $this->getOrderMenuOptions($result['order_id']);
            if ($menus) {
                foreach ($menus as $menu) {
                    $option_data = array();

                    if (!empty($options)) {
                        foreach ($options as $key => $option) {
                            if ($menu['order_menu_id'] === $option['order_menu_id']) {
                                $option_data[] = $option['order_option_name'] . $this->lang->line('text_equals') . $this->currency->format($option['order_option_price']);
                            }
                        }
                    }

                    $data['order_menus'][] = array(
                        'menu_name'     => $menu['name'],
                        'menu_quantity' => $menu['quantity'],
                        'menu_price'    => $this->currency->format($menu['price']),
                        'menu_subtotal' => $this->currency->format($menu['subtotal']),
                        'menu_options'  => implode('<br /> ', $option_data),
                        'menu_comment'  => $menu['comment'],
                    );
                }
            }

            $data['order_totals'] = array();
            $order_totals = $this->getOrderTotals($result['order_id']);
            if ($order_totals) {
                foreach ($order_totals as $total) {
                    $data['order_totals'][] = array(
                        'order_total_title' => htmlspecialchars_decode($total['title']),
                        'order_total_value' => $this->currency->format($total['value']),
                        'priority' => $total['priority'],
                    );
                }
            }

            $data['order_address'] = $this->lang->line('text_collection_order_type');
            if ( ! empty($result['address_id'])) {
                $this->load->model('Addresses_model');
                $order_address = $this->Addresses_model->getAddress($result['customer_id'], $result['address_id']);
                $data['order_address'] = $this->country->addressFormat($order_address);
            }

            if ( ! empty($result['location_id'])) {
                $this->load->model('Locations_model');
                $location = $this->Locations_model->getLocation($result['location_id']);
                $data['location_name'] = $location['location_name'];
            }
        }

        return $data;
    }

    public function sendMail($email, $mail_template = array(), $mail_data = array()) {
        if (empty($mail_template) OR !isset($mail_template['subject'], $mail_template['body']) OR empty($mail_data)) {
            return FALSE;
        }

        $this->load->library('email');

        $this->email->initialize();

        if (!empty($mail_data['status_comment'])) {
            $mail_data['status_comment'] = $this->email->parse_template($mail_data['status_comment'], $mail_data);
        }

        $this->email->from($this->config->item('site_email'), $this->config->item('site_name'));
        $this->email->to(strtolower($email));
        $this->email->subject($mail_template['subject'], $mail_data);
        $this->email->message($mail_template['body'], $mail_data);

        if ( ! $this->email->send()) {
            log_message('error', $this->email->print_debugger(array('headers')));
            $notify = '0';
        } else {
            $notify = '1';
        }

        return $notify;
    }

    public function validateOrder($order_id) {
        if ( ! empty($order_id)) {
            $this->db->from('orders');
            $this->db->where('order_id', $order_id);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public function deleteOrder($order_id) {
        if (is_numeric($order_id)) $order_id = array($order_id);

        if ( ! empty($order_id) AND ctype_digit(implode('', $order_id))) {
            $this->db->where_in('order_id', $order_id);
            $this->db->delete('orders');

            if (($affected_rows = $this->db->affected_rows()) > 0) {
                $this->db->where_in('order_id', $order_id);
                $this->db->delete('order_menus');

                $this->db->where_in('order_id', $order_id);
                $this->db->delete('order_options');

                $this->db->where_in('order_id', $order_id);
                $this->db->delete('order_totals');

                $this->db->where_in('order_id', $order_id);
                $this->db->delete('coupons_history');

                return $affected_rows;
            }
        }
    }
}

/* End of file orders_model.php */
/* Location: ./system/tastyigniter/models/orders_model.php */