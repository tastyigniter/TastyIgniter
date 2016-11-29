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
 * Location tables Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Location_tables_model.php
 * @link           http://docs.tastyigniter.com
 */
class Location_tables_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'location_tables';

//	protected $primaryKey = ['location_id', 'table_id'];

	public $belongsTo = [
		'tables' => ['Tables_model'],
	];
}

/* End of file Location_tables_model.php */
/* Location: ./system/tastyigniter/models/Location_tables_model.php */