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
 * Add status column to categories table
 */
class Migration_add_status_column_to_categories_table extends TI_Migration {

	public function up() {
		$this->dbforge->add_column('categories', array('status TINYINT(4) NOT NULL DEFAULT "1"'));

		$this->db->set('status', '1');
		$this->db->update('categories');
	}

	public function down() {
		$this->dbforge->drop_column('categories', 'status');
	}
}

/* End of file 018_add_status_column_to_categories_table.php */
/* Location: ./system/tastyigniter/migrations/018_add_status_column_to_categories_table.php */