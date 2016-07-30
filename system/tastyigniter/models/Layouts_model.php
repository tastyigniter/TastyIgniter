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
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Layouts Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Layouts_model.php
 * @link           http://docs.tastyigniter.com
 */
class Layouts_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'layouts';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'layout_id';

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->count_all();
	}

	/**
	 * List all coupons matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		return $this->filter($filter)->find_all();
	}

	/**
	 * Return all layouts
	 *
	 * @return array
	 */
	public function getLayouts() {
		return $this->find_all();
	}

	/**
	 * Return all layout routes
	 *
	 * @return array
	 */
	public function getRoutes() {
		return $this->order_by('priority')->from('uri_routes')->get_many();
	}

	/**
	 * Find a single layout by layout_id
	 *
	 * @param int $layout_id
	 *
	 * @return mixed
	 */
	public function getLayout($layout_id) {
		return $this->find($layout_id);
	}

	/**
	 * Return all layout modules
	 *
	 * @param int $layout_id
	 *
	 * @return array
	 */
	public function getLayoutModules($layout_id) {
		$this->load->model('Layout_modules_model');

		$result = array();
		if ($modules = $this->Layout_modules_model->find_all('layout_id', $layout_id)) {
			foreach ($modules as $row) {
				$row['options'] = $options = !empty($row['options']) ? unserialize($row['options']) : array();
				$row['title'] = isset($options['title']) ? htmlspecialchars_decode($options['title']) : '';
				$row['fixed'] = isset($options['fixed']) ? $options['fixed'] : '';
				$row['fixed_top_offset'] = isset($options['fixed_top_offset']) ? $options['fixed_top_offset'] : '';
				$row['fixed_bottom_offset'] = isset($options['fixed_bottom_offset']) ? $options['fixed_bottom_offset'] : '';

				$result[$row['partial']][] = $row;
			}
		}

		return $result;
	}

	/**
	 * Return all layouts by module code
	 *
	 * @param string $module_code
	 *
	 * @return array
	 */
	public function getModuleLayouts($module_code) {
		$this->load->model('Layout_modules_model');
		$this->Layout_modules_model->join('layouts', 'layouts.layout_id = layout_modules.layout_id', 'left');
		$layouts = $this->Layout_modules_model->order_by('priority')->find_all('module_code', $module_code);

		$result = array();
		if ($layouts) {
			foreach ($layouts as $row) {
				$row['options'] = $options = !empty($row['options']) ? unserialize($row['options']) : array();
				$row['title'] = isset($options['title']) ? htmlspecialchars_decode($options['title']) : '';
				$row['fixed'] = isset($options['fixed']) ? $options['fixed'] : '';
				$row['fixed_top_offset'] = isset($options['fixed_top_offset']) ? $options['fixed_top_offset'] : '';
				$row['fixed_bottom_offset'] = isset($options['fixed_bottom_offset']) ? $options['fixed_bottom_offset'] : '';

				$result[] = $row;
			}
		}

		return $result;
	}

	/**
	 * Return all layouts by $uri_route
	 *
	 * @param string $uri_route
	 *
	 * @return array
	 */
	public function getRouteLayoutModules($uri_route) {
		$result = array();
		$this->load->model('Layout_routes_model');

		if (!empty($uri_route)) {
			foreach (array_unique($uri_route) as $route) {
				$this->Layout_routes_model->select('layout_modules.layout_id, layout_module_id, module_code, uri_route, partial, priority, layout_modules.options, layout_modules.status');
				$this->Layout_routes_model->join('layout_modules', 'layout_modules.layout_id = layout_routes.layout_id', 'left');
				$this->Layout_routes_model->join('pages', 'pages.layout_id = layout_routes.layout_id', 'left');
				$this->Layout_routes_model->group_by('layout_module_id');

				if (is_numeric($route)) {
					$this->Layout_routes_model->or_where('pages.page_id', $route);
				} else {
					$this->Layout_routes_model->or_where('layout_routes.uri_route', $route);
				}

				if ($layouts = $this->Layout_routes_model->find_all()) {
					foreach ($layouts as $row) {
						$row['options'] = $options = !empty($row['options']) ? unserialize($row['options']) : array();
						$row['title'] = isset($options['title']) ? htmlspecialchars_decode($options['title']) : '';
						$row['fixed'] = isset($options['fixed']) ? $options['fixed'] : '';
						$row['fixed_top_offset'] = isset($options['fixed_top_offset']) ? $options['fixed_top_offset'] : '';
						$row['fixed_bottom_offset'] = isset($options['fixed_bottom_offset']) ? $options['fixed_bottom_offset'] : '';

						$result[$row['partial']][] = $row;
					}

					return $result;
				}
			}
		}

		return $result;
	}

	/**
	 * Return all layout routes by layout_id
	 *
	 * @param int $layout_id
	 *
	 * @return array
	 */
	public function getLayoutRoutes($layout_id) {
		$this->load->model('Layout_routes_model');

		return $this->Layout_routes_model->find_all('layout_id', $layout_id);
	}

	/**
	 * Find a single layout by uri route
	 *
	 * @param string $uri_route
	 *
	 * @return null
	 */
	public function getRouteLayoutId($uri_route = '') {
		$layout_id = NULL;

		if ($uri_route !== '') {
			$this->load->model('Layout_routes_model');
			if ($row = $this->Layout_routes_model->find('uri_route', $uri_route)) {
				$layout_id = $row['layout_id'];
			}
		}

		return $layout_id;
	}

	/**
	 * Find a single layout by page_id
	 *
	 * @param string $page_id
	 *
	 * @return null
	 */
	public function getPageLayoutId($page_id = '') {
		$layout_id = NULL;

		if ($page_id !== '') {
			$this->load->model('Pages_model');

			if ($row = $this->Pages_model->find($page_id)) {
				$layout_id = $row['layout_id'];
			}
		}

		return $layout_id;
	}

	/**
	 * Update existing routes
	 *
	 * @param array $routes
	 *
	 * @return bool TRUE on success
	 */
	public function updateRoutes($routes = array()) {
		if (!empty($routes)) {
			$write_routes = array();

			$this->truncate('uri_routes');
			$priority = 1;
			foreach ($routes as $key => $value) {
				if (!empty($value['uri_route']) AND !empty($value['controller'])) {
					$write_routes[$priority] = $value;

					$this->insert_into('uri_routes', array(
						'uri_route'  => $value['uri_route'],
						'controller' => $value['controller'],
						'priority'   => $priority,
					));

					$priority++;
				}
			}

//			$this->writeRoutesFile($write_routes);

			if ($this->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	/**
	 * Write routes into system routes file
	 *
	 * @param array $write_routes
	 */
	public function writeRoutesFile($write_routes = array()) {

		$filepath = IGNITEPATH . 'config/routes.php';
		$line = '';

		if ($fp = @fopen($filepath, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {

			$line .= "<" . "?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');\n\n";

			$line .= "$" . "route['default_controller'] = 'home';\n";
			$line .= "$" . "route[\"^(\".implode('|', array('home', 'menus', 'reserve', 'contact', 'checkout', 'maintenance', 'local', 'pages')).\")?$\"] = '$1';\n";
			$line .= "$" . "route[\"^(\".implode('|', array('home', 'menus', 'reserve', 'contact', 'checkout', 'maintenance', 'local', 'pages')).\")?/(:any)$\"] = '$1';\n";
			$line .= "$" . "route[\"^(\".implode('|', array('home', 'menus', 'reserve', 'contact', 'checkout', 'maintenance', 'local', 'pages')).\")?/(:any)$\"] = '$1/$2';\n";

			if (!empty($write_routes) AND is_array($write_routes)) {
				foreach ($write_routes as $key => $value) {
					$line .= "$" . "route['" . $value['uri_route'] . "'] = '" . $value['controller'] . "';\n";
				}
			}

			//$line .= "$"."route['(:any)'] = 'slug';\n\n";
			$line .= "$" . "route['404_override'] = '';\n\n";

			$line .= "/* End of file routes.php */\n";
			$line .= "/* Location: ./system/tastyigniter/config/routes.php */";

			flock($fp, LOCK_EX);
			fwrite($fp, $line);
			flock($fp, LOCK_UN);
			fclose($fp);

			@chmod($filepath, FILE_WRITE_MODE);
		}
	}

	/**
	 * Create a new or update existing layout
	 *
	 * @param       $layout_id
	 * @param array $save
	 *
	 * @return bool
	 */
	public function saveLayout($layout_id, $save = array()) {
		if (empty($save)) return FALSE;

		if ($layout_id = $this->skip_validation(TRUE)->save($save, $layout_id)) {
			$routes = (isset($save['routes'])) ? $save['routes'] : array();
			$this->addLayoutRoutes($layout_id, $routes);

			$modules = (isset($save['modules'])) ? $save['modules'] : array();
			$this->addLayoutModules($layout_id, $modules);

			return $layout_id;
		}
	}

	/**
	 * Create a new or update existing layout routes
	 *
	 * @param int   $layout_id
	 * @param array $routes
	 *
	 * @return bool|int
	 */
	protected function addLayoutRoutes($layout_id, $routes = array()) {
		$query = FALSE;
		$this->load->model('Layout_routes_model');
		$this->Layout_routes_model->delete('layout_id', $layout_id);

		if (is_array($routes)) {
			foreach ($routes as $route) {
				if (!empty($route['uri_route'])) {
					$query = $this->Layout_routes_model->insert(array(
						'layout_id' => $layout_id,
						'uri_route' => $route['uri_route'],
					));
				}
			}
		}

		return $query;
	}

	/**
	 * Create a new or update existing layout modules
	 *
	 * @param int   $layout_id
	 * @param array $partial_modules
	 *
	 * @return bool|int
	 */
	protected function addLayoutModules($layout_id, $partial_modules = array()) {
		$query = FALSE;
		$this->load->model('Layout_modules_model');
		$this->Layout_modules_model->delete('layout_id', $layout_id);

		if (is_array($partial_modules)) {
			foreach ($partial_modules as $partial => $modules) {
				$priority = 1;
				foreach ($modules as $module) {
					if (!empty($module) AND is_array($module)) {
						$options = array();
						$options['title'] = isset($module['title']) ? htmlspecialchars($module['title']) : '';
						$options['fixed'] = isset($module['fixed']) ? $module['fixed'] : '';
						$options['fixed_top_offset'] = isset($module['fixed_top_offset']) ? $module['fixed_top_offset'] : '';
						$options['fixed_bottom_offset'] = isset($module['fixed_bottom_offset']) ? $module['fixed_bottom_offset'] : '';

						$query = $this->Layout_modules_model->insert(array(
							'layout_id'   => $layout_id,
							'module_code' => $module['module_code'],
							'partial'     => $module['partial'],
							'priority'    => $priority,
							'options'     => serialize($options),
							'status'      => $module['status'],
						));

						$priority++;
					}
				}
			}
		}

		return $query;
	}

	/**
	 * Delete a single or multiple layout by layout_id
	 *
	 * @param string|array $layout_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteLayout($layout_id) {
		if (is_numeric($layout_id)) $layout_id = array($layout_id);

		if (!empty($layout_id) AND ctype_digit(implode('', $layout_id))) {
			$affected_rows = $this->delete('layout_id', $layout_id);

			if ($affected_rows > 0) {
				$this->load->model('Layout_routes_model');
				$this->Layout_routes_model->delete('layout_id', $layout_id);

				$this->load->model('Layout_modules_model');
				$this->Layout_modules_model->delete('layout_id', $layout_id);

				return $affected_rows;
			}
		}
	}
}

/* End of file Layouts_model.php */
/* Location: ./system/tastyigniter/models/Layouts_model.php */