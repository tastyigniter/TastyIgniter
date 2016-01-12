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
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Email Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\TI_Email.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Email extends CI_Email {

    public $useragent	= 'TastyIgniter';

    public $mailtype	= 'html';

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
        $config['smtp_host'] = $this->CI->config->item('smtp_host');
        $config['smtp_port'] = $this->CI->config->item('smtp_port');
        $config['smtp_user'] = $this->CI->config->item('smtp_user');
        $config['smtp_pass'] = $this->CI->config->item('smtp_pass');
        $config['crlf']      = "\r\n";
        $config['newline']   = "\r\n";

        return parent::initialize($config);
    }

    // --------------------------------------------------------------------

    public function subject($subject, $parse_data = NULL) {
        if (!empty($parse_data)) {
            $subject = $this->parse_template($subject, $parse_data);
        }

        return parent::subject($subject);
    }

    public function message($body, $parse_data = NULL) {
        if (!empty($parse_data)) {
            $body = $this->parse_template($body, $parse_data);
        }

        $body = ($this->mailtype === 'html') ? $this->_build_html_mail($body) : strip_tags($body);

        return parent::message($body);
    }

    public function parse_template($template, $data = array()) {
        if (!is_string($template) OR !is_array($data)) return NULL;

        $data['site_name'] = $this->CI->config->item('site_name');
        $data['signature'] = $this->CI->config->item('site_name');
        $data['site_url'] = root_url();

        $this->CI->load->model('Image_tool_model');
        $data['site_logo'] = $this->CI->Image_tool_model->resize($this->CI->config->item('site_logo'));

        $this->CI->load->library('parser');

        return $this->CI->parser->parse_string($template, $data);
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
                            padding: 0;
                            margin: 0;
                        }

                        html { -webkit-text-size-adjust:none; -ms-text-size-adjust: none;}
                        @media only screen and (max-device-width: 680px), only screen and (max-width: 680px) {
                            *[class="table_width_100"] {
                                width: 96% !important;
                            }
                            *[class="border-right_mob"] {
                                border-right: 1px solid #dddddd;
                            }
                            *[class="mob_100"] {
                                width: 100% !important;
                            }
                            *[class="mob_center"] {
                                text-align: center !important;
                            }
                            *[class="mob_center_bl"] {
                                float: none !important;
                                display: block !important;
                                margin: 0px auto;
                            }
                            .iage_footer a {
                                text-decoration: none;
                                color: #929ca8;
                            }
                            img.mob_display_none {
                                width: 0px !important;
                                height: 0px !important;
                                display: none !important;
                            }
                            img.mob_width_50 {
                                width: 40% !important;
                                height: auto !important;
                            }
                        }
                        .table_width_100 {
                            width: 680px;
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