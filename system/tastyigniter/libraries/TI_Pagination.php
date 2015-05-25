<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * TastyIgniter Pagination extension Class
 *
 */
class TI_Pagination extends CI_Pagination {

    protected $text = '';

    /**
     * Initialize Preferences
     *
     * @param	array	$params	Initialization parameters
     * @return	TI_Pagination
     */
    public function initialize(array $params = array())
    {
        if (isset($params['attributes']) && is_array($params['attributes']))
        {
            $this->_parse_attributes($params['attributes']);
            unset($params['attributes']);
        }

        // Deprecated legacy support for the anchor_class option
        // Should be removed in CI 3.1+
        if (isset($params['anchor_class']))
        {
            empty($params['anchor_class']) OR $attributes['class'] = $params['anchor_class'];
            unset($params['anchor_class']);
        }

        foreach ($params as $key => $val)
        {
            if (property_exists($this, $key))
            {
                $this->$key = $val;
            }
        }

        if ($this->CI->config->item('enable_query_strings') === TRUE)
        {
            $this->page_query_string = TRUE;
        }

        $this->base_url = rtrim($this->base_url, "?");

        return $this;
    }

    // --------------------------------------------------------------------
	/**
	 * Generate the pagination info
	 *
	 * @return	string
	 */
	function create_infos()
	{
		$num_pages = ceil($this->total_rows / $this->per_page);

		if ($this->CI->input->get($this->query_string_segment)) {
			$page = $this->CI->input->get($this->query_string_segment);
		} else {
			$page = 1;
		}

		$find = array(
			'{start}',
			'{end}',
			'{total}',
			'{pages}'
		);

		$replace = array(
			($this->total_rows) ? (($page - 1) * $this->per_page) + 1 : 0,
			((($page - 1) * $this->per_page) > ($this->total_rows - $this->per_page)) ? $this->total_rows : ((($page - 1) * $this->per_page) + $this->per_page),
			$this->total_rows,
			$num_pages
		);

		return ('<span>' . str_replace($find, $replace, $this->text) . '</span>');
	}

	// --------------------------------------------------------------------

}

/* End of file TI_Pagination.php */
/* Location: ./system/tastyigniter/libraries/TI_Pagination.php */