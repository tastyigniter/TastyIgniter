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
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin Controller Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\Admin_Controller.php
 * @link           http://docs.tastyigniter.com
 */
class Admin_Controller extends Authenticated_Controller
{
	/**
	 * @var array Filters for list columns
	 */
	public $list_filters = array();

	/**
	 * @var array Sorting columns
	 */
	public $sort_columns = array();

	/**
	 * Class constructor
	 *
	 */
	public function __construct() {
		$this->libraries[] = 'form_validation';

		parent::__construct();

		log_message('info', 'Admin Controller Class Initialized');

		// Load template library
		$this->load->library('template');

		$this->form_validation->CI =& $this;

		if (!isset($this->index_url)) $this->index_url = $this->controller;
		if (!isset($this->create_url)) $this->create_url = $this->controller . '/edit';
		if (!isset($this->edit_url)) $this->edit_url = $this->controller . '/edit?id={id}';
		if (!isset($this->delete_url)) $this->delete_url = $this->controller;

		$this->createFilter();
	}

	public function createFilter() {
		if (is_array($this->list_filters)) {
			foreach ($this->list_filters as $item => $value) {
				$this->list_filters[$item] = ($this->input->get($item)) ? $this->input->get($item) : $value;
			}
		}

		if (is_array($this->sort_columns)) {
			$order_by = (isset($this->list_filters['order_by']) AND $this->list_filters['order_by'] == 'ASC') ? 'DESC' : 'ASC';
			foreach ($this->sort_columns as $sort) {
				$url = array_merge(array_filter($this->input->get()), array('sort_by' => $sort, 'order_by' => $order_by));
				if (strpos($sort, '.') !== FALSE) {
					$sort = explode('.', $sort);
					$sort = end($sort);
				}
				$this->sort_columns['sort_' . $sort] = site_url($this->index_url . '?' . http_build_query($url));
			}
		}
	}

	protected function pageUrl($uri = NULL, $params = array()) {
		return site_url($this->pageUri($uri, $params));
	}

	protected function pageUri($uri = NULL, $params = array()) {
		if (!empty($params)) {
			$uri = preg_replace_callback('/{(.*?)}/', function ($preg) use ($params) {
				$preg[1] = ($preg[1] == 'id' AND !isset($params[$preg[1]])) ? singular($this->controller).'_'.$preg[1] : $preg[1];
				return isset($params[$preg[1]]) ? $params[$preg[1]] : '';
			}, $uri);
		}

		return ($uri === NULL) ? $this->index_url : $uri;
	}

	protected function redirect($uri = NULL) {
		if (is_numeric($uri)) {
			$uri = ($this->input->post('save_close') !== '1') ? str_replace('{id}', $uri, $this->edit_url) : NULL;
		}

		redirect(($uri === NULL) ? $this->index_url : $uri);
	}
}

/* End of file Admin_Controller.php */
/* Location: ./system/tastyigniter/core/Admin_Controller.php */