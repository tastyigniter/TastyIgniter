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
 * Rename column position to partial in the layout_modules table
 */
class Migration_rename_column_layout_modules_table extends TI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('layout_modules')." CHANGE `position` `partial` VARCHAR(32) NOT NULL;");
    }

    public function down() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('layout_modules')." CHANGE `partial` `position` VARCHAR(32) NOT NULL;");
    }
}

/* End of file 012_rename_column_layout_modules_table.php */
/* Location: ./system/tastyigniter/migrations/012_rename_column_layout_modules_table.php */