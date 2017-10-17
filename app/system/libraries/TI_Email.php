<?php

/**
 * TastyIgniter Email Class
 *
 * @package        Igniter\Libraries\TI_Email.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Email extends CI_Email
{

	public $useragent = 'TastyIgniter';

	public $mailtype = 'html';

	/**
	 * Initialize preferences
	 *
	 * @param    array
	 *
	 * @return    CI_Email
	 */
	public function initialize(array $config = [])
	{
        $CI =& get_instance();

		$config['protocol'] = $CI->config->item('protocol');
		$config['smtp_host'] = $CI->config->item('smtp_host');
		$config['smtp_port'] = $CI->config->item('smtp_port');
		$config['smtp_user'] = $CI->config->item('smtp_user');
		$config['smtp_pass'] = $CI->config->item('smtp_pass');
		$config['crlf'] = "\r\n";
		$config['newline'] = "\r\n";

		return parent::initialize($config);
	}

    public function set_template($template, $data = [])
    {
        if (!is_array($template)) {
            $CI =& get_instance();
            $CI->load->model('Mail_templates_model');
            $template = $CI->Mail_templates_model->getDefaultTemplateData($template);
        }

        $this->subject($template['subject'], $data);
        $this->message($template['body'], $data);
    }

	// --------------------------------------------------------------------

	public function subject($subject, $parse_data = null)
	{
		if (!empty($parse_data)) {
			$subject = $this->parse_template($subject, $parse_data);
		}

		return parent::subject($subject);
	}

	public function message($body, $parse_data = null)
	{
		if (!empty($parse_data)) {
			$body = $this->parse_template($body, $parse_data);
		}

		$body = ($this->mailtype === 'html') ? $this->_build_html_mail($body) : strip_tags($body);

		return parent::message($body);
	}

	public function parse_template($template, $data = [])
	{
		if (!is_string($template) OR !is_array($data)) return null;

        $CI =& get_instance();

        $data['site_url'] = root_url();
        $data['site_logo'] = image_url($CI->config->item('site_logo'));
        $data['site_name'] = $CI->config->item('site_name');
        $data['signature'] = $CI->config->item('site_name');

        $CI->load->library('parser');

		return $CI->parser->parse_string($template, $data);
	}

	protected function _build_html_mail($body = '')
	{
		$build = '';
		$build .= '<!DOCTYPE html>';
		$build .= '<html xmlns="http://www.w3.org/1999/xhtml">';
		$build .= '<head>';
		$build .= '<title>' . str_replace(["\n", "\r"], '', $this->_headers['Subject']) . '</title>';
		$build .= '<meta http-equiv="Content-Type" content="text/html; charset=' . strtolower($this->charset) . '">';
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
		$build .= '<div id="content">' . $body . '</div>';
		$build .= '</div>';
		$build .= '</body>';
		$build .= '</html>';

		return $build;
	}
}

/* End of file TI_Email.php */
/* Location: ./system/core/TI_Email.php */