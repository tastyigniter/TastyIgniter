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
 * @since     File available since Release 2.2
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Layout routes Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Layout_routes_model.php
 * @link           http://docs.tastyigniter.com
 */
class Layout_routes_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'layout_routes';

	protected $primary_key = 'layout_route_id';
}

/* End of file Layout_routes_model.php */
/* Location: ./system/tastyigniter/models/Layout_routes_model.php */