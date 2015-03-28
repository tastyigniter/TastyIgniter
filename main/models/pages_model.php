<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Pages_model extends CI_Model {

	public function getPages() {
		$this->db->from('pages');

		$this->db->where('status', '1');

		$query = $this->db->get();
		$result = array();

		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				if (!empty($row['navigation'])) {
					$row['navigation'] = unserialize($row['navigation']);
				}

				$result[] = $row;
			}
		}

		return $result;
	}

	public function getPage($page_id) {
		$this->db->from('pages');

		$this->db->where('page_id', $page_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}
}

/* End of file currencies_model.php */
/* Location: ./main/models/currencies_model.php */