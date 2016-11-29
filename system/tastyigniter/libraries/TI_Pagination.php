<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package       TastyIgniter
 * @author        SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link          http://tastyigniter.com
 * @license       http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since         File available since Release 1.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Pagination Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\TI_Pagination.php
 * @link           http://docs.tastyigniter.com
 */
class TI_Pagination extends CI_Pagination
{

	/**
	 * Constructor
	 *
	 * @param    array $params Initialization parameters
	 *
	 * @return    void
	 */
	public function __construct($params = [])
	{
		$this->CI =& get_instance();
		$this->CI->load->language('pagination');
		foreach (['first_link', 'next_link', 'prev_link', 'last_link', 'info_text', 'per_page_text'] as $key) {
			if (($val = $this->CI->lang->line('pagination_' . $key)) !== FALSE) {
				$this->$key = $val;
			}
		}

		$this->initialize($params);
		log_message('info', 'Pagination Class Initialized');
	}

	/**
	 * Initialize Preferences
	 *
	 * @param    array $params Initialization parameters
	 *
	 * @return    TI_Pagination
	 */
	public function initialize(array $params = [])
	{
		isset($params['attributes']) OR $params['attributes'] = [];
		if (is_array($params['attributes'])) {
			$this->_parse_attributes($params['attributes']);
			unset($params['attributes']);
		}

		// Deprecated legacy support for the anchor_class option
		// Should be removed in CI 3.1+
		if (isset($params['anchor_class'])) {
			empty($params['anchor_class']) OR $attributes['class'] = $params['anchor_class'];
			unset($params['anchor_class']);
		}

		foreach ($params as $key => $val) {
			if (property_exists($this, $key)) {
				$this->$key = $val;
			}
		}

		if ($this->CI->config->item('enable_query_strings') === TRUE) {
			$this->page_query_string = TRUE;
		}

		if ($this->use_global_url_suffix === TRUE) {
			$this->suffix = $this->CI->config->item('url_suffix');
		}

		return $this;
	}

	// --------------------------------------------------------------------
	/**
	 * Generate the pagination info
	 *
	 * @return    string
	 */
	function create_infos()
	{
		$num_pages = ceil($this->total_rows / $this->per_page);

		if ($this->CI->input->get($this->query_string_segment)) {
			$page = $this->CI->input->get($this->query_string_segment);
		} else {
			$page = 1;
		}

		$find = [
			'{start}',
			'{end}',
			'{total}',
			'{pages}',
		];

		$replace = [
			($this->total_rows) ? (($page - 1) * $this->per_page) + 1 : 0,
			((($page - 1) * $this->per_page) > ($this->total_rows - $this->per_page)) ? $this->total_rows : ((($page - 1) * $this->per_page) + $this->per_page),
			$this->total_rows,
			$num_pages,
		];

		$per_page = ['20', '50', '100', '250', '500', '1000', '2500'];
		if (APPDIR === MAINDIR) {
			$info = '<span>' . str_replace($find, $replace, $this->info_text) . '</span>';
		} else {
			$info = '<div class="input-group">';
			$info .= '<span class="input-group-addon">' . str_replace($find, $replace, $this->info_text) . '</span>';
			if ($this->total_rows > $this->per_page) {
				$info .= '<select id="per-page-limit" class="form-control per-page-limit" onchange="filterList()">';
				foreach ($per_page as $num) {
					$selected = ($this->per_page == $num) ? 'selected' : '';
					$info .= '<option value="' . $num . '" ' . $selected . '>' . str_replace('{per_page}', $num, $this->per_page_text) . '</option>';
				}
				$info .= '</select>';
			}
			$info .= '</div>';
		}

		return $info;
	}

	// --------------------------------------------------------------------

}

/* End of file TI_Pagination.php */
/* Location: ./system/tastyigniter/libraries/TI_Pagination.php */