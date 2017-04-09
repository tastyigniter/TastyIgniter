<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

use Igniter\Database\Model;

/**
 * Layout routes Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Layout_routes_model.php
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