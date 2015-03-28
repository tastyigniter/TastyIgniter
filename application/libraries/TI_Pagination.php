<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

 class TI_Pagination extends CI_Pagination {

	public $text = 'Displaying {start} to {end} of {total}';

    public function __construct()
    {
        parent::__construct();
		$this->CI =& get_instance();
    }

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
}

// END TI_Pagination Class

/* End of file TI_Pagination.php */
/* Location: ./application/libraries/TI_Pagination.php */