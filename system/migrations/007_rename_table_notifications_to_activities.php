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
 * Drop notifications table
 * Create activities table
 */
class Migration_rename_table_notifications_to_activities extends TI_Migration {

    public function up() {
        $this->dbforge->drop_table('notifications');

        $fields = array(
            'activity_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'domain VARCHAR(10) NOT NULL',
            'context VARCHAR(128) NOT NULL',
            'user VARCHAR(10) NOT NULL',
            'user_id INT(11) NOT NULL',
            'action VARCHAR(32) NOT NULL',
            'message TEXT NOT NULL',
            'status TINYINT(4) NOT NULL',
            'date_added DATETIME NOT NULL',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('activities');
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('activities').' AUTO_INCREMENT 11');
    }

    public function down() {
        $this->dbforge->drop_table('activities');

        $fields = array(
            'notification_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'action VARCHAR(255) NOT NULL',
            'object VARCHAR(255) NOT NULL',
            'suffix VARCHAR(255) NOT NULL',
            'object_id INT(11) NOT NULL',
            'actor_id INT(11) NOT NULL',
            'subject_id INT(11) NOT NULL',
            'status TINYINT(4) NOT NULL',
            'date_added DATETIME NOT NULL',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('notifications');
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('notifications').' AUTO_INCREMENT 11');
    }
}

/* End of file 007_rename_table_notifications_to_activities.php */
/* Location: ./system/tastyigniter/migrations/007_rename_table_notifications_to_activities.php */