<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class Extension
 *
 */
class TI_Model extends CI_Model {

    public function __construct($config = array())
    {
        $class = str_replace($this->config->item('subclass_prefix'), '', get_class($this));
        log_message('info', $class . ' Class Initialized');
        $this->load->database();
    }
}

/* End of file TI_Model.php */
/* Location: ./system/tastyigniter/core/TI_Model.php */