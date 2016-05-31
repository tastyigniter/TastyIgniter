<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Cart_model extends TI_Model {

    public function __construct() {
        parent::__construct();

        if ($this->db->where('type', 'cart_total')->get('extensions')->num_rows() <= 0) {
            $this->extension->runMigration('cart_module');
        }
    }

    public function getMenus() {
        $this->db->select('menus.menu_id, menu_name, menu_description, menu_price, menu_photo, stock_qty, subtract_stock,
			minimum_qty, special_status, special_price, menus.mealtime_id, mealtimes.mealtime_name, mealtimes.start_time, mealtimes.end_time, mealtime_status');
        $this->db->select('IF(start_date <= CURRENT_DATE(), IF(end_date >= CURRENT_DATE(), "1", "0"), "0") AS is_special', FALSE);
        $this->db->select('IF(start_time <= CURRENT_TIME(), IF(end_time >= CURRENT_TIME(), "1", "0"), "0") AS is_mealtime', FALSE);
        $this->db->from('menus');
        $this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');
        $this->db->join('mealtimes', 'mealtimes.mealtime_id = menus.mealtime_id', 'left');
        $this->db->where('menu_status', '1');

        $query = $this->db->get();

        $result = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['start_time'] = !empty($row['start_time']) ? mdate($this->config->item('time_format'), strtotime($row['start_time'])) : '';
                $row['end_time'] = !empty($row['end_time']) ? mdate($this->config->item('time_format'), strtotime($row['end_time'])) : '';

                $result[$row['menu_id']] = $row;
            }
        }

        return $result;
    }

    public function getMenu($menu_id) {
        if (!empty($menu_id) AND is_numeric($menu_id)) {
            $this->db->select('menus.menu_id, menu_name, menu_description, menu_price, menu_photo, stock_qty, subtract_stock,
				minimum_qty, special_status, special_price, menus.mealtime_id, mealtimes.mealtime_name, mealtimes.start_time, mealtimes.end_time, mealtime_status');
            $this->db->select('IF(start_date <= CURRENT_DATE(), IF(end_date >= CURRENT_DATE(), "1", "0"), "0") AS is_special', FALSE);
            $this->db->select('IF(start_time <= CURRENT_TIME(), IF(end_time >= CURRENT_TIME(), "1", "0"), "0") AS is_mealtime', FALSE);
            $this->db->from('menus');
            $this->db->join('menus_specials', 'menus_specials.menu_id = menus.menu_id', 'left');
            $this->db->join('mealtimes', 'mealtimes.mealtime_id = menus.mealtime_id', 'left');
            $this->db->where('menu_status', '1');
            $this->db->where('menus.menu_id', $menu_id);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                $row['start_time'] = !empty($row['start_time']) ? mdate($this->config->item('time_format'), strtotime($row['start_time'])) : '';
                $row['end_time'] = !empty($row['end_time']) ? mdate($this->config->item('time_format'), strtotime($row['end_time'])) : '';

                return $row;
            }
        }
    }

    public function getMenuOptions($menu_id) {
        $results = array();

        if (!empty($menu_id) AND is_numeric($menu_id)) {
            $this->db->select('*, menu_options.menu_id, menu_options.option_id');
            $this->db->from('menu_options');
            $this->db->join('options', 'options.option_id = menu_options.option_id', 'left');

            $this->db->order_by('options.priority', 'ASC');

            $this->db->where('menu_options.menu_id', $menu_id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    if (!isset($results[$row['menu_option_id']])) {
                        $results[$row['menu_option_id']] = array(
                            'menu_option_id'	=> $row['menu_option_id'],
                            'menu_id'			=> $row['menu_id'],
                            'option_id'			=> $row['option_id'],
                            'option_name'		=> $row['option_name'],
                            'display_type'		=> $row['display_type'],
                            'required'			=> $row['required'],
                            'default_value_id'  => isset($row['default_value_id']) ? $row['default_value_id'] : 0,
                            'priority'			=> $row['priority']
                        );
                    }
                }
            }
        }

        return $results;
    }

    public function getMenuOption($option_id) {
        if (!empty($option_id)) {
            $this->db->from('options');
            $this->db->where('option_id', $option_id);

            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row_array();
            }
        }
    }

    public function getMenuOptionValues($menu_option_id = FALSE, $option_id = FALSE) {
        $result = array();

        if ($menu_option_id !== FALSE AND $option_id !== FALSE) {
            $this->db->select('*, menu_option_values.option_id, option_values.option_value_id');
            $this->db->from('menu_option_values');
            $this->db->join('option_values', 'option_values.option_value_id = menu_option_values.option_value_id', 'left');

            $this->db->order_by('option_values.priority', 'ASC');
            $this->db->where('menu_option_values.menu_option_id', $menu_option_id);
            $this->db->where('menu_option_values.option_id', $option_id);
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                foreach ($query->result_array() as $row) {
                    $result[$row['option_value_id']] = array(
                        'menu_option_value_id'	=> $row['menu_option_value_id'],
                        'option_value_id'		=> $row['option_value_id'],
                        'menu_id'				=> $row['menu_id'],
                        'option_id'				=> $row['option_id'],
                        'value'					=> $row['value'],
                        'new_price'				=> $row['new_price'],
                        'price'					=> (empty($row['new_price']) OR $row['new_price'] == '0.00') ? $row['price'] : $row['new_price']
                    );
                }
            }
        }

        return $result;
    }

    public function getTotals($filter = array('filter_status' => '1')) {
        $this->db->from('extensions');
        $this->db->where('type', 'cart_total');

        if (!empty($filter['filter_status'])) {
            $this->db->where('status', $filter['filter_status']);
        }

        $query = $this->db->get();

        $results = array();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $row['data'] = ($row['serialized'] === '1' AND ! empty($row['data'])) ? unserialize($row['data']) : array();

                $results[$row['name']] = array(
                    'name'        => $row['name'],
                    'title'       => htmlspecialchars_decode($row['data']['title']),
                    'admin_title' => htmlspecialchars_decode($row['data']['admin_title']),
                    'type'        => $row['type'],
                    'data'        => $row['data'],
                    'status'      => $row['status'],
                    'priority'    => $row['data']['priority'],
                );
            }
        }

        return sort_array($results, 'priority');
    }

    public function checkCoupon($code) {
        $result = FALSE;

        if (!empty($code)) {
            $this->db->from('coupons');
            $this->db->where('code', $code);

            $this->db->where('status', '1');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $row = $query->row_array();
                if ($row['validity'] === 'forever') {
                    $result = $row;
                } else if ($row['validity'] === 'fixed') {
                    $fixed_date = mdate('%Y-%m-%d', strtotime($row['fixed_date']));
                    $fixed_from_time = mdate('%H:%i', strtotime($row['fixed_from_time']));
                    $fixed_to_time = mdate('%H:%i', strtotime($row['fixed_to_time']));
                    $current_date = mdate('%Y-%m-%d', time());
                    $current_time = mdate('%H:%i', time());

                    if ($fixed_date === $current_date AND ($fixed_from_time <= $current_time AND $fixed_to_time >= $current_time)) {
                        $result = $row;
                    }
                } else if ($row['validity'] === 'period') {
                    $period_start_date = mdate('%Y-%m-%d', strtotime($row['period_start_date']));
                    $period_end_date = mdate('%Y-%m-%d', strtotime($row['period_end_date']));
                    $current_date = mdate('%Y-%m-%d', time());

                    if ($period_start_date <= $current_date AND $period_end_date >= $current_date) {
                        $result = $row;
                    }
                } else if ($row['validity'] === 'recurring') {
                    $weekdays = array_flip(array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'));
                    $current_day = date('l');
                    $weekday = $weekdays[$current_day];
                    $recurring_every = explode(', ', $row['recurring_every']);
                    $recurring_from_time = mdate('%H:%i', strtotime($row['recurring_from_time']));
                    $recurring_to_time = mdate('%H:%i', strtotime($row['recurring_to_time']));
                    $current_time = mdate('%H:%i', time());

                    if (in_array($weekday, $recurring_every) AND ($recurring_from_time <= $current_time AND $recurring_to_time >= $current_time)) {
                        $result = $row;
                    }
                }
            }
        }

        return $result;
    }

    public function checkCouponHistory($coupon_id) {
        if (!empty($coupon_id)) {
            $this->db->where('coupon_id', $coupon_id);
            $this->db->where('status', '1');
            $this->db->from('coupons_history');

            return $this->db->count_all_results();
        }
    }

    public function checkCustomerCouponHistory($coupon_id, $customer_id) {
        if (!empty($coupon_id)) {
            $this->db->where('coupon_id', $coupon_id);
            $this->db->where('customer_id', $customer_id);
            $this->db->where('status', '1');
            $this->db->from('coupons_history');

            return $this->db->count_all_results();
        }
    }

    public function updateTotals($save = array()) {
        if (empty($save) AND ! is_array($save)) return FALSE;

        $query = FALSE;

        $total_row = 1;
        foreach ($save as $key => $value) {
            $value['priority'] = $total_row;
            $value['title'] = htmlspecialchars($value['title']);

            $this->db->set('status', $value['status']);
            $this->db->set('title', $value['title']);
            $this->db->set('data', serialize($value));
            $this->db->set('serialized', '1');

            $this->db->where('type', 'cart_total');
            $this->db->where('name', $value['name']);

            $query = $this->db->update('extensions');

            $total_row++;
        }

        return $query;
    }
}

/* End of file cart_model.php */
/* Location: ./extensions/cart_module/models/cart_model.php */