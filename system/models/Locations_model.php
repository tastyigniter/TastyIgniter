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
 * Locations Model Class
 *
 * @category       Models
 * @package        Igniter\Models\Locations_model.php
 * @link           http://docs.tastyigniter.com
 */
class Locations_model extends Model
{
	/**
	 * @var string The database table name
	 */
	protected $table = 'locations';

	/**
	 * @var string The database table primary key
	 */
	protected $primaryKey = 'location_id';

	public $fillable = ['location_id', 'location_name', 'location_email', 'description', 'location_address_1',
		'location_address_2', 'location_city', 'location_state', 'location_postcode', 'location_country_id', 'location_telephone',
		'location_lat', 'location_lng', 'location_radius', 'offer_delivery', 'offer_collection', 'delivery_time',
		'last_order_time', 'reservation_time_interval', 'reservation_stay_time', 'location_status', 'collection_time',
		'options', 'location_image'];

	public $hasMany = [
		'working_hours' => ['Working_hours_model'],
	];

	public $belongsTo = [
		'country' => ['Countries_model', 'country_id', 'location_country_id'],
	];

	protected $casts = [
		'options' => 'serialize',
	];

	public function scopeJoinCountryTable($query)
	{
		return $query->join('countries', 'countries.country_id', '=', 'locations.location_country_id', 'left');
	}

	/**
	 * Scope a query to only include enabled location
	 *
	 * @return $this
	 */
	public function scopeIsEnabled($query)
	{
		return $query->where('location_status', '1');
	}

	/**
	 * Filter database records
	 *
	 * @param array $filter an associative array of field/value pairs
	 *
	 * @return $this
	 */
	public function scopeFilter($query, $filter = [])
	{
		if (!empty($filter['filter_search'])) {
			$query->search($filter['filter_search'], ['location_name', 'location_city', 'location_state', 'location_postcode']);
		}

		if (isset($filter['filter_status']) AND is_numeric($filter['filter_status'])) {
			$query->where('location_status', $filter['filter_status']);
		}

		return $query;
	}

	/**
	 * Return all enabled locations
	 *
	 * @return array
	 */
	public function getLocations()
	{
		return $this->where('location_status', '1')->getAsArray();
	}

	/**
	 * Find a single location by location_id
	 *
	 * @param $location_id
	 *
	 * @return mixed
	 */
	public function getLocation($location_id)
	{
		if (is_numeric($location_id)) {
			return $this->joinCountryTable()->findOrNew($location_id)->toArray();
		}
	}

	/**
	 * Return all location working hours by location id
	 *
	 * @param int $location_id
	 *
	 * @return array
	 */
	public function getWorkingHours($location_id = null)
	{
		$this->load->model('Working_hours_model');
		$workingHoursModel = $this->Working_hours_model->query();

		if ($location_id !== null) {
			$workingHoursModel->where('location_id', $location_id);
		}

		return $workingHoursModel->getAsArray();
	}

	/**
	 * Find a single location address by location id
	 *
	 * @param int $location_id
	 *
	 * @return array
	 */
	public function getAddress($location_id)
	{
		$address_data = [];

		if ($location_id !== 0) {
			if ($locationModel = $this->joinCountryTable()->find($location_id)) {
				$row = $locationModel->toArray();
				$address_data = [
					'location_id'   => $row['location_id'],
					'location_name' => $row['location_name'],
					'address_1'     => $row['location_address_1'],
					'address_2'     => $row['location_address_2'],
					'city'          => $row['location_city'],
					'state'         => $row['location_state'],
					'postcode'      => $row['location_postcode'],
					'country_id'    => $row['location_country_id'],
					'country'       => $row['country_name'],
					'iso_code_2'    => $row['iso_code_2'],
					'iso_code_3'    => $row['iso_code_3'],
					'location_lat'  => $row['location_lat'],
					'location_lng'  => $row['location_lng'],
					'format'        => $row['format'],
				];
			}
		}

		return $address_data;
	}

	/**
	 * Find a location working hour by day of the week
	 *
	 * @param int $location_id
	 * @param string $day
	 *
	 * @return array
	 */
	public function getOpeningHourByDay($location_id = null, $day = null)
	{
		$weekdays = ['Monday' => 0, 'Tuesday' => 1, 'Wednesday' => 2, 'Thursday' => 3, 'Friday' => 4, 'Saturday' => 5, 'Sunday' => 6];
		$day = (!isset($weekdays[$day])) ? date('l', strtotime($day)) : $day;
		$hour = ['open' => '00:00:00', 'close' => '00:00:00', 'status' => '0'];

		$this->load->model('Working_hours_model');
		$working_hours = $this->Working_hours_model->where('location_id', $location_id)
												   ->where('weekday', $weekdays[$day])->firstAsArray();

		if ($working_hours) {
			$hour['open'] = $row['opening_time'];
			$hour['close'] = $row['closing_time'];
			$hour['status'] = $row['status'];
		}

		return $hour;
	}

