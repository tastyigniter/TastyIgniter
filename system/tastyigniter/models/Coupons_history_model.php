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
 * Coupons History Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Coupons_history_model.php
 * @link           http://docs.tastyigniter.com
 */
class Coupons_history_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'coupons_history';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'coupon_history_id';
}

/* End of file Coupons_history_model.php */
/* Location: ./system/tastyigniter/models/Coupons_history_model.php */