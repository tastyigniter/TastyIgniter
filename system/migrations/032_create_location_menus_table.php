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
 * Create menus_locations table
 */
class Migration_create_location_menus_table extends CI_Migration {

    public function up() {
        $fields = array(
            'location_id INT(11) DEFAULT NULL',
            'menu_id INT(11) DEFAULT NULL',
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('location_menus');
    }

    public function down() {
        $this->dbforge->drop_table('location_menus');
    }
}

/* End of file 032_create_location_menus_table.php */
/* Location: ./extensions/cart_module/migrations/032_create_location_menus_table.php */