	/**
	 * Return all locations by table
	 *
	 * @param int $table_id
	 *
	 * @return array
	 */
	public function getLocationsByTable($table_id = null)
	{
		$table_locations = [];
		$this->load->model('Location_tables_model');
		$locations = $this->Location_tables_model->where('table_id', $table_id)->getAsArray();
		foreach ($locations as $row) {
			$table_locations[] = $row['location_id'];
		}

		return $table_locations;
	}

	/**
	 * Find the nearest location to latitude and longitude
	 *
	 * @deprecated since 2.0.0
	 *
	 * @param string $lat
	 * @param string $lng
	 * @param string $search_query
	 *
	 * @return array|bool an array of the nearest location, or FALSE on failure
	 */
	public function getLocalRestaurant($lat = null, $lng = null, $search_query = null)
	{
		if ($this->config->item('distance_unit') === 'km') {
			$sql = "SELECT *, ( 6371 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) *";
		} else {
			$sql = "SELECT *, ( 3959 * acos( cos( radians(?) ) * cos( radians( location_lat ) ) *";
		}

		$sql .= "cos( radians( location_lng ) - radians(?) ) + sin( radians(?) ) *";
		$sql .= "sin( radians( location_lat ) ) ) ) AS distance ";
		$sql .= "FROM {$this->tablePrefix('locations')} WHERE location_status = 1 ";
		$sql .= "ORDER BY distance LIMIT 0 , 20";

		if (!empty($lat) && !empty($lng)) {
			$query = $this->query($sql, [$lat, $lng, $lat]);
		}

		if ($query->num_rows() > 0) {
			$result = $query->first_row('array');

			if (!empty($result['location_radius'])) {
				$search_radius = $result['location_radius'];
			} else {
				$search_radius = (int)$this->config->item('search_radius');
			}

			if ($result['distance'] <= $search_radius) {
				return [
					'location_id'   => $result['location_id'],
					'location_name' => $result['location_name'],
					'distance'      => $result['distance'],
					'search_query'  => $search_query,
				];
			}
		}

		return FALSE;
	}

	/**
	 * Update the default location
	 *
	 * @param array $address
	 *
	 * @return bool|int
	 */
	public function updateDefault($address = [])
	{
		$query = FALSE;

		if (empty($address) AND !is_array($address)) return $query;

		if (isset($address['address_1'])) {
			$update['location_address_1'] = $address['address_1'];
		}

		if (isset($address['address_2'])) {
			$update['location_address_2'] = $address['address_2'];
		}

		if (isset($address['city'])) {
			$update['location_city'] = $address['city'];
		}

		if (isset($address['state'])) {
			$update['location_state'] = $address['state'];
		}

		if (isset($address['postcode'])) {
			$update['location_postcode'] = $address['postcode'];
		}

		if (isset($address['country_id'])) {
			$update['location_country_id'] = $address['country_id'];
		}

		if (isset($address['location_lat'])) {
			$update['location_lat'] = $address['location_lat'];
		}

		if (isset($address['location_lng'])) {
			$update['location_lng'] = $address['location_lng'];
		}

		$update['location_status'] = '1';

		if (isset($address['location_id']) AND is_numeric($address['location_id'])) {
			$location_id = (int)$address['location_id'];
		} else {
			$location_id = $this->config->item('default_location_id');
		}

		$locationModel = $this->findOrNew($location_id);

		$saved = $locationModel->fill($update)->save();

		if ($saved AND $default_address = $this->getAddress($locationModel->getKey())) {
			$this->Settings_model->addSetting('prefs', 'main_address', $default_address, '1');
			$this->Settings_model->addSetting('prefs', 'default_location_id', $locationModel->getKey(), '0');

			if (is_single_location()) {
				$this->where('location_id', '!=', $locationModel->getKey())->update(['location_status' => '0']);
			}
		}

		return $saved ? $locationModel->getKey() : $saved;
	}

