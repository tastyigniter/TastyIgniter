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
 * Coupons Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Coupons_model.php
 * @link           http://docs.tastyigniter.com
 */
class Coupons_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'coupons';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'coupon_id';

	public $timestamps = TRUE;

	const CREATED_AT = 'date_added';

	/**
	 * Filter database records
	 *
	 * @param $query
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function scopeFilter($query, $filter = [])
	{
		if (!empty($filter['filter_search'])) {
			$query->search($filter['filter_search'], ['name', 'code']);
		}

		if (!empty($filter['filter_type'])) {
			$query->where('type', $filter['filter_type']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$query->where('status', $filter['filter_status']);
		}

		return $query;
	}

	public function getAttribute($key)
	{
		$value = parent::getAttribute($key);

		if (in_array($key, ['fixed_date', 'period_start_date', 'period_end_date'])) {
			$value = mdate('%d-%m-%Y', strtotime($value));
		}

		if (in_array($key, ['fixed_from_time', 'recurring_from_time'])) {
			$value = mdate('%h:%i %a', strtotime((empty($value) ? '12:00 AM' : $value)));
		}

		if (in_array($key, ['fixed_to_time', 'recurring_to_time'])) {
			$value = mdate('%h:%i %a', strtotime((empty($value) ? '11:59 PM' : $value)));
		}

		return $value;
	}

	public function setAttribute($key, $value)
	{
		if (in_array($key, ['fixed_date', 'period_start_date', 'period_end_date'])) {
			$value = mdate('%Y-%m-%d', strtotime($value));
		}

		if (in_array($key, ['fixed_from_time', 'recurring_from_time'])) {
			$value = mdate('%H:%i', strtotime((empty($value) ? '12:00 AM' : $value)));
		}

		if (in_array($key, ['fixed_to_time', 'recurring_to_time'])) {
			$value = mdate('%H:%i', strtotime((empty($value) ? '11:59 PM' : $value)));
		}

		return parent::setAttribute($key, $value);
	}

	public function getRecurringEveryAttribute($value)
	{
		return (empty($value)) ? [] : explode(', ', $value);
	}

	public function setRecurringEveryAttribute($value)
	{
		return (empty($value)) ? [] : implode(', ', $value);
	}

	/**
	 * Return all coupons
	 *
	 * @return array
	 */
	public function getCoupons()
	{
		return $this->getAsArray();
	}

	/**
	 * Find a single coupon by coupon_id
	 *
	 * @param int $coupon_id
	 *
	 * @return array
	 */
	public function getCoupon($coupon_id)
	{
		return $this->findOrNew($coupon_id)->toArray();
	}

	/**
	 * Find a single coupon by coupon code
	 *
	 * @param string $code
	 *
	 * @return array
	 */
	public function getCouponByCode($code)
	{
		return $this->firstOrNew(['code' => $code])->toArray();
	}

	/**
	 * Return all coupon history by coupon_id
	 *
	 * @return array
	 */
	public function getCouponHistories()
	{
		$couponHistoryTable = $this->tablePrefix('coupons_history');

		$this->load->model('Coupons_history_model');
		$couponHistoryModel = $this->Coupons_history_model->join('orders', 'orders.order_id', '=', 'coupons_history.order_id', 'left');
		$couponHistoryModel->selectRaw("*, COUNT({$couponHistoryTable}.customer_id) as total_redemption, SUM(amount) as total_amount, ".
			"MAX({$couponHistoryTable}.date_used) as date_last_used");
		$couponHistoryModel->groupBy('customers.customer_id');
		$couponHistoryModel->join('customers', 'customers.customer_id', '=', 'coupons_history.customer_id', 'left');
		$couponHistoryModel->where('coupon_id', $this->getKey());

		return $couponHistoryModel->orderBy('date_used', 'DESC')->getAsArray();
	}

	/**
	 * Redeem coupon by order_id
	 *
	 * @param int $order_id
	 *
	 * @return bool TRUE on success, or FALSE on failure
	 */
	public function redeemCoupon($order_id)
	{
		$this->load->model('Coupons_history_model');
		$couponModel = $this->Coupons_history_model->where([['status', '!=', '1'], ['order_id', '=', $order_id]])->first();
		if ($couponModel) {
			return $couponModel->touchStatus();
		}
	}

	/**
	 * Create a new or update existing coupon
	 *
	 * @param int $coupon_id
	 * @param array $save
	 *
	 * @return bool|int The $coupon_id of the affected row, or FALSE on failure
	 */
	public function saveCoupon($coupon_id, $save = [])
	{
		if (empty($save)) return FALSE;

		if (!empty($save['validity']) AND !empty($save['validity_times'])) {

			$save = array_merge($save, $save['validity_times']);
			unset($save['validity_times'], $save['fixed_time'], $save['recurring_time']);
		}

		$couponModel = $this->findOrNew($coupon_id);

		$saved = $couponModel->fill($save)->save();

		return $saved ? $couponModel->getKey() : $saved;
	}

	/**
	 * Delete a single or multiple coupon by coupon_id
	 *
	 * @param string|array $coupon_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteCoupon($coupon_id)
	{
		if (is_numeric($coupon_id)) $coupon_id = [$coupon_id];

		if (!empty($coupon_id) AND ctype_digit(implode('', $coupon_id))) {
			return $this->whereIn('coupon_id', $coupon_id)->delete();
		}
	}
}

/* End of file Coupons_model.php */
/* Location: ./system/tastyigniter/models/Coupons_model.php */