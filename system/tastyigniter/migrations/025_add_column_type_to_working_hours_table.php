<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add type column to the working_hours table
 */
class Migration_add_column_type_to_working_hours_table extends CI_Migration {

	public function up() {
		$this->dbforge->add_column('working_hours', array('type VARCHAR(32) NOT NULL'));
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('working_hours')." DROP PRIMARY KEY, ADD PRIMARY KEY (`location_id`, `weekday`, `type`);");

		$this->db->set('type', 'opening');
		$this->db->update('working_hours');
	}

	public function down() {

		$this->db->where('type !=', 'opening');
		$this->db->delete('working_hours');

		$this->dbforge->drop_column('working_hours', 'type');
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('working_hours')." DROP PRIMARY KEY, ADD PRIMARY KEY (`location_id`, `weekday`);");
	}
}

/* End of file 023_add_column_type_to_working_hours_table.php */
/* Location: ./setup/migrations/023_add_column_type_to_working_hours_table.php */