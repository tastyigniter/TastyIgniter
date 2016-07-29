<?php
/**
 * Copyright (c) 2016. Igniter Labs
 */
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Users Model Class
 *
 * @category       Models
 * @package        TastyIgniter\Models\Users_model.php
 * @link           http://docs.tastyigniter.com
 */
class Users_model extends TI_Model
{
	/**
	 * @var string The database table name
	 */
	protected $table_name = 'users';

	protected $primary_key = 'user_id';
}

/* End of file Users_model.php */
/* Location: ./system/tastyigniter/models/Users_model.php */