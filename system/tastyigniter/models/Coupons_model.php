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
 * @since     File available since Release 1.0
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Coupons Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Coupons_model.php
 * @link           http://docs.tastyigniter.com
 */
class Coupons_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'coupons';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'coupon_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	protected $timestamps = array('created');

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		return $this->filter($filter)->count();
	}

	/**
	 * List all coupons matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		return $this->filter($filter)->find_all();
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function filter($filter = array()) {
		if (!empty($filter['filter_search'])) {
			$this->like('name', $filter['filter_search']);
			$this->or_like('code', $filter['filter_search']);
		}

		if (!empty($filter['filter_type'])) {
			$this->where('type', $filter['filter_type']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->where('status', $filter['filter_status']);
		}

		return $this;
	}

	/**
	 * Return all coupons
	 *
	 * @return array
	 */
	public function getCoupons() {
		return $this->find_all();
	}

	/**
	 * Find a single coupon by coupon_id
	 *
	 * @param int $coupon_id
	 *
	 * @return array
	 */
	public function getCoupon($coupon_id) {
		return $this->find($coupon_id);
	}

	/**
	 * Find a single coupon by coupon code
	 *
	 * @param string $code
	 *
	 * @return array
	 */
	public function getCouponByCode($code) {
		return $this->find(array('code' => $code));
	}

	/**
	 * Return all coupon history by coupon_id
	 *
	 * @param int $coupon_id
	 *
	 * @return array
	 */
	public function getCouponHistories($coupon_id) {
		$this->load->model('Coupons_history_model');
		$this->Coupons_history_model->join('orders', 'orders.order_id = coupons_history.order_id', 'left');
		$this->Coupons_history_model->where('coupons_history.coupon_id', $coupon_id);

		//$this->Coupons_history_model->group_by('coupons_history.customer_id');

		return $this->Coupons_history_model->order_by('coupons_history.date_used', 'DESC')->find_all();
	}

	/**
	 * Redeem coupon by order_id
	 *
	 * @param int $order_id
	 *
	 * @return bool TRUE on success, or FALSE on failure
	 */
	public function redeemCoupon($order_id) {
		$this->load->model('Coupons_history_model');
		if ($this->Coupons_history_model->find(array('order_id' => $order_id, 'status !=' => '1'))) {
			return $this->Coupons_history_model->update(array('order_id' => $order_id), array('status' => '1'));
		}
	}

	/**
	 * Create a new or update existing coupon
	 *
	 * @param int   $coupon_id
	 * @param array $save
	 *
	 * @return bool|int The $coupon_id of the affected row, or FALSE on failure
	 */
	public function saveCoupon($coupon_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (!empty($save['validity']) AND !empty($save['validity_times'])) {

			if ($save['validity'] == 'fixed') {
				if (isset($save['validity_times']['fixed_date'])) {
					$save['fixed_date'] = mdate('%Y-%m-%d', strtotime($save['validity_times']['fixed_date']));
				}

				$save['fixed_from_time'] = mdate('%H:%i', strtotime('12:00 AM'));
				if (isset($save['validity_times']['fixed_from_time'])) {
					$save['fixed_from_time'] = mdate('%H:%i', strtotime($save['validity_times']['fixed_from_time']));
				}

				$save['fixed_to_time'] = mdate('%H:%i', strtotime('11:59 PM'));
				if (isset($save['validity_times']['fixed_to_time'])) {
					$save['fixed_to_time'] = mdate('%H:%i', strtotime($save['validity_times']['fixed_to_time']));
				}
			} else if ($save['validity'] == 'period') {
				if (isset($save['validity_times']['period_start_date'])) {
					$save['period_start_date'] = mdate('%Y-%m-%d', strtotime($save['validity_times']['period_start_date']));
				}

				if (isset($save['validity_times']['period_end_date'])) {
					$save['period_end_date'] = mdate('%Y-%m-%d', strtotime($save['validity_times']['period_end_date']));
				}
			} else if ($save['validity'] == 'recurring') {
				if (isset($save['validity_times']['recurring_every'])) {
					$save['recurring_every'] = implode(', ', $save['validity_times']['recurring_every']);
				}

				$save['recurring_from_time'] = mdate('%H:%i', strtotime('12:00 AM'));
				if (isset($save['validity_times']['recurring_from_time'])) {
					$save['recurring_from_time'] = mdate('%H:%i', strtotime($save['validity_times']['recurring_from_time']));
				}

				$save['recurring_to_time'] = mdate('%H:%i', strtotime('11:59 PM'));
				if (isset($save['validity_times']['recurring_to_time'])) {
					$save['recurring_to_time'] = mdate('%H:%i', strtotime($save['validity_times']['recurring_to_time']));
				}
			}
		}

		return $this->skip_validation(TRUE)->save($save, $coupon_id);
	}

	/**
	 * Delete a single or multiple coupon by coupon_id
	 *
	 * @param string|array $coupon_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteCoupon($coupon_id) {
		if (is_numeric($coupon_id)) $coupon_id = array($coupon_id);

		if (!empty($coupon_id) AND ctype_digit(implode('', $coupon_id))) {
			return $this->delete('coupon_id', $coupon_id);
		}
	}
}

/* End of file Coupons_model.php */
/* Location: ./system/tastyigniter/models/Coupons_model.php */