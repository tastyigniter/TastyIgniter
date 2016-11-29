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
defined('BASEPATH') or exit('No direct script access allowed');

use TastyIgniter\Database\Model;

/**
 * Layouts Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Layouts_model.php
 * @link           http://docs.tastyigniter.com
 */
class Layouts_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'layouts';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'layout_id';

	/**
	 * Return all layouts
	 *
	 * @return array
	 */
	public function getLayouts()
	{
		return $this->getAsArray();
	}

	/**
	 * Return all layout routes
	 *
	 * @return array
	 */
	public function getRoutes()
	{
		return $this->orderBy('priority')->from('uri_routes')->getAsArray();
	}

	/**
	 * Find a single layout by layout_id
	 *
	 * @param int $layout_id
	 *
	 * @return mixed
	 */
	public function getLayout($layout_id)
	{
		return $this->findOrNew($layout_id)->toArray();
	}

	/**
	 * Return all layout modules
	 *
	 * @param int $layout_id
	 *
	 * @return array
	 * @TODO    use relationship
	 */
	public function getLayoutModules($layout_id)
	{
		$this->load->model('Layout_modules_model');

		$result = [];
		if ($modules = $this->Layout_modules_model->where('layout_id', $layout_id)->getAsArray()) {
			foreach ($modules as $row) {
				$row = $this->getModuleOptionsArray($row);

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
	 * @TODO    use relationship
	 */
	public function getModuleLayouts($module_code)
	{
		$this->load->model('Layout_modules_model');
		$layouts = $this->Layout_modules_model->join('layouts', 'layouts.layout_id', '=', 'layout_modules.layout_id', 'left')
											  ->orderBy('priority')->where('module_code', $module_code)->getAsArray();

		$result = [];
		if ($layouts) {
			foreach ($layouts as $row) {
				$row = $this->getModuleOptionsArray($row);

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
	 * @TODO    use relationship
	 */
	public function getRouteLayoutModules($uri_route)
	{
		$result = [];
		$this->load->model('Layout_routes_model');

		if (!empty($uri_route)) {
			foreach (array_unique($uri_route) as $route) {
				$query = $this->Layout_routes_model->groupBy('layout_module_id');
				$query->select('layout_modules.layout_id', 'layout_module_id', 'module_code', 'uri_route', 'partial', 'priority', 'layout_modules.options', 'layout_modules.status');
				$query->leftJoin('layout_modules', 'layout_modules.layout_id', '=', 'layout_routes.layout_id');
				$query->leftJoin('pages', 'pages.layout_id', '=', 'layout_routes.layout_id');

				if (is_numeric($route)) {
					$query->orWhere('pages.page_id', $route);
				} else {
					$query->orWhere('layout_routes.uri_route', $route);
				}

				if ($rows = $query->getAsArray()) {
					foreach ($rows as $row) {
						$row = $this->getModuleOptionsArray($row);

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
	 * @TODO    use relationship
	 */
	public function getLayoutRoutes($layout_id)
	{
		$this->load->model('Layout_routes_model');

		return $this->Layout_routes_model->where('layout_id', $layout_id)->getAsArray();
	}

	/**
	 * Find a single layout by uri route
	 *
	 * @param string $uri_route
	 *
	 * @return null
	 */
	public function getRouteLayoutId($uri_route = '')
	{
		$layout_id = null;

		if ($uri_route !== '') {
			$this->load->model('Layout_routes_model');
			if ($row = $this->Layout_routes_model->where('uri_route', $uri_route)->first()) {
				$layout_id = $row->layout_id;
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
	 * @TODO    use relationship
	 */
	public function getPageLayoutId($page_id = '')
	{
		$layout_id = null;

		if ($page_id !== '') {
			$this->load->model('Pages_model');

			if ($row = $this->Pages_model->find($page_id)) {
				$layout_id = $row->layout_id;
			}
		}

		return $layout_id;
	}

	/**
	 * @param $row
	 *
	 * @return mixed
	 */
	protected function getModuleOptionsArray($row = [])
	{
		$options = $row['options'];
		$row['title'] = isset($options['title']) ? htmlspecialchars_decode($options['title']) : '';
		$row['fixed'] = isset($options['fixed']) ? $options['fixed'] : '';
		$row['fixed_top_offset'] = isset($options['fixed_top_offset']) ? $options['fixed_top_offset'] : '';
		$row['fixed_bottom_offset'] = isset($options['fixed_bottom_offset']) ? $options['fixed_bottom_offset'] : '';

		return $row;
	}

	/**
	 * Update existing routes
	 *
	 * @deprecated since 2.2.0
	 *
	 * @param array $routes
	 *
	 * @return bool TRUE on success
	 */
	public function updateRoutes($routes = [])
	{
		if (!empty($routes)) {
			$write_routes = [];

			$this->queryBuilder()->table('uri_routes')->truncate();
			$priority = 1;
			foreach ($routes as $key => $value) {
				if (!empty($value['uri_route']) AND !empty($value['controller'])) {
					$write_routes[$priority] = $value;

					$this->queryBuilder()->table('uri_routes')->insert([
						'uri_route'  => $value['uri_route'],
						'controller' => $value['controller'],
						'priority'   => $priority,
					]);

					$priority++;
				}
			}

			return TRUE;
		}
	}

	/**
	 * Write routes into system routes file
	 *
	 * @deprecated since 2.2.0
	 *
	 * @param array $write_routes
	 */
	public function writeRoutesFile($write_routes = [])
	{

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
	public function saveLayout($layout_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$routes = (isset($save['routes'])) ? $save['routes'] : [];
		$components = (isset($save['components'])) ? $save['components'] : [];
		unset($save['routes'], $save['components']);

		$layoutModel = $this->findOrNew($layout_id);

		if ($saved = $layoutModel->fill($save)->save()) {
			$this->addLayoutRoutes($layout_id, $routes);

			$this->addLayoutModules($layout_id, $components);

			return $layout_id;
		}
	}

	/**
	 * Create a new or update existing layout routes
	 *
	 * @param int $layout_id
	 * @param array $routes
	 *
	 * @return bool|int
	 * @TODO    use relationship
	 */
	protected function addLayoutRoutes($layout_id, $routes = [])
	{
		$query = FALSE;
		$this->load->model('Layout_routes_model');
		$this->Layout_routes_model->where('layout_id', $layout_id)->delete();

		return $this->Layout_routes_model->createLayoutRoutes($layout_id, $routes);
	}

	/**
	 * Create a new or update existing layout modules
	 *
	 * @param int $layout_id
	 * @param array $partial_modules
	 *
	 * @return bool|int
	 * @TODO    use relationship
	 */
	protected function addLayoutModules($layout_id, $partial_modules = [])
	{
		$query = FALSE;
		$this->load->model('Layout_modules_model');
		$this->Layout_modules_model->where('layout_id', $layout_id)->delete();

		if (is_array($partial_modules)) {
			foreach ($partial_modules as $partial => $modules) {
				$query = $this->Layout_modules_model->createLayoutModules($layout_id, $modules);
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
	 * @TODO    use relationship
	 */
	public function deleteLayout($layout_id)
	{
		if (is_numeric($layout_id)) $layout_id = [$layout_id];

		if (!empty($layout_id) AND ctype_digit(implode('', $layout_id))) {
			$affected_rows = $this->whereIn('layout_id', $layout_id)->delete();

			if ($affected_rows > 0) {
				$this->load->model('Layout_routes_model');
				$this->Layout_routes_model->whereIn('layout_id', $layout_id)->delete();

				$this->load->model('Layout_modules_model');
				$this->Layout_modules_model->whereIn('layout_id', $layout_id)->delete();

				return $affected_rows;
			}
		}
	}
}

/* End of file Layouts_model.php */
/* Location: ./system/tastyigniter/models/Layouts_model.php */