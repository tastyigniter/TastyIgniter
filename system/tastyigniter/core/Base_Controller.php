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
 * Base Controller Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Core\Base_Controller.php
 * @link           http://docs.tastyigniter.com
 */
class Base_Controller extends MX_Controller
{
	/**
	 * @var string Link URL for the index page
	 */
	public $index_url = NULL;

	/**
	 * @var string Page controller being called.
	 */
	protected $controller;

	/**
	 * @var string Page method being called.
	 */
	protected $method;

	/**
	 * @var bool If TRUE, this class requires the user to be logged in before
	 * accessing any method.
	 */
	protected $authentication = FALSE;

	/**
	 * A list of models to be auto-loaded
	 */
	protected $models = array();

	/**
	 * A list of libraries to be auto-loaded
	 */
	protected $libraries = array();

	/**
	 * A list of helpers to be auto-loaded
	 */
	protected $helpers = array();

	/**
	 * A list of languages to be auto-loaded
	 */
	protected $languages = array();

	/**
	 * @var object Stores the logged in admin user.
	 */
	protected $current_user;

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
	 */
	public function __construct() {
		// Handle any auto-loading here...
		$this->autoload = array(
			'model'    => $this->models,
			'libraries' => array_merge(array('session', 'alert', 'installer', 'extension', 'events'), $this->libraries),
			'helper' => array_merge(array('inflector', 'text', 'number'), $this->helpers),
			'language' => $this->languages,
		);

		parent::__construct();

		log_message('info', 'Base Controller Class Initialized');

		$this->controller = strtolower($this->router->class);
		$this->method = $this->router->method;

		Events::trigger('before_controller', $this->controller);

		// If database is connected, then app is ready
		if ($this->installer->db_exists === TRUE) {

			// If the requested controller is a module controller then load the module config
			if (ENVIRONMENT !== 'testing') {
				if ($this->extension AND $this->router AND $_module = $this->router->fetch_module()) {
					// Load the module configuration file and retrieve its items.
					// Shows 404 error message on failure to load
					$this->extension->loadConfig($_module, TRUE);
				}
			}
		}

		// Ensures that a user is logged in, if required
		if ($this->authentication) {
			$this->setUser();
		}

		// Enable profiler for development environments.
		if (TI_DEBUG) $this->showProfiler();

		// After-Controller Constructor Event
		Events::trigger('after_controller_constructor', $this->controller);
	}

	protected function showProfiler() {
		if (!is_cli() AND !$this->input->is_ajax_request()) {
			if (!class_exists('Console', FALSE)) {
				$this->load->library('Console');
			}

			$this->output->enable_profiler(TI_DEBUG);
		}
	}

	protected function setUser() {
		if (class_exists('User', FALSE)) {
			$this->user->auth();

			// Load the currently logged-in user for convenience
			if ($this->user->isLogged()) {
				$this->current_user = $this->user;
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
		redirect(($uri === NULL) ? $this->index_url : $uri);
	}

	public function createFilter() {
		if (is_array($this->list_filters)) {
			if (!isset($this->list_filters['page'])) $this->list_filters['page'] = '';
			if (!isset($this->list_filters['limit'])) $this->list_filters['limit'] = $this->config->item('page_limit');

			foreach ($this->list_filters as $item => $value) {
				$this->list_filters[$item] = ($this->input->get($item)) ? $this->input->get($item) : $value;
			}
		}
	}

	protected function createSorting() {
		if (is_array($this->sort_columns)) {
			$order_by = (isset($this->list_filters['order_by']) AND $this->list_filters['order_by'] == 'ASC') ? 'DESC' : 'ASC';
			foreach ($this->sort_columns as $sort) {
				$url = array_merge(array_filter($this->input->get()), array('sort_by' => $sort, 'order_by' => $order_by));
				if ((strpos($sort, '.') !== FALSE)) {
					$sort = explode('.', $sort);
					$sort = end($sort);
				}
				$this->sort_columns['sort_' . $sort] = site_url($this->index_url . '?' . http_build_query($url));
			}
		}
	}

}

/* End of file Base_Controller.php */
/* Location: ./system/tastyigniter/core/Base_Controller.php */