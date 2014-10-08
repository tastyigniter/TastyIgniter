<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Migration_Schema extends CI_Migration {

	public function up() {
		$this->load->database();
		$this->load->dbforge();
		
		$this->_menu_options();
		$this->_menu_option_values();
		$this->_locations();
	}

	public function down() {}

	public function _menu_options() {
		//$this->dbforge->remove_key('option_id');
		$this->dbforge->drop_column('menu_options', 'option_price');

		$fields = array(
			'display_type VARCHAR(15) NOT NULL',
			'priority INT(11) NOT NULL'
		);

		$this->dbforge->add_column('menu_options', $fields);
	}

	public function _menu_option_values() {
		$this->dbforge->drop_table('menu_option_values');
		
		$fields = array(
			'option_value_id INT(11) NOT NULL AUTO_INCREMENT',
			'option_id INT(11) NOT NULL',
			'value VARCHAR(128) NOT NULL',
			'price DECIMAL(15,2) NOT NULL',
			'priority INT(11) NOT NULL'
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('option_value_id', TRUE);
		$this->dbforge->create_table('menu_option_values');

		$this->db->query('ALTER TABLE '.$this->db->dbprefix('menu_option_values').' AUTO_INCREMENT 11');
	}

	public function _locations() {
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('locations').' CHANGE `ready_time` `delivery_time` INT(11) NOT NULL');

		$fields = array('collection_time INT(11) NOT NULL');
		$this->dbforge->add_column('locations', $fields);
	}
}

/* End of file 002_schema.php */
/* Location: ./application/extensions/setup/migrations/002_schema.php */