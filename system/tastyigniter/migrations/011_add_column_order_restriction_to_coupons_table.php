<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Migration_add_column_order_restriction_to_coupons_table extends CI_Migration {

    public function up() {
        $this->dbforge->add_column('coupons', array('order_restriction TINYINT NOT NULL'));
    }

    public function down() {
        $this->dbforge->drop_column('coupons', 'order_restriction');
    }
}

/* End of file 011_add_column_order_restriction_to_coupons_table.php */
/* Location: ./setup/migrations/011_add_column_order_restriction_to_coupons_table.php */