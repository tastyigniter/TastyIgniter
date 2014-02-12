<?php
class Specials_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}

    public function record_count() {
        return $this->db->count_all('menus_specials');
    }
    
	public function getList($filter = array()) {
		if ($filter['page'] !== 0) {
			$filter['page'] = ($filter['page'] - 1) * $filter['limit'];
		}
        	
        $this->db->limit($limit, $start);

        //selecting all records from the menus and categories tables.
		$this->db->from('menus_specials');
		//$this->db->join('menus', 'menus.menu_id = menus_specials.menu_id', 'left');
		
		$query = $this->db->get();
		$result = array();
	
		if ($query->num_rows() > 0) {
			$result = $query->result_array();
		}
	
		return $result;
	}
	
	public function getMainSpecials($specials = FALSE) {
		if ($specials === FALSE) {
			$this->db->select('menu_id, special_id, start_date, end_date, special_price');
			$this->db->from('menus_specials');
			//$this->db->join('menus', 'menus_specials.menu_id = menus.menu_id', 'left');
			
			$this->db->where('start_date <=', 'NOW()', FALSE);
			$this->db->where('end_date >=', 'NOW()', FALSE);
		}	
	}
	
	public function getDeals($deals = FALSE) {
		if ($deals === FALSE) {
			$this->db->from('specials');

			$query = $this->db->get();
			$result = array();
		
			if ($query->num_rows() > 0) {
				$result = $query->result_array();
			}
		
			return $result;
		}
	}

	public function getSpecial($special_id) {
		
		$this->db->from('menus_specials');
		//$this->db->join('menus', 'menus.menu_id = menus_specials.menu_id', 'left');
		
		$this->db->where('special_id', $special_id);
	}
	
	public function getDeal($deal_id) {
		
		$this->db->from('specials');
		$this->db->where('deal_id', $deal_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getMainSpecial($special_id) {
		
		$this->db->select('menu_id, special_id, start_date, end_date, special_price');
		$this->db->from('menus_specials');
		//$this->db->join('menus', 'menus.menu_id = menus_specials.menu_id', 'left');
		
		$this->db->where('start_date <=', 'NOW()', FALSE);
		$this->db->where('end_date >=', 'NOW()', FALSE);

		$this->db->where('special_id', $special_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) {
			return $query->row_array();
		}
	}

	public function getIsSpecials() {
		$specials = array();
		
		$this->db->select('menu_id, special_id');
		$this->db->from('menus_specials');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $row) {
				$specials[] = $row['menu_id'];
			}
		}
		return $specials;
	}

	public function updateSpecial($update = array()) {
		
		if (!empty($update['special_name'])) {
			$this->db->set('special_name', $update['special_name']);
		}
		
		if (!empty($update['special_description'])) {
			$this->db->set('special_description', $update['special_description']);
		}
		
		if (!empty($update['special_price'])) {
			$this->db->set('special_price', $update['special_price']);
		}
		
		if (!empty($update['start_date'])) {
			$this->db->set('start_date', $update['start_date']);
		}
		
		if (!empty($update['end_date'])) {
			$this->db->set('end_date', $update['end_date']);
		}
		
		if (!empty($update['special_photo'])) {
			$this->db->set('special_photo', $update['special_photo']);
		}
		
		if (!empty($update['stock_qty'])) {
			$this->db->set('stock_qty', $update['stock_qty']);
		}

		/*$special_prefix = $this->config->item('special_prefix');
		
		if ($special_prefix) {
			$menu_id = $special_prefix.'_'.$update['special_id'];
			$this->db->set('menu_id', $menu_id);
		}
		
		if (!empty($update['special_id'])) {
			$this->db->where('special_id', $update['special_id']);
			$this->db->update('menus_specials');
		}*/
		
		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}

	public function addSpecial($add = array()) {
		
		if (!empty($add['special_name'])) {
			$this->db->set('special_name', $add['special_name']);
		}
	
		if (!empty($add['special_description'])) {
			$this->db->set('special_description', $add['special_description']);
		}
	
		if (!empty($add['special_price'])) {
			$this->db->set('special_price', $add['special_price']);
		}
	
		if (!empty($add['start_date'])) {
			$this->db->set('start_date', $add['start_date']);
		}
	
		if (!empty($add['end_date'])) {
			$this->db->set('end_date', $add['end_date']);
		}
		
		if (!empty($add['special_photo'])) {
			$this->db->set('special_photo', $add['special_photo']);
		}

		if (!empty($add['stock_qty'])) {
			$this->db->set('stock_qty', $add['stock_qty']);
		}

		$this->db->insert('menus_specials');

		if ($this->db->affected_rows() > 0 && $this->db->insert_id()) {
			$special_id = $this->db->insert_id();

			/*$special_prefix = $this->config->item('special_prefix');
			
			if ($special_prefix) {
				$menu_id = $special_prefix.'_'.$special_id;
			
				$this->db->set('menu_id', $menu_id);
				$this->db->where('special_id', $special_id);

				$this->db->update('menus_specials'); 
			}*/
			
			return TRUE;
		}
	}
	
	public function deleteSpecial($special_id) {
		$this->db->where('special_id', $special_id);
			
		$this->db->delete('menus_specials');

		if ($this->db->affected_rows() > 0) {
			return TRUE;
		}
	}
	
	public function addDeal($deal_name, $deal_description, $deal_price, $start_date, $end_date, $deal_photo) {
		$add_data = array(
			'deal_name' 		=> $deal_name,
			'deal_description' 	=> $deal_description,
			'deal_price' 		=> $deal_price,
			'start_date' 		=> $start_date,
			'end_date' 			=> $end_date,
			'deal_photo' 		=> $deal_photo
		);
		
		return $this->db->insert('specials', $add_data);
	}

	public function updateDeal($deal_id, $deal_name, $deal_description, $deal_price, $start_date, $end_date, $deal_photo) {
		if ($deal_photo !== '') {
			$update_data['deal_photo'] = $deal_photo;
		}
		
		$update_data['deal_name'] 		= $deal_name;
		$update_data['deal_description'] = $deal_description;
		$update_data['deal_price'] 		= $deal_price;
		$update_data['start_date'] 		= $start_date;
		$update_data['end_date'] 		= $end_date;
		
		$this->db->where('deal_id', $deal_id);
		return $this->db->update('specials', $update_data);
	}
	
	public function deleteDeal($deal_id) {
		$remove_data = array(
			'deal_id' => $deal_id
		);
			
		return $this->db->delete('specials', $remove_data);
	}
}