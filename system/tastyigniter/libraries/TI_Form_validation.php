<?php defined('BASEPATH') OR exit('No direct script access allowed');

class TI_Form_validation extends CI_Form_validation
{
    public $CI;

	/**
	 * Is Unique
	 *
	 * Check if the input value doesn't already exist
	 * in the specified database field.
	 *
	 * @param	string	$str
	 * @param	string	$field
	 * @return	bool
	 */
	public function is_unique($str, $field)
	{
		sscanf($field, '%[^.].%[^.]', $table, $field);
        $query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
        return $query->num_rows() === 0;
	}

	// --------------------------------------------------------------------

	/**
     * Valid Time
     *
     * @access  public
     * @param   string
     * @return  bool
     */
    public function valid_time($str)
    {
        return ( ! preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $str) AND ! preg_match('/^(1[012]|[1-9]):[0-5][0-9](\s)?(?i)(am|pm)$/', $str)) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Valid Date
     *
     * @access  public
     * @param   string
     * @return  bool
     */
    public function valid_date($str)
    {
        if ($str != '0000-00-00' AND $str != '00-00-0000')
        {
            return ( ! preg_match('/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/', $str) AND ! preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $str)) ? FALSE : TRUE;
        }
    }

    // --------------------------------------------------------------------

    /**
     * Valid Date
     *
     * @access  public
     * @param $str
     * @param string $post_item
     * @return bool
     */
    public function get_lat_lag($str, $post_item = 'address') {
        if (!empty($str) AND $post_data = $this->CI->input->post($post_item)) {
            if (is_array($post_data) AND !empty($post_data['address_1']) AND !empty($post_data['postcode'])) {
                $address_string = implode(", ", $post_data);
                $address = urlencode($address_string);
                $geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&sensor=false&region=GB');
                $output = json_decode($geocode);
                $status = $output->status;

                if ($status === 'OK') {
                    $_POST['address']['location_lat'] = $output->results[0]->geometry->location->lat;
                    $_POST['address']['location_lng'] = $output->results[0]->geometry->location->lng;

                    return TRUE;
                }
            } else {
                return FALSE;
            }
        }
    }

    // --------------------------------------------------------------------

    /**
     * XSS Clean
     *
     * @param	string
     * @return	string
     */
    public function xss_clean($str)
    {
        return $this->CI->security->xss_clean($str);
    }

    // --------------------------------------------------------------------

}

// END Form_validation Class

/* End of file Form_validation.php */
/* Location: ./system/tastyigniter/libraries/Form_validation.php */