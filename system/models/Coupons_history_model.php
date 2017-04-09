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
 * Coupons History Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Coupons_history_model.php
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

	public $timestamps = TRUE;

	const CREATED_AT = 'date_used';

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