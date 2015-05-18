<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Mail_template {

	private $left_delim = '{';
	private $right_delim = '}';
	private $header = '';
	private $subject = '';
	private $body = '';
	private $footer = '';

	public function __construct() {
		$this->CI =& get_instance();
		$this->CI->load->database();
	}

	public function setTemplate($template_id, $code) {
		$template = array();

		if (isset($this->CI->db) AND $template_id AND $code) {
			$this->CI->db->from('mail_templates_data');
			$this->CI->db->join('mail_templates', 'mail_templates.template_id = mail_templates_data.template_id', 'left');
			$this->CI->db->where('mail_templates_data.template_id', $template_id);
			$this->CI->db->where('mail_templates_data.code', $code);

			$query = $this->CI->db->get();

			if ($query->num_rows() > 0) {
				$template = $query->row_array();
			}
		}

		return $template;
	}

	public function parseTemplate($code, $data) {
		$template_id = (int) $this->CI->config->item('mail_template_id');
		$template = $this->setTemplate($template_id, $code);

		if (!empty($template)) {
			$this->subject 	= $this->_parseTemplate($template['subject'], $data);
			$this->body 	= $this->_parseTemplate($template['body'], $data);
			return $this->_buildTemplate();
		}

		return FALSE;
	}

	public function getSubject() {
		return $this->subject;
	}

	public function _parseTemplate($template, $data) {
		if ($template == '') {
			return FALSE;
		}

		foreach ($data as $key => $value) {
			if (is_array($value)) {
				$template = $this->_parseArray($key, $value, $template);
			} else {
				$template = $this->_parseString($key, (string)$value, $template);
			}
		}

		return $template;
	}

	public function _parseString($find, $string, $template) {
		return str_replace($this->left_delim . $find . $this->right_delim, $string, $template);
	}

	public function _parseArray($find, $array, $template) {
		if ( ! preg_match('|'. preg_quote($this->left_delim) . $find . preg_quote($this->right_delim) . '(.+?)'. preg_quote($this->left_delim) . '/' . $find . preg_quote($this->right_delim) . '|s', $template, $match)) {
			return $template;
		}

		$str = '';
		if (is_array($array)) {
			foreach ($array as $roww) {
				$temp = $match['1'];
				foreach ($roww as $find => $value) {
					if ( ! is_array($value)) {
						$temp = $this->_parseString($find, $value, $temp);
					} else {
						$temp = $this->_parseArray($find, $value, $temp);
					}
				}

				$str .= $temp;
			}
		}

		return str_replace($match['0'], $str, $template);
	}

	public function _buildTemplate() {
		$build  = '';
		$build .= '<!DOCTYPE html>';
		$build .= '<html xmlns="http://www.w3.org/1999/xhtml">';
		$build .= '<head>';
		$build .= '<title>'. $this->subject .'</title>';
		$build .= '<meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
		$build .= '</head>';
		$build .= '<body>';
		$build .= '<div id="container">';
		$build .= '<div id="content">'. $this->body .'</div>';
		$build .= '</div>';
		$build .= '</body>';
		$build .= '</html>';

		return $build;
	}
}

// END Mail_template Class

/* End of file Mail_template.php */
/* Location: ./system/tastyigniter/libraries/Mail_template.php */