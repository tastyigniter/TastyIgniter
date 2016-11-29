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
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Location Geocode Class
 *
 * @category       Libraries
 * @package        TastyIgniter\Libraries\Location_geocode.php
 * @link           http://docs.tastyigniter.com
 */
class Location_geocode
{
	public $searchQuery = null;
	public $distanceUnit = null;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	public function findUserPosition()
	{
		$searchQuery = $this->getSearchQuery();

		if (empty($searchQuery))
			return "NO_SEARCH_QUERY";

		$sessionPosition = $this->getSessionPosition();
		if (isset($sessionPosition->search_query) AND $sessionPosition->search_query == $searchQuery)
			return $sessionPosition;

		$geocodePosition = $this->geocodePosition($searchQuery);

		if (empty($geocodePosition->status))
			return "FAILED";

		if ($geocodePosition->status === 'OK')
			return $geocodePosition;

		return "INVALID_SEARCH_QUERY";
	}

	public function findPositionInBoundaries($userPositionPoint, $boundaries)
	{
		$positionBoundary = 'outside';

		if ((isset($boundaries['vertices']) OR isset($boundaries['circle'])) AND isset($boundaries['type'])) {
			$type = ($boundaries['type'] == 'shape') ? 'vertices' : 'circle';

			$findPointMethod = 'pointIn' . ucwords($type);
			$positionBoundary = $this->{$findPointMethod}($userPositionPoint, $boundaries[$type]);
		}

		return $positionBoundary;
	}

	public function calculateDistance($fromPosition, $toPosition)
	{
		$fromPosition = $this->validatePositionArray($fromPosition);
		$toPosition = $this->validatePositionArray($toPosition);

		if (!isset($fromPosition['y'], $fromPosition['x'], $toPosition['y'], $toPosition['x']))
			return null;

		$degrees = sin(deg2rad($fromPosition['y'])) * sin(deg2rad($toPosition['y'])) +
			cos(deg2rad($fromPosition['y'])) * cos(deg2rad($toPosition['y'])) *
			cos(deg2rad($fromPosition['x'] - $toPosition['x']));

		$distance = rad2deg(acos($degrees));

		$distanceUnit = $this->getDistanceUnit();

		return $distanceUnit == 'km' ? ($distance * 111.13384) : ($distance * 69.05482);
	}

	public function geocodePosition($searchQuery, $options = [])
	{
		$searchQuery = $this->parseSearchQuery($searchQuery);

		$mapsApiKey = isset($options['api_key']) ? $options['api_key'] : $this->CI->config->item('maps_api_key');

		//encode $postcode string and construct the url query
		$url = $this->getGeocodeEndpoint($searchQuery, $mapsApiKey, $options);

		$output = $this->getRemoteGeocodeData($url);

		$position = $this->getDefaultPosition();

		if (!empty($output->status)) {
			$position->status = $output->status;
			$position->search_query = $searchQuery;

			if (isset($output->results[0]->geometry->location, $output->results[0]->formatted_address)) {
				$position->lat = $output->results[0]->geometry->location->lat;
				$position->lng = $output->results[0]->geometry->location->lng;
				$position->formatted_address = $output->results[0]->formatted_address;
			}
		}

		return $position;                                            // decode the geocode data
	}

	public function getGeocodeEndpoint($address = null, $mapsApiKey = null, $options = [])
	{
		$optionString = '';
		$optionString .= isset($options['region']) ? '&region=' . urlencode($options['region']) : '';
		$optionString .= isset($options['components']) ? '&components=' : '';
		$optionString .= isset($options['components']['admin_area']) ? 'administrative_area:' . urlencode($options['components']['admin_area']) . '|' : '';
		$optionString .= isset($options['components']['country']) ? 'country:' . urlencode($options['components']['country']) : '';

		$endPoint = 'https://maps.googleapis.com/maps/api/geocode/json?address=' .
			urlencode($address) . $optionString . '&key=' . urlencode($mapsApiKey);

		return $endPoint;
	}

	/**
	 * @return \Location
	 */
	public function getLocation()
	{
		return $this->CI->location;
	}

	/**
	 * @return \Location_delivery
	 */
	public function locationDelivery()
	{
		if (isset($this->CI->location_delivery))
			return $this->CI->location_delivery;

		$this->CI->load->library('location_delivery');

		return $this->CI->location_delivery;
	}

	public function setLocation($location)
	{
		$this->location = $location;

		return $this;
	}

	public function getDefaultPosition()
	{
		$position = new \stdClass;
		$position->status = $position->search_query = $position->lat = $position->lng = null;

		return $position;
	}

	public function getSearchQuery()
	{
		if (is_null($this->searchQuery))
			return $this->getSessionPosition()->search_query;

		return $this->searchQuery;
	}

	public function setSearchQuery($searchQuery)
	{
		$this->searchQuery = $searchQuery;

		return $this;
	}

	public function hasSearchQuery()
	{
		$sessionPosition = $this->getSessionPosition();

		return (empty($sessionPosition->search_query)) ? FALSE : TRUE;
	}

	public function getDistanceUnit()
	{
		return strtolower($this->distanceUnit ? $this->distanceUnit : $this->CI->config->item('distance_unit'));
	}

	public function setDistanceUnit($distanceUnit)
	{
		$this->distanceUnit = $distanceUnit;

		return $this;
	}

	public function getSessionPosition()
	{
		$localInfo = empty($localInfo) ? $this->getLocation()->getSessionData() : $localInfo;

		return isset($localInfo['geocode']) ? $localInfo['geocode'] : $this->getDefaultPosition();
	}

