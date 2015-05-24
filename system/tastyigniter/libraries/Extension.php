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

        !empty($this->extensions) OR $this->extensions = $this->CI->Extensions_model->getExtensions();
    }

    public function getExtensions($type = NULL) {
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
        if (!empty($name)) {
            if (!empty($this->extensions['module'][$name]) AND is_array($this->extensions['module'][$name])) {
                return $this->extensions['module'][$name];
            }
        }
    }

    public function getPayments() {
        return $this->getExtensions('payment');
    }

    public function getPayment($name) {
        if (!empty($name)) {
            if (!empty($this->extensions['payment'][$name]) AND is_array($this->extensions['payment'][$name])) {
                return $this->extensions['payment'][$name];
            }
        }
    }

    public function getConfig($ext_name = '', $item = '', $fail_gracefully = FALSE) {
        return $this->CI->Extensions_model->getConfig($ext_name, $item, $fail_gracefully);
    }
}

// END Extension Class

/* End of file Extension.php */
/* Location: ./system/tastyigniter/libraries/Extension.php */