<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_edit_languages_columns extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('languages')." CHANGE `directory` `idiom` VARCHAR(32) NOT NULL;");

        $this->dbforge->add_column('languages', array('can_delete TINYINT(1) NOT NULL'));

        $this->db->set('can_delete', '1');
        $this->db->where('language_id', '11');
        $this->db->update('languages');
    }

    public function down() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('languages')." CHANGE `idiom` `directory` VARCHAR(32)  NOT NULL;");

        $this->dbforge->drop_column('languages', 'can_delete');
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./setup/migrations/008_edit_languages_columns.php */