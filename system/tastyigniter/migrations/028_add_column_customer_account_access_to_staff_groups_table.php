<?php if (!defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add customer_account_access column to the staff_groups table
 * Update customer_account_access value to 1 on staff_group_id = 11
 */
class Migration_add_column_customer_account_access_to_staff_groups_table extends CI_Migration {

    public function up() {
        $this->dbforge->add_column('staff_groups', array('customer_account_access TINYINT NOT NULL AFTER staff_group_name'));

        $this->db->set('customer_account_access', '1');
        $this->db->where('staff_group_id', '11');

        $this->db->update('staff_groups');
    }

    public function down() {
        $this->dbforge->drop_column('staff_groups', 'customer_account_access');
    }
}

/* End of file 028_add_column_customer_account_access_to_staff_groups_table.php */
/* Location: ./setup/migrations/028_add_column_customer_account_access_to_staff_groups_table.php */