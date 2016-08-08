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
 * Reviews Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Reviews_model.php
 * @link           http://docs.tastyigniter.com
 */
class Reviews_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'reviews';

	/**
	 * @var string The database table primary key
	 */
	protected $primary_key = 'review_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	protected $timestamps = array('created');

	protected $belongs_to = array(
		'locations' => 'Locations_model',
	);

	/**
	 * Count the number of records
	 *
	 * @param array $filter
	 *
	 * @return int
	 */
	public function getCount($filter = array()) {
		$this->with('locations');

		return parent::getCount($filter);
	}

	/**
	 * List all reviews matching the filter
	 *
	 * @param array $filter
	 *
	 * @return array
	 */
	public function getList($filter = array()) {
		$this->with('locations');

		return parent::getList($filter);
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
			$this->like('author', $filter['filter_search']);
			$this->or_like('location_name', $filter['filter_search']);
			$this->or_like('order_id', $filter['filter_search']);
		}

		if (!empty($filter['filter_location'])) {
			$this->where('reviews.location_id', $filter['filter_location']);
		}

		if (!empty($filter['customer_id'])) {
			$this->where('customer_id', $filter['customer_id']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$this->where('review_status', $filter['filter_status']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$this->where('YEAR(date_added)', $date[0]);
			$this->where('MONTH(date_added)', $date[1]);
		}

		return $this;
	}

	/**
	 * Return all reviews by customer_id
	 *
	 * @param int $customer_id
	 *
	 * @return array
	 */
	public function getReviews($customer_id = NULL) {
		if ($customer_id !== NULL) {
			$this->where('review_status', '1');
			$this->where('customer_id', $customer_id);

			return $this->with('locations')->find_all();
		}
	}

	/**
	 * Return all reviews grouped by location_id
	 *
	 * @param int $location_id
	 *
	 * @return array
	 */
	public function getTotalsbyId($location_id = NULL) {
		$this->select('location_id, COUNT(location_id) as review_total');
		$this->group_by('location_id');
		$this->order_by('review_total');
		$this->where('review_status', '1');

		if ($location_id !== NULL) {
			$this->where('location_id', $location_id);
		}

		$result = array();
		if ($rows = $this->find_all()) {
			foreach ($rows as $row) {
				$result[$row['location_id']] = $row['review_total'];
			}
		}

		return $result;
	}

	/**
	 * Find a single review by review_id
	 *
	 * @param int    $review_id
	 * @param int    $customer_id
	 * @param string $sale_type
	 *
	 * @return array
	 */
	public function getReview($review_id, $customer_id = NULL, $sale_type = '') {
		if (!empty($review_id)) {
			if (!empty($customer_id)) {
				$this->where('customer_id', $customer_id);
			}

			if (!empty($sale_type)) {
				$this->where('sale_type', $sale_type);
			}

			return $this->with('locations')->find($review_id);
		}
	}

	/**
	 * Return the dates of all reviews
	 *
	 * @return array
	 */
	public function getReviewDates() {
		$this->select('date_added, MONTH(date_added) as month, YEAR(date_added) as year');
		$this->group_by('MONTH(date_added)');
		$this->group_by('YEAR(date_added)');

		return $this->find_all();
	}

	/**
	 * Return the total number of reviews by location_id
	 *
	 * @param int $location_id
	 *
	 * @return int
	 */
	public function getTotalLocationReviews($location_id) {
		$this->where('location_id', $location_id);
		$this->where('review_status', '1');

		return $this->count();
	}

	/**
	 * Check if review already exist for an order or reservation
	 *
	 * @param string $sale_type
	 * @param string $sale_id
	 * @param string $customer_id
	 *
	 * @return bool TRUE if already exist, or FALSE if not
	 */
	public function checkReviewed($sale_type = 'order', $sale_id = '', $customer_id = '') {
		if ($sale_type === 'reservation') {
			$this->load->model('Reservations_model');
			$check_query = $this->Reservations_model->find(array('reservation_id' => $sale_id, 'customer_id' => $customer_id));
		} else {
			$this->load->model('Orders_model');
			$check_query = $this->Orders_model->find(array('order_id' => $sale_id, 'customer_id' => $customer_id));
		}

		if (empty($check_query)) {
			return TRUE;
		}

		$this->where('customer_id', $customer_id);
		$this->where('sale_type', $sale_type);
		$this->where('sale_id', $sale_id);

		if ($this->find()) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Create a new or update existing review
	 *
	 * @param int   $review_id
	 * @param array $save
	 *
	 * @return bool|int The $review_id of the affected row, or FALSE on failure
	 */
	public function saveReview($review_id, $save = array()) {
		if (empty($save)) return FALSE;

		if (isset($save['rating'])) {
			if (isset($save['rating']['quality'])) {
				$save['quality'] = $save['rating']['quality'];
			}

			if (isset($save['rating']['delivery'])) {
				$save['delivery'] = $save['rating']['delivery'];
			}

			if (isset($save['rating']['service'])) {
				$save['service'] = $save['rating']['service'];
			}
		}

		if (APPDIR === ADMINDIR AND isset($save['review_status']) AND $save['review_status'] === '1') {
			$save['review_status'] = '1';
		} else if ($this->config->item('approve_reviews') !== '1') {
			$save['review_status'] = '1';
		} else {
			$save['review_status'] = '0';
		}

		return $this->skip_validation(TRUE)->save($save, $review_id);
	}

	/**
	 * Delete a single or multiple review by review_id
	 *
	 * @param string|array $review_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteReview($review_id) {
		if (is_numeric($review_id)) $review_id = array($review_id);

		if (!empty($review_id) AND ctype_digit(implode('', $review_id))) {
			return $this->delete('review_id', $review_id);
		}
	}
}

/* End of file Reviews_model.php */
/* Location: ./system/tastyigniter/models/Reviews_model.php */