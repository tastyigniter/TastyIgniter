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
 * Add options column to the layout_modules table
 */
class Migration_add_options_column_to_layout_modules_table extends TI_Migration {

    public function up() {
        $this->dbforge->add_column('layout_modules', array('options TEXT NOT NULL AFTER priority'));
    }

    public function down() {
        $this->dbforge->drop_column('layout_modules', 'options');
    }
}

/* End of file 030_add_options_column_to_layout_modules_table.php */
/* Location: ./system/tastyigniter/migrations/030_add_options_column_to_layout_modules_table.php */