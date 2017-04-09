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
 * Rename column reservation_interval to reservation_time_interval in the locations table
 * Rename column reservation_turn to reservation_stay_time in the locations table
 */
class Migration_add_column_location_image_to_locations_table extends TI_Migration {

    public function up() {
        $this->dbforge->add_column('locations', array('location_image VARCHAR(255) NOT NULL'));

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('locations')." CHANGE `reservation_interval` `reservation_time_interval` INT(11) NOT NULL;");
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('locations')." CHANGE `reservation_turn` `reservation_stay_time` INT(11) NOT NULL;");

        $this->Setup_model->querySchema('locations', 'initial');
        $this->Setup_model->querySchema('locations', 'demo');
    }

    public function down() {
        $this->dbforge->drop_column('locations', 'location_image');

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('locations')." CHANGE `reservation_time_interval` `reservation_interval` INT(11) NOT NULL;");
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('locations')." CHANGE `reservation_stay_time` `reservation_turn` INT(11) NOT NULL;");
    }
}

/* End of file 009_add_column_location_image_to_locations_table.php */
/* Location: ./system/tastyigniter/migrations/009_add_column_location_image_to_locations_table.php */