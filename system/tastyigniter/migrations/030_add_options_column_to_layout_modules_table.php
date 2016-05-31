<?php if (!defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add options column to the layout_modules table
 */
class Migration_add_options_column_to_layout_modules_table extends CI_Migration {

    public function up() {
        $this->dbforge->add_column('layout_modules', array('options TEXT NOT NULL AFTER priority'));
    }

    public function down() {
        $this->dbforge->drop_column('layout_modules', 'options');
    }
}

/* End of file 030_add_options_column_to_layout_modules_table.php */
/* Location: ./setup/migrations/030_add_options_column_to_layout_modules_table.php */