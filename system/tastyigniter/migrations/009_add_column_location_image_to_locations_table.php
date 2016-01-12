<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Rename column reservation_interval to reservation_time_interval in the locations table
 * Rename column reservation_turn to reservation_stay_time in the locations table
 */
class Migration_add_column_location_image_to_locations_table extends CI_Migration {

    public function up() {
        $this->dbforge->add_column('locations', array('location_image VARCHAR(255) NOT NULL'));

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('locations')." CHANGE `reservation_interval` `reservation_time_interval` INT(11) NOT NULL;");
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('locations')." CHANGE `reservation_turn` `reservation_stay_time` INT(11) NOT NULL;");
    }

    public function down() {
        $this->dbforge->drop_column('locations', 'location_image');

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('locations')." CHANGE `reservation_time_interval` `reservation_interval` INT(11) NOT NULL;");
        $this->db->query("ALTER TABLE ".$this->db->dbprefix('locations')." CHANGE `reservation_stay_time` `reservation_turn` INT(11) NOT NULL;");
    }
}

/* End of file 009_add_column_location_image_to_locations_table.php */
/* Location: ./setup/migrations/009_add_column_location_image_to_locations_table.php */