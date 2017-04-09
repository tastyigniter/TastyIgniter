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
 * Drop column can_delete from the languages table
 * Rename column directory to idiom in the staff_groups table
 */
class Migration_edit_languages_columns extends TI_Migration {

    public function up() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('languages')." CHANGE `directory` `idiom` VARCHAR(32) NOT NULL;");

        $this->dbforge->add_column('languages', array('can_delete TINYINT(1) NOT NULL'));

        $this->db->set('can_delete', '1');
        $this->db->where('language_id', '11');
        $this->db->update('languages');
    }

    public function down() {
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('languages')." CHANGE `idiom` `directory` VARCHAR(32)  NOT NULL;");

        $this->dbforge->drop_column('languages', 'can_delete');
    }
}

/* End of file 008_edit_languages_columns.php */
/* Location: ./system/tastyigniter/migrations/008_edit_languages_columns.php */