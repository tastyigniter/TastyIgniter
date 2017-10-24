<?php namespace Igniter\Libraries\Location;

use Exception;
use Igniter\Classes\GeoPosition;
use Igniter\Traits\DelegateToCI;
use Igniter\Flame\Traits\Singleton;

/**
 * Location Geocode Class
 *
 * @package System
 */
class Geocode
{
    use Singleton;
    use DelegateToCI;

    const KMUNIT = 111.13384;
    const MUNIT = 69.05482;

    protected $endpoint;

    public $distanceUnit = null;

    public function initialize()
    {
        $this->mapsApiKey = setting('maps_api_key');
        $this->ci()->config->load('location');
//	    $this->location = $location;
//		$this->CI =& get_instance();
    }

    public function calculateDistance($fromPosition, $toPosition)
    {
        list($fromLatitude, $fromLongitude) = $this->validatePosition($fromPosition);
        list($toLatitude, $toLongitude) = $this->validatePosition($toPosition);

        $degrees = sin(deg2rad($fromLatitude)) * sin(deg2rad($toLatitude)) +
            cos(deg2rad($fromLatitude)) * cos(deg2rad($toLatitude)) *
            cos(deg2rad($fromLongitude - $toLongitude));

        $distance = rad2deg(acos($degrees));

        $distanceUnit = $this->getDistanceUnit();

        return $distanceUnit == 'km' ? ($distance * static::KMUNIT) : ($distance * static::MUNIT);
    }

    public function geocodePosition($searchQuery, $options = [])
    {
        $output = null;
        if ($searchQuery = $this->parseSearchQuery($searchQuery))
            $output = $this->requestGeocode($searchQuery, $options);

        $position = new GeoPosition($searchQuery);

        $position->geocodeAs($output);

        //        $position = $this->defaultPosition();
//
//        if (!empty($output->status)) {
//            $position->status = $output->status;
//            $position->search_query = $searchQuery;
//
//            if (isset($output->results[0]->geometry->location, $output->results[0]->formatted_address)) {
//                $position->lat = $output->results[0]->geometry->location->lat;
//                $position->lng = $output->results[0]->geometry->location->lng;
//                $position->formatted_address = $output->results[0]->formatted_address;
//            }
//        }

        return $position;                                            // decode the geocode data
    }

    /**
     * @return \Location
     */
//    public function getLocation()
//    {
//        return $this->location;
//    }

    /**
     * @return \Location_delivery
     */
//    public function locationDelivery()
//    {
//        if (isset($this->ci()->location_delivery))
//            return $this->ci()->location_delivery;
//
//        $this->ci()->load->library('location_delivery');
//
//        return $this->ci()->location_delivery;
//    }

//    public function setLocation($location)
//    {
//        $this->location = $location;
//
//        return $this;
//    }

    public function getDistanceUnit()
    {
        return strtolower($this->distanceUnit ? $this->distanceUnit : setting('distance_unit'));
    }

    public function setDistanceUnit($distanceUnit)
    {
        $this->distanceUnit = $distanceUnit;

        return $this;
    }

    public function newPosition()
    {
        return new GeoPosition();
    }

//    public function getSessionPosition()
//    {
//        $localInfo = empty($localInfo) ? $this->getLocation()->getSessionData() : $localInfo;
//
//        return isset($localInfo['geocode']) ? $localInfo['geocode'] : $this->defaultPosition();
//    }

    protected function validatePosition($position)
    {
//        if (isset($positionArray['lat'])) {
//            $positionArray['y'] = $positionArray['lat'];
//            unset($positionArray['lat']);
//        }
//
//        if (isset($positionArray['lng'])) {
//            $positionArray['x'] = $positionArray['lng'];
//            unset($positionArray['lng']);
//        }

        if (is_array($position))
            return [$position['lat'], $position['lng']];

        return [$position->latitude, $position->longitude];
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
//			} else {
//				$searchQuery = explode(' ', $searchQuery);
            }
        }

        return is_array($searchQuery) ? implode(' ', $searchQuery) : $searchQuery;
    }

    protected function requestGeocode($searchQuery, $options)
    {
        $curl = curl_init();
        $endpoint = $this->ci()->config->item('geocode.endpoint', 'location');
        curl_setopt($curl, CURLOPT_URL, $this->prepareQuery($endpoint, $searchQuery, $options));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($curl, CURLOPT_USERAGENT, $this->ci()->agent->agent_string());
        $geocodeData = curl_exec($curl);

        if (curl_error($curl))
            throw new Exception('Google Maps Geocode cURL Error: '.curl_errno($curl).':'.curl_error($curl));

        $output = json_decode($geocodeData);

        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 200)
            throw new Exception('Google Maps Geocode cURL Error: '.$output->error_message);

        curl_close($curl);

        return $output;
    }

    /**
     * Encode address string and construct the geocode query
     *
     * @param mixed $address
     * @param array $options
     *
     * @return string
     */
    protected function prepareQuery($url, $address = null, $options = [])
    {
        $optionString = '?address='.urlencode($address);
        $optionString .= isset($options['region']) ? '&region='.urlencode($options['region']) : '';
        $optionString .= isset($options['components']) ? '&components=' : '';
        $optionString .= isset($options['components']['admin_area']) ? 'administrative_area:'.urlencode($options['components']['admin_area']).'|' : '';
        $optionString .= isset($options['components']['country']) ? 'country:'.urlencode($options['components']['country']) : '';

        $mapsApiKey = isset($options['key']) ? $options['key'] : $this->mapsApiKey;

        return $url.$optionString.'&key='.urlencode($mapsApiKey);
    }
}
