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
if (!defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add customer_account_access column to the staff_groups table
 * Update customer_account_access value to 1 on staff_group_id = 11
 */
class Migration_add_column_customer_account_access_to_staff_groups_table extends TI_Migration {

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
/* Location: ./system/tastyigniter/migrations/028_add_column_customer_account_access_to_staff_groups_table.php */