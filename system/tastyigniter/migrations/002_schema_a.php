<?php if ( ! defined('BASEPATH')) exit('No direct access allowed');

class Migration_Schema_a extends CI_Migration {

	public function up() {
		$this->_countries();
		$this->_coupons();
		$this->_locations();
		$this->_menu_options();
		$this->_menu_option_values();
		$this->_options();
		$this->_option_values();
		$this->_order_menus();
		$this->_order_options();
		$this->_pages();
	}

	public function down() {
		$this->dbforge->drop_column('countries', 'flag');

		$this->dbforge->add_column('coupons', array('start_date DATE NOT NULL'));
		$this->dbforge->add_column('coupons', array('end_date DATE NOT NULL'));
		$this->dbforge->drop_column('coupons', 'validity');
        $this->dbforge->drop_column('coupons', 'fixed_date');
        $this->dbforge->drop_column('coupons', 'fixed_from_time');
        $this->dbforge->drop_column('coupons', 'fixed_to_time');
        $this->dbforge->drop_column('coupons', 'period_start_date');
        $this->dbforge->drop_column('coupons', 'period_end_date');
        $this->dbforge->drop_column('coupons', 'recurring_every');
        $this->dbforge->drop_column('coupons', 'recurring_from_time');
        $this->dbforge->drop_column('coupons', 'recurring_to_time');

		$this->db->query('ALTER TABLE '.$this->db->dbprefix('locations').' CHANGE `delivery_time` `ready_time` INT(11) NOT NULL');
		$this->dbforge->add_column('locations', 'delivery_charge DECIMAL(15,2) NOT NULL');
		$this->dbforge->add_column('locations', 'min_delivery_total DECIMAL(15,2) NOT NULL');
		$this->dbforge->drop_column('locations', 'options');

        $this->dbforge->drop_column('menu_options', 'option_id');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('menu_options').' CHANGE `menu_option_id` `option_id` INT(11) NOT NULL AUTO_INCREMENT');
		$this->dbforge->drop_column('menu_options', 'menu_id');
		$this->dbforge->drop_column('menu_options', 'required');
		$this->dbforge->drop_column('menu_options', 'option_values');

		$fields = array(
			'option_name VARCHAR(32) NOT NULL',
			'option_price DECIMAL(15,2) NOT NULL'
		);

		$this->dbforge->add_column('menu_options', $fields);

		$this->dbforge->drop_table('menu_option_values');
		$this->dbforge->drop_table('options');
		$this->dbforge->drop_table('option_values');

