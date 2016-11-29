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
 * Coupons History Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Coupons_history_model.php
 * @link           http://docs.tastyigniter.com
 */
class Coupons_history_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'coupons_history';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'coupon_history_id';

	public $belongsTo = [
		'customer' => 'Customers_model',
		'order'    => 'Orders_model',
	];

	public function order()
	{
		$this->belongsTo('Orders_model');
	}

	public function touchStatus()
	{
		$this->status = ($this->status < 1) ? 1 : 0;

		return $this->save();
	}
}

/* End of file Coupons_history_model.php */
/* Location: ./system/tastyigniter/models/Coupons_history_model.php */