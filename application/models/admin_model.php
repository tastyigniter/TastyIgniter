<?php
class Admin_model extends CI_Model {

	public function __construct() {
		$this->load->database();
	}




	
	




	public function getReservations($reservations = FALSE) {
		if ($reservations === FALSE) {
			$this->db->from('reservations');
			$this->db->join('tables', 'tables.table_id = reservations.table_id', 'left');
			$this->db->join('locations', 'locations.location_id = reservations.location_id', 'left');

			$query = $this->db->get();
			return $query->result_array();
		}
	}



}