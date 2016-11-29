<?php
/**
 * TastyIgniter
 *
 * An open source online ordering, reservation and management system for restaurants.
 *
 * @package   TastyIgniter
 * @author    SamPoyigi
 * @copyright (c) 2013 - 2016. TastyIgniter
 * @link      http://tastyigniter.com
 * @license   http://opensource.org/licenses/GPL-3.0 The GNU GENERAL PUBLIC LICENSE
 * @since     File available since Release 1.0
 */
if (!defined('BASEPATH')) exit('No direct access allowed');

/**
 * Fix nullable columns
 */
class Migration_modify_tables_eloquently extends TI_Migration {

    public function up() {
		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('customers') . ' MODIFY ip_address VARCHAR(40) DEFAULT NULL');
		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('customers') . ' MODIFY cart TEXT DEFAULT NULL');

		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('locations') . ' MODIFY location_radius INT(11) DEFAULT NULL');

		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('staffs') . ' MODIFY timezone VARCHAR(32) DEFAULT NULL');
		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('staffs') . ' MODIFY language_id INT(11) DEFAULT NULL');

		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('orders') . ' MODIFY cart TEXT DEFAULT NULL');
		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('orders') . ' MODIFY status_id INT(11) DEFAULT NULL');
		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('orders') . ' MODIFY notify TINYINT(1) DEFAULT NULL');

		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('orders') . ' MODIFY assignee_id INT(11) DEFAULT NULL');
		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('orders') . ' MODIFY invoice_no INT(11) DEFAULT NULL');
		$this->db->query('ALTER TABLE ' . $this->db->dbprefix('orders') . ' MODIFY invoice_prefix VARCHAR(32) DEFAULT NULL');
    }

    public function down() {}
}

/* End of file 031_modify_tables_eloquently.php */
/* Location: ./system/tastyigniter/migrations/031_modify_tables_eloquently.php */