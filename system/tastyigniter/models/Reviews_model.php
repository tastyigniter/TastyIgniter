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
 * Reviews Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Reviews_model.php
 * @link           http://docs.tastyigniter.com
 */
class Reviews_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'reviews';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'review_id';

	/**
	 * @var array The model table column to convert to dates on insert/update
	 */
	public $timestamps = TRUE;

	const CREATED_AT = 'date_added';

	public $belongsTo = [
		'locations' => 'Locations_model',
	];

	public function scopeJoinLocationsTable($query)
	{
		return $query->join('locations', 'locations.location_id', '=', 'reviews.location_id', 'left');
	}

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
		$query->joinLocationsTable();

		if (!empty($filter['filter_search'])) {
			$query->like('author', $filter['filter_search']);
			$query->orLike('location_name', $filter['filter_search']);
			$query->orLike('order_id', $filter['filter_search']);
		}

		if (!empty($filter['filter_location'])) {
			$query->where('reviews.location_id', $filter['filter_location']);
		}

		if (!empty($filter['customer_id'])) {
			$query->where('customer_id', $filter['customer_id']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$query->where('review_status', $filter['filter_status']);
		}

		if (!empty($filter['filter_date'])) {
			$date = explode('-', $filter['filter_date']);
			$query->whereRaw('YEAR(date_added)', $date[0]);
			$query->whereRaw('MONTH(date_added)', $date[1]);
		}

		return $query;
	}

	/**
	 * Return all reviews by customer_id
	 *
	 * @param int $customer_id
	 *
	 * @return array
	 */
	public function getReviews($customer_id = null)
	{
		if ($customer_id !== null) {
			return $this->joinLocationsTable()->where('review_status', '1')
						->where('customer_id', $customer_id)->getAsArray();
		}
	}

	/**
	 * Return all reviews grouped by location_id
	 *
	 * @param int $location_id
	 *
	 * @return array
	 */
	public function getTotalsbyId($location_id = null)
	{
		$query = $this->selectRaw('location_id, COUNT(location_id) as review_total')
					  ->groupBy('location_id')->orderBy('review_total')->where('review_status', '1');

		if ($location_id !== null) {
			$query->where('location_id', $location_id);
		}

		$result = [];
		if ($rows = $query->getAsArray()) {
			foreach ($rows as $row) {
				$result[$row['location_id']] = $row['review_total'];
			}
		}

		return $result;
	}

	/**
	 * Find a single review by review_id
	 *
	 * @param int $review_id
	 * @param int $customer_id
	 * @param string $sale_type
	 *
	 * @return array
	 */
	public function getReview($review_id, $customer_id = null, $sale_type = '')
	{
		if (!empty($review_id)) {
			$query = $this->query();

			if (!empty($customer_id)) {
				$query->where('customer_id', $customer_id);
			}

			if (!empty($sale_type)) {
				$query->where('sale_type', $sale_type);
			}

			return $query->where('review_id', $review_id)->firstAsArray();
		}
	}

	/**
	 * Return the dates of all reviews
	 *
	 * @return array
	 */
	public function getReviewDates()
	{
		return $this->pluckDates('date_added');
	}

	/**
	 * Return the total number of reviews by location_id
	 *
	 * @param int $location_id
	 *
	 * @return int
	 */
	public function getTotalLocationReviews($location_id)
	{
		return $this->where('location_id', $location_id)->where('review_status', '1')->count();
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
	public function checkReviewed($sale_type = 'order', $sale_id = '', $customer_id = '')
	{
		if ($sale_type === 'reservation') {
			$this->load->model('Reservations_model');
			$check_query = $this->Reservations_model->where([
				['reservation_id', '=', $sale_id],
				['customer_id', '=', $customer_id],
			])->first();
		} else {
			$this->load->model('Orders_model');
			$check_query = $this->Orders_model->where([
				['order_id', '=', $sale_id],
				['customer_id', '=', $customer_id],
			])->first();
		}

		if (empty($check_query)) {
			return TRUE;
		}

		$query = $this->where('customer_id', $customer_id)
					  ->where('sale_type', $sale_type)->where('sale_id', $sale_id);

		if ($query->first()) {
			return TRUE;
		}

		return FALSE;
	}

	/**
	 * Create a new or update existing review
	 *
	 * @param int $review_id
	 * @param array $save
	 *
	 * @return bool|int The $review_id of the affected row, or FALSE on failure
	 */
	public function saveReview($review_id, $save = [])
	{
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

		if (is_single_location()) {
			$save['location_id'] = $this->config->item('default_location_id');
		}

		if (APPDIR === ADMINDIR AND isset($save['review_status']) AND $save['review_status'] == '1') {
			$save['review_status'] = '1';
		} else if ($this->config->item('approve_reviews') != '1') {
			$save['review_status'] = '1';
		} else {
			$save['review_status'] = '0';
		}

		$reviewModel = $this->findOrNew($review_id);

		$saved = $reviewModel->fill($save)->save();

		return $saved ? $reviewModel->getKey() : $saved;
	}

	/**
	 * Delete a single or multiple review by review_id
	 *
	 * @param string|array $review_id
	 *
	 * @return int  The number of deleted rows
	 */
	public function deleteReview($review_id)
	{
		if (is_numeric($review_id)) $review_id = [$review_id];

		if (!empty($review_id) AND ctype_digit(implode('', $review_id))) {
			return $this->whereIn('review_id', $review_id)->delete();
		}
	}
}

/* End of file Reviews_model.php */
/* Location: ./system/tastyigniter/models/Reviews_model.php */