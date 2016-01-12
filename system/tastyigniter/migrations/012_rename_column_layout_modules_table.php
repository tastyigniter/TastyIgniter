<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Rename column position to partial in the layout_modules table
 */
class Migration_rename_column_layout_modules_table extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('layout_modules')." CHANGE `position` `partial` VARCHAR(32) NOT NULL;");
    }

    public function down() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('layout_modules')." CHANGE `partial` `position` VARCHAR(32) NOT NULL;");
    }
}

/* End of file 012_rename_column_layout_modules_table.php */
/* Location: ./setup/migrations/012_rename_column_layout_modules_table.php */