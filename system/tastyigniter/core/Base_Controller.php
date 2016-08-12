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
	 * @var array Default methods which cannot be called as actions.
	 */
	public $hidden_methods = array('getList', 'getForm');

	/**
	 * @var array Filters for list columns
	 */
	public $filter = array();

	/**
	 * @var array Default sort
	 */
	public $default_sort = array();

	/**
	 * @var array Sorting columns
	 */
	public $sort = array();

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
			// Load the currently logged-in user for convenience
			if ($this->user->auth() AND $this->user->isLogged()) {
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

	public function setFilter($filter = '', $value = NULL) {
		if (!isset($this->filter['page'])) $this->filter['page'] = '';
		if (!isset($this->filter['limit'])) $this->filter['limit'] = $this->config->item('page_limit');
		$this->filter['order_by'] = (isset($this->default_sort[1])) ? $this->default_sort[1] : 'ASC';
		$this->filter['sort_by'] = (isset($this->default_sort[0])) ? $this->default_sort[0] : '';

		if (is_string($filter)) {
			$filter = array($filter => $value);
		}

		foreach (array_merge($this->filter, $filter) as $name => $value) {
			$this->filter[$name] = $this->input->get($name) !== NULL ? $this->input->get($name) : $value;
		}
	}

	public function getFilter($filter = NULL) {
		if ($filter === NULL) {
			return $this->filter;
		} else if ($filter AND $this->input->get($filter)) {
			return $this->input->get($filter);
		} else if (isset($this->filter[$filter])) {
			return $this->filter[$filter];
		} else {
			return NULL;
		}
	}

	public function setSort($sort = array()) {
		if (is_array($this->sort)) {
			$order_by = (isset($this->filter['order_by']) AND $this->filter['order_by'] == 'ASC') ? 'DESC' : 'ASC';
			$this->sort['order_by_active'] = $order_by . ' active';
			foreach (array_merge($this->sort, $sort) as $sort_by) {
				$url = array_merge(array_filter($this->input->get()), array('sort_by' => $sort_by, 'order_by' => $order_by));
				if ((strpos($sort_by, '.') !== FALSE)) {
					$sort_by = explode('.', $sort_by);
					$sort_by = end($sort_by);
				}
				$this->sort['sort_' . $sort_by] = site_url($this->uri->uri_string() . '?' . http_build_query($url));
			}
		}
	}

	protected function getSort($sort_by = NULL) {
		if ($sort_by === NULL) {
			return $this->sort;
		} else if (isset($this->sort[$sort_by])) {
			return $this->sort[$sort_by];
		} else if (isset($this->sort['sort_'.$sort_by])) {
			return $this->sort['sort_'.$sort_by];
		}
	}

	public function _remap($method) {
		if (in_array(strtolower($method), array_map('strtolower', $this->hidden_methods))) {
			$this->index();
		} else if (method_exists($this, $method)) {
			$this->$method();
		} else {
			show_404(strtolower($this->controller).'/'.$method);
		}
	}
}

/* End of file Base_Controller.php */
/* Location: ./system/tastyigniter/core/Base_Controller.php */