<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create permissions table
 * Rename column permission to permissions in the staff_groups table
 */
class Migration_create_permissions_table extends CI_Migration {

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

        include(IGNITEPATH . '/migrations/initial_schema.php');

        if ( ! empty($insert_permissions_data)) {
            $this->db->query($insert_permissions_data);
        }
    }

    public function down() {
        $this->dbforge->drop_table('permissions');

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('staff_groups')." CHANGE `permissions` `permission` TEXT  NOT NULL;");
    }
}

/* End of file 006_create_permissions_table.php */
/* Location: ./setup/migrations/006_create_permissions_table.php */