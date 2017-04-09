<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package Igniter
 * @author Samuel Adepoyigi
 * @copyright (c) 2013 - 2016. Samuel Adepoyigi
 * @copyright (c) 2016 - 2017. TastyIgniter Dev Team
 * @link https://tastyigniter.com
 * @license http://opensource.org/licenses/MIT The MIT License
 * @since File available since Release 1.0
 */
if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add type column to the working_hours table
 */
class Migration_add_column_type_to_working_hours_table extends TI_Migration {

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
/* Location: ./system/tastyigniter/migrations/023_add_column_type_to_working_hours_table.php */