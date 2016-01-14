<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create the layouts and modules relationship table
 */
class Migration_create_layout_modules_table extends CI_Migration {

    public function up() {
        $fields = array(
            'layout_module_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'layout_id INT(11) NOT NULL',
            'module_code VARCHAR(128) NOT NULL',
            'position VARCHAR(32) NOT NULL',
            'priority INT(11) NOT NULL',
            'status TINYINT(1) NOT NULL',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('layout_modules');

        include(IGNITEPATH . '/migrations/initial_schema.php');
        if (!empty($insert_layout_modules_data)) {
            $this->db->query($insert_layout_modules_data);
        }
    }

    public function down() {
        $this->dbforge->drop_table('layout_modules');
    }
}

/* End of file 004_create_layout_modules_table.php */
/* Location: ./setup/migrations/004_create_layout_modules_table.php */