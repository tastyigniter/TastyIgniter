<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

/**
 * Add columns status and title to the extensions table
 * Add column status to the working_hours table
 * Add columns parent_id, priority and image to the categories table
 * Add columns parent_id, priority and image to the categories table
 * Add default themes array to the settings table
 * Add unique index slug and controller to the permalinks table
 * Add column sale_type to the reviews table
 * Rename column order_id to sales_id in the reviews table
 * Add unique index review_id, sale_type and sale_id to the reviews table
 * Drop column covered_area from the locations table
 * Add column status_color to the statuses table
 * Add column assignee_id to the orders table
 * Rename table customers_activity to the customers_online
 * Add column user_agent to the customers_online table
 */
class Migration_1_3_0 extends CI_Migration {

	public function up() {
        $this->dbforge->add_column('extensions', array('status TINYINT(1) NOT NULL'));
        $this->dbforge->add_column('extensions', array('title VARCHAR(255) NOT NULL'));

        $this->dbforge->add_column('working_hours', array('status TINYINT(1) NOT NULL'));
        $this->dbforge->add_column('categories', array('parent_id INT(11) NOT NULL'));
        $this->dbforge->add_column('categories', array('priority INT(11) NOT NULL'));
        $this->dbforge->add_column('categories', array('image VARCHAR(255) NOT NULL'));

		$this->db->query("INSERT INTO ".$this->db->dbprefix('settings')." (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES (10971, 'prefs', 'default_themes', 'a:2:{s:5:\"admin\";s:18:\"tastyigniter-blue/\";s:4:\"main\";s:20:\"tastyigniter-orange/\";}', 1);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('permalinks')." ADD UNIQUE INDEX `uniqueSlug` (`slug`, `controller`);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('reviews')." CHANGE `order_id` `sale_id` INT(11)  NOT NULL;");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('reviews')." ADD `sale_type` VARCHAR(32)  NULL  DEFAULT NULL  AFTER `sale_id`;");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('reviews')." DROP PRIMARY KEY, ADD PRIMARY KEY (`review_id`, `sale_type`, `sale_id`);");

        // Drop covered areas column, now using options column
        $this->dbforge->drop_column('locations', 'covered_area');

        $this->dbforge->add_column('statuses', array('status_color VARCHAR(32) NOT NULL'));

        $this->dbforge->add_column('orders', array('assignee_id INT(11) NOT NULL'));

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('customers_activity')." RENAME ".$this->db->dbprefix('customers_online').";");
        $this->dbforge->add_column('customers_online', array('user_agent TEXT NOT NULL'));

        $this->_notifications();
	}

	public function down() {
        $this->dbforge->drop_column('extensions', 'status');
        $this->dbforge->drop_column('extensions', 'title');

        $this->dbforge->drop_column('categories', 'parent_id');
        $this->dbforge->drop_column('categories', 'priority');
        $this->dbforge->drop_column('categories', 'image');
		$this->db->where('sort', 'prefs')->where('item', 'default_themes')->delete('settings');

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('permalinks')." DROP INDEX `uniqueSlug`;");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('reviews')." CHANGE `sale_id` `order_id` INT(11)  NOT NULL;");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('reviews')." DROP PRIMARY KEY, ADD PRIMARY KEY (`review_id`, `order_id`);");

        // Roll back and add covered areas column
        $this->dbforge->add_column('locations', array('covered_area TEXT NOT NULL'));

        $this->dbforge->drop_column('statuses', 'status_color');

        $this->dbforge->drop_column('orders', 'assignee_id');

        $this->db->query("ALTER TABLE ".$this->db->dbprefix('customers_online')." RENAME ".$this->db->dbprefix('customers_activity').";");
        $this->dbforge->drop_column('customers_activity', 'user_agent');

        $this->dbforge->drop_table('notifications');
	}

	private function _notifications() {
		$fields = array(
            'notification_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'action VARCHAR(255) NOT NULL',
			'object VARCHAR(255) NOT NULL',
			'suffix VARCHAR(255) NOT NULL',
			'object_id INT(11) NOT NULL',
			'actor_id INT(11) NOT NULL',
			'subject_id INT(11) NOT NULL',
			'status TINYINT(4) NOT NULL',
			'date_added DATETIME NOT NULL',
  		);

		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('notifications');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('notifications').' AUTO_INCREMENT 11');
	}
}

/* End of file 003_1_3_0.php */
/* Location: ./setup/migrations/003_1_3_0.php */