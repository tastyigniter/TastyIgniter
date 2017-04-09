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
 * Add column comment to the order_menus table
 */
class Migration_add_column_comment_to_order_menus_table extends TI_Migration {

    public function up() {
        $this->dbforge->add_column('order_menus', array('comment TEXT NOT NULL'));
    }

    public function down() {
        $this->dbforge->drop_column('order_menus', 'comment');
    }
}

/* End of file 010_add_column_comment_to_order_menus_table.php */
/* Location: ./system/tastyigniter/migrations/010_add_column_comment_to_order_menus_table.php */