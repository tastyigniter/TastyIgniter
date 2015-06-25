<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Migration_edit_languages_columns extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('languages')." CHANGE `directory` `idiom` VARCHAR(32) NOT NULL;");

        $this->dbforge->add_column('languages', array('can_delete TINYINT(1) NOT NULL'));
    }

    public function down() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('languages')." CHANGE `idiom` `directory` VARCHAR(32)  NOT NULL;");

        $this->dbforge->drop_column('languages', 'can_delete');
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */