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
 * Add column version to the extensions table
 */
class Migration_add_version_field_to_extensions_table extends TI_Migration {

	public function up() {
		$this->dbforge->add_column('extensions', array('version VARCHAR(11) NOT NULL DEFAULT "1.0.0"'));
	}

	public function down() {
		$this->dbforge->drop_column('extensions', 'version');
	}
}

/* End of file 016_add_version_field_to_extensions_table.php */
/* Location: ./system/tastyigniter/migrations/016_add_version_field_to_extensions_table.php */