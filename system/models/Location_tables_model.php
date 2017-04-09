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
 * Location tables Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Location_tables_model.php
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