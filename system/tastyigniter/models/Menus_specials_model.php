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
 * Menu Specials Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Menus_specials_model.php
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