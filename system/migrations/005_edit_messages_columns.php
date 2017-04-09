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
 * Add messages recipient to the database
 */
class Migration_edit_messages_columns extends TI_Migration {

    public function up() {
        $this->dbforge->drop_column('messages', 'location_id');
        $this->dbforge->drop_column('messages', 'staff_id_to');
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('messages')." CHANGE `staff_id_from` `sender_id` INT(11)  NOT NULL;");

        $this->dbforge->drop_column('message_recipients', 'staff_id');
        $this->dbforge->drop_column('message_recipients', 'customer_id');
        $this->dbforge->drop_column('message_recipients', 'staff_email');
        $this->dbforge->drop_column('message_recipients', 'customer_email');

        $this->dbforge->add_column('message_recipients', array('item VARCHAR(32) NOT NULL'));
        $this->dbforge->add_column('message_recipients', array('value TEXT NOT NULL'));
    }

    public function down() {
        $this->dbforge->add_column('messages', array('location_id INT(11) NOT NULL'));
        $this->dbforge->add_column('messages', array('staff_id_to INT(11) NOT NULL'));
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('messages')." CHANGE `sender_id` `staff_id_from` INT(11)  NOT NULL;");

        $this->dbforge->add_column('message_recipients', 'staff_id int(11) NOT NULL');
        $this->dbforge->add_column('message_recipients', 'customer_id int(11) NOT NULL');
        $this->dbforge->add_column('message_recipients', 'staff_email VARCHAR(96) NOT NULL');
        $this->dbforge->add_column('message_recipients', 'customer_email VARCHAR(96) NOT NULL');

        $this->dbforge->drop_column('message_recipients', 'item');
        $this->dbforge->drop_column('message_recipients', 'value');
    }
}

/* End of file 005_edit_messages_columns.php */
/* Location: ./system/tastyigniter/migrations/005_edit_messages_columns.php */