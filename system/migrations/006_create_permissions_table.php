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
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_permissions_table extends TI_Migration {

    public function up() {
        $fields = array(
            'permission_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'name VARCHAR(128) NOT NULL',
            'description VARCHAR(255) NOT NULL',
            'action TEXT NOT NULL',
            'status TINYINT(1) NOT NULL'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('permissions');
        $this->db->query('ALTER TABLE '.$this->db->dbprefix('permissions').' AUTO_INCREMENT 11');

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('staff_groups')." CHANGE `permission` `permissions` TEXT  NOT NULL;");

        $this->Setup_model->querySchema('permissions', 'initial');
    }

    public function down() {
        $this->dbforge->drop_table('permissions');

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('staff_groups')." CHANGE `permissions` `permission` TEXT  NOT NULL;");
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./system/tastyigniter/migrations/006_create_permissions_table.php */