        $fields = array(
            'menu_id INT(11) NOT NULL',
            'option_id INT(11) NOT NULL',
            'PRIMARY KEY (menu_id, option_id)'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->create_table('menus_to_options');

        $this->db->query('ALTER TABLE '.$this->db->dbprefix('order_menus').' CHANGE `option_values` `order_option_id` INT(11) NOT NULL');

		$this->dbforge->add_column('order_options', array('option_id  INT(11) NOT NULL'));
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('order_options').' CHANGE `order_option_name` `option_name` VARCHAR(32) NOT NULL');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('order_options').' CHANGE `order_option_price` `option_price` DECIMAL(15,2) NOT NULL');

		$this->db->query('ALTER TABLE '.$this->db->dbprefix('pages').' CHANGE `navigation` `menu_location` TINYINT(11) NOT NULL');
	}

	public function _countries() {
		$this->dbforge->add_column('countries', array('flag VARCHAR(255) NOT NULL'));
	}

	public function _coupons() {
		$this->dbforge->drop_column('coupons', 'start_date');
		$this->dbforge->drop_column('coupons', 'end_date');

  		$this->dbforge->add_column('coupons', array('validity CHAR(15) NOT NULL'));
		$this->dbforge->add_column('coupons', array('fixed_date DATE DEFAULT NULL'));
		$this->dbforge->add_column('coupons', array('fixed_from_time TIME DEFAULT NULL'));
		$this->dbforge->add_column('coupons', array('fixed_to_time TIME DEFAULT NULL'));
		$this->dbforge->add_column('coupons', array('period_start_date DATE DEFAULT NULL'));
		$this->dbforge->add_column('coupons', array('period_end_date DATE DEFAULT NULL'));
		$this->dbforge->add_column('coupons', array('recurring_every VARCHAR(35) NOT NULL'));
		$this->dbforge->add_column('coupons', array('recurring_from_time TIME DEFAULT NULL'));
		$this->dbforge->add_column('coupons', array('recurring_to_time TIME DEFAULT NULL'));
  	}

	public function _locations() {
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('locations').' CHANGE `ready_time` `delivery_time` INT(11) NOT NULL');
		$fields = array('collection_time INT(11) NOT NULL', 'options TEXT NOT NULL');
		$this->dbforge->add_column('locations', $fields);
		$this->dbforge->drop_column('locations', 'delivery_charge');
		$this->dbforge->drop_column('locations', 'min_delivery_total');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('locations').' AUTO_INCREMENT 11');
	}

	public function _menu_options() {
        $this->dbforge->drop_table('menus_to_options');

		$this->db->query('ALTER TABLE '.$this->db->dbprefix('menu_options').' CHANGE `option_id` `menu_option_id` INT(11) NOT NULL AUTO_INCREMENT');
		$this->dbforge->drop_column('menu_options', 'option_name');
		$this->dbforge->drop_column('menu_options', 'option_price');

		$fields = array(
			'option_id INT(11) NOT NULL',
			'menu_id INT(11) NOT NULL',
			'required TINYINT(4) NOT NULL',
			'option_values  TEXT NOT NULL'
		);

		$this->dbforge->add_key('menu_option_id', TRUE);
		$this->dbforge->add_column('menu_options', $fields);
	}

	public function _menu_option_values() {
		$fields = array(
			'menu_option_value_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'menu_option_id INT(11) NOT NULL',
			'menu_id INT(11) NOT NULL',
			'option_id INT(11) NOT NULL',
			'option_value_id INT(11) NOT NULL',
			'new_price DECIMAL(15,2) NOT NULL',
			'quantity INT(11) NOT NULL',
			'subtract_stock TINYINT(4) NOT NULL',
  		);

		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('menu_option_values');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('menu_option_values').' AUTO_INCREMENT 11');
	}

	public function _options() {
		$fields = array(
  			'option_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'option_name VARCHAR(32) NOT NULL',
			'display_type VARCHAR(15) NOT NULL',
			'priority INT(11) NOT NULL'
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('options');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('options').' AUTO_INCREMENT 11');
	}

	public function _option_values() {
		$fields = array(
			'option_value_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
			'option_id INT(11) NOT NULL',
			'value VARCHAR(128) NOT NULL',
			'price DECIMAL(15,2) NOT NULL',
			'priority INT(11) NOT NULL'
  		);

		$this->dbforge->add_field($fields);
		$this->dbforge->create_table('option_values');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('option_values').' AUTO_INCREMENT 11');
	}

	public function _order_menus() {
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('order_menus').' CHANGE `order_option_id` `option_values` TEXT NOT NULL');
	}

	public function _order_options() {
		$this->dbforge->drop_column('order_options', 'option_id');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('order_options').' CHANGE `option_name` `order_option_name` VARCHAR(128) NOT NULL');
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('order_options').' CHANGE `option_price` `order_option_price` DECIMAL(15,2) NOT NULL');
		$fields = array(
  			'order_menu_id INT(11) NOT NULL',
  			'order_menu_option_id INT(11) NOT NULL',
  			'menu_option_value_id INT(11) NOT NULL'
  		);

		$this->dbforge->add_column('order_options', $fields);
  	}

	public function _pages() {
		$this->db->query('ALTER TABLE '.$this->db->dbprefix('pages').' CHANGE `menu_location` `navigation` TEXT NOT NULL');
	}
}

/* End of file 002_schema.php */
/* Location: ./setup/migrations/002_schema.php */