	/**
	 * Create a new or update existing location
	 *
	 * @param int $location_id
	 * @param array $save
	 *
	 * @return bool|int
	 */
	public function saveLocation($location_id, $save = [])
	{
		if (empty($save)) return FALSE;

		$save = $this->postData($save);

		$locationModel = $this->findOrNew($location_id);

		if ($saved = $locationModel->fill($save)->save()) {
			$location_id = $locationModel->getKey();

			if ($location_id == $this->config->item('default_location_id')) {
				$this->Settings_model->addSetting('prefs', 'main_address', $this->getAddress($location_id), '1');
			}

			if (is_single_location()) {
				$this->where('location_id', '!=', $location_id)->update(['location_status' => '0']);
			}

			if (!empty($save['options']['opening_hours'])) {
				$this->addOpeningHours($location_id, $save['options']['opening_hours']);
			}

			if (isset($save['menus_select_type']) AND $save['menus_select_type'] == '1') {
				$this->load->model('Menus_model');
				 $menusCollection = $this->Menus_model->lists('menu_id');
				 $save['menus'] = $menusCollection->toArray();
			}

			$this->addLocationMenus($location_id, isset($save['menus']) ? $save['menus'] : []);

			if (isset($save['tables_select_type']) AND $save['tables_select_type'] == '1') {
				$this->load->model('Tables_model');
				$tablesCollection = $this->Tables_model->lists('table_id');
				$save['tables'] = $tablesCollection->toArray();
			}

			$this->addLocationTables($location_id, isset($save['tables']) ? $save['tables'] : []);

			if (!empty($save['permalink']) AND !is_single_location()) {
				$this->permalink->savePermalink('local', $save['permalink'], 'location_id=' . $location_id);
			}

			return $location_id;
		}
	}

	/**
	 * Create a new or update existing location working hours
	 *
	 * @param int $location_id
	 * @param array $data
	 *
	 * @return bool
	 */
	public function addOpeningHours($location_id, $data = [])
	{
		$this->load->model('Working_hours_model');
		$this->Working_hours_model->where('location_id', $location_id)->delete();

		$hours = [];

		if (!empty($data['opening_type'])) {
			if ($data['opening_type'] === '24_7') {
				for ($day = 0; $day <= 6; $day++) {
					$hours['opening'][] = ['day' => $day, 'open' => '00:00', 'close' => '23:59', 'status' => '1'];
				}
			} else if ($data['opening_type'] === 'daily') {
				for ($day = 0; $day <= 6; $day++) {
					if (!empty($data['daily_days']) AND in_array($day, $data['daily_days'])) {
						$hours['opening'][] = ['day' => $day, 'open' => $data['daily_hours']['open'], 'close' => $data['daily_hours']['close'], 'status' => '1'];
					} else {
						$hours['opening'][] = ['day' => $day, 'open' => $data['daily_hours']['open'], 'close' => $data['daily_hours']['close'], 'status' => '0'];
					}
				}
			} else if ($data['opening_type'] === 'flexible' AND !empty($data['flexible_hours'])) {
				$hours['opening'] = $data['flexible_hours'];
			}

			$hours['delivery'] = empty($data['delivery_type']) ? $hours['opening'] : $this->_createWorkingHours('delivery', $data);
			$hours['collection'] = empty($data['collection_type']) ? $hours['opening'] : $this->_createWorkingHours('collection', $data);

			if (is_numeric($location_id) AND !empty($hours) AND is_array($hours)) {
				foreach ($hours as $type => $hr) {
					foreach ($hr as $hour) {
						$query = $this->Working_hours_model->create([
							'location_id'  => $location_id,
							'weekday'      => $hour['day'],
							'type'         => $type,
							'opening_time' => mdate('%H:%i', strtotime($hour['open'])),
							'closing_time' => mdate('%H:%i', strtotime($hour['close'])),
							'status'       => $hour['status'],
						]);
					}
				}

				return $query;
			}
		}
	}

	/**
	 * Create a new or update existing location tables
	 *
	 * @param int $location_id
	 * @param array $tables
	 *
	 * @return bool
	 */
	public function addLocationTables($location_id, $tables = [])
	{
		$this->load->model('Location_tables_model');
		$affected_rows = $this->Location_tables_model->where('location_id', $location_id)->delete();

		if (is_array($tables) && !empty($tables)) {
			foreach ($tables as $key => $table_id) {

				$this->Location_tables_model->firstOrCreate([
					'location_id' => $location_id,
					'table_id'    => $table_id,
				]);
			}
		}

		if (!empty($tables) AND $affected_rows > 0) {
			return TRUE;
		}
	}

	/**
	 * Delete a single or multiple location by location_id
	 *
	 * @param string|array $location_id
	 *
	 * @return int The number of deleted rows
	 */
	public function deleteLocation($location_id)
	{
		if (is_numeric($location_id)) $location_id = [$location_id];

		if (!empty($location_id) AND ctype_digit(implode('', $location_id))) {
			$affected_rows = $this->whereIn('location_id', $location_id)->delete();
			if ($affected_rows > 0) {
				$this->load->model('Location_tables_model');
				$this->Location_tables_model->whereIn('location_id', $location_id)->delete();

				$this->load->model('Location_menus_model');
				$this->Location_menus_model->whereIn('location_id', $location_id)->delete();

				$this->load->model('Working_hours_model');
				$this->Working_hours_model->whereIn('location_id', $location_id)->delete();

				foreach ($location_id as $id) {
					$this->permalink->deletePermalink('local', 'location_id=' . $id);
				}

				return $affected_rows;
			}
		}
	}

	/**
	 * Validate a single location by language_id
	 *
	 * @param int $location_id
	 *
	 * @return bool TRUE on success, FALSE on failure
	 */
	public function validateLocation($location_id)
	{
		if (!empty($location_id)) {
			if ($this->find($location_id)) {
				return TRUE;
			}
		}

		return FALSE;
	}

	/**
	 * Build working hours array
	 *
	 * @param $type
	 * @param $data
	 *
	 * @return array
	 */
	protected function _createWorkingHours($type, $data)
	{
		$days = (empty($data["{$type}_days"])) ? [] : $data["{$type}_days"];
		$hours = (empty($data["{$type}_hours"])) ? ['open' => '00:00', 'close' => '23:59'] : $data["{$type}_hours"];

		$working_hours = [];

		for ($day = 0; $day <= 6; $day++) {
			$status = in_array($day, $days) ? '1' : '0';
			$working_hours[] = ['day' => $day, 'open' => $hours['open'], 'close' => $hours['close'], 'status' => $status];
		}

		return $working_hours;
	}

	/**
	 * Build post data to save in database
	 *
	 * @param array $save
	 *
	 * @return array
	 */
	protected function postData($save = [])
	{
		if (isset($save['address']['address_1'])) {
			$save['location_address_1'] = $save['address']['address_1'];
		}

		if (isset($save['address']['address_2'])) {
			$save['location_address_2'] = $save['address']['address_2'];
		}

		if (isset($save['address']['city'])) {
			$save['location_city'] = $save['address']['city'];
		}

		if (isset($save['address']['state'])) {
			$save['location_state'] = $save['address']['state'];
		}

		if (isset($save['address']['postcode'])) {
			$save['location_postcode'] = $save['address']['postcode'];
		}

		if (isset($save['address']['country'])) {
			$save['location_country_id'] = $save['address']['country'];
		}

		if (isset($save['address']['location_lat'])) {
			$save['location_lat'] = $save['address']['location_lat'];
		}

		if (isset($save['address']['location_lng'])) {
			$save['location_lng'] = $save['address']['location_lng'];
		}

		if (isset($save['email'])) {
			$save['location_email'] = $save['email'];
		}

		if (isset($save['telephone'])) {
			$save['location_telephone'] = $save['telephone'];
		}

		$options = [];
		if (isset($save['auto_lat_lng'])) {
			$options['auto_lat_lng'] = $save['auto_lat_lng'];
		}

		if (isset($save['opening_type'])) {
			$options['opening_hours']['opening_type'] = $save['opening_type'];
		}

		if (isset($save['daily_days'])) {
			$options['opening_hours']['daily_days'] = $save['daily_days'];
		}

		if (isset($save['daily_hours'])) {
			$options['opening_hours']['daily_hours'] = $save['daily_hours'];
		}

		if (isset($save['flexible_hours'])) {
			$options['opening_hours']['flexible_hours'] = $save['flexible_hours'];
		}

		if (isset($save['delivery_type'])) {
			$options['opening_hours']['delivery_type'] = $save['delivery_type'];
		}

		if (isset($save['delivery_days'])) {
			$options['opening_hours']['delivery_days'] = $save['delivery_days'];
		}

		if (isset($save['delivery_hours'])) {
			$options['opening_hours']['delivery_hours'] = $save['delivery_hours'];
		}

		if (isset($save['collection_type'])) {
			$options['opening_hours']['collection_type'] = $save['collection_type'];
		}

		if (isset($save['collection_days'])) {
			$options['opening_hours']['collection_days'] = $save['collection_days'];
		}

		if (isset($save['collection_hours'])) {
			$options['opening_hours']['collection_hours'] = $save['collection_hours'];
		}

		if (isset($save['future_orders'])) {
			$options['future_orders'] = $save['future_orders'];
		}

		if (isset($save['future_order_days'])) {
			$options['future_order_days'] = $save['future_order_days'];
		}

		if (isset($save['payments'])) {
			$options['payments'] = $save['payments'];
		}

		if (isset($save['delivery_areas'])) {
			$options['delivery_areas'] = $save['delivery_areas'];
		}

		if (isset($save['gallery'])) {
			$options['gallery'] = $save['gallery'];
		}

		$save['options'] = $options;

		return $save;
	}
}

/* End of file Locations_model.php */
/* Location: ./system/tastyigniter/models/Locations_model.php */
