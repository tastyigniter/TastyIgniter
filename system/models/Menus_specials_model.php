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
 * Menu Specials Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Menus_specials_model.php
 * @link           http://docs.tastyigniter.com
 */
class Menus_specials_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'menus_specials';

	protected $primaryKey = 'special_id';

	protected $fillable = ['special_id', 'menu_id', 'start_date', 'end_date', 'special_price', 'special_status'];

	protected $casts = [
		'start_date' => 'date',
		'end_date'   => 'date',
	];

	public function getAttribute($key)
	{
		$value = parent::getAttribute($key);

		if (in_array($key, ['start_date', 'end_date'])) {
			$value = mdate('%d-%m-%Y', strtotime($value));
		}

		return $value;
	}

	public function setAttribute($key, $value)
	{
		if (in_array($key, ['start_date', 'end_date'])) {
			$value = mdate('%Y-%m-%d', strtotime($value));
		}

		return parent::setAttribute($key, $value);
	}
}

/* End of file Menus_specials_model.php */
/* Location: ./system/tastyigniter/models/Menus_specials_model.php */