	// Check if the point is inside the polygon or on the boundary
	public function pointInVertices($point, $vertices = [])
	{
		// Check if the point sits exactly on a vertex
		if ($this->isPointOnVertex($point, $vertices) === TRUE)
			return "vertex";

		$intersections = 0;
		for ($i = 1; $i < count($vertices); $i++) {
			$vertex1 = $vertices[$i - 1];
			$vertex2 = $vertices[$i];

			if ($this->isPointOnBoundary($point, $vertex1, $vertex2)) return "boundary";

			$boundary = $this->isPointInBoundary($point, $vertex1, $vertex2);

			if ($boundary === TRUE) return "boundary";

			if ($boundary === 1) $intersections++;
		}

		// If the number of edges we passed through is odd, then it's in the polygon.
		return ($intersections % 2 != 0) ? "inside" : "outside";
	}

	public function pointInCircle($point, $circle = [])
	{
		$center = $this->transformPointToArray($circle['center']);

		return $this->isPointInCircle($point, $center, $circle) ? "inside" : "outside";
	}

	protected function isPointInCircle($point, $center, $circle)
	{
		$distanceUnit = $this->getDistanceUnit();
		$earthRadius = ($distanceUnit === 'km') ? 6371 : 3959;
		$radius = ($distanceUnit === 'km') ? $circle['radius'] / 1000 : $circle['radius'] / 1609.344;

		$dLat = deg2rad($center['y'] - $point['y']);
		$dLon = deg2rad($center['x'] - $point['x']);

		$a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($point['y'])) * cos(deg2rad($center['y'])) * sin($dLon / 2) * sin($dLon / 2);
		$c = 2 * asin(sqrt($a));
		$distance = $earthRadius * $c;

		return ($distance <= $radius) ? TRUE : FALSE;
	}

	protected function isPointOnVertex($point, $vertices)
	{
		foreach ($vertices as $vertex) {
			if ($point == $vertex) {
				return TRUE;
			}
		}
	}

	protected function isPointOnBoundary($point, $vertex1, $vertex2)
	{
		return ($vertex1['y'] == $vertex2['y'] AND $vertex1['y'] == $point['y']
			AND $point['x'] > min($vertex1['x'], $vertex2['x'])
			AND $point['x'] < max($vertex1['x'], $vertex2['x']));
	}

	protected function isPointInBoundary($point, $vertex1, $vertex2)
	{
		if ($point['y'] > min($vertex1['y'], $vertex2['y'])
			AND $point['y'] <= max($vertex1['y'], $vertex2['y'])
			AND $point['x'] <= max($vertex1['x'], $vertex2['x'])
			AND $vertex1['y'] != $vertex2['y']
		) {
			$xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];

			// Check if point is on the polygon boundary (other than horizontal)
			if ($xinters == $point['x']) {
				return TRUE;
			}

			// Check if point is in the polygon boundary
			if ($vertex1['x'] == $vertex2['x'] OR $point['x'] <= $xinters) {
				return 1;
			}
		}
	}

	protected function transformPointToArray($pointString)
	{
		$array = explode('|', $pointString);

		return ['y' => $array[0], 'x' => $array[1]];
	}

	protected function validatePositionArray($positionArray)
	{
		if (isset($positionArray['lat'])) {
			$positionArray['y'] = $positionArray['lat'];
			unset($positionArray['lat']);
		}

		if (isset($positionArray['lng'])) {
			$positionArray['x'] = $positionArray['lng'];
			unset($positionArray['lng']);
		}

		return $positionArray;
	}

	// method to perform regular expression match on postcode string and return latitude and longitude
	protected function parseSearchQuery($searchQuery = null)
	{
		if (is_string($searchQuery)) {
			$postcode = strtoupper(str_replace(' ', '', $searchQuery));                                // strip spaces from postcode string and convert to uppercase

			if (preg_match("/^[A-Z]{1,2}[0-9]{2,3}[A-Z]{2}$/", $postcode) OR
				preg_match("/^[A-Z]{1,2}[0-9]{1}[A-Z]{1}[0-9]{1}[A-Z]{2}$/", $postcode) OR
				preg_match("/^GIR0[A-Z]{2}$/", $postcode)
			) {
				$searchQuery = $postcode;
			} else {
				$searchQuery = explode(' ', $searchQuery);
			}
		}

		return (is_array($searchQuery)) ? implode(' ', $searchQuery) : $searchQuery;
	}

	protected function getRemoteGeocodeData($url)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($curl, CURLOPT_USERAGENT, $this->CI->agent->agent_string());
		$geocodeData = curl_exec($curl);

		if (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200)
			log_message('error', 'Google Maps Geocode cURL Error -> ' . $this->parseRemoteResponseHtml($geocodeData));

		if (curl_error($curl))
			log_message('error', 'Google Maps Geocode cURL Error -> ' . curl_errno($curl) . ':' . curl_error($curl));

		curl_close($curl);
		$output = json_decode($geocodeData);

		return $output;
	}

	protected function parseRemoteResponseHtml($geocodeData)
	{
		if (!preg_match("/<title>(.*)<\/title>/siU", $geocodeData, $titleMatches))
			return null;

		// Clean up title: remove EOL's and excessive whitespace.
		$responseTitle = preg_replace('/\s+/', ' ', $titleMatches[1]);
		$responseTitle = trim($responseTitle);

		return $responseTitle;
	}
}
