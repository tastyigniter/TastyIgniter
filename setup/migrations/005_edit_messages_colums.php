<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Migration_edit_messages_columns extends CI_Migration {

    public function up() {
        $this->dbforge->drop_column('messages', 'location_id');
        $this->dbforge->drop_column('messages', 'staff_id_to');
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('messages')." CHANGE `staff_id_form` `staff_id` INT(11)  NOT NULL;");
        $this->dbforge->add_column('working_hours', array('status TINYINT(1) NOT NULL'));

        $this->dbforge->drop_column('message_recipients', 'staff_id');
        $this->dbforge->drop_column('message_recipients', 'customer_id');
        $this->dbforge->drop_column('message_recipients', 'staff_email');
        $this->dbforge->drop_column('message_recipients', 'customer_email');

        $this->dbforge->add_column('message_recipients', array('key VARCHAR(32) NOT NULL'));
        $this->dbforge->add_column('message_recipients', array('value TEXT NOT NULL'));
    }

    public function down() {
        $this->dbforge->drop_column('locations', 'covered_area');
    }
}

/* End of file 004_create_layout_modules_table.php */
/* Location: ./setup/migrations/004_create_layout_modules_table.php */