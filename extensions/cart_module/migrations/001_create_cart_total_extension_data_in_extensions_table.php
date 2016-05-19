<?php if (!defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add new cart total extension records as type 'total' in extensions table
 */
class Migration_create_cart_total_extension_data_in_extensions_table extends CI_Migration {

    public function up() {
        $this->db->replace('extensions', array(
            'title'      => 'Sub Total',
            'name'       => 'cart_total',
            'type'       => 'cart_total',
            'data'       => serialize(array(
                'priority' => '1',
                'name'     => 'cart_total',
                'title'    => 'Sub Total',
                'admin_title'    => 'Sub Total',
                'status'   => '1',
            )),
            'serialized' => '1',
            'status'     => '1',
        ));

        $this->db->replace('extensions', array(
            'title'      => 'Coupon',
            'name'       => 'coupon',
            'type'       => 'cart_total',
            'data'       => serialize(array(
                'priority' => '3',
                'name'     => 'coupon',
                'title'    => 'Coupon {coupon}',
                'admin_title'    => 'Coupon {coupon}',
                'status'   => '1',
            )),
            'serialized' => '1',
            'status'     => '1',
        ));

        $this->db->replace('extensions', array(
            'title'      => 'Delivery',
            'name'       => 'delivery',
            'type'       => 'cart_total',
            'data'       => serialize(array(
                'priority' => '4',
                'name'     => 'delivery',
                'title'    => 'Delivery',
                'admin_title'    => 'Delivery',
                'status'   => '1',
            )),
            'serialized' => '1',
            'status'     => '1',
        ));

        $this->db->replace('extensions', array(
            'title'      => 'VAT',
            'name'       => 'taxes',
            'type'       => 'cart_total',
            'data'       => serialize(array(
                'priority' => '5',
                'name'     => 'taxes',
                'title'    => 'VAT {tax}',
                'admin_title'    => 'VAT {tax}',
                'status'   => '1',
            )),
            'serialized' => '1',
            'status'     => '1',
        ));

        $this->db->replace('extensions', array(
            'title'      => 'Order Total',
            'name'       => 'order_total',
            'type'       => 'cart_total',
            'data'       => serialize(array(
                'priority' => '6',
                'name'     => 'order_total',
                'title'    => 'Order Total',
                'admin_title'    => 'Order Total',
                'status'   => '1',
            )),
            'serialized' => '1',
            'status'     => '1',
        ));
    }

    public function down() {
        $this->db->where('type', 'cart_total');
        $this->db->where_in('name', array('cart_total', 'coupon', 'delivery', 'taxes', 'order_total'));
        $this->db->delete('extensions');
    }
}

/* End of file 001_create_cart_total_extension_data_in_extensions_table.php */
/* Location: ./setup/migrations/001_create_cart_total_extension_data_in_extensions_table.php */