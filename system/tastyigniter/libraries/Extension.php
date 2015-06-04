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
            if (!empty($this->extensions[$type]) AND is_array($this->extensions[$type])) {
                return $this->extensions[$type];
            }
        }

        return $this->extensions;
    }

    public function getModules() {
        return $this->getExtensions('module');
    }

    public function getModule($name) {
        $modules = $this->getExtensions('module');

        if (!empty($modules[$name]) AND is_array($modules[$name])) {
            return $modules[$name];
        }
    }

    public function getPayments() {
        return $this->getExtensions('payment');
    }

    public function getPayment($name) {
        $payments = $this->getExtensions('payment');

        if (!empty($payments[$name]) AND is_array($payments[$name])) {
            return $payments[$name];
        }
    }

    public function getConfig($ext_name = '', $item = '', $fail_gracefully = FALSE) {
        return $this->CI->Extensions_model->getConfig($ext_name, $item, $fail_gracefully);
    }
}

// END Extension Class

/* End of file Extension.php */
/* Location: ./system/tastyigniter/libraries/Extension.php */