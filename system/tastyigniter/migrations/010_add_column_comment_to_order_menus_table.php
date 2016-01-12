<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add column comment to the order_menus table
 */
class Migration_add_column_comment_to_order_menus_table extends CI_Migration {

    public function up() {
        $this->dbforge->add_column('order_menus', array('comment TEXT NOT NULL'));
    }

    public function down() {
        $this->dbforge->drop_column('order_menus', 'comment');
    }
}

/* End of file 010_add_column_comment_to_order_menus_table.php */
/* Location: ./setup/migrations/010_add_column_comment_to_order_menus_table.php */