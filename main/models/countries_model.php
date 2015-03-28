<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Countries_model extends CI_Model {

	public function getCountries() {
		$this->db->from('countries');
		$this->db->order_by('country_name', 'ASC');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}

		return $result;
	}
}

/* End of file countries_model.php */
/* Location: ./main/models/countries_model.php */