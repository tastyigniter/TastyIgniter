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
 * Location tables Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Location_tables_model.php
 * @link           http://docs.tastyigniter.com
 */
class Location_tables_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'location_tables';

	protected $belongs_to = array(
		'tables' => array('Tables_model')
	);
}

/* End of file Location_tables_model.php */
/* Location: ./system/tastyigniter/models/Location_tables_model.php */