<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Migration_1_3_0 extends CI_Migration {

	public function up() {
        $this->dbforge->add_column('extensions', array('status TINYINT(1) NOT NULL'));
        $this->dbforge->add_column('extensions', array('title VARCHAR(255) NOT NULL'));

        $this->dbforge->add_column('working_hours', array('status TINYINT(1) NOT NULL'));
		$this->dbforge->add_column('categories', array('parent_id INT(11) NOT NULL'));

		$this->db->query("INSERT INTO ".$this->db->dbprefix('settings')." (`setting_id`, `sort`, `item`, `value`, `serialized`) VALUES (10971, 'prefs', 'default_themes', 'a:2:{s:5:\"admin\";s:18:\"tastyigniter-blue/\";s:4:\"main\";s:20:\"tastyigniter-orange/\";}', 1);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('permalinks')." ADD UNIQUE INDEX `uniqueSlug` (`slug`, `controller`);");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('reviews')." CHANGE `order_id` `sale_id` INT(11)  NOT NULL;");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('reviews')." ADD `sale_type` VARCHAR(32)  NULL  DEFAULT NULL  AFTER `sale_id`;");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('reviews')." DROP PRIMARY KEY, ADD PRIMARY KEY (`review_id`, `sale_type`, `sale_id`);");

		$this->notifications();

	}

	public function down() {
		$this->dbforge->drop_column('categories', 'parent_id');
		$this->db->where('sort', 'prefs')->where('item', 'default_themes')->delete('settings');

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('permalinks')." DROP INDEX `uniqueSlug`;");

		$this->db->query("ALTER TABLE ".$this->db->dbprefix('reviews')." CHANGE `sale_id` `order_id` INT(11)  NOT NULL;");
		$this->db->query("ALTER TABLE ".$this->db->dbprefix('reviews')." DROP PRIMARY KEY, ADD PRIMARY KEY (`review_id`, `order_id`);");

        $this->dbforge->drop_table('notifications');
	}

	private function notifications() {
		$fields = array(
			'notification_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'menu_option_id INT(11) NOT NULL',
			'menu_id INT(11) NOT NULL',
			'option_id INT(11) NOT NULL',
			'option_value_id INT(11) NOT NULL',
			'new_price DECIMAL(15,2) NOT NULL',
			'quantity INT(11) NOT NULL',
			'substract_stock TINYINT(4) NOT NULL',
  		);

		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('notifications');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('notifications').' AUTO_INCREMENT 11');
	}
}

/* End of file 003_1_3_0.php */
/* Location: ./setup/migrations/003_1_3_0.php */