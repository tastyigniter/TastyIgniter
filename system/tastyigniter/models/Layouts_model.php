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
class Layouts_model extends TI_Model {

	public function getCount($filter = array()) {
		$this->db->from('layouts');

		return $this->db->count_all_results();
	}

	public function getList($filter = array()) {
		if ( ! empty($filter['page']) AND $filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}

		if ($this->db->limit($filter['limit'], $filter['page'])) {
			$this->db->from('layouts');

			if ( ! empty($filter['sort_by']) AND ! empty($filter['order_by'])) {
				$this->db->order_by($filter['sort_by'], $filter['order_by']);
			}

			$query = $this->db->get();
			$result = array();

			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}

			return $result;
		}
	}

	public function getLayouts() {
		$this->db->from('layouts');

		$query = $this->db->get();

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getRoutes() {
		$this->db->from('uri_routes');

		$this->db->order_by('priority', 'ASC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getLayout($layout_id) {
		$this->db->from('layouts');

		$this->db->where('layout_id', $layout_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getLayoutModules($layout_id) {
		$this->db->from('layout_modules');
		$this->db->where('layout_id', $layout_id);

		$query = $this->db->get();

		$result = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
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

	public function getModuleLayouts($module_code) {
		$this->db->from('layout_modules');
		$this->db->where('module_code', $module_code);
		$this->db->join('layouts', 'layouts.layout_id = layout_modules.layout_id', 'left');
		$this->db->order_by('priority', 'ASC');

		$query = $this->db->get();

		$result = array();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
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

	public function getRouteLayoutModules($uri_route) {
		$result = array();

		if ( ! empty($uri_route)) {
			foreach (array_unique($uri_route) as $route) {
				$this->db->select('layout_modules.layout_id, layout_module_id, module_code, uri_route, partial, priority, layout_modules.options, layout_modules.status');

				$this->db->from('layout_routes');
				$this->db->join('layout_modules', 'layout_modules.layout_id = layout_routes.layout_id', 'left');
				$this->db->join('pages', 'pages.layout_id = layout_routes.layout_id', 'left');

				if (is_numeric($route)) {
					$this->db->or_where('pages.page_id', $route);
				} else {
					$this->db->or_where('layout_routes.uri_route', $route);
				}

				$this->db->group_by('layout_module_id');

				$query = $this->db->get();

				if ($query->num_rows() > 0) {
					foreach ($query->result_array() as $row) {
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

	public function getLayoutRoutes($layout_id) {
		$this->db->from('layout_routes');

		$this->db->where('layout_id', $layout_id);

		$query = $this->db->get();

		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}

	public function getRouteLayoutId($uri_route = '') {
		$layout_id = NULL;

		if ($uri_route !== '') {
			$this->db->from('layout_routes');
			$this->db->where('uri_route', $uri_route);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array('first');
				$layout_id = $row['layout_id'];
			}
		}

		return $layout_id;
	}

	public function getPageLayoutId($page_id = '') {
		$layout_id = NULL;

		if ($page_id !== '') {
			$this->db->from('pages');
			$this->db->where('page_id', $page_id);

			$query = $this->db->get();

			if ($query->num_rows() > 0) {
				$row = $query->row_array('first');
				$layout_id = $row['layout_id'];
			}
		}

		return $layout_id;
	}

	public function updateRoutes($routes = array()) {
		if ( ! empty($routes)) {
			$write_routes = array();

			$this->db->truncate('uri_routes');
			$priority = 1;
			foreach ($routes as $key => $value) {
				if ( ! empty($value['uri_route']) AND ! empty($value['controller'])) {
					$write_routes[$priority] = $value;

					$this->db->set('uri_route', $value['uri_route']);
					$this->db->set('controller', $value['controller']);
					$this->db->set('priority', $priority);

					$this->db->insert('uri_routes');
					$priority ++;
				}
			}

//			$this->writeRoutesFile($write_routes);

			if ($this->db->affected_rows() > 0) {
				return TRUE;
			}
		}
	}

	public function writeRoutesFile($write_routes = array()) {

		$filepath = IGNITEPATH . 'config/routes.php';
		$line = '';

		if ($fp = @fopen($filepath, FOPEN_READ_WRITE_CREATE_DESTRUCTIVE)) {

			$line .= "<" . "?php  if ( ! defined('BASEPATH')) exit('No direct access allowed');\n\n";

			$line .= "$" . "route['default_controller'] = 'home';\n";
			$line .= "$" . "route[\"^(\".implode('|', array('home', 'menus', 'reserve', 'contact', 'checkout', 'maintenance', 'local', 'pages')).\")?$\"] = '$1';\n";
			$line .= "$" . "route[\"^(\".implode('|', array('home', 'menus', 'reserve', 'contact', 'checkout', 'maintenance', 'local', 'pages')).\")?/(:any)$\"] = '$1';\n";
			$line .= "$" . "route[\"^(\".implode('|', array('home', 'menus', 'reserve', 'contact', 'checkout', 'maintenance', 'local', 'pages')).\")?/(:any)$\"] = '$1/$2';\n";

			if ( ! empty($write_routes) AND is_array($write_routes)) {
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

	public function saveLayout($layout_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['name'])) {
			$this->db->set('name', $save['name']);
		}

		if (is_numeric($layout_id)) {
			$this->db->where('layout_id', $layout_id);
			$query = $this->db->update('layouts');
		} else {
			$query = $this->db->insert('layouts');
			$layout_id = $this->db->insert_id();
		}

		if ($query === TRUE AND is_numeric($layout_id)) {
			$routes = ( isset($save['routes'])) ? $save['routes'] : array();
			$this->addLayoutRoutes($layout_id, $routes);

			$modules = ( isset($save['modules'])) ? $save['modules'] : array();
			$this->addLayoutModules($layout_id, $modules);

			return $layout_id;
		}
	}

	private function addLayoutRoutes($layout_id, $routes = array()) {
		$query = FALSE;
		$this->db->where('layout_id', $layout_id);
		$this->db->delete('layout_routes');

		if (is_array($routes)) {
			foreach ($routes as $route) {
				if ( ! empty($route['uri_route'])) {
					$this->db->set('layout_id', $layout_id);
					$this->db->set('uri_route', $route['uri_route']);
					$query = $this->db->insert('layout_routes');
				}
			}
		}

		return $query;
	}

	private function addLayoutModules($layout_id, $partial_modules = array()) {
		$query = FALSE;
		$this->db->where('layout_id', $layout_id);
		$this->db->delete('layout_modules');

		if (is_array($partial_modules)) {
			foreach ($partial_modules as $partial => $modules) {
				$priority = 1;
				foreach ($modules as $module) {
					if ( ! empty($module) AND is_array($module)) {
						$this->db->set('layout_id', $layout_id);
						$this->db->set('module_code', $module['module_code']);
						$this->db->set('partial', $module['partial']);
						$this->db->set('priority', $priority);

						$options = array();
						$options['title'] = isset($module['title']) ? htmlspecialchars($module['title']) : '';
						$options['fixed'] = isset($module['fixed']) ? $module['fixed'] : '';
						$options['fixed_top_offset'] = isset($module['fixed_top_offset']) ? $module['fixed_top_offset'] : '';
						$options['fixed_bottom_offset'] = isset($module['fixed_bottom_offset']) ? $module['fixed_bottom_offset'] : '';

						$this->db->set('options', serialize($options));

						$this->db->set('status', $module['status']);
						$query = $this->db->insert('layout_modules');

						$priority++;
					}
				}
			}

			return $query;
		}

		return $query;
	}

	public function deleteLayout($layout_id) {
		if (is_numeric($layout_id)) $layout_id = array($layout_id);

		if ( ! empty($layout_id) AND ctype_digit(implode('', $layout_id))) {
			$this->db->where_in('layout_id', $layout_id);
			$this->db->delete('layouts');

			if (($affected_rows = $this->db->affected_rows()) > 0) {
				$this->db->where_in('layout_id', $layout_id);
				$this->db->delete('layout_routes');

				$this->db->where_in('layout_id', $layout_id);
				$this->db->delete('layout_modules');

				return $affected_rows;
			}
		}
	}
}

/* End of file layouts_model.php */
/* Location: ./system/tastyigniter/models/layouts_model.php */