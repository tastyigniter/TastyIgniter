<?php if (!defined('BASEPATH')) exit('No direct access allowed');

/**
 * Create mealtimes table and update permission table
 * Add priority column to menus table
 * Add is_default column to menu_options table
 */
class Migration_create_mealtimes_table_and_add_column_to_menus_table_and_menu_options_table extends CI_Migration {

    public function up() {
        $this->_mealtimes();

        $this->dbforge->add_column('menus', array('mealtime_id INT(11) NOT NULL AFTER subtract_stock'));
        $this->dbforge->add_column('menus', array('menu_priority INT(11) NOT NULL AFTER menu_status'));

        $this->db->set('mealtime_id', '0');
        $this->db->set('menu_priority', '0');
        $this->db->update('menus');

        $this->dbforge->add_column('menu_options', array('default_value_id TINYINT(4) NOT NULL AFTER required'));

        $this->db->set('default_value_id', '0');
        $this->db->update('menu_options');
    }

    public function down() {
        $this->dbforge->drop_table('mealtimes');

        $this->dbforge->drop_column('menus', 'mealtime_id');
        $this->dbforge->drop_column('menus', 'menu_priority');
        $this->dbforge->drop_column('menu_options', 'default_value_id');
    }

    protected function _mealtimes() {
        $fields = array(
            'mealtime_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'mealtime_name VARCHAR(128) NOT NULL',
            'start_time TIME NOT NULL DEFAULT "00:00:00"',
            'end_time TIME NOT NULL DEFAULT "23:59:59"',
            'mealtime_status TINYINT(1) NOT NULL',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('mealtimes');
        $this->db->query('ALTER TABLE ' . $this->db->dbprefix('mealtimes') . ' AUTO_INCREMENT 11');

        $this->db->insert('mealtimes', array('mealtime_name' => 'Breakfast', 'start_time' => '07:00:00', 'end_time' => '10:00:00', 'mealtime_status' => '1'));
        $this->db->insert('mealtimes', array('mealtime_name' => 'Lunch', 'start_time' => '12:00:00', 'end_time' => '14:30:00', 'mealtime_status' => '1'));
        $this->db->insert('mealtimes', array('mealtime_name' => 'Dinner', 'start_time' => '18:00:00', 'end_time' => '20:00:00', 'mealtime_status' => '1'));

        $this->db->insert('permissions', array(
            'name'        => 'Admin.Mealtimes',
            'description' => 'Ability to access, manage, add and delete mealtimes',
            'action'      => serialize(array('access', 'manage', 'add', 'delete')),
            'status'      => '1',
        ));

        $permission_id = $this->db->insert_id();
        $staff_group = $this->db->get_where('staff_groups', array('staff_group_id' => '11'));
        if ($staff_group->num_rows() > 0) {
            $row = $staff_group->row_array();
            $group_permissions = (!empty($row['permissions'])) ? unserialize($row['permissions']) : array();

            $group_permissions[$permission_id] = array('access', 'manage', 'add', 'delete');
            $this->db->set('permissions', serialize($group_permissions));
            $this->db->where('staff_group_id', '11');
            $this->db->update('staff_groups');
        }
    }
}

/* End of file 029_create_mealtimes_table_and_add_column_to_menus_table_and_menu_options_table.php */
/* Location: ./setup/migrations/029_create_mealtimes_table_and_add_column_to_menus_table_and_menu_options_table.php */