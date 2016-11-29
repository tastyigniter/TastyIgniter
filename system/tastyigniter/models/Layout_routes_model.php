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
 * Layout routes Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Layout_routes_model.php
 * @link           http://docs.tastyigniter.com
 */
class Layout_routes_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'layout_routes';

	protected $primaryKey = 'layout_route_id';

	public function createLayoutRoutes($layout_id, $routes = [])
	{
		if (is_array($routes)) {
			foreach ($routes as $route) {
				if (!empty($route['uri_route'])) {
					$query = $this->Layout_routes_model->create([
						'layout_id' => $layout_id,
						'uri_route' => $route['uri_route'],
					]);
				}
			}
		}

		return $query;
	}
}

/* End of file Layout_routes_model.php */
/* Location: ./system/tastyigniter/models/Layout_routes_model.php */