<?php if (!defined('BASEPATH')) exit('No direct access allowed');

/**
 * Rename message_recipients table to message_meta_data
 * Add existing sender data from messages table
 */
class Migration_rename_message_recipients_table_and_add_sender_data extends CI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE " . $this->db->dbprefix('message_recipients') . " RENAME " . $this->db->dbprefix('message_meta') . ";");

        $this->db->query("ALTER TABLE " . $this->db->dbprefix('message_meta') . " CHANGE `message_recipient_id` `message_meta_id` INT(11) NOT NULL AUTO_INCREMENT;");

        $this->dbforge->add_column('message_meta', array('deleted TINYINT NOT NULL AFTER status'));

        $this->db->select('sender_id, message_id');
        $this->db->where('status', '1');

        $query = $this->db->get('messages');

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $this->db->set('message_id', $row['message_id']);
                $this->db->set('deleted', '0');
                $this->db->set('status', '1');
                $this->db->set('item', 'sender_id');
                $this->db->set('value', $row['sender_id']);

                $this->db->insert('message_meta');
            }
        }
    }

    public function down() {
        $this->db->query("ALTER TABLE " . $this->db->dbprefix('message_meta') . " RENAME " . $this->db->dbprefix('message_recipients') . ";");

        $this->db->query("ALTER TABLE " . $this->db->dbprefix('message_recipients') . " CHANGE `message_meta_id` `message_recipient_id`;");

        $this->dbforge->drop_column('message_recipients', 'deleted');

        $this->db->delete('message_recipients', array('item' => 'sender_id'));
    }
}

/* End of file 027_rename_message_recipients_table_and_add_sender_data.php */
/* Location: ./setup/migrations/027_rename_message_recipients_table_and_add_sender_data.php */