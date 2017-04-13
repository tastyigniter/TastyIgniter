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
 * Update password fields on users and customers tables
 */
class Migration_add_auth_fields_to_users_and_customers_tables extends CI_Migration
{

    public function up()
    {
        $fields = [
            'password' => ['name' => 'password', 'type' => 'VARCHAR', 'constraint' => '255'],
        ];

        $this->dbforge->modify_column('customers', $fields);
        $this->dbforge->modify_column('users', $fields);

        $fields = [
            'reset_code'      => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE],
            'reset_time'      => ['type' => 'DATETIME', 'null' => TRUE],
            'activation_code' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE],
            'remember_token'  => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE],
            'is_activated'    => ['type' => 'INT', 'constraint' => '11', 'null' => TRUE],
            'date_activated'  => ['type' => 'DATETIME ', 'null' => TRUE],
            'last_login'      => ['type' => 'DATETIME', 'null' => TRUE],
        ];

        $this->dbforge->add_column('customers', $fields);
        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
        $fields = [
            'password' => ['name' => 'password', 'type' => 'VARCHAR', 'constraint' => '40'],
        ];

        $this->dbforge->modify_column('customers', $fields);
        $this->dbforge->modify_column('users', $fields);

        $fields = ['reset_code', 'reset_time', 'activation_code', 'remember_token', 'is_activated', 'date_activated', 'last_login'];
        foreach ($fields as $field) {
            $this->dbforge->drop_column('customers', $field);
            $this->dbforge->drop_column('users', $field);
        }
    }
}

/* End of file 032_add_auth_fields_to_users_and_customers_tables.php */
/* Location: ./extensions/cart_module/migrations/032_add_auth_fields_to_users_and_customers_tables.php */
