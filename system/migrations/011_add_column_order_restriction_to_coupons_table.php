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
 * Add column coupons to the order_restriction table
 * Add unique index code to the coupons table
 */
class Migration_add_column_order_restriction_to_coupons_table extends TI_Migration {

    public function up() {
        $this->dbforge->add_column('coupons', array('order_restriction TINYINT NOT NULL'));

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons')." ADD UNIQUE INDEX (`code`);");
    }

    public function down() {
        $this->dbforge->drop_column('coupons', 'order_restriction');

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('coupons')." DROP INDEX `code`;");
    }
}

/* End of file 011_add_column_order_restriction_to_coupons_table.php */
/* Location: ./system/tastyigniter/migrations/011_add_column_order_restriction_to_coupons_table.php */