<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Email Libary Class Extension
 *
 */
class TI_Email extends CI_Email {

    public $useragent	= 'TastyIgniter';

    /**
     * Initialize preferences
     *
     * @param	array
     * @return	CI_Email
     */
    public function initialize($config = array())
    {
        $this->CI =& get_instance();

        $config['protocol']  = $this->CI->config->item('protocol');
        $config['mailtype']  = $this->CI->config->item('mailtype');
        $config['smtp_host'] = $this->CI->config->item('smtp_host');
        $config['smtp_port'] = $this->CI->config->item('smtp_port');
        $config['smtp_user'] = $this->CI->config->item('smtp_user');
        $config['smtp_pass'] = $this->CI->config->item('smtp_pass');
        $config['newline']   = "\r\n";

        return parent::initialize($config);
    }

    // --------------------------------------------------------------------
}

/* End of file TI_Email.php */
/* Location: ./system/tastyigniter/core/TI_Email.php */