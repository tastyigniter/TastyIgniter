<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

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