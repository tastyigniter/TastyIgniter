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

    public function parse_template($template, $data = array()) {
        if (!is_string($template) OR !is_array($data)) return NULL;

        $this->CI->load->library('parser');

        return $this->CI->parser->parse_string($template, $data);
    }

    public function message($body) {
        $body = ($this->mailtype === 'html') ? $this->_build_html_mail($body) : strip_tags($body);

        return parent::message($body);
    }

    private function _build_html_mail($body = '') {
        $build  = '';
        $build .= '<!DOCTYPE html>';
        $build .= '<html xmlns="http://www.w3.org/1999/xhtml">';
        $build .= '<head>';
        $build .= '<title>'. str_replace(array("\n", "\r"), '', $this->_headers['Subject']) .'</title>';
        $build .= '<meta http-equiv="Content-Type" content="text/html; charset='.strtolower($this->charset).'">';
        $build .= '<style type="text/css">
						body {
							font-family: Arial, Verdana, Helvetica, sans-serif;
							font-size: 16px;
						}
					</style>';
        $build .= '</head>';
        $build .= '<body>';
        $build .= '<div id="container">';
        $build .= '<div id="content">'. $body .'</div>';
        $build .= '</div>';
        $build .= '</body>';
        $build .= '</html>';

        return $build;
    }
}

/* End of file TI_Email.php */
/* Location: ./system/tastyigniter/core/TI_Email.php */