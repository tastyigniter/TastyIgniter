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