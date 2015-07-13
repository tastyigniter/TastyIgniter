<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Class Extension
 *
 */
class Extension {

    private $extensions = array();

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('Extensions_model');
    }

    public function getExtensions($type = NULL) {
        !empty($this->extensions) OR $this->extensions = $this->CI->Extensions_model->getExtensions('', TRUE);

        if (!empty($type)) {
            $results = array();

            foreach ($this->extensions as $name => $extenion) {
                if ($extenion['type'] === $type) {
                    $results[$name] = $extenion;
                }
            }

            return $results;
        }

        return $this->extensions;
    }

    public function getModules() {
        return $this->CI->Extensions_model->getExtensions('module', TRUE);
    }

    public function getModule($name) {
        $modules = $this->getModules();

        if (!empty($modules[$name]) AND is_array($modules[$name])) {
            return $modules[$name];
        }
    }

    public function getPayments() {
        return $this->CI->Extensions_model->getExtensions('payment', TRUE);
    }

    public function getPayment($name) {
        $payments = $this->getPayments();

        if (!empty($payments[$name]) AND is_array($payments[$name])) {
            return $payments[$name];
        }
    }

    public function getAvailablePayments($load_payment = TRUE) {
        $payments = array();
        $this->CI->load->library('location');

        foreach ($this->getPayments() as $payment) {
            if (!empty($payment['ext_data'])) {
                if ($payment['ext_data']['status'] === '1') {

                    $payments[$payment['name']] = array(
                        'name'		=> $payment['title'],
                        'code'		=> $payment['name'],
                        'priority'	=> $payment['ext_data']['priority'],
                        'status'	=> $payment['ext_data']['status'],
                        'data'      => ($load_payment) ? Modules::run($payment['name'] . '/' . $payment['name'] . '/index') : array()
                    );
                }
            }
        }

        if (!empty($payments)) {
            $sort_order = array();
            foreach ($payments as $key => $value) {
                $sort_order[$key] = $value['priority'];
            }
            array_multisort($sort_order, SORT_ASC, $payments);
        }

        return $payments;
    }

    public function getConfig($ext_name = '', $item = '', $fail_gracefully = FALSE) {
        return $this->CI->Extensions_model->getConfig($ext_name, $item, $fail_gracefully);
    }
}

// END Extension Class

/* End of file Extension.php */
/* Location: ./system/tastyigniter/libraries/Extension